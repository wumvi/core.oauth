<?php
declare(strict_types=1);

namespace Wumvi\Classes\Social\Facebook;

use Wumvi\Classes\CurlExt;
use Wumvi\Classes\Utils\ArrayHelp;

/**
 * Сервис для Facebook
 * @author Kozlenko Vitaliy
 * @see https://developers.facebook.com/tools/explorer?method=GET&path=me%3Ffields%3Dwebsite%2Cbirthday&version=v2.6
 */
class FbSocialService
{
    /**
     * @var CurlExt Расширенный curl
     */
    protected $curl;

    /**
     * @var string Id приложения
     */
    private $appId;

    /**
     * @var string Приватный ключ
     */
    private $privateKey;

    /**
     * FbSocialService constructor.
     * @param string $appId ID приложения
     * @param string $privateKey Приватный ключ
     */
    public function __construct(string $appId, string $privateKey)
    {
        $this->curl = new CurlExt();
        $this->appId = $appId;
        $this->privateKey = $privateKey;
    }

    /**
     * Возвращает модель пользователя сайта Facebook
     *
     * @param string $authToken Токен после авторизации
     *
     * @return FbUser|null Модель пользователя
     *
     * @see https://developers.facebook.com/docs/graph-api/reference/user
     */
    public function getUserInfo(string $authToken): ?FbUser
    {
        $data = $this->curl->get('https://graph.facebook.com/me?fields=birthday,website,email,first_name,' .
            'last_name,gender&access_token=' . $authToken);
        $data = @json_decode($data);
        if (!$data) {
            return null;
        }

        return new FbUser([
            FbUser::PROP_SEX => $data->gender,
            FbUser::PROP_ID => $data->id,
            FbUser::PROP_LAST_NAME => $data->last_name,
            FbUser::PROP_FIRST_NAME => $data->first_name,
            FbUser::PROP_EMAIL => $data->email
        ]);
    }
}
