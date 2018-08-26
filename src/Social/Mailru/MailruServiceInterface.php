<?php
declare(strict_types=1);


namespace Core\OAuth\Social\Mailru;


interface MailruServiceInterface
{
    public function getUserInfo($accessToken): ?MailRuUserInterface;
}
