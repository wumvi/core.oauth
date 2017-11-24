<?php
declare(strict_types = 1);

namespace Wumvi\Classes\Social\Google;

use Wumvi\Classes\Read;

/**
 * Модель пользователя сайта Google.com
 * @method string getId() Id пользователя
 * @method string getEmail() Email пользователя
 * @method string getFirstName() Имя пользователя
 * @method string getLastName() Фамилия пользователя
 * @method string getSex() Пол пользователя
 */
class GoogleUser extends Read
{
    /** Id пользователя */
    const PROP_ID = 'id';

    /** Email пользователя */
    const PROP_EMAIL = 'email';

    /** Имя пользователя */
    const PROP_FIRST_NAME = 'firstName';

    /** Фамилия пользователя */
    const PROP_LAST_NAME = 'lastName';

    /** Пол пользователя */
    const PROP_SEX = 'sex';
}
