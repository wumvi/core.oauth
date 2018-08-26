<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Yandex;

use LightweightCurl\CurlInterface;
use LightweightCurl\Request;

/**
 * Class YandexService
 */
class YandexService implements YandexServiceInterface
{
    private const URL_API = 'https://login.yandex.ru/info?format=json&oauth_token=';

    /**
     * @var CurlInterface Расширенный curl
     */
    protected $curl;

    /**
     * Yandex constructor.
     *
     * @param CurlInterface $curl
     */
    public function __construct(CurlInterface $curl)
    {
        $this->curl = $curl;
    }

    /**
     * @param string $authToken
     *
     * @return YaUserInterface|null
     *
     * @throws
     */
    public function getUserInfo(string $authToken): ?YaUserInterface
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
