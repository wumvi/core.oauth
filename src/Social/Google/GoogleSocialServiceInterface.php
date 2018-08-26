<?php
declare(strict_types=1);


namespace Core\OAuth\Social\Google;


interface GoogleSocialServiceInterface
{
    public function getUserInfo(string $accessToken): ?GoogleUserInterface;
}
