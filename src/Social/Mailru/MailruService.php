<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Mailru;

use Core\OAuth\OAuthBase\Mailru\OAuthMailRu;
use Core\OAuth\OAuthBase\TokenCodeResponseInterface;
use Core\Utils\JsonToReadConverter;
use LightweightCurl\CurlInterface;
use LightweightCurl\Request;

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
     * @var OAuthMailRu
     */
    protected $mailRuData;

    /**
     * MailruService constructor.
     *
     * @param OAuthMailRu $mailRuData
     * @param CurlInterface $curl
     */
    public function __construct(OAuthMailRu $mailRuData, CurlInterface $curl)
    {
        $this->curl = $curl;
        $this->mailRuData = $mailRuData;
    }

    public function getLink(string $redirectUrl): string
    {
        $url = 'https://connect.mail.ru/oauth/authorize?client_id=' . $this->mailRuData->getClientId();
        // $url .= '&cope=widget&display=mobile';
        $url .= '&response_type=code&redirect_uri=' . $redirectUrl;

        return $url;
    }

    /**
     * @param string $accessToken
     * @param string $userId
     *
     * @return MailRuUserInterface|null Массив моделей пользователей
     *
     * @throws
     */
    public function getUserInfo(string $accessToken, string $userId): ?MailRuUserInterface
    {
        // Ключи должны быть в алфавитном порядке, это крайне важно!
        $params = [
            'app_id' => $this->mailRuData->getClientId(),
            'method' => 'users.getInfo',
            'secure' => '1',
            'session_key' => $accessToken->getAccessToken()
        ];

        $params['sig'] = $this->createSign($params);


        $request = new Request();
        $request->setUrl(self::URL_API);
        $request->setData($params);
        $request->setMethod(Request::METHOD_POST);

        $response = $this->curl->call($request);
        $data = json_decode($response->getData(), true);

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
        return md5(http_build_query($params, '', '') . $this->mailRuData->getClientSecret());
    }
}
