<?php
declare(strict_types = 1);

namespace Wumvi\Classes\OAuth\OAuthBase\Facebook;

use Wumvi\Classes\OAuth\OAuthBase\OAuthBase;
use \Wumvi\Classes\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Управление OAuth авторизацией для сайта Facebook
 */
class OAuthFacebook extends OAuthBase
{
    const USER_DB_OAUTH_KEY = 'facebook';

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
        $data = $this->curl->post($this->tokenUrl, [
            'client_id' => $this->siteId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri
        ]);

        @parse_str($data, $arr);
        if (!isset($arr['access_token'])) {
            return null;
        }

        return new TokenCodeResponse([TokenCodeResponse::PROP_ACCESS_TOKEN => $arr['access_token']]);
    }
}
