<?php
declare(strict_types = 1);

namespace Core\OAuth\OAuthBase\Facebook;

use Core\Model\Read;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Модель токена для сайта Facebook
 *
 * @method string getAccessToken()
 */
class TokenCodeResponse extends Read implements TokenCodeResponseInterface
{
    /** Access Токен */
    public const PROP_ACCESS_TOKEN = 'accessToken';
}
