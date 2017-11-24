<?php
declare(strict_types = 1);

namespace Wumvi\Classes\OAuth\OAuthBase\Google;

use Wumvi\Classes\Read;
use \Wumvi\Classes\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * TokenCodeResponse
 * @method string getAccessToken() Получаем AccessToken
 */
class TokenCodeResponse extends Read implements TokenCodeResponseInterface
{
    /** AccessToken Google */
    const PROP_ACCESS_TOKEN = 'accessToken';
}
