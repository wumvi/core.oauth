<?php

namespace Core\OAuth\Social\Pinterest;

use Core\OAuth\Exception\GetUserException;
use Core\OAuth\Exception\JsonException;
use Core\OAuth\OAuthBase\Pinterest\OAuthPinterest;
use Core\OAuth\Social\ISocialUser;
use LightweightCurl\Curl;
use LightweightCurl\Request;

class PinterestService
{
    /**
     * @var OAuthPinterest
     */
    private $oauth;

    /**
     * FbSocialService constructor.
     *
     * @param OAuthPinterest $oauth
     */
    public function __construct(OAuthPinterest $oauth)
    {
        $this->oauth = $oauth;
    }

    public function getLink(string $redirectUrl, string $oauthId): string
    {
        $url = 'https://api.pinterest.com/oauth/?';
        $url .= 'client_id=' . $this->oauth->getClientId();
        $url .= '&redirect_uri=' . $redirectUrl;
        $url .= '&state=' . $oauthId;
        $url .= '&scope=read_public';
        $url .= '&response_type=code';

        return $url;
    }

    public function getUserInfo(string $token): ISocialUser
    {
        $url = 'https://api.pinterest.com/v1/me/?';
        $url .= 'access_token=' . $token;

        $curl = new Curl();
        $request = new Request();
        $request->setUrl($url);
        $response = $curl->call($request);

        $data = json_decode($response->getData());
        if (empty($data)) {
            throw new JsonException('Wrong json for getting stackoverflow user', JsonException::WRONG_JSON_CODE);
        }

        return new PinterestUser($data);
    }
}
