<?php
declare(strict_types = 1);

namespace Core\OAuth\OAuthBase\Yandex;

use Core\Model\Read;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Модель Token сайта Яндекс
 */
class TokenCodeResponse implements TokenCodeResponseInterface
{
    /** AccessToken */
    public const PROP_ACCESS_TOKEN = 'accessToken';

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
