<?php
declare(strict_types = 1);

namespace Core\OAuth\Social;

/**
 * Модель пользователя
 */
interface ISocialUser
{
    public function getId(): string;
    public function getEmail(): string;
    public function getFirstName(): string;
    public function getLastName(): string;
}
