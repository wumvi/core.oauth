<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase;

use LightweightCurl\Curl;
use LightweightCurl\Request;

abstract class OAuthBase
{
    /**
     * @var Curl Расширенный curl
     */
    protected $curl;

    /**
     * @var string ID сайта
     */
    protected $siteId;

    /**
     * @var string Секретный ключ
     */
    protected $clientSecret;

    /**
     * @var string URL для обращения
     */
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
        $this->curl = new Curl();
        $this->siteId = $siteId;
        $this->clientSecret = $clientSecret;
        $this->tokenUrl = $tokenUrl;
    }

    /**
     * @param mixed $data Данные
     *
     * @return TokenCodeResponseInterface
     */
    abstract protected function getTokenCodeResponse($data): TokenCodeResponseInterface;

    /**
     * Производит запрос и получает данные
     *
     * @param string $code Код от редиректа
     * @param string $redirectUri Страница редиректа. *По факту не используемый параметр для запроса
     *
     * @return TokenCodeResponseInterface|null Ответ сервера
     *
     * @throws
     */
    public function getAuthorizationCode(string $code, string $redirectUri): ?TokenCodeResponseInterface
    {
        $post = [
            'client_id' => $this->siteId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri
        ];

        $request = new Request();
        $request->setUrl($this->tokenUrl);
        $request->setData($post);
        $request->setMethod(Request::METHOD_POST);

        $response = $this->curl->call($request);
        $data = json_decode($response->getData());

        return $data === null || isset($data->error) ? null : $this->getTokenCodeResponse($data);
    }

    /**
     * @param $refreshToken
     *
     * @return TokenCodeResponseInterface|null
     *
     * @throws
     */
    public function getRefreshTokenCode($refreshToken): ?TokenCodeResponseInterface
    {
        $post = [
            'client_id' => $this->siteId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken
        ];

        $request = new Request();
        $request->setUrl($this->tokenUrl);
        $request->setData($post);
        $request->setMethod(Request::METHOD_POST);

        $response = $this->curl->call($request);
        $data = json_decode($response->getData());

        return $data === null || isset($data->error) ? null : $this->getTokenCodeResponse($data);
    }
}
