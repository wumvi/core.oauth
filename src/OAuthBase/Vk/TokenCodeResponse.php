<?php
declare(strict_types = 1);

namespace Core\OAuth\OAuthBase\Vk;

use Core\Model\Read;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Модель данных от VK, после OAuth авторизации
 *
 * @method integer getExpiresIn() Через сколько истекёт
 * @method string getAccessToken() AccessTocken VK
 * @method string getUserId() User ID в системе VK
 * @method string getEmail() Email пользователя
 */
class TokenCodeResponse extends Read implements TokenCodeResponseInterface
{
    /** Через сколько истекёт */
    public const PROP_EXPIRES_IN = 'expiresIn';

    /** AccessTocken VK */
    public const PROP_ACCESS_TOKEN = 'accessToken';

    /** User ID в системе VK */
    public const PROP_USER_ID = 'userId';

    /** Email пользователя */
    public const PROP_EMAIL = 'email';
}
