<?php
declare(strict_types=1);

namespace Core\OAuth\Social\GitHub;

use Core\OAuth\Exception\GetUserException;
use Core\OAuth\Exception\JsonException;
use Core\OAuth\OAuthBase\GitHub\OAuthGitHub;
use LightweightCurl\Curl;
use LightweightCurl\Request;

/**
 * @author Kozlenko Vitaliy
 */
class GitHubService
{
    /**
     * @var OAuthGitHub
     */
    private $auth;

    public function __construct(OAuthGitHub $auth)
    {
        $this->auth = $auth;
    }

    public function getLink(string $redirectUri, string $oauthId): string
    {
        $url = 'https://github.com/login/oauth/authorize?redirect_uri=' . urlencode($redirectUri);
        $url .= '&state=' . $oauthId;
        $url .= '&response_type=code';
        $url .= '&client_id=' . $this->auth->getClientId();
        $url .= '&scope=user';

        return $url;
    }

    /**
     * @param string $accessToken
     *
     * @return GitHubUser
     *
     * @throws
     */
    public function getUserInfo(string $accessToken): GitHubUser
    {
        $curl = new Curl();
        $request = new Request();
        $request->setUrl('https://api.github.com/user');
        $request->addHeader('Authorization', 'token ' . $accessToken);
        $request->addHeader('User-Agent', 'MutliOAuth');
        $response = $curl->call($request);
        $data = json_decode($response->getData());
        if (empty($data)) {
            throw new JsonException('Wrong json for getting google user', JsonException::WRONG_JSON_CODE);
        }

        if (isset($data->error)) {
            throw new GetUserException($data->error->message, $data->error->code);
        }

        return new GitHubUser($data);
    }

    /**
     * @param string $accessToken
     *
     * @return GitHubUser
     *
     * @throws
     */
    public function getEmails(string $accessToken): GitHubUser
    {
        $curl = new Curl();
        $request = new Request();
        $request->setUrl('https://api.github.com/user/emails');
        $request->addHeader('Authorization', 'token ' . $accessToken);
        $request->addHeader('User-Agent', 'MutliOAuth');
        $response = $curl->call($request);
        $data = json_decode($response->getData());
        if (empty($data)) {
            throw new JsonException('Wrong json for getting google user', JsonException::WRONG_JSON_CODE);
        }

        if (isset($data->error)) {
            throw new GetUserException($data->error->message, $data->error->code);
        }

        return new GitHubUser($data);
    }
}
