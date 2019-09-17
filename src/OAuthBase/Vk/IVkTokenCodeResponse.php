<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Vk;


/**
 * Модель данных от VK, после OAuth авторизации
 */
interface IVkTokenCodeResponse
{
    /**
     * @return int
     */
    public function getUserId(): int;

    /**
     * @return int
     */
    public function getExpiresIn(): int;

    /**
     * @return string
     */
    public function getEmail(): string;
}
