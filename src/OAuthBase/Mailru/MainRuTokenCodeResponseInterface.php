<?php
declare(strict_types=1);


namespace Core\OAuth\OAuthBase\Mailru;


interface MainRuTokenCodeResponseInterface
{
    public function getUserId(): string;
}
