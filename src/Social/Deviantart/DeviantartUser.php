<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Deviantart;

use Core\OAuth\Social\ISocialUser;

/**
 * Модель пользователя сайта Facebook
 */
class DeviantartUser implements ISocialUser
{
    /** @var \stdClass */
    private $raw;

    public function __construct(\stdClass $raw)
    {
        $this->raw = $raw;
    }

    public function getId(): string
    {
        return $this->raw->userid;
    }

    public function getFirstName(): string
    {
        return '';
    }

    public function getLastName(): string
    {
        return '';
    }

    public function getEmail(): string
    {
        return '';
    }
}
