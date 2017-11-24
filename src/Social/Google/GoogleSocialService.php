<?php
declare(strict_types = 1);

namespace Wumvi\Classes\Social\Google;

use Wumvi\Classes\CurlExt;
use Wumvi\Classes\Utils\ArrayHelp;

/**
 * @author Kozlenko Vitaliy
 */
class GoogleSocialService
{
    /** @var CurlExt Расширенный curl */
    protected $curl;

    public function __construct()
    {
        $this->curl = new CurlExt();
    }

    /**
     * @param string $accessToken
     * @return GoogleUser|null
     */
    public function getUserInfo(string $accessToken): ?GoogleUser
    {
        $data = $this->curl->get('https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $accessToken);
        $data = @json_decode($data);
        if (!$data) {
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
