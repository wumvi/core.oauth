<?php
declare(strict_types=1);

namespace Core\OAuth\Social\Stackoverflow;

use Core\OAuth\Exception\GetUserException;
use Core\OAuth\Exception\JsonException;
use Core\OAuth\OAuthBase\Stackoverflow\OAuthStackoverflow;
use LightweightCurl\Curl;
use LightweightCurl\Request;

/**
 * Сервис для Stackoverflow
 *
 * @author Kozlenko Vitaliy
 * @see https://api.stackexchange.com/docs/authentication
 * @see https://stackapps.com/apps/oauth
 */
class StackoverflowService
{
    /**
     * @var OAuthStackoverflow
     */
    private $oauthStackoverflow;

    /**
     * FbSocialService constructor.
     *
     * @param OAuthStackoverflow $oAuthStackoverflow
     */
    public function __construct(OAuthStackoverflow $oAuthStackoverflow)
    {
        $this->oauthStackoverflow = $oAuthStackoverflow;
    }

    public function getLink(string $redirectUrl, string $oauthId): string
    {
        $url = 'https://stackoverflow.com/oauth?client_id=' . $this->oauthStackoverflow->getClientId();
        $url .= '&redirect_uri=' . $redirectUrl;
        $url .= '&state=' . $oauthId;
        $url .= '&response_type=code&scope=';

        return $url;
    }

    public function getUserInfo(string $authToken, string $key): StackoverflowUser
    {
        $url = 'https://api.stackexchange.com/2.2/me?site=stackoverflow&key=' . $key . '&access_token=' . $authToken . '&callback=';
        $curl = new Curl();
        $request = new Request();
        $request->setUrl($url);
        $request->setEncoding('gzip');
        $response = $curl->call($request);

        $data = json_decode($response->getData());
        if (empty($data)) {
            throw new JsonException('Wrong json for getting stackoverflow user', JsonException::WRONG_JSON_CODE);
        }

        if (isset($data->error_id)) {
            throw new GetUserException($data->error_message, $data->error_id);
        }

        return new StackoverflowUser($data->items[0]);
    }
}
