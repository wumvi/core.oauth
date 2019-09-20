<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Vk;

use Core\OAuth\Social\ISocialUser;

/**
 * Модель пользователя VK
 */
class VkUser implements ISocialUser
{
    /** @var string Email пользователя */
    private $email = '';
    private $raw;

    public function __construct(\stdClass $raw)
    {
        $this->raw = $raw;
    }

    /**
     * Устанавливаем Email пользователя
     *
     * @param string $email Email пользователя
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Получаем Email пользователя
     * @return string Email пользователя
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getId(): string
    {
        return $this->raw->id . '';
    }

    public function getFirstName(): string
    {
        return $this->raw->first_name;
    }

    public function getLastName(): string
    {
        return $this->raw->last_name;
    }
}
