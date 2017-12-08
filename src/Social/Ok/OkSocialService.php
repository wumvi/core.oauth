<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Ok;

use LightweightCurl\Curl;
use LightweightCurl\Request;
use LightweightCurl\CurlException;

/**
 * @author Kozlenko Vitaliy
 * @see http://coddism.com/php/oauth_avtorizacija_cherez_odnoklassnikiru
 */
class OkSocialService
{
    private const URL_API = 'http://api.odnoklassniki.ru/fb.do?%s';

    /**
     * @var Curl Расширенный curl
     */
    protected $curl;

    /** @var string ID приложения */
    private $appId;

    /** @var string Приватный ключ */
    private $privateKey;

    /** @var string Публичный ключ */
    private $publicKey;

    /**
     * OkSocial constructor.
     * @param string $appId ID приложения
     * @param string $privateKey Приватный ключ
     * @param string $publicKey Публичный ключ
     */
    public function __construct(string $appId, string $privateKey, string $publicKey)
    {
        $this->curl = new Curl();
        $this->appId = $appId;
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
    }

    /**
     * Получаем модель пользователя сайта Одноклассники
     *
     * @param string $authToken AuthToken
     *
     * @return OkUser|null
     *
     * @throws CurlException
     */
    public function getUserInfo(string $authToken): ?OkUser
    {
        $sign = md5($authToken . $this->privateKey);
        $sing = md5('application_key=' . $this->publicKey . 'method=users.getCurrentUser' . $sign);

        $params = [
            'access_token' => $authToken,
            'method' => 'users.getCurrentUser',
            'application_key' => $this->publicKey,
            'sig' => $sing
        ];

        $url = vsprintf(self::URL_API, [http_build_query($params),]);

        $request = new Request();
        $request->setUrl($url);

        $response = $this->curl->call($request);
        $data = json_decode($response->getData());
        if ($data === null) {
            return null;
        }

        return new OkUser([
            OkUser::PROP_ID => $data->uid,
            OkUser::PROP_FIRST_NAME => $data->first_name,
            OkUser::PROP_LAST_NAME => $data->last_name,
            OkUser::PROP_HAS_EMAIL => $data->has_email,
            OkUser::PROP_EMAIL => $data->email,
            OkUser::PROP_BIRTHDAY => $data->birthday,
            OkUser::PROP_SEX => $data->gender,
        ]);
    }
}
