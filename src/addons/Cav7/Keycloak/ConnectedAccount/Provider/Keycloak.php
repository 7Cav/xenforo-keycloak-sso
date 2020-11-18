<?php

namespace Cav7\Keycloak\ConnectedAccount\Provider;

use XF\ConnectedAccount\Http\HttpResponseException;
use XF\ConnectedAccount\Provider\AbstractProvider;
use XF\Entity\ConnectedAccountProvider;

class Keycloak extends AbstractProvider
{

    /**
     * @inheritDoc
     */
    public function getOAuthServiceName()
    {
        return 'Cav7\Keycloak:Service\Keycloak';
    }

    public function getProviderDataClass()
    {
        return 'Cav7\Keycloak:ProviderData\Keycloak';
    }

    public function getDefaultOptions()
    {
        return [
            'client_id' => '',
            'client_secret' => '',
            'auth_url' => '',
            'token_url' => '',
            'resource_url' => '',
            'user_identifier' => '',
            'scopes' => '',
        ];
    }

    public function isUsable(ConnectedAccountProvider $provider)
    {
        $addon = \XF::app()->finder('XF:Addon')->whereId('Cav7/Keycloak')->fetchOne();
        if (!$addon || !$addon->active)
        {
            return false;
        }
        return parent::isUsable($provider);
    }

    public function getOAuthConfig(ConnectedAccountProvider $provider, $redirectUri = null)
    {
        return [
            'key' => $provider->options['client_id'],
            'secret' => $provider->options['client_secret'],
            'auth_url' => $provider->options['auth_url'],
            'token_url' => $provider->options['token_url'],
            'resource_url' => $provider->options['resource_url'],
            'scopes' => explode(",", $provider->options['scopes']),
            'id' => $provider->options['user_identifier'],
            'redirect' => $redirectUri ?: $this->getRedirectUri($provider)
        ];
    }

    public function canBeTested()
    {
        return false;
    }

    public function parseProviderError(HttpResponseException $e, &$error = null)
    {
        $errorDetails = json_decode($e->getResponseContent(), true);
        if (isset($errorDetails['error_description']))
        {
            $e->setMessage($errorDetails['error_description']);
        }
        parent::parseProviderError($e, $error);
    }
}