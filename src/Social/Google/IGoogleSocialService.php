<?php
declare(strict_types=1);


namespace Core\OAuth\Social\Google;


use Core\OAuth\Social\ISocialUser;

interface IGoogleSocialService
{
    public function getUserInfo(string $accessToken): ?ISocialUser;
    public function getLink(string $redirectUri, string $oauthId): string;
}
