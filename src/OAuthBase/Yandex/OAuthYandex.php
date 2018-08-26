<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Yandex;

use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\OAuthBaseInterface;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Управление OAuth авторизацией для сайта Yandex
 */
class OAuthYandex extends OAuthBase implements OAuthBaseInterface
{
    /**
     * @param Object $data Сырые данные из запроса
     *
     * @return TokenCodeResponseInterface
     */
    public function getTokenCodeResponse($data): TokenCodeResponseInterface
    {
        return new TokenCodeResponse($data->access_token);
    }
}
