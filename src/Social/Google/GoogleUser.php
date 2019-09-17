<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Google;

use Core\OAuth\Social\ISocialUser;

/**
 * Модель пользователя сайта Google.com
 */
class GoogleUser implements ISocialUser
{
    /** Id пользователя */
    const PROP_ID = 'id';

    /** Email пользователя */
    const PROP_EMAIL = 'email';

    /** Имя пользователя */
    const PROP_FIRST_NAME = 'firstName';

    /** Фамилия пользователя */
    const PROP_LAST_NAME = 'lastName';

    /** Пол пользователя */
    const PROP_SEX = 'sex';

    /**
     * @var int
     */
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $sex;

    public function __construct(array $raw)
    {
        $this->id = (int)$raw[self::PROP_ID];
        $this->firstName = $raw[self::PROP_FIRST_NAME];
        $this->lastName = $raw[self::PROP_LAST_NAME];
        $this->email = $raw[self::PROP_EMAIL];
        $this->sex = $raw[self::PROP_SEX];
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSex(): string
    {
        return $this->sex;
    }
}
