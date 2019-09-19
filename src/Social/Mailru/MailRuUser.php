<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Mailru;

/**
 * Модель пользователя сайта Mail.ru
 */
class MailRuUser
{
    private $raw;

    public function __construct(\stdClass $raw)
    {
        $this->raw = $raw;
    }

    public function getId(): int
    {
        return (int)$this->raw->uid;
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

    public function getBirthday(): string
    {
        return $this->raw->birthday;
    }

    public function getSex(): string
    {
        return $this->raw->sex;
    }
}
