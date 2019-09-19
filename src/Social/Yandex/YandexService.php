<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Yandex;

use Core\OAuth\Exception\GetUserException;
use Core\OAuth\Exception\JsonException;
use Core\OAuth\OAuthBase\Yandex\OAuthYandex;
use LightweightCurl\Curl;
use LightweightCurl\Request;

/**
 * Class YandexService
 */
class YandexService
{
    private const URL_API = 'https://login.yandex.ru/info?format=json&oauth_token=%s';

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
        $this->authYandex = $authYandex;
    }

    public function getLink(string $oauthId): string
    {
        $url = 'https://oauth.yandex.ru/authorize?response_type=code';
        $url .= '&client_id=' . $this->authYandex->getClientId();
        $url .= '&state=' . $oauthId;

        return $url;
    }

    /**
     * @param string $authToken
     *
     * @return YaUser|null
     *
     * @throws
     */
    public function getUserInfo(string $authToken): ?YaUser
    {
        $url = vsprintf(self::URL_API, [$authToken,]);

        $request = new Request();
        $request->setUrl($url);
        $curl = new Curl();
        $response = $curl->call($request);
        $data = json_decode($response->getData());
        if (empty($data)) {
            throw new JsonException('Wrong json for getting yandex user', JsonException::WRONG_JSON_CODE);
        }

        return new YaUser($data);
    }
}
