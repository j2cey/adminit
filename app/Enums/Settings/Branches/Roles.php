<?php

namespace App\Enums\Settings\Branches;

use App\Enums\Settings\SettingNode;

/**
 * Class Roles. Roles settings
 * @package App\Enums\Settings\Branches
 *
 * @method default()
 */
class Roles extends SettingNode
{
    public function __construct()
    {
        parent::__construct("roles",null,null,null,null,"Roles settings");

        $this->addChild("default", "1", "integer","Role par défaut à la création d un utilisateur dont le role n est pas explicitement déterminé.");
    }
}
