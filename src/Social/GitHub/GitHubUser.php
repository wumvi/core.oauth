<?php
declare(strict_types=1);

namespace Core\OAuth\Social\GitHub;

use Core\OAuth\Social\ISocialUser;

/**
 * Модель пользователя сайта Google.com
 */
class GitHubUser implements ISocialUser
{
    private $raw;

    public function __construct(\stdClass $raw)
    {
        $this->raw = $raw;
    }

    public function getId(): string
    {
        return $this->raw->id . '';
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
