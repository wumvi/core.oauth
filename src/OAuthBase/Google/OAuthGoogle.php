<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Google;

use Core\OAuth\Exception\OAuthException;
use Core\OAuth\OAuthBase\Common\CommonTokenCodeResponse;
use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\IOAuthBase;

class OAuthGoogle extends OAuthBase implements IOAuthBase
{
    /**
     * @param \stdClass $data Сырые данные из запроса
     *
     * @return CommonTokenCodeResponse
     *
     * @throws
     */
    public function getTokenCodeResponse(\stdClass $data): CommonTokenCodeResponse
    {
        if (isset($data->error)) {
            throw new OAuthException($data->error);
        }
        return new CommonTokenCodeResponse($data);
    }

    public function getTokenUrl(): string
    {
        return 'https://accounts.google.com/o/oauth2/token';
    }
}
