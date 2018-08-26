<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Mailru;

use LightweightCurl\Curl;
use LightweightCurl\CurlInterface;
use LightweightCurl\Request;
use LightweightCurl\CurlException;

use Core\Utils\JsonToReadConverter;
use Core\OAuth\OAuthBase\Mailru\TokenCodeResponse;

/**
 * @author Козленко В.Л.
 * @see http://api.mail.ru/docs/guides/oauth/sites/
 * @see http://habrahabr.ru/company/mailru/blog/115163/
 */
class MailruService implements MailruServiceInterface
{
    const URL_API = 'http://www.appsmail.ru/platform/api';

    /**
     * @var CurlInterface Расширенный curl
     */
    protected $curl;

    protected $siteId;

    protected $clientSecret;

    /**
     * MailruService constructor.
     * @param string $siteId
     * @param string $clientSecret
     * @param CurlInterface $curl
     */
    public function __construct(string $siteId, string $clientSecret, CurlInterface $curl)
    {
        $this->curl = $curl;
        $this->siteId = $siteId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @param TokenCodeResponse $accessToken
     *
     * @return MailRuUserInterface|null Массив моделей пользователей
     *
     * @throws
     */
    public function getUserInfo($accessToken): ?MailRuUserInterface
    {
        // Ключи должны быть в алфавитном порядке, это крайне важно!
        $params = [
            'app_id' => $this->siteId,
            'method' => 'users.getInfo',
            'secure' => '1',
            'session_key' => $accessToken->getAccessToken()
        ];

        $params['sig'] = $this->createSign($params);

        $request = new Request();
        $request->setUrl(self::URL_API);
        $request->setData($params);
        $request->setMethod(Request::METHOD_POST);

        $data = $this->curl->call($request);
        $data = json_decode($data, true);
        if ($data === null || isset($data['error'])) {
            return null;
        }

        $jsonMapping = new JsonToReadConverter([
            MailRuUser::PROP_BIRTHDAY => 'birthday',
            MailRuUser::PROP_EMAIL => 'email',
            MailRuUser::PROP_ID => 'uid',
            MailRuUser::PROP_LAST_NAME => 'last_name',
            MailRuUser::PROP_SEX => 'sex',
            MailRuUser::PROP_FIRST_NAME => 'first_name',
        ]);

        return new MailRuUser($jsonMapping->convert($data[0]));
    }

    /**
     * @param [] $data Массив данных для процедуры.
     * Ключи должны быть в алфавитном порядке, это крайне важно!
     *
     * @return string Подпись для запроса
     */
    protected function createSign($params)
    {
        return md5(http_build_query($params) . $this->clientSecret);
    }
}
