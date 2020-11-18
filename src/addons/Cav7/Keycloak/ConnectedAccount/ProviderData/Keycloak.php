<?php

namespace Cav7\Keycloak\ConnectedAccount\ProviderData;

use XF\ConnectedAccount\ProviderData\AbstractProviderData;

class Keycloak extends AbstractProviderData
{
    public function getDefaultEndpoint()
    {
        // TODO: Implement getDefaultEndpoint() method.
    }

    public function getProviderKey()
    {
        return $this->requestFromEndpoint('sub');
    }

    public function getFormattedName()
    {
        $firstName = $this->requestFromEndpoint('given_name');
        $lastName = $this->requestFromEndpoint('family_name');

        if ($firstName && $lastName)
        {
            return "$firstName $lastName";
        }

        return null;
    }

    public function getEmail()
    {
        $emailData = $this->requestFromEndpoint('email');

        if ($emailData)
        {
            return "$emailData";
        }

        return null;
    }
}