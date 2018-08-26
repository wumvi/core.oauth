<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Yandex;

/**
 * Модель пользователя сайта Яндекс
 */
class YaUser implements YaUserInterface
{
    /** Имя пользователя */
    const PROP_FIRST_NAME = 'firstName';

    /** Фамилия пользователя */
    const PROP_LAST_NAME = 'lastName';

    /** Email пользователя */
    const PROP_EMAIL = 'email';

    /** Id пользователя */
    const PROP_ID = 'id';

    /** День рождения пользователя */
    const PROP_BIRTHDAY = 'birthday';

    /** Пол пользователя */
    const PROP_SEX = 'sex';

    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $birthday;
    private $sex;

    public function __construct(array $raw)
    {
        $this->id = $raw[self::PROP_ID];
        $this->firstName = $raw[self::PROP_FIRST_NAME];
        $this->lastName = $raw[self::PROP_LAST_NAME];
        $this->email = $raw[self::PROP_EMAIL];
        $this->birthday = $raw[self::PROP_BIRTHDAY];
        $this->sex = $raw[self::PROP_SEX];
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

    public function getEmail(): string
    {
        return $this->email;
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
