<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Vk;

use Core\OAuth\OAuthBase\Vk\OAuthVk;
use LightweightCurl\Curl;
use LightweightCurl\CurlException;
use LightweightCurl\Request;

/**
 * Сервис работы с API сайта ВКонтакте
 */
class VkSocialService
{
    private const URL_API = 'https://api.vk.com/method/';

    /**
     * @var Curl Расширенный curl
     */
    protected $curl;

    /**
     * @var OAuthVk
     */
    protected $authVk;

    /**
     * VkSocialService constructor.
     *
     * @param OAuthVk $authVk
     */
    public function __construct(OAuthVk $authVk)
    {
        $this->curl = new Curl();
        $this->authVk = $authVk;
    }

    public function getLink($redirectUrl): string
    {
        $url = 'https://oauth.vk.com/authorize?client_id=' . $this->authVk->getClientId();
        $url .= '&redirect_uri=' . $redirectUrl;
        $url .= '&display=page&scope=4194304&response_type=code&v=5.52';

        return $url;
    }

    /**
     * Получение информацию по пользователю
     *
     * @param string $vkUserId Id пользователя сайта Вконтакте
     * @param string $accessToken AccessToken
     *
     * @see https://vk.com/dev/users.get
     *
     * @return VkUser|null
     *
     * @throws CurlException
     */
    public function getUserInfo(int $vkUserId, string $accessToken): ?VkUser
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
