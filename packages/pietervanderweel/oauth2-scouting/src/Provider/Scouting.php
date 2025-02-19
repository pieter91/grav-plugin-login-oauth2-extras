<?php

namespace Pietervanderweel\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Scouting extends AbstractProvider
{
    use BearerAuthorizationTrait;
    
    protected $issuer = '';
    
    /**
     * Get authorization url to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return 'https://login.scouting.nl/authorize';
    }

    /**
     * Get access token url to retrieve token
     *
     * @param  array $params
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://login.scouting.nl/token';
    }

    /**
     * Get provider url to fetch user details
     *
     * @param  AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return 'https://login.scouting.nl/oidc/userinfo';
    }

    /**
     * @return array
     **/
    protected function getAuthorizationParameters(array $options)
    {
        return parent::getAuthorizationParameters($options);
    }

    /**
     * @return array
     **/
    protected function getDefaultScopes()
    {
        return [
            'openid',
            'email',
            'profile',
			'membership'
        ];
    }

    /**
     * @return string
     **/
    protected function getScopeSeparator()
    {
        return ' ';
    }

    /**
     * @return void
     **/
    protected function checkResponse(ResponseInterface $response, $data)
    {
        // @codeCoverageIgnoreStart
        if (empty($data['error'])) {
            return;
        }
        // @codeCoverageIgnoreEnd

        $code = $response->getStatusCode();
        $error = $data['error'];

        if (is_array($error)) {
            $code = $error['code'];
            $error = $error['message'];
        }

        throw new IdentityProviderException($error, $code, $data);
    }

    /**
     * @return ResourceOwnerInterface
     **/
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        $user = new ScoutingUser($response);

        return $user;
    }
}
