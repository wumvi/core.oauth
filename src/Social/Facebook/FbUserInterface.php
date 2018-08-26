<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Facebook;

interface FbUserInterface
{
    public function getId(): string;

    public function getFirstName(): string;

    public function getLastName(): string;

    public function getEmail(): string;

    public function getBirthday(): string;

    public function getSex(): string;
}
