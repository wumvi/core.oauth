<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Instagram;

use Core\OAuth\Social\ISocialUser;

/**
 * Модель пользователя сайта Google.com
 */
class InstagramUser implements ISocialUser
{
    private $raw;
    private $firstName;
    private $lastName;
    // private $middleName;

    public function __construct(\stdClass $raw)
    {
        $this->raw = $raw;

        $data = explode(' ', $this->raw->user->full_name);
        $data[] = '';
        $data[] = '';
        [$firstName, $middleName, $lastName] = $data;

        $this->firstName = $firstName;
        // $this->middleName = empty($lastName) ? '' : $middleName;
        $this->lastName = empty($lastName) ? $middleName : $lastName;
    }

    public function getId(): string
    {
        return $this->raw->user->id;
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
        return '';
    }
}
