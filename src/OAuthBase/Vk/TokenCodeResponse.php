<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Vk;

use Core\OAuth\OAuthBase\Common\CommonTokenCodeResponse;

/**
 * Модель данных от VK, после OAuth авторизации
 */
class TokenCodeResponse extends CommonTokenCodeResponse
{
    /**
     * @return int
     */
    public function getUserId(): int
    {
        return (int)$this->raw->user_id;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->raw->expires_in;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->raw->email ?? '';
    }
}
