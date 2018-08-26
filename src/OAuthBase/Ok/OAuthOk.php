<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Ok;

use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\OAuthBaseInterface;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;
use LightweightCurl\CurlException;
use LightweightCurl\Request;

/**
 * Управление OAuth авторизацией для сайта Однокласники
 */
class OAuthOk extends OAuthBase implements OAuthBaseInterface
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
     * @param Object $dataRaw Сырые данные после запроса access_token от сервера сайта Одноклассники
     *
     * @return TokenCodeResponseInterface Модель токена
     */
    public function getTokenCodeResponse($dataRaw): TokenCodeResponseInterface
    {
        return new TokenCodeResponse($dataRaw->access_token);
    }

    public function getTokenUrl(): string
    {
        return 'https://api.ok.ru/oauth/token.do';
    }

    /**
     * @param string $code
     * @param string $redirectUri
     *
     * @return TokenCodeResponseInterface|null
     * @throws \Exception
     * @throws CurlException
     */
    public function getAuthorizationCode(string $code, string $redirectUri): ?TokenCodeResponseInterface
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

        if ($response->getHttpCode() !== 200) {
            throw new \Exception('Error during request');
        }

        return $data === null || isset($data->error) ? null : $this->getTokenCodeResponse($data);
    }
}
