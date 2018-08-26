<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Vk;

/**
 * Модель пользователя VK
 */
class VkUser implements VkUserInterface
{
    /** Id пользователя */
    const PROP_ID = 'id';

    /** Имя пользователя */
    const PROP_FIRST_NAME = 'firstName';

    /** Фамилия пользователя */
    const PROP_LAST_NAME = 'lastName';

    /** День рождения пользователя */
    const PROP_BIRTHDAY = 'birthday';

    /** Пол пользователя */
    const PROP_SEX = 'sex';

    /** @var string Email пользователя */
    private $email = '';
    private $id;
    private $firstName;
    private $lastName;
    private $birthday;
    private $sex;

    public function __construct(array $raw)
    {
        $this->id = $raw[self::PROP_ID];
        $this->firstName = $raw[self::PROP_FIRST_NAME];
        $this->lastName = $raw[self::PROP_LAST_NAME];
        $this->birthday = $raw[self::PROP_BIRTHDAY];
        $this->sex = $raw[self::PROP_SEX];
    }

    /**
     * Устанавливаем Email пользователя
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
}
