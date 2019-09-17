<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Vk;

use Core\OAuth\OAuthBase\Vk\OAuthVk;
use Core\OAuth\Social\ISocialUser;
use LightweightCurl\CurlInterface;
use LightweightCurl\Request;

/**
 * Сервис работы с API сайта ВКонтакте
 */
class VkSocialService implements IVkSocialService
{
    private const URL_API = 'https://api.vk.com/method/';

    private const VERSION = '5.8';

    /**
     * @var CurlInterface Расширенный curl
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
     * @param CurlInterface $curl
     */
    public function __construct(OAuthVk $authVk, CurlInterface $curl)
    {
        $this->curl = $curl;
        $this->authVk = $authVk;
    }

    public function getLink(string $redirectUrl, string $scope): string
    {
        $url = 'https://oauth.vk.com/authorize?';
        $url .= 'client_id=' . $this->authVk->getClientId();
        $url .= '&redirect_uri=' . $redirectUrl;
        $url .= '&display=page&scope=' . $scope;
        $url .= '&response_type=code&v=5.52';

        return $url;
    }

    /**
     * Получение информацию по пользователю
     *
     * @param int $userId Id пользователя сайта Вконтакте
     * @param string $accessToken AccessToken
     *
     * @see https://vk.com/dev/users.get
     *
     * @return ISocialUser|null
     *
     * @throws
     */
    public function getUserInfo(int $userId, string $accessToken): ?ISocialUser
    {
        $params = [
            'user_id' => $userId,
            'version' => self::VERSION,
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
