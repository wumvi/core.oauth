<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Vk;

/**
 * Модель пользователя VK
 */
interface IVkUser
{
    /**
     * Устанавливаем Email пользователя
     *
     * @param string $email Email пользователя
     */
    public function setEmail(string $email): void;
}
