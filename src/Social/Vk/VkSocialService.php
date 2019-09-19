<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Vk;

use Core\OAuth\OAuthBase\Vk\OAuthVk;
use LightweightCurl\Curl;
use LightweightCurl\ICurl;
use LightweightCurl\Request;

/**
 * Сервис работы с API сайта ВКонтакте
 */
class VkSocialService
{
    private const URL_API = 'https://api.vk.com/method/';

    private const VERSION = '5.101';

    /**
     * @var ICurl Расширенный curl
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

    public function getLink(string $redirectUrl, string $scope): string
    {
        $url = 'https://oauth.vk.com/authorize?';
        $url .= 'client_id=' . $this->authVk->getClientId();
        $url .= '&redirect_uri=' . urlencode($redirectUrl);
        $url .= '&display=page';
        $url .= '&scope=' . $scope;
        $url .= '&response_type=code&v=5.101';

        return $url;
    }

    /**
     * Получение информацию по пользователю
     *
     * @param int $userId Id пользователя сайта Вконтакте
     * @param string $accessToken AccessToken
     *
     * @return VkUser|null
     *
     * @throws
     * @see https://vk.com/dev/users.get
     *
     */
    public function getUserInfo(int $userId, string $accessToken): ?VkUser
    {
        $params = [
            'user_id' => $userId,
            'access_token' => $accessToken,
            'fields' => 'sex,bdate,is_closed',
            'v' => self::VERSION,
        ];

        $url = vsprintf(self::URL_API . 'users.get?%s', [http_build_query($params),]);

        $request = new Request();
        $request->setUrl($url);

        $response = $this->curl->call($request);
        $data = json_decode($response->getData());
        if (!isset($data->response) || !$data->response || count($data->response) == 0) {
            return null;
        }

        return new VkUser($data->response[0]);
    }
}
