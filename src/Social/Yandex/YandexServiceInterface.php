<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Yandex;

/**
 * Class YandexService
 */
interface YandexServiceInterface
{
    /**
     * @param string $authToken
     *
     * @return YaUserInterface|null
     *
     * @throws
     */
    public function getUserInfo(string $authToken): ?YaUserInterface;

    public function getLink(string $oauthId): string;
}
