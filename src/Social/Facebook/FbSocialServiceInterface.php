<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Facebook;

interface FbSocialServiceInterface
{
    /**
     * Возвращает модель пользователя сайта Facebook
     *
     * @param string $authToken Токен после авторизации
     *
     * @return FbUserInterface|null Модель пользователя
     *
     * @see https://developers.facebook.com/docs/graph-api/reference/user
     */
    public function getUserInfo(string $authToken): ?FbUserInterface;
    public function getLink(string $redirectUrl): string;
}
