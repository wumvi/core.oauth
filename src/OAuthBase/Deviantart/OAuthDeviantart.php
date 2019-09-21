<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Deviantart;

use Core\OAuth\Exception\OAuthException;
use Core\OAuth\OAuthBase\Common\CommonTokenCodeResponse;
use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\IOAuthBase;

/**
 * Управление OAuth авторизацией для сайта Facebook
 */
class OAuthDeviantart extends OAuthBase implements IOAuthBase
{
    /**
     * @inheritdoc
     */
    public function getTokenCodeResponse(\stdClass $data): CommonTokenCodeResponse
    {
        if (isset($data->error)) {
            throw new OAuthException($data->error, $data->status);
        }
        return new CommonTokenCodeResponse($data);
    }

    public function getTokenUrl(): string
    {
        return 'https://www.deviantart.com/oauth2/token';
    }
}
