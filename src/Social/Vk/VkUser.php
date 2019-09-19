<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Vk;

/**
 * Модель пользователя VK
 */
class VkUser
{
    /** @var string Email пользователя */
    private $email = '';

    private $isClosed = true;

    /** @var int */
    private $id;
    private $firstName;
    private $lastName;
    private $birthday;
    private $sex;

    public function __construct(\stdClass $data)
    {
        $this->id = (int)$data->id;
        $this->firstName = $data->first_name;
        $this->lastName = $data->last_name;
        $this->birthday = $data->bdate ?? '';
        $this->sex = $data->sex;
        $this->isClosed = $data->is_closed;
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

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function getSex(): string
    {
        return $this->sex;
    }

    public function isClosed(): bool
    {
        return $this->isClosed;
    }
}
