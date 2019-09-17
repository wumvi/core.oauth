<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Mailru;

use Core\OAuth\Social\ISocialUser;

interface IMailruService
{
    public function getUserInfo(string $accessToken, int $userId): ?ISocialUser;
    public function getLink(string $redirectUrl): string;
}
