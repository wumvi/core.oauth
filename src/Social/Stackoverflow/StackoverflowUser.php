<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Stackoverflow;

/**
 * Модель пользователя сайта Facebook
 */
class StackoverflowUser
{
    /** @var \stdClass */
    private $raw;

    public function __construct(\stdClass $raw)
    {
        $this->raw = $raw;
    }

    public function getId(): int
    {
        return $this->raw->user_id;
    }

    public function getDisplayName(): string
    {
        return $this->raw->display_name;
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
}
