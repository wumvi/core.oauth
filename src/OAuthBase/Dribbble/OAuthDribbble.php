<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Dribbble;

use Core\OAuth\Exception\OAuthException;
use Core\OAuth\OAuthBase\Common\CommonTokenCodeResponse;
use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\IOAuthBase;

/**
 * Управление OAuth авторизацией для сайта Facebook
 */
class OAuthDribbble extends OAuthBase implements IOAuthBase
{
    /**
     * @inheritdoc
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
        return 'https://dribbble.com/oauth/token';
    }
}
