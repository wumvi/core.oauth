<?php

namespace Core\OAuth\OAuthBase\MailRu;

use Core\OAuth\OAuthBase\Common\CommonTokenCodeResponse;

/**
 * TokenCodeResponse
 */
class TokenCodeResponse extends CommonTokenCodeResponse
{
    public function getAccessToken(): string
    {
        return $this->token;
    }

    public function getUserId(): int
    {
        return (int)$this->raw->x_mailru_vid;
    }
}
