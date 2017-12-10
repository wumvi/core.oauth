<?php
declare(strict_types = 1);

namespace Core\OAuth\OAuthBase\Google;

use Core\Model\Read;
use \Core\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * TokenCodeResponse
 */
class TokenCodeResponse implements TokenCodeResponseInterface
{
    /**
     * @var string
     */
    private $token;

    /**
     * TokenCodeResponse constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getAccessToken(): string
    {
        return $this->token;
    }
}
