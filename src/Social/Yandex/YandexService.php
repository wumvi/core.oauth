<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Yandex;

use LightweightCurl\Curl;
use LightweightCurl\Request;
use LightweightCurl\CurlException;

/**
 * Class YandexService
 */
class YandexService
{
    private const URL_API = 'https://login.yandex.ru/info?format=json&oauth_token=';
    /**
     * @var Curl Расширенный curl
     */
    protected $curl;

    /**
     * Yandex constructor.
     */
    public function __construct()
    {
        $this->curl = new Curl();
    }

    /**
     * @param string $authToken
     *
     * @return YaUser|null
     *
     * @throws CurlException
     */
    public function getUserInfo(string $authToken): ?YaUser
    {
        $url = vsprintf(self::URL_API, [$authToken,]);

        $request = new Request();
        $request->setUrl($url);

        $response = $this->curl->call($request);
        $data = json_decode($response->getData());
        if ($data === null) {
            return null;
        }

        return new YaUser([
            YaUser::PROP_ID => $data->id,
            YaUser::PROP_FIRST_NAME => $data->first_name,
            YaUser::PROP_EMAIL => $data->default_email,
            YaUser::PROP_LAST_NAME => $data->last_name,
            YaUser::PROP_BIRTHDAY => $data->birthday,
            YaUser::PROP_SEX => $data->sex,
        ]);
    }
}
