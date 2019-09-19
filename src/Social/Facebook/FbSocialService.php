<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Facebook;

use Core\OAuth\Exception\GetUserException;
use Core\OAuth\Exception\JsonException;
use Core\OAuth\OAuthBase\Facebook\OAuthFacebook;
use LightweightCurl\Curl;
use LightweightCurl\Request;

/**
 * Сервис для Facebook
 *
 * @author Kozlenko Vitaliy
 * @see https://developers.facebook.com/tools/explorer?method=GET&path=me%3Ffields%3Dwebsite%2Cbirthday&version=v2.6
 */
class FbSocialService
{
    /**
     * @var OAuthFacebook
     */
    private $oauthFacebook;

    /**
     * FbSocialService constructor.
     *
     * @param OAuthFacebook $authFacebook
     */
    public function __construct(OAuthFacebook $authFacebook)
    {
        $this->oauthFacebook = $authFacebook;
    }

    public function getLink(string $redirectUrl, string $oauthId): string
    {
        $url = 'https://www.facebook.com/dialog/oauth?client_id=' . $this->oauthFacebook->getClientId();
        $url .= '&redirect_uri=' . $redirectUrl;
        $url .= '&state=' . $oauthId;
        $url .= '&response_type=code&scope=email';

        return $url;
    }

    /**
     * Возвращает модель пользователя сайта Facebook
     *
     * @param string $authToken Токен после авторизации
     *
     * @return FbUser Модель пользователя
     *
     * @throws
     *
     * @see https://developers.facebook.com/docs/graph-api/reference/user
     */
    public function getUserInfo(string $authToken): FbUser
    {
        $url = 'https://graph.facebook.com/me?fields=' .
            'birthday,website,email,first_name,last_name,gender&access_token=' . $authToken;

        $request = new Request();
        $request->setUrl($url);

        $curl = new Curl();
        $response = $curl->call($request);
        $data = json_decode($response->getData());
        if (empty($data)) {
            throw new JsonException('Wrong json for getting fb user', JsonException::WRONG_JSON_CODE);
        }

        if (isset($data->error)) {
            throw new GetUserException($data->error->message, $data->error->code);
        }

        return new FbUser($data);
    }
}
