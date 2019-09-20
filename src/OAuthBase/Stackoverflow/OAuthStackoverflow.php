<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Stackoverflow;

use Core\OAuth\Exception\OAuthException;
use Core\OAuth\OAuthBase\Common\CommonTokenCodeResponse;
use Core\OAuth\OAuthBase\OAuthBase;
use Core\OAuth\OAuthBase\IOAuthBase;

/**
 * Управление OAuth авторизацией для сайта Stackoverflow
 *
 * @see https://api.stackexchange.com/docs/authentication
 * @see https://stackapps.com/
 */
class OAuthStackoverflow extends OAuthBase implements IOAuthBase
{
    /**
     * @var string
     */
    private $publicKey;

    public function __construct(string $clientId, string $clientSecret, string $publicKey)
    {
        parent::__construct($clientId, $clientSecret);

        $this->publicKey = $publicKey;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * @inheritdoc
     */
    public function getTokenCodeResponse(\stdClass $data): CommonTokenCodeResponse
    {
        if (isset($data->error_message)) {
            throw new OAuthException($data->error_message);
        }
        return new CommonTokenCodeResponse($data);
    }

    public function getTokenUrl(): string
    {
        return 'https://stackoverflow.com/oauth/access_token/json';
    }
}
