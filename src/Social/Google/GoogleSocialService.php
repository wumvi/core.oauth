<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Google;

use Core\OAuth\Exception\GetUserException;
use Core\OAuth\Exception\JsonException;
use Core\OAuth\OAuthBase\Google\OAuthGoogle;
use LightweightCurl\Curl;
use LightweightCurl\Request;

/**
 * @author Kozlenko Vitaliy
 */
class GoogleSocialService
{
    /**
     * @var OAuthGoogle
     */
    private $authGoogle;

    public function __construct(OAuthGoogle $authGoogle)
    {
        $this->authGoogle = $authGoogle;
    }

    public function getLink(string $redirectUri, string $oauthId): string
    {
        $url = 'https://accounts.google.com/o/oauth2/auth?redirect_uri=' . urlencode($redirectUri);
        $url .= '&state=' . $oauthId;
        $url .= '&response_type=code&client_id=' . $this->authGoogle->getClientId();
        $url .= '&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile';

        return $url;
    }

    /**
     * @param string $accessToken
     *
     * @return GoogleUser
     *
     * @throws
     */
    public function getUserInfo(string $accessToken): GoogleUser
    {
        $url = vsprintf('https://www.googleapis.com/oauth2/v1/userinfo?access_token=%s', [$accessToken,]);

        $request = new Request();
        $request->setUrl($url);
        $curl = new Curl();
        $response = $curl->call($request);
        $data = json_decode($response->getData());
        if (empty($data)) {
            throw new JsonException('Wrong json for getting google user', JsonException::WRONG_JSON_CODE);
        }

        if (isset($data->error)) {
            throw new GetUserException($data->error->message, $data->error->code);
        }

        return new GoogleUser($data);
    }
}
