<?php

namespace Cav7\Keycloak;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

    public function install(array $stepParams = [])
    {
        $db = $this->db();
        $db->query("REPLACE INTO `xf_connected_account_provider` (`provider_id`, `provider_class`, `display_order`, `options`)
        VALUES
            ('keycloak', 'Cav7\Keycloak:Provider\\\\Keycloak', 80, '')");
    }

    public function uninstall(array $stepParams = [])
    {
        $db = $this->db();
        $db->query("DELETE FROM `xf_connected_account_provider` WHERE `provider_id` = 'keycloak'");
    }
}