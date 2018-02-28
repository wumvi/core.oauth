<?php

namespace Core\OAuth\OAuthBase\Mailru;

use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Управление OAuth авторизацией для сайта Mail.ru
 */
class OAuthMailRu extends OAuthBase
{
    /**
     * @param mixed $data
     *
     * @return TokenCodeResponseInterface
     */
    protected function getTokenCodeResponse($data): TokenCodeResponseInterface
    {
        return new TokenCodeResponse($data->access_token, $data->x_mailru_vid);
    }

    public function getTokenUrl(): string
    {
        return 'https://connect.mail.ru/oauth/token';
    }
}
