<?php
declare(strict_types = 1);

namespace Wumvi\Classes\OAuth\OAuthBase\Ok;

use Wumvi\Classes\OAuth\OAuthBase\OAuthBase;
use \Wumvi\Classes\OAuth\OAuthBase\TokenCodeResponseInterface;

/**
 * Управление OAuth авторизацией для сайта Однокласники
 */
class OAuthOk extends OAuthBase
{
    /**
     * Получение модели TokenCodeResponse по данным с сервера сайта Однокласники
     * @see https://apiok.ru/wiki/pages/viewpage.action?pageId=81822109
     * @param Object $dataRaw Сырые данные после запроса access_token от сервера сайта Одноклассники
     * @return TokenCodeResponseInterface Модель токена
     */
    protected function getTokenCodeResponse($dataRaw): TokenCodeResponseInterface
    {
        return new TokenCodeResponse([
            TokenCodeResponse::PROP_ACCESS_TOKEN => $dataRaw->access_token,
        ]);
    }
}
