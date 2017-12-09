<?php
declare(strict_types = 1);

namespace Core\OAuth\OAuthBase\Google;

use Core\Model\Read;
use \Core\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * TokenCodeResponse
 * @method string getAccessToken() Получаем AccessToken
 */
class TokenCodeResponse extends Read implements TokenCodeResponseInterface
{
    /** AccessToken Google */
    public const PROP_ACCESS_TOKEN = 'accessToken';
}
