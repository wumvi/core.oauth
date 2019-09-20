<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Instagram;

use Core\OAuth\Exception\OAuthException;
use Core\OAuth\OAuthBase\Common\CommonTokenCodeResponse;
use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\IOAuthBase;
use LightweightCurl\Request;

/**
 * Управление OAuth авторизацией для сайта Facebook
 */
class OAuthInstagram extends OAuthBase implements IOAuthBase
{
    /**
     * @inheritdoc
     */
    public function getTokenCodeResponse(\stdClass $data): CommonTokenCodeResponse
    {
        if (isset($data->error_message)) {
            throw new OAuthException($data->error_message, $data->code);
        }
        return new CommonTokenCodeResponse($data);
    }

    public function getTokenUrl(): string
    {
        return 'https://api.instagram.com/oauth/access_token';
    }
}
