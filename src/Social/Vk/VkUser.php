<?php
declare(strict_types = 1);

namespace Wumvi\Classes\Social\Vk;

use Wumvi\Classes\Read;

/**
 * Модель пользователя VK
 * @method string getBirthday() Получаем День рождения пользователя
 * @method string getId() Получаем ID пользователя
 * @method string getLastName() Получаем фамилия пользователя
 * @method int getSex() Получаем пол пользователя
 * @method string getFirstName() Получаем имя пользователя
 */
class VkUser extends Read
{
    /** Id пользователя */
    const PROP_ID = 'id';

    /** Имя пользователя */
    const PROP_FIRST_NAME = 'firstName';

    /** Фамилия пользователя */
    const PROP_LAST_NAME = 'lastName';

    /** День рождения пользователя */
    const PROP_BIRTHDAY = 'birthday';

    /** Пол пользователя */
    const PROP_SEX = 'sex';

    /** @var string Email пользователя */
    private $email = '';

    /**
     * Устанавливаем Email пользователя
     * @param string $email Email пользователя
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Получаем Email пользователя
     * @return string Email пользователя
     */
    public function getEmail()
    {
        return $this->email;
    }
}
