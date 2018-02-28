<?php
declare(strict_types = 1);

namespace Core\OAuth\OAuthBase\Google;

use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;

class OAuthGoogle extends OAuthBase
{
    /**
     * @param Object $data Сырые данные из запроса
     * @return TokenCodeResponseInterface
     */
    protected function getTokenCodeResponse($data): TokenCodeResponseInterface
    {
        return new TokenCodeResponse($data->access_token);
    }

    public function getTokenUrl(): string
    {
        return 'https://accounts.google.com/o/oauth2/token';
    }
}
