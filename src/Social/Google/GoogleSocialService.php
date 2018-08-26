<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Google;

use Core\OAuth\OAuthBase\Google\OAuthGoogle;
use LightweightCurl\CurlInterface;
use LightweightCurl\Request;

/**
 * @author Kozlenko Vitaliy
 */
class GoogleSocialService implements GoogleSocialServiceInterface
{
    /**
     * @var CurlInterface Расширенный curl
     */
    protected $curl;

    /**
     * @var OAuthGoogle
     */
    private $authGoogle;

    public function __construct(OAuthGoogle $authGoogle, CurlInterface $curl)
    {
        $this->curl = $curl;
        $this->authGoogle = $authGoogle;
    }

    public function getLink(string $redirectUri, string $oauthId): string
    {
        $url = 'https://accounts.google.com/o/oauth2/auth?redirect_uri=' . $redirectUri;
        $url .= '&state=' . $oauthId;
        $url .= '&response_type=code&client_id=' . $this->authGoogle->getClientId();
        $url .= '&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile';

        return $url;
    }

    /**
     * @param string $accessToken
     *
     * @return GoogleUserInterface|null
     */
    public function getUserInfo(string $accessToken): ?GoogleUserInterface
    {
        $url = vsprintf('https://www.googleapis.com/oauth2/v1/userinfo?access_token=%s', [$accessToken,]);

        $request = new Request();
        $request->setUrl($url);

        $response = $this->curl->call($request);
        $data = json_decode($response->getData());
        if ($data === null) {
            return null;
        }

        return new GoogleUser([
            GoogleUser::PROP_ID => $data->id,
            GoogleUser::PROP_EMAIL => $data->email,
            GoogleUser::PROP_FIRST_NAME => $data->given_name,
            GoogleUser::PROP_LAST_NAME => $data->family_name,
            GoogleUser::PROP_SEX => $data->gender,
        ]);
    }
}
