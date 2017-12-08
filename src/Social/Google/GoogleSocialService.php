<?php
declare(strict_types = 1);

namespace Core\OAuth\Social\Google;

use LightweightCurl\Curl;
use LightweightCurl\Request;
use LightweightCurl\CurlException;

/**
 * @author Kozlenko Vitaliy
 */
class GoogleSocialService
{
    /**
     * @var Curl Расширенный curl
     */
    protected $curl;

    public function __construct()
    {
        $this->curl = new Curl();
    }

    /**
     * @param string $accessToken
     *
     * @return GoogleUser|null
     *
     * @throws CurlException
     */
    public function getUserInfo(string $accessToken): ?GoogleUser
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
