<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Facebook;

use LightweightCurl\Curl;
use LightweightCurl\Request;
use LightweightCurl\CurlException;

/**
 * Сервис для Facebook
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
     * @var string Id приложения
     */
    private $appId;

    /**
     * @var string Приватный ключ
     */
    private $privateKey;

    /**
     * FbSocialService constructor.
     * @param string $appId ID приложения
     * @param string $privateKey Приватный ключ
     */
    public function __construct(string $appId, string $privateKey)
    {
        $this->curl = new Curl();
        $this->appId = $appId;
        $this->privateKey = $privateKey;
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
