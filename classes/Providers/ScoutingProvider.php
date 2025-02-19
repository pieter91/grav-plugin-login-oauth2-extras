<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

class ScoutingProvider extends ExtraProvider
{
    protected $name = 'Scouting';
    protected $classname = 'Pietervanderweel\\Oauth2\\Client\\Provider\\Scouting';

    public function initProvider(array $options): void
    {
        $options += [
            'clientId'      => $this->config->get('providers.scouting.client_id'),
            'clientSecret'  => $this->config->get('providers.scouting.client_secret'),
            'redirectUri'   => $this->getCallbackUri(),
        ];

        parent::initProvider($options);
    }

    public function getAuthorizationUrl()
    {
        $options = ['state' => $this->state];
        $options['scope'] = $this->config->get('providers.scouting.options.scope');

        return $this->provider->getAuthorizationUrl($options);
    }

    public function getUserData($user)
    {
        $data = $user->toArray();

        $data_user = [
            'id'         => $user->getId(),
            'login'      => $data['email'],
            'fullname'   => $data['name'],
            'email'      => $data['email'],
        ];

        return $data_user;
    }
}