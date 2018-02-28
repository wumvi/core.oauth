<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Yandex;

use Core\OAuth\OAuthBase\Yandex\OAuthYandex;
use LightweightCurl\Curl;
use LightweightCurl\CurlException;
use LightweightCurl\Request;

/**
 * Class YandexService
 */
class YandexService
{
    private const URL_API = 'https://login.yandex.ru/info?format=json&oauth_token=%s';

    /**
     * @var Curl Расширенный curl
     */
    protected $curl;

    /**
     * @var OAuthYandex
     */
    private $authYandex;

    /**
     * YandexService constructor.
     *
     * @param OAuthYandex $authYandex
     */
    public function __construct(OAuthYandex $authYandex)
    {
        $this->curl = new Curl();
        $this->authYandex = $authYandex;
    }

    public function getLink(string $oauthId): string
    {
        $url = 'https://oauth.yandex.ru/authorize?response_type=code&client_id=' . $this->authYandex->getClientId();
        $url .= '&state=' . $oauthId;

        return $url;
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
