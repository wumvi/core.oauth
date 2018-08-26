<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Google;

/**
 * Модель пользователя сайта Google.com
 */
interface GoogleUserInterface
{
    public function getId(): string;

    public function getFirstName(): string;

    public function getLastName(): string;

    public function getEmail(): string;

    public function getSex(): string;
}
