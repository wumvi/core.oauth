<?php
declare(strict_types = 1);

namespace Wumvi\Classes\Social\Yandex;

use Wumvi\Classes\Read;

/**
 * Модель пользователя сайта Яндекс
 * @method string getFirstName() Имя пользователя
 * @method string getEmail() Email Пользователя
 * @method string getId() Id пользователя
 * @method string getLastName() Фамилия пользователя
 * @method string getBirthday() День рождения пользователя
 * @method string getSex() Пол пользователя: female
 */
class YaUser extends Read
{
    /** Имя пользователя */
    const PROP_FIRST_NAME = 'firstName';

    /** Фамилия пользователя */
    const PROP_LAST_NAME = 'lastName';

    /** Email пользователя */
    const PROP_EMAIL = 'email';

    /** Id пользователя */
    const PROP_ID = 'id';

    /** День рождения пользователя */
    const PROP_BIRTHDAY = 'birthday';

    /** Пол пользователя */
    const PROP_SEX = 'sex';
}
