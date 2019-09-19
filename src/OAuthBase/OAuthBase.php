<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase;

use Core\OAuth\OAuthBase\Common\CommonTokenCodeResponse;
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
    protected $clientId;

    /**
     * @var string Секретный ключ
     */
    protected $clientSecret;

    /**
     * OAuthBase constructor.
     *
     * @param string $clientId Id клиента
     * @param string $clientSecret Секретный ключ
     */
    public function __construct(string $clientId, string $clientSecret)
    {
        $this->curl = new Curl();
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @param mixed $data Данные
     *
     * @return CommonTokenCodeResponse
     */
    abstract public function getTokenCodeResponse(\stdClass $data): CommonTokenCodeResponse;

    /**
     * Производит запрос и получает данные
     *
     * @param string $code Код от редиректа
     * @param string $redirectUri Страница редиректа. *По факту не используемый параметр для запроса
     *
     * @return CommonTokenCodeResponse|null Ответ сервера
     *
     * @throws
     */
    public function getAuthorizationCode(string $code, string $redirectUri): ?CommonTokenCodeResponse
    {
        $post = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri
        ];

        $request = new Request();
        $request->setUrl($this->getTokenUrl());
        $request->setData($post);
        $request->setMethod(Request::METHOD_POST);

        $response = $this->curl->call($request);
        $data = json_decode($response->getData());
        // var_dump($response);

        if ($response->getHttpCode() !== 200) {
            throw new \Exception('Error during request');
        }

        return $data === null || isset($data->error) ? null : $this->getTokenCodeResponse($data);
    }

    /**
     * @param $refreshToken
     *
     * @return CommonTokenCodeResponse|null
     *
     * @throws
     */
    public function getRefreshTokenCode($refreshToken): ?CommonTokenCodeResponse
    {
        $post = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken
        ];

        $request = new Request();
        $request->setUrl($this->getTokenUrl());
        $request->setData($post);
        $request->setMethod(Request::METHOD_POST);

        $response = $this->curl->call($request);
        $data = json_decode($response->getData());

        return $data === null || isset($data->error) ? null : $this->getTokenCodeResponse($data);
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public abstract function getTokenUrl(): string;
}
