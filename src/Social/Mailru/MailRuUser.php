<?php
declare(strict_types=1);

namespace Core\OAuth\Social\MailRu;

use Core\OAuth\Social\ISocialUser;

/**
 * Модель пользователя сайта Mail.ru
 */
class MailRuUser implements ISocialUser
{
    private $raw;

    public function __construct(\stdClass $raw)
    {
        $this->raw = $raw;
    }

    public function getId(): string
    {
        return $this->raw->uid;
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
