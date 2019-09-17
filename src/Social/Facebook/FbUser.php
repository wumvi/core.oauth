<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Facebook;

use Core\OAuth\Social\ISocialUser;

/**
 * Модель пользователя сайта Facebook
 */
class FbUser implements ISocialUser
{
    /** Id пользователя */
    public const PROP_ID = 'id';

    /** Имя пользователя */
    public const PROP_FIRST_NAME = 'firstName';

    /** Фамилия пользователя */
    public const PROP_LAST_NAME = 'lastName';

    /** Email пользователя */
    public const PROP_EMAIL = 'email';

    /**
     * @var int
     */
    private $id;
    private $firstName;
    private $lastName;
    private $email;

    public function __construct(array $raw)
    {
        $this->id = (int)$raw[self::PROP_ID];
        $this->firstName = $raw[self::PROP_FIRST_NAME];
        $this->lastName = $raw[self::PROP_LAST_NAME];
        $this->email = $raw[self::PROP_EMAIL];
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
}
