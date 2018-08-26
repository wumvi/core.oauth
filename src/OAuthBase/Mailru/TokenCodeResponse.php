<?php

namespace Core\OAuth\OAuthBase\Mailru;

use Core\OAuth\OAuthBase\Common\TokenCodeResponseInterface;

/**
 * TokenCodeResponse
 */
class TokenCodeResponse implements TokenCodeResponseInterface, MainRuTokenCodeResponseInterface
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $userId;

    /**
     * TokenCodeResponse constructor.
     *
     * @param string $token
     * @param string $userId
     */
    public function __construct(string $token, string $userId)
    {
        $this->token = $token;
        $this->userId = $userId;
    }

    public function getAccessToken(): string
    {
        return $this->token;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
