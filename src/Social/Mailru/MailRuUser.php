<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Mailru;

use Core\Model\Read;

/**
 * Модель пользователя сайта Mail.ru
 * @method string getBirthday() Получаем День рождения пользователя
 * @method string getEmail() Получаем Email пользователя
 * @method int getId() Получаем ID пользователя
 * @method string getLastName() Получаем фамилия пользователя
 * @method int getSex() Получаем пол пользователя
 * @method string getFirstName() Получаем имя пользователя
 */
class MailRuUser extends Read
{
    /** День рождения пользователя */
    const PROP_BIRTHDAY = 'birthday';

    /** Почта пользователя */
    const PROP_EMAIL  = 'email';

    /** ID пользователя */
    const PROP_UID  = 'id';

    /** Фамилия пользователя */
    const PROP_LAST_NAME  = 'lastName';

    /** Пол пользователя */
    const PROP_SEX  = 'sex';

    /** Имя пользователя */
    const PROP_FIRST_NAME  = 'firstName';
}
