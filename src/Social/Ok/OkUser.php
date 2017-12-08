<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Ok;

use Core\Model\Read;

/**
 * Модель пользователя сайта Одноклассники
 * @method string getId() ID пользователя
 * @method string getFirstName() Имя пользователя
 * @method string getLastName() Фамилия пользователя
 * @method string getBirthday() День рождения пользователя
 * @method string getSex() Пол пользователя
 */
class OkUser extends Read
{
    /** Id пользователя */
    const PROP_ID = 'id';

    /** Имеет ли он почту */
    const PROP_HAS_EMAIL = 'hasEmail';

    /** Имя пользователя */
    const PROP_FIRST_NAME = 'firstName';

    /** Фамилия пользователя */
    const PROP_LAST_NAME = 'lastName';

    /** Email пользователя */
    const PROP_EMAIL = 'email';

    /** День рождения пользователя */
    const PROP_BIRTHDAY = 'birthday';

    /** Пол пользователя */
    const PROP_SEX = 'sex';

    /**
     * Получаем Email пользователя, если он есть
     * @return string|null Email пользователя
     */
    public function getEmail()
    {
        return $this->list[self::PROP_HAS_EMAIL] ? $this->list[self::PROP_EMAIL] : null;
    }
}
