<?php

namespace Core\OAuth\OAuthBase\Mailru;

use Core\Model\Read;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * TokenCodeResponse
 *
 * @method string getAccessToken() AccessToken
 * @method string getUserId() Id пользователя
 */
class TokenCodeResponse extends Read implements TokenCodeResponseInterface
{
    /** AccessTocken VK */
    const PROP_ACCESS_TOKEN = 'accessToken';

    /** User ID в системе VK */
    const PROP_USER_ID = 'userId';
}
