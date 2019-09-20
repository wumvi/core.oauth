<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Ok;

use Core\OAuth\Social\ISocialUser;

/**
 * Модель пользователя сайта Одноклассники
 */
class OkUser implements ISocialUser
{
    /** @var \stdClass */
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

    /**
     * Получаем Email пользователя, если он есть
     * @return string Email пользователя
     */
    public function getEmail(): string
    {
        return $this->raw->has_email ? $this->raw->email : '';
    }
}
