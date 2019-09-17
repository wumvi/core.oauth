<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Facebook;

use Core\OAuth\Social\ISocialUser;

interface IFbSocialService
{
    /**
     * Возвращает модель пользователя сайта Facebook
     *
     * @param string $authToken Токен после авторизации
     *
     * @return ISocialUser|null Модель пользователя
     *
     * @see https://developers.facebook.com/docs/graph-api/reference/user
     */
    public function getUserInfo(string $authToken): ?ISocialUser;
    public function getLink(string $redirectUrl, string $oauthId): string;
}
