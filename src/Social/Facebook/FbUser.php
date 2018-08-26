<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Facebook;

/**
 * Модель пользователя сайта Facebook
 */
class FbUser implements FbUserInterface
{
    /** Id пользователя */
    public const PROP_ID = 'id';

    /** Имя пользователя */
    public const PROP_FIRST_NAME = 'firstName';

    /** Фамилия пользователя */
    public const PROP_LAST_NAME = 'lastName';

    /** Email пользователя */
    public const PROP_EMAIL = 'email';

    /** День рождения пользователя */
    public const PROP_BIRTHDAY = 'birthday';

    /** Пол пользователя */
    public const PROP_SEX = 'sex';

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
