<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Yandex;

use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Управление OAuth авторизацией для сайта Yandex
 */
class OAuthYandex extends OAuthBase
{
    /**
     * @param Object $data Сырые данные из запроса
     *
     * @return TokenCodeResponseInterface
     */
    protected function getTokenCodeResponse($data): TokenCodeResponseInterface
    {
        return new TokenCodeResponse($data->access_token);
    }
}
