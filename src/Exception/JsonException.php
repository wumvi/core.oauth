<?php

namespace Core\OAuth\Exception;

class JsonException extends OAuthException
{
    public const WRONG_JSON_CODE = 1;
    public const UNSUPPORTED_FORMAT = 2;
}
