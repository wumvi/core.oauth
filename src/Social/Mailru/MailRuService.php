<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Mailru;

use Core\OAuth\OAuthBase\Mailru\OAuthMailRu;
use LightweightCurl\Curl;
use LightweightCurl\Request;

/**
 * @author Козленко В.Л.
 * @see http://api.mail.ru/docs/guides/oauth/sites/
 * @see http://habrahabr.ru/company/mailru/blog/115163/
 */
class MailRuService
{
    const URL_API = 'http://www.appsmail.ru/platform/api';

    /**
     * @var Curl Расширенный curl
     */
    protected $curl;

    protected $siteId;

    protected $clientSecret;
    /**
     * @var OAuthMailRu
     */
    protected $mailRuData;

    /**
     * MailruService constructor.
     *
     * @param OAuthMailRu $mailRuData
     */
    public function __construct(OAuthMailRu $mailRuData)
    {
        $this->curl = new Curl();
        $this->mailRuData = $mailRuData;
    }

    public function getLink(string $redirectUrl): string
    {
        $url = 'https://connect.mail.ru/oauth/authorize?';
        $url .= 'client_id=' . $this->mailRuData->getClientId();
        $url .= '&response_type=code&redirect_uri=' . urlencode($redirectUrl);

        return $url;
    }

    /**
     * @param string $accessToken
     *
     * @return MailRuUser|null Массив моделей пользователей
     *
     * @throws
     *
     * @see https://api.mail.ru/docs/guides/restapi/
     * @see https://api.mail.ru/docs/reference/rest/users.getInfo/
     */
    public function getUserInfo(string $accessToken): ?MailRuUser
    {
        // Ключи должны быть в алфавитном порядке, это крайне важно!
        $params = [
            'method' => 'users.getInfo',
            'app_id' => $this->mailRuData->getClientId(),
            'session_key' => $accessToken,
            'secure' => '1'
        ];
        $params['sig'] = $this->createSign($params);
        $request = new Request();
        $request->setUrl(self::URL_API);
        $request->setData($params);
        $request->setMethod(Request::METHOD_POST);

        $response = $this->curl->call($request);
        $data = json_decode($response->getData());
        if ($data === null || isset($data->error)) {
            return null;
        }

        return new MailRuUser($data[0]);
    }

    /**
     * @param array $params Массив данных для процедуры. Ключи должны быть в алфавитном порядке, это крайне важно!
     *
     * @return string Подпись для запроса
     */
    protected function createSign(array $params)
    {
        ksort($params);
        return md5(http_build_query($params, '', '') . $this->mailRuData->getClientSecret());
    }
}
