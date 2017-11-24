<?php
declare(strict_types = 1);

namespace Wumvi\Classes\Social\Vk;

use Wumvi\Classes\CurlExt;

/**
 * Сервис работы с API сайта ВКонтакте
 */
class VkSocialService
{
    const URL_API = 'https://api.vk.com/method/';

    /** @var CurlExt Расширенный curl */
    protected $curl;

    /** @var string ID сайта */
    protected $siteId;

    /** @var string Секретный ключ */
    protected $clientSecret;

    /**
     * VkSocialService constructor.
     * @param string $siteId ID сайта
     * @param string $clientSecret Секретный ключ
     */
    public function __construct(string $siteId, string $clientSecret)
    {
        $this->curl = new CurlExt();
        $this->siteId = $siteId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * Получение информацию по пользователю
     * @param string $vkUserId Id пользователя сайта Вконтакте
     * @param string $accessToken AccessToken
     * @see https://vk.com/dev/users.get
     * @return VkUser|null
     */
    public function getUserInfo(string $vkUserId, string $accessToken): ?VkUser
    {
        //
        $params = [
            'user_id' => $vkUserId,
            'vk' => '5.8',
            'access_token' => $accessToken,
            'fields' => 'sex,bdate',
        ];

        $url = self::URL_API . 'users.get';
        $data = $this->curl->get($url, $params);
        $data = @json_decode($data);

        if (!isset($data->response) || !$data->response || count($data->response) == 0) {
            return null;
        }

        $data = $data->response[0];

        return new VkUser([
            VkUser::PROP_ID => $data->uid,
            VkUser::PROP_FIRST_NAME => $data->first_name,
            VkUser::PROP_LAST_NAME => $data->last_name,
            VkUser::PROP_SEX => $data->sex,
            VkUser::PROP_BIRTHDAY => $data->bdate,
        ]);
    }
}
