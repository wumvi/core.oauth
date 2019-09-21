<?php
namespace Core\OAuth\Social\Deviantart;

use Core\OAuth\Exception\GetUserException;
use Core\OAuth\Exception\JsonException;
use Core\OAuth\OAuthBase\Deviantart\OAuthDeviantart;
use Core\OAuth\Social\Deviantart\DeviantartUser;
use LightweightCurl\Curl;
use LightweightCurl\Request;

class DeviantartService
{
    /**
     * @var OAuthDeviantart
     */
    private $oauth;

    /**
     * FbSocialService constructor.
     *
     * @param OAuthDeviantart $oauth
     */
    public function __construct(OAuthDeviantart $oauth)
    {
        $this->oauth = $oauth;
    }

    public function getLink(string $redirectUrl, string $oauthId): string
    {
        $url = 'https://www.deviantart.com/oauth2/authorize?client_id=' . $this->oauth->getClientId();
        $url .= '&redirect_uri=' . $redirectUrl;
        $url .= '&state=' . $oauthId;
        $url .= '&scope=basic';
        $url .= '&response_type=code';

        return $url;
    }

    /**
     * Возвращает модель пользователя сайта Deviantart
     *
     * @param string $authToken Токен после авторизации
     *
     * @return DeviantartUser Модель пользователя
     *
     * @throws
     *
     * @see hhttps://www.deviantart.com/developers/http/v1/20160316/user_whoami/2413749853e66c5812c9beccc0ab3495
     */
    public function getUserInfo(string $authToken): DeviantartUser
    {
        $url = 'https://www.deviantart.com/api/v1/oauth2/user/whoami?access_token=' . $authToken;
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

        return new DeviantartUser($data);
    }
}
