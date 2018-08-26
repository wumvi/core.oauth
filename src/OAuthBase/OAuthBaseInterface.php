<?php
declare(strict_types=1);

namespace Core\OAuth\OAuthBase;

interface OAuthBaseInterface
{
    /**
     * @param mixed $data Данные
     *
     * @return TokenCodeResponseInterface
     */
    public function getTokenCodeResponse($data): TokenCodeResponseInterface;

    /**
     * Производит запрос и получает данные
     *
     * @param string $code Код от редиректа
     * @param string $redirectUri Страница редиректа. *По факту не используемый параметр для запроса
     *
     * @return TokenCodeResponseInterface|null Ответ сервера
     *
     * @throws
     */
    public function getAuthorizationCode(string $code, string $redirectUri): ?TokenCodeResponseInterface;

    /**
     * @param $refreshToken
     *
     * @return TokenCodeResponseInterface|null
     *
     * @throws
     */
    public function getRefreshTokenCode($refreshToken): ?TokenCodeResponseInterface;

    public function getClientId(): string;

    public function getClientSecret(): string;
}
