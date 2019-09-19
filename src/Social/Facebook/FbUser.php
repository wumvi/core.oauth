<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Facebook;

/**
 * Модель пользователя сайта Facebook
 */
class FbUser
{
    /** @var \stdClass */
    private $raw;

    public function __construct(\stdClass $raw)
    {
        $this->raw = $raw;
    }

    public function getId(): int
    {
        return $this->raw->id;
    }

    public function getFirstName(): string
    {
        return $this->raw->first_name;
    }

    public function getLastName(): string
    {
        return $this->raw->last_name;
    }

    public function getEmail(): string
    {
        return $this->raw->email;
    }
}
