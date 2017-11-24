<?php

namespace Wumvi\Classes\OAuth\OAuthBase\Mailru;

use Wumvi\Classes\OAuth\OAuthBase\OAuthBase;
use \Wumvi\Classes\OAuth\OAuthBase\TokenCodeResponseInterface;

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
        return new TokenCodeResponse([
            TokenCodeResponse::PROP_ACCESS_TOKEN => $data->access_token,
            TokenCodeResponse::PROP_USER_ID => $data->x_mailru_vid,
        ]);
    }
}
