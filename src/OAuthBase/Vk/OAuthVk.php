<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Vk;

use Core\OAuth\Exception\OAuthException;
use Core\OAuth\OAuthBase\Common\CommonTokenCodeResponse;
use Core\OAuth\OAuthBase\OAuthBase;

/**
 * Управление OAuth авторизацией для сайта ВКонтакте
 */
class OAuthVk extends OAuthBase
{
    /**
     * @param \stdClass $data Сырые данные из запроса
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
        return 'https://oauth.vk.com/access_token';
    }
}
