<?php
declare(strict_types = 1);

namespace Wumvi\Classes\Social\Yandex;

use Wumvi\Classes\CurlExt;

/**
 * Class YandexService
 * @package Wumvi\Classes\Social\Yandex
 */
class YandexService
{
    /** @var CurlExt Расширенный curl */
    protected $curl;

    /**
     * Yandex constructor.
     */
    public function __construct()
    {
        $this->curl = new CurlExt();
    }

    /**
     * @param string $authToken
     * @return YaUser|null
     */
    public function getUserInfo(string $authToken): ?YaUser
    {
        $data = $this->curl->get('https://login.yandex.ru/info?format=json&oauth_token=' . $authToken);
        $data = @json_decode($data);
        if (!$data) {
            return null;
        }

        return new YaUser([
            YaUser::PROP_ID => $data->id,
            YaUser::PROP_FIRST_NAME => $data->first_name,
            YaUser::PROP_EMAIL => $data->default_email,
            YaUser::PROP_LAST_NAME => $data->last_name,
            YaUser::PROP_BIRTHDAY => $data->birthday,
            YaUser::PROP_SEX => $data->sex,
        ]);
    }
}
