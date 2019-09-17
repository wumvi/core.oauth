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
     * @var int
     */
    private $userId;

    /**
     * TokenCodeResponse constructor.
     *
     * @param string $token
     * @param int $userId
     */
    public function __construct(string $token, int $userId)
    {
        $this->token = $token;
        $this->userId = $userId;
    }

    public function getAccessToken(): string
    {
        return $this->token;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
