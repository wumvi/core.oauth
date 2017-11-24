<?php
declare(strict_types = 1);

namespace Wumvi\Classes\OAuth\OAuthBase\Yandex;

use Wumvi\Classes\Read;
use \Wumvi\Classes\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Модель Token сайта Яндекс
 * @method string getAccessToken() Получаем AccessToken
 */
class TokenCodeResponse extends Read implements TokenCodeResponseInterface
{
    /** AccessToken */
    const PROP_ACCESS_TOKEN = 'accessToken';
}
