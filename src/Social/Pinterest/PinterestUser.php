<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Pinterest;

use Core\OAuth\Social\ISocialUser;

/**
 * Модель пользователя сайта Facebook
 */
class PinterestUser implements ISocialUser
{
    /** @var \stdClass */
    private $raw;

    public function __construct(\stdClass $raw)
    {
        $this->raw = $raw;
    }

    public function getId(): string
    {
        return $this->raw->data->id;
    }

    public function getFirstName(): string
    {
        return $this->raw->data->first_name;
    }

    public function getLastName(): string
    {
        return $this->raw->data->last_name;
    }

    public function getEmail(): string
    {
        return '';
    }
}
