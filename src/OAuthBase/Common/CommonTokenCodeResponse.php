<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase\Common;

abstract class CommonTokenCodeResponse
{
    /**
     * @var string
     */
    protected $token;

    /** @var \stdClass */
    protected $raw;

    /**
     * TokenCodeResponse constructor.
     *
     * @param \stdClass $raw
     */
    public function __construct(\stdClass $raw)
    {
        $this->raw = $raw;
        $this->token = $raw->access_token;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->token;
    }
}
