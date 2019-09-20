<?php
namespace Core\OAuth\Social\Instagram;

use Core\OAuth\OAuthBase\Instagram\OAuthInstagram;

class InstagramService
{
    /**
     * @var OAuthInstagram
     */
    private $oauth;

    /**
     * FbSocialService constructor.
     *
     * @param OAuthInstagram $oauth
     */
    public function __construct(OAuthInstagram $oauth)
    {
        $this->oauth = $oauth;
    }

    public function getLink(string $redirectUrl, string $oauthId): string
    {
        $url = 'https://api.instagram.com/oauth/authorize/?client_id=' . $this->oauth->getClientId();
        $url .= '&redirect_uri=' . $redirectUrl;
        $url .= '&state=' . $oauthId;
        $url .= '&response_type=code';

        return $url;
    }
}
