<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Yandex;

use Core\OAuth\Social\ISocialUser;

/**
 * Class YandexService
 */
interface IYandexService
{
    /**
     * @param string $authToken
     *
     * @return ISocialUser|null
     *
     * @throws
     */
    public function getUserInfo(string $authToken): ?ISocialUser;

    public function getLink(string $oauthId): string;
}
