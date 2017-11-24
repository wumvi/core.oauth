<?php
declare(strict_types = 1);

namespace Wumvi\Classes\Social\Mailru;

use Wumvi\Classes\CurlExt;
use Wumvi\Classes\Utils\JsonToReadConverter;
use Wumvi\Classes\OAuth\OAuthBase\Mailru\TokenCodeResponse;
use Wumvi\Classes\Utils\ArrayHelp;

/**
 * @author Козленко В.Л.
 * @see http://api.mail.ru/docs/guides/oauth/sites/
 * @see http://habrahabr.ru/company/mailru/blog/115163/
 */
class MailruService
{
    const URL_API = 'http://www.appsmail.ru/platform/api';

    /** @var CurlExt Расширенный curl */
    protected $curl;
    protected $siteId;
    protected $clientSecret;

    /**
     * MailruService constructor.
     * @param string $siteId
     * @param string $clientSecret
     */
    public function __construct(string $siteId, string $clientSecret)
    {
        $this->curl = new CurlExt();
        $this->siteId = $siteId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @param TokenCodeResponse $accessToken
     *
     * @return MailRuUser|null Массив моделей пользователей
     */
    public function getUserInfo($accessToken): ?MailRuUser
    {
        // Ключи должны быть в алфавитном порядке, это крайне важно!
        $params = [
            'app_id' => $this->siteId,
            'method' => 'users.getInfo',
            'secure' => '1',
            'session_key' => $accessToken->getAccessToken()
        ];

        $params['sig'] = $this->createSign($params);
        $data = $this->curl->post(self::URL_API, $params);
        $data = @json_decode($data, true);
        if (isset($data['error'])) {
            return null;
        }

        $jsonMapping = new JsonToReadConverter([
            MailRuUser::PROP_BIRTHDAY => 'birthday',
            MailRuUser::PROP_EMAIL => 'email',
            MailRuUser::PROP_UID => 'uid',
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
        $sign = (new ArrayHelp())->arrayKeyValueJoin($params);
        return md5($sign . $this->clientSecret);
    }
}
