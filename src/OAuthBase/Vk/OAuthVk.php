<?php
declare(strict_types = 1);

namespace Core\OAuth\OAuthBase\Vk;

use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Управление OAuth авторизацией для сайта ВКонтакте
 */
class OAuthVk extends OAuthBase
{
    /**
     * @param Object $data Сырые данные из запроса
     * @return TokenCodeResponseInterface
     */
    protected function getTokenCodeResponse($data): TokenCodeResponseInterface
    {
        return new TokenCodeResponse([
            TokenCodeResponse::PROP_EXPIRES_IN => $data->expires_in,
            TokenCodeResponse::PROP_ACCESS_TOKEN => $data->access_token,
            TokenCodeResponse::PROP_USER_ID => $data->user_id,
            TokenCodeResponse::PROP_EMAIL => $data->email,
        ]);
    }
}
