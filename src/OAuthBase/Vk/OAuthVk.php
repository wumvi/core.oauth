<?php
declare(strict_types = 1);

namespace Core\OAuth\OAuthBase\Vk;

use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\OAuthBaseInterface;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Управление OAuth авторизацией для сайта ВКонтакте
 */
class OAuthVk extends OAuthBase implements OAuthBaseInterface
{
    /**
     * @param Object $data Сырые данные из запроса
     * @return TokenCodeResponseInterface
     */
    public function getTokenCodeResponse($data): TokenCodeResponseInterface
    {
        return new TokenCodeResponse(
            $data->expires_in,
            $data->access_token,
            $data->user_id,
            $data->email
        );
    }
}
