<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Mailru;

interface MailruServiceInterface
{
    public function getUserInfo(string $accessToken, string $userId): ?MailRuUserInterface;
    public function getLink(string $redirectUrl): string;
}
