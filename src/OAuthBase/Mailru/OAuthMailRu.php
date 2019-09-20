<?php

namespace Core\OAuth\OAuthBase\MailRu;

use Core\OAuth\Exception\OAuthException;
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
     *
     * @throws
     */
    public function getTokenCodeResponse(\stdClass $data): CommonTokenCodeResponse
    {
        if (isset($data->error)) {
            throw new OAuthException($data->error);
        }
        return new TokenCodeResponse($data);
    }

    public function getTokenUrl(): string
    {
        return 'https://connect.mail.ru/oauth/token';
    }
}
