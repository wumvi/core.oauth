<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Ok;

use Core\OAuth\Social\ISocialUser;

/**
 * @author Kozlenko Vitaliy
 *
 * @see http://coddism.com/php/oauth_avtorizacija_cherez_odnoklassnikiru
 */
interface IOkSocialService
{
    /**
     * Получаем модель пользователя сайта Одноклассники
     *
     * @param string $authToken AuthToken
     *
     * @return ISocialUser|null
     *
     * @throws
     */
    public function getUserInfo(string $authToken): ?ISocialUser;

    public function getLink(string $redirectUrl, string $oauthId): string;
}
