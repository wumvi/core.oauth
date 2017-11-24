<?php
declare(strict_types = 1);

namespace Wumvi\Classes\OAuth\OAuthBase\Yandex;

use Wumvi\Classes\OAuth\OAuthBase\OAuthBase;
use \Wumvi\Classes\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Управление OAuth авторизацией для сайта Yandex
 */
class OAuthYandex extends OAuthBase
{
    /**
     * @param Object $data Сырые данные из запроса
     * @return TokenCodeResponse
     */
    protected function getTokenCodeResponse($data): TokenCodeResponseInterface
    {
        return new TokenCodeResponse([
            TokenCodeResponse::PROP_ACCESS_TOKEN => $data->access_token
        ]);
    }
}
