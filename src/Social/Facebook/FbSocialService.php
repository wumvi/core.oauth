<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Facebook;

use Core\OAuth\OAuthBase\Facebook\OAuthFacebook;
use LightweightCurl\CurlInterface;
use LightweightCurl\Request;

/**
 * Сервис для Facebook
 *
 * @author Kozlenko Vitaliy
 * @see https://developers.facebook.com/tools/explorer?method=GET&path=me%3Ffields%3Dwebsite%2Cbirthday&version=v2.6
 */
class FbSocialService implements FbSocialServiceInterface
{
    private const URL_API = 'https://graph.facebook.com/me?fields=' .
    'birthday,website,email,first_name,last_name,gender&access_token=%s';

    /**
     * @var CurlInterface Расширенный curl
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
     * @param CurlInterface $curl
     */
    public function __construct(OAuthFacebook $authFacebook, CurlInterface $curl)
    {
        $this->curl = $curl;
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
     * @return FbUserInterface|null Модель пользователя
     *
     * @see https://developers.facebook.com/docs/graph-api/reference/user
     *
     * @throws
     */
    public function getUserInfo(string $authToken): ?FbUserInterface
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
