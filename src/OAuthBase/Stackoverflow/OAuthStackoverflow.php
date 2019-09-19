<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Stackoverflow;

use Core\OAuth\OAuthBase\Common\CommonTokenCodeResponse;
use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\IOAuthBase;
use LightweightCurl\Request;

/**
 * Управление OAuth авторизацией для сайта Stackoverflow
 *
 * @see https://api.stackexchange.com/docs/authentication
 * @see https://stackapps.com/
 */
class OAuthStackoverflow extends OAuthBase implements IOAuthBase
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
     * @inheritdoc
     */
    public function getTokenCodeResponse(\stdClass $data): CommonTokenCodeResponse
    {
        // Dummy method. Only for override method
    }

    /**
     * @param string $code Код от редиректа
     * @param string $redirectUri Страница редиректа. *По факту не используемый параметр для запроса
     * @return TokenCodeResponse|null Ответ сервера
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
        if (!isset($data->access_token)) {
            return null;
        }

        return new TokenCodeResponse($data);
    }

    public function getTokenUrl(): string
    {
        return 'https://stackoverflow.com/oauth/access_token/json';
    }
}
