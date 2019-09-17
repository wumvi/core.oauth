<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Vk;

use Core\OAuth\Social\ISocialUser;

/**
 * Сервис работы с API сайта ВКонтакте
 */
interface IVkSocialService
{
    /**
     * Получение информацию по пользователю
     * @param int $userId Id пользователя сайта Вконтакте
     * @param string $accessToken AccessToken
     *
     * @see https://vk.com/dev/users.get
     *
     * @return ISocialUser|null
     */
    public function getUserInfo(int $userId, string $accessToken): ?ISocialUser;

    public function getLink(string $redirectUrl, string $scope): string;
}
