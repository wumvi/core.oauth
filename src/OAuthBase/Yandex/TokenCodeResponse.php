<?php
declare(strict_types = 1);

namespace Core\OAuth\OAuthBase\Yandex;

use Core\Model\Read;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Модель Token сайта Яндекс
 * @method string getAccessToken() Получаем AccessToken
 */
class TokenCodeResponse extends Read implements TokenCodeResponseInterface
{
    /** AccessToken */
    public const PROP_ACCESS_TOKEN = 'accessToken';
}
