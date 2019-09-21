<?php
namespace Core\OAuth\Social\Dribbble;

use Core\OAuth\Exception\GetUserException;
use Core\OAuth\Exception\JsonException;
use Core\OAuth\OAuthBase\Dribbble\OAuthDribbble;
use Core\OAuth\Social\Dribbble\DribbbleUser;
use LightweightCurl\Curl;
use LightweightCurl\Request;

class DribbbleService
{
    /**
     * @var OAuthDribbble
     */
    private $oauth;

    /**
     * FbSocialService constructor.
     *
     * @param OAuthDribbble $oauth
     */
    public function __construct(OAuthDribbble $oauth)
    {
        $this->oauth = $oauth;
    }

    public function getLink(string $redirectUrl, string $oauthId): string
    {
        $url = 'https://dribbble.com/oauth/authorize?client_id=' . $this->oauth->getClientId();
        $url .= '&redirect_uri=' . $redirectUrl;
        $url .= '&state=' . $oauthId;
        $url .= '&scope=public';

        return $url;
    }

    /**
     * Возвращает модель пользователя сайта Dribbble
     *
     * @param string $authToken Токен после авторизации
     *
     * @return DribbbleUser Модель пользователя
     *
     * @throws
     *
     * @see hhttps://www.Dribbble.com/developers/http/v1/20160316/user_whoami/2413749853e66c5812c9beccc0ab3495
     */
    public function getUserInfo(string $authToken): DribbbleUser
    {
        $url = 'https://api.dribbble.com/v2/user?access_token=' . $authToken;
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

        return new DribbbleUser($data);
    }
}
