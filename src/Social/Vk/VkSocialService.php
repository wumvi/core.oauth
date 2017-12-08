<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Vk;

use LightweightCurl\Curl;
use LightweightCurl\Request;
use LightweightCurl\CurlException;

/**
 * Сервис работы с API сайта ВКонтакте
 */
class VkSocialService
{
    const URL_API = 'https://api.vk.com/method/';

    /**
     * @var Curl Расширенный curl
     */
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
        $this->curl = new Curl();
        $this->siteId = $siteId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * Получение информацию по пользователю
     * @param string $vkUserId Id пользователя сайта Вконтакте
     * @param string $accessToken AccessToken
     *
     * @see https://vk.com/dev/users.get
     *
     * @return VkUser|null
     *
     * @throws CurlException
     */
    public function getUserInfo(string $vkUserId, string $accessToken): ?VkUser
    {
        $params = [
            'user_id' => $vkUserId,
            'vk' => '5.8',
            'access_token' => $accessToken,
            'fields' => 'sex,bdate',
        ];

        $url = vsprintf(self::URL_API . 'users.get?%s', [http_build_query($params),]);

        $request = new Request();
        $request->setUrl($url);

        $response = $this->curl->call($request);
        $data = json_decode($response->getData());
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
