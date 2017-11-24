<?php
declare(strict_types = 1);

namespace Wumvi\Classes\OAuth\OAuthBase\Ok;

use Wumvi\Classes\Read;
use \Wumvi\Classes\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Модель токена для сайта Одноклассники
 *
 * @method string getAccessToken()
 */
class TokenCodeResponse extends Read implements TokenCodeResponseInterface
{
    /** Access Токен */
    const PROP_ACCESS_TOKEN = 'accessToken';
}
