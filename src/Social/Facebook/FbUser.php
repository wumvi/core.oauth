<?php
declare(strict_types = 1);

namespace Wumvi\Classes\Social\Facebook;

use Wumvi\Classes\Read;

/**
 * Модель пользователя сайта Facebook
 * @method string getId() ID пользователя
 * @method string getFirstName() Имя пользователя
 * @method string getLastName() Фамилия пользователя
 * @method string getBirthday() День рождения пользователя
 * @method string getSex() Пол, пользователя
 * @method string getEmail() Почта пользователя
 */
class FbUser extends Read
{
    /** Id пользователя */
    const PROP_ID = 'id';

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
}
