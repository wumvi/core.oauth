<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Vk;

use Core\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Модель данных от VK, после OAuth авторизации
 */
class TokenCodeResponse implements TokenCodeResponseInterface
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
     * @var string
     */
    private $expiresIn;

    /**
     * @var string
     */
    private $email;

    /**
     * TokenCodeResponse constructor.
     * @param string $expiresIn
     * @param string $token
     * @param string $userId
     * @param string $email
     */
    public function __construct(string $expiresIn, string $token, string $userId, string $email)
    {
        $this->token = $token;
        $this->userId = $userId;
        $this->expiresIn = $expiresIn;
        $this->email = $email;
    }

    public function getAccessToken(): string
    {
        return $this->token;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getExpiresIn(): string
    {
        return $this->expiresIn;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
