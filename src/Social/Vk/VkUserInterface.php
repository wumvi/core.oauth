<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Vk;

/**
 * Модель пользователя VK
 */
interface VkUserInterface
{
    /**
     * Устанавливаем Email пользователя
     * @param string $email Email пользователя
     */
    public function setEmail(string $email): void;

    /**
     * Получаем Email пользователя
     * @return string Email пользователя
     */
    public function getEmail(): string;

    public function getId(): string;

    public function getFirstName(): string;

    public function getLastName(): string;

    public function getBirthday(): string;

    public function getSex(): string;
}
