<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Mailru;

use Core\OAuth\OAuthBase\TokenCodeResponseInterface;

interface MailruServiceInterface
{
    public function getUserInfo(TokenCodeResponseInterface $accessToken): ?MailRuUserInterface;
    public function getLink(string $redirectUrl): string;
}
