<?php

namespace Core\OAuth\OAuthBase\Mailru;

use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\OAuthBaseInterface;
use Core\OAuth\OAuthBase\Common\TokenCodeResponseInterface;

/**
 * Управление OAuth авторизацией для сайта Mail.ru
 */
class OAuthMailru extends OAuthBase implements OAuthBaseInterface
{
    /**
     * @param mixed $data
     *
     * @return TokenCodeResponseInterface
     */
    public function getTokenCodeResponse($data): TokenCodeResponseInterface
    {
        return new TokenCodeResponse($data->access_token, (int)$data->x_mailru_vid);
    }

    public function getTokenUrl(): string
    {
        return 'https://connect.mail.ru/oauth/token';
    }
}
