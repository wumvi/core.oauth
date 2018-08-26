<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Vk;

use LightweightCurl\CurlInterface;
use LightweightCurl\Request;

/**
 * Сервис работы с API сайта ВКонтакте
 */
interface VkSocialServiceInterface
{
    /**
     * Получение информацию по пользователю
     * @param string $vkUserId Id пользователя сайта Вконтакте
     * @param string $accessToken AccessToken
     *
     * @see https://vk.com/dev/users.get
     *
     * @return VkUserInterface|null
     */
    public function getUserInfo(string $vkUserId, string $accessToken): ?VkUserInterface;

    public function getLink(string $redirectUrl): string;
}
