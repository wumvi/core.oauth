<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase;

use Core\OAuth\Exception\JsonException;
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
     *
     * @throws
     */
    abstract public function getTokenCodeResponse(\stdClass $data): CommonTokenCodeResponse;

    /**
     * Производит запрос и получает данные
     *
     * @param string $code Код от редиректа
     * @param string $redirectUri Страница редиректа. *По факту не используемый параметр для запроса
     *
     * @return CommonTokenCodeResponse Ответ сервера
     *
     * @throws
     */
    public function getAuthorizationCode(string $code, string $redirectUri): CommonTokenCodeResponse
    {
        $post = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri
        ];

        $request = new Request();
        $request->setTimeout(25);
        $request->setUrl($this->getTokenUrl());
        $request->setData($post);
        $request->setMethod(Request::METHOD_POST);
        $request->addHeader('Accept', 'application/json');

        $response = $this->curl->call($request);
        $data = json_decode($response->getData());
        if (empty($data)) {
            throw new JsonException('Wrong Authorization Code json', JsonException::WRONG_JSON_CODE);
        }

        return $this->getTokenCodeResponse($data);
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public abstract function getTokenUrl(): string;
}
