<?php
declare(strict_types = 1);

namespace Core\OAuth\OAuthBase;

use Core\OAuth\CurlExt;
use LightweightCurl;

abstract class OAuthBase
{
    /** @var CurlExt Расширенный curl */
    protected $curl;

    /** @var string ID сайта */
    protected $siteId;

    /** @var string Секретный ключ */
    protected $clientSecret;

    /** @var string URL для обращения */
    protected $tokenUrl;

    /**
     * OAuthBase constructor.
     *
     * @param string $siteId ID сайта
     * @param string $clientSecret Секретный ключ
     * @param string $tokenUrl URL для обращения
     */
    public function __construct(string $siteId, string $clientSecret, string $tokenUrl)
    {
        $this->curl = new CurlExt();
        $this->siteId = $siteId;
        $this->clientSecret = $clientSecret;
        $this->tokenUrl = $tokenUrl;
    }

    /**
     * @param mixed $data Данные
     * @return TokenCodeResponseInterface
     */
    abstract protected function getTokenCodeResponse($data): TokenCodeResponseInterface;

    /**
     * Производит запрос и получает данные
     *
     * @param string $code Код от редиректа
     * @param string $redirectUri Страница редиректа. *По факту не используемый параметр для запроса
     * @return TokenCodeResponseInterface|null Ответ сервера
     */
    public function getAuthorizationCode(string $code, string $redirectUri): ?TokenCodeResponseInterface
    {
        $data = $this->curl->post($this->tokenUrl, [
            'client_id' => $this->siteId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri
        ]);

        $data = json_decode($data);

        return $data === null || isset($data->error) ? null : $this->getTokenCodeResponse($data);
    }

    /**
     * @param $refreshToken
     * @return TokenCodeResponseInterface|null
     */
    public function getRefreshTokenCode($refreshToken): ?TokenCodeResponseInterface
    {
        $data = $this->curl->post($this->tokenUrl, [
            'client_id' => $this->siteId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken
        ]);

        $data = json_decode($data);

        return isset($data->error) ? null : $this->getTokenCodeResponse($data);
    }
}
