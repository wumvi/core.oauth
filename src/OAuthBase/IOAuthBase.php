<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase;

use Core\OAuth\OAuthBase\Common\CommonTokenCodeResponse;

interface IOAuthBase
{
    /**
     * @param mixed $data Данные
     *
     * @return CommonTokenCodeResponse
     */
    public function getTokenCodeResponse(\stdClass $data): CommonTokenCodeResponse;

    /**
     * Производит запрос и получает данные
     *
     * @param string $code Код от редиректа
     * @param string $redirectUri Страница редиректа. *По факту не используемый параметр для запроса
     *
     * @return CommonTokenCodeResponse|null Ответ сервера
     *
     * @throws
     */
    public function getAuthorizationCode(string $code, string $redirectUri): CommonTokenCodeResponse;

//    /**
//     * @param $refreshToken
//     *
//     * @return CommonTokenCodeResponse|null
//     *
//     * @throws
//     */
//    public function getRefreshTokenCode($refreshToken): ?CommonTokenCodeResponse;

    public function getClientId(): string;

    public function getClientSecret(): string;
}
