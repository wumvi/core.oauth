<?php
declare(strict_types = 1);

namespace Core\OAuth\OAuthBase\Common;

/**
 * Interface TokenCodeResponse
 */
interface TokenCodeResponseInterface
{
    /**
     * Получаем Token доступа
     * @return string Token доступа
     */
    public function getAccessToken(): string;
}
