<?php

namespace App\Enums\Settings\Branches;

use App\Enums\Settings\SettingNode;
use App\Enums\Settings\ArchiveUnit;
use App\Enums\Settings\ArchiveState;

/**
 * Class Jobs. Raw Jobs settings
 * @package App\Enums\Settings\Branches
 *
 * @method max_finished()
 */
class JobBatches extends SettingNode
{
    public function __construct()
    {
        parent::__construct("jobbatches",null,null,null,null,"settings Job Batches.");

        $this->addChild("max_finished", null, null, "max finished")
            ->addArchiveChildren(ArchiveState::ENABLED, ArchiveUnit::MINUTE, "30");
        //$max_finished->addChild("unit", "min", "string", "max reserved unit.");
        //$max_finished->addChild("value", "30", "integer", "max reserved value.");
    }
}
