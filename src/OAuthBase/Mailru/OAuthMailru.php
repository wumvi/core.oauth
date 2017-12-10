<?php

namespace Core\OAuth\OAuthBase\Mailru;

use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Управление OAuth авторизацией для сайта Mail.ru
 */
class OAuthMailru extends OAuthBase
{
    /**
     * @param mixed $data
     * @return TokenCodeResponseInterface
     */
    protected function getTokenCodeResponse($data): TokenCodeResponseInterface
    {
        return new TokenCodeResponse($data->access_token,  $data->x_mailru_vid);
    }
}
