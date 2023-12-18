<?php

namespace App\Enums\Settings\Branches;

use App\Enums\Settings\SettingNode;

/**
 * Class SelectedRetrieveAction. Raw SelectedRetrieveAction settings
 * @package App\Enums\Settings\Branches
 *
 * @method default_actions_scopes()
 */
class SelectedRetrieveAction extends SettingNode
{
    public function __construct()
    {
        parent::__construct("selretrieveaction",null,null,null,null,"settings SelectedRetrieveAction.");

        $this->addChild("default_actions_scopes", "retrieveByName,renameFile", "array", "liste des actions par défaut.");
    }
}
