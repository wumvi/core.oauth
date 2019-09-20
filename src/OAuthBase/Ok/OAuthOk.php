<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Ok;

use Core\OAuth\Exception\JsonException;
use Core\OAuth\Exception\OAuthException;
use Core\OAuth\OAuthBase\Common\CommonTokenCodeResponse;
use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\IOAuthBase;
use LightweightCurl\Request;

/**
 * Управление OAuth авторизацией для сайта Однокласники
 */
class OAuthOk extends OAuthBase implements IOAuthBase
{
    /**
     * @var string
     */
    private $publicKey;

    public function __construct(string $clientId, string $clientSecret, string $publicKey)
    {
        parent::__construct($clientId, $clientSecret);

        $this->publicKey = $publicKey;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * Получение модели TokenCodeResponse по данным с сервера сайта Однокласники
     *
     * @see https://apiok.ru/wiki/pages/viewpage.action?pageId=81822109
     *
     * @param \stdClass $data Сырые данные после запроса access_token от сервера сайта Одноклассники
     *
     * @return CommonTokenCodeResponse Модель токена
     *
     * @throws
     */
    public function getTokenCodeResponse(\stdClass $data): CommonTokenCodeResponse
    {
        if (isset($data->error)) {
            throw new OAuthException($data->error);
        }
        return new CommonTokenCodeResponse($data);
    }

    public function getTokenUrl(): string
    {
        return 'https://api.ok.ru/oauth/token.do';
    }

    /**
     * @param string $code
     * @param string $redirectUri
     *
     * @return CommonTokenCodeResponse
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
        $url = $this->getTokenUrl() . '?' . http_build_query($post);
        $request->setUrl($url);
        $request->setMethod(Request::METHOD_POST);
        $response = $this->curl->call($request);
        $data = json_decode($response->getData());
        if (empty($data)) {
            throw new JsonException('Wrong Authorization Code json', JsonException::WRONG_JSON_CODE);
        }

        return $this->getTokenCodeResponse($data);
    }
}
