<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Vk;

use Core\OAuth\OAuthBase\Common\CommonTokenCodeResponse;
use Core\OAuth\OAuthBase\OAuthBase;

/**
 * Управление OAuth авторизацией для сайта ВКонтакте
 */
class OAuthVk extends OAuthBase
{
    /**
     * @param \stdClass $raw Сырые данные из запроса
     *
     * @return TokenCodeResponse
     */
    public function getTokenCodeResponse(\stdClass $raw): CommonTokenCodeResponse
    {
        return new TokenCodeResponse($raw);
    }

    public function getTokenUrl(): string
    {
        return 'https://oauth.vk.com/access_token';
    }
}
