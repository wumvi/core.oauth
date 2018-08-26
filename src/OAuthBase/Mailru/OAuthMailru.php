<?php

namespace Core\OAuth\OAuthBase\Mailru;

use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\OAuthBaseInterface;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Управление OAuth авторизацией для сайта Mail.ru
 */
class OAuthMailru extends OAuthBase implements OAuthBaseInterface
{
    /**
     * @param mixed $data
     * @return TokenCodeResponseInterface
     */
    public function getTokenCodeResponse($data): TokenCodeResponseInterface
    {
        return new TokenCodeResponse($data->access_token,  $data->x_mailru_vid);
    }
}
