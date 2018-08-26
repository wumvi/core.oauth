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
     *
     * @param int $expiresIn
     * @param string $token
     * @param int $userId
     * @param string $email
     */
    public function __construct(int $expiresIn, string $token, int $userId, string $email)
    {
        $this->token = $token;
        $this->userId = $userId;
        $this->expiresIn = $expiresIn;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->token;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
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
