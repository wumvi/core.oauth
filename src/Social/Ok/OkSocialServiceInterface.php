<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Ok;

/**
 * @author Kozlenko Vitaliy
 *
 * @see http://coddism.com/php/oauth_avtorizacija_cherez_odnoklassnikiru
 */
interface OkSocialServiceInterface
{
    /**
     * Получаем модель пользователя сайта Одноклассники
     *
     * @param string $authToken AuthToken
     *
     * @return OkUserInterface|null
     *
     * @throws
     */
    public function getUserInfo(string $authToken): ?OkUserInterface;
}
