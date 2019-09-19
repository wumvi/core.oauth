<?php

namespace Core\OAuth\OAuthBase\Mailru;

use Core\OAuth\OAuthBase\Common\CommonTokenCodeResponse;
use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\IOAuthBase;

/**
 * Управление OAuth авторизацией для сайта Mail.ru
 */
class OAuthMailRu extends OAuthBase implements IOAuthBase
{
    /**
     * @param mixed $data
     *
     * @return TokenCodeResponse
     */
    public function getTokenCodeResponse(\stdClass $data): CommonTokenCodeResponse
    {
        return new TokenCodeResponse($data);
    }

    public function getTokenUrl(): string
    {
        return 'https://connect.mail.ru/oauth/token';
    }
}
