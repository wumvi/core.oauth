<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Ok;

use Core\OAuth\OAuthBase\Ok\OAuthOk;
use LightweightCurl\Curl;
use LightweightCurl\CurlException;
use LightweightCurl\Request;
use LightweightCurl\CurlInterface;


/**
 * @author Kozlenko Vitaliy
 *
 * @see http://coddism.com/php/oauth_avtorizacija_cherez_odnoklassnikiru
 */
class OkSocialService implements OkSocialServiceInterface
{
    private const URL_API = 'http://api.odnoklassniki.ru/fb.do?%s';

    /**
     * @var CurlInterface Расширенный curl
     */
    protected $curl;

    /**
     * @var OAuthOk
     */
    private $authOk;

    /**
     * OkSocial constructor.
     *
     * @param OAuthOk $authOk
     * @param CurlInterface $curl
     */
    public function __construct(OAuthOk $authOk, CurlInterface $curl)
    {
        $this->curl = $curl;
        $this->authOk = $authOk;
    }

    public function getLink(string $redirectUrl, string $oauthId): string
    {
        $url = 'https://connect.ok.ru/oauth/authorize?client_id=' . $this->authOk->getClientId();
        $url .= '&response_type=code&redirect_uri=' . $redirectUrl;
        $url .= '&scope=GET_EMAIL&state=' . $oauthId;

        return $url;
    }

    /**
     * Получаем модель пользователя сайта Одноклассники
     *
     * @param string $authToken AuthToken
     *
     * @return OkUserInterface|null
     *
     * @throws
     */
    public function getUserInfo(string $authToken): ?OkUserInterface
    {
        $sign = md5($authToken . $this->authOk->getClientSecret());
        $sing = md5('application_key=' . $this->authOk->getPublicKey() . 'method=users.getCurrentUser' . $sign);

        $params = [
            'access_token' => $authToken,
            'method' => 'users.getCurrentUser',
            'application_key' => $this->authOk->getPublicKey(),
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
