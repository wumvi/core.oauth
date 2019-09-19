<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Facebook;

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
    private const URL_API = 'https://graph.facebook.com/me?fields=' .
    'birthday,website,email,first_name,last_name,gender&access_token=%s';

    /**
     * @var Curl Расширенный curl
     */
    protected $curl;

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
        $this->curl = new Curl();
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
     * @return FbUser|null Модель пользователя
     *
     * @throws
     *
     * @see https://developers.facebook.com/docs/graph-api/reference/user
     */
    public function getUserInfo(string $authToken): ?FbUser
    {
        $url = vsprintf(self::URL_API, [$authToken,]);

        $request = new Request();
        $request->setUrl($url);

        $response = $this->curl->call($request);
        if ($response->getHttpCode() !== 200) {
            return null;
        }
        $data = json_decode($response->getData());
        if ($data === null) {
            return null;
        }

        return new FbUser($data);
    }
}
