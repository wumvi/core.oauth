<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Google;

use Core\OAuth\Social\ISocialUser;

/**
 * Модель пользователя сайта Google.com
 */
class GoogleUser implements ISocialUser
{
    private $raw;

    public function __construct(\stdClass $raw)
    {
        $this->raw = $raw;
    }

    public function getId(): string
    {
        return $this->raw->id;
    }

    public function getFirstName(): string
    {
        return $this->raw->given_name;
    }

    public function getLastName(): string
    {
        return $this->raw->family_name;
    }

    public function getEmail(): string
    {
        return $this->raw->email;
    }
}
