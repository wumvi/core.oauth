<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Ok;

use Core\OAuth\Exception\GetUserException;
use Core\OAuth\Exception\JsonException;
use Core\OAuth\OAuthBase\Ok\OAuthOk;
use LightweightCurl\Curl;
use LightweightCurl\Request;

/**
 * @author Kozlenko Vitaliy
 *
 * @see http://coddism.com/php/oauth_avtorizacija_cherez_odnoklassnikiru
 */
class OkSocialService
{
    private const URL_API = 'http://api.odnoklassniki.ru/fb.do?%s';

    /**
     * @var OAuthOk
     */
    private $authOk;

    /**
     * OkSocial constructor.
     *
     * @param OAuthOk $authOk
     */
    public function __construct(OAuthOk $authOk)
    {
        $this->authOk = $authOk;
    }

    public function getLink(string $redirectUrl, string $oauthId): string
    {
        $url = 'https://connect.ok.ru/oauth/authorize?';
        $url .= 'client_id=' . $this->authOk->getClientId();
        $url .= '&response_type=code&redirect_uri=' . urlencode($redirectUrl);
        $url .= '&scope=GET_EMAIL&state=' . $oauthId;

        return $url;
    }

    /**
     * Получаем модель пользователя сайта Одноклассники
     *
     * @param string $authToken AuthToken
     *
     * @return OkUser
     *
     * @throws
     */
    public function getUserInfo(string $authToken): OkUser
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
        $curl = new Curl();
        $response = $curl->call($request);
        $data = json_decode($response->getData());
        if (empty($data)) {
            throw new JsonException('Wrong json for getting ok user', JsonException::WRONG_JSON_CODE);
        }

        if (isset($data->error_code)) {
            throw new GetUserException($data->error_msg, $data->error_code);
        }

        return new OkUser($data);
    }
}
