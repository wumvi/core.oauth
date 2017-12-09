<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Facebook;

use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;
use LightweightCurl\Request;

/**
 * Управление OAuth авторизацией для сайта Facebook
 */
class OAuthFacebook extends OAuthBase
{
    /**
     * @inheritdoc
     */
    protected function getTokenCodeResponse($data): TokenCodeResponseInterface
    {
        // Dummy method. Only for override method
    }

    /**
     * @param string $code Код от редиректа
     * @param string $redirectUri Страница редиректа. *По факту не используемый параметр для запроса
     * @return TokenCodeResponseInterface|null Ответ сервера
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

        parse_str($response->getData(), $arr);
        if (!isset($arr['access_token'])) {
            return null;
        }

        return new TokenCodeResponse([TokenCodeResponse::PROP_ACCESS_TOKEN => $arr['access_token']]);
    }
}
