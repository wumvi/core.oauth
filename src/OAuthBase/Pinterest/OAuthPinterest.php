<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Pinterest;

use Core\OAuth\Exception\OAuthException;
use Core\OAuth\OAuthBase\Common\CommonTokenCodeResponse;
use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\IOAuthBase;

/**
 * Управление OAuth авторизацией для сайта Facebook
 */
class OAuthPinterest extends OAuthBase implements IOAuthBase
{
    /**
     * @inheritdoc
     */
    public function getTokenCodeResponse(\stdClass $data): CommonTokenCodeResponse
    {
        if (isset($data->message)) {
            throw new OAuthException($data->message);
        }
        return new CommonTokenCodeResponse($data);
    }

    public function getTokenUrl(): string
    {
        return 'https://api.pinterest.com/v1/oauth/token';
    }
}
