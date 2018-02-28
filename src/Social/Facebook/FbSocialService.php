<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Facebook;

use Core\OAuth\OAuthBase\Facebook\OAuthFacebook;
use LightweightCurl\Curl;
use LightweightCurl\CurlException;
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

    public function getLink(string $redirectUrl): string
    {
        $url = 'https://www.facebook.com/dialog/oauth?client_id=' . $this->oauthFacebook->getClientId();
        $url .= '&redirect_uri=' . $redirectUrl;
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
     * @see https://developers.facebook.com/docs/graph-api/reference/user
     *
     * @throws CurlException
     */
    public function getUserInfo(string $authToken): ?FbUser
    {
        $url = vsprintf(self::URL_API, [$authToken,]);

        $request = new Request();
        $request->setUrl($url);

        $response = $this->curl->call($request);
        $data = json_decode($response->getData());
        if ($data === null) {
            return null;
        }

        return new FbUser([
            FbUser::PROP_SEX => $data->gender,
            FbUser::PROP_ID => $data->id,
            FbUser::PROP_LAST_NAME => $data->last_name,
            FbUser::PROP_FIRST_NAME => $data->first_name,
            FbUser::PROP_EMAIL => $data->email
        ]);
    }
}
