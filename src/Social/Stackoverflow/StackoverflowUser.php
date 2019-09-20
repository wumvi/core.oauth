<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Stackoverflow;

use Core\OAuth\Social\ISocialUser;

/**
 * Модель пользователя сайта Facebook
 */
class StackoverflowUser implements ISocialUser
{
    /** @var \stdClass */
    private $raw;

    public function __construct(\stdClass $raw)
    {
        $this->raw = $raw;
    }

    public function getId(): string
    {
        return $this->raw->user_id . '';
    }

    public function getFirstName(): string
    {
        $data = explode(' ', $this->raw->display_name);
        [$firstName, $lastName] = count($data) >= 2 ? $data : [$data[0]];

        return $firstName;
    }

    public function getLastName(): string
    {
        $data = explode(' ', $this->raw->display_name);
        [$firstName, $lastName] = count($data) >= 2 ? $data : [$data[0]];

        return $lastName;
    }

    public function getEmail(): string
    {
        return '';
    }
}
