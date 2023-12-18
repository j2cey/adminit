<?php

namespace App\Enums\Settings\Branches;

use App\Enums\Settings\SettingNode;
use App\Enums\Settings\ArchiveUnit;
use App\Enums\Settings\ArchiveState;

/**
 * Class TreatmentArchive. Raw TreatmentArchive settings
 * @package App\Enums\Settings\Branches
 *
 * @method level_0()
 * @method level_1()
 * @method level_2()
 * @method level_3()
 * @method level_over_3()
 */
class TreatmentArchive extends SettingNode
{
    public function __construct()
    {
        parent::__construct("treatmentarchive",null,null,null,null,"settings Treatment Archive.");

        $level_0 = $this->addChild("level_0", null, null, "Archives settings for Treatment with level 0.");
        $level_0->addChild("max_before_del", null, null, "Max before deletion for level 0.")
            ->addArchiveChildren(ArchiveState::ENABLED, ArchiveUnit::DAY, "5");
        //$level_0_max_before_del->addChild("unit", "day", "string", "Unit for Max before deletion for level 0.");
        //$level_0_max_before_del->addChild("value", "5", "integer", "Value for Max before deletion for level 0.");

        $level_1 = $this->addChild("level_1", null, null, "Archives settings for Treatment with level 1.");
        $level_1->addChild("max_before_del", null, null, "Max before deletion for level 1.")
            ->addArchiveChildren(ArchiveState::ENABLED, ArchiveUnit::DAY, "4");
        //$level_1_max_before_del->addChild("unit", "day", "string", "Unit for Max before deletion for level 1.");
        //$level_1_max_before_del->addChild("value", "4", "integer", "Value Max before deletion for level 1.");

        $level_2 = $this->addChild("level_2", null, null, "Archives settings for Treatment with level 2.");
        $level_2->addChild("max_before_del", null, null, "Max before deletion for level 2.")
            ->addArchiveChildren(ArchiveState::ENABLED, ArchiveUnit::DAY, "3");
        //$level_2_max_before_del->addChild("unit", "day", "string", "Unit for Max before deletion for level 2.");
        //$level_2_max_before_del->addChild("value", "3", "integer", "Value for Max before deletion for level 2.");

        $level_3 = $this->addChild("level_3", null, null, "Archives settings for Treatment with level 3.");
        $level_3->addChild("max_before_del", null, null, "Max before deletion for level 3.")
            ->addArchiveChildren(ArchiveState::ENABLED, ArchiveUnit::DAY, "2");
        //$level_3_max_before_del->addChild("unit", "day", "string", "Unit for Max before deletion for level 3.");
        //$level_3_max_before_del->addChild("value", "2", "integer", "Value for Max before deletion for level 3.");

        $level_over_3 = $this->addChild("level_over_3", null, null, "Archives settings for Treatment with level over 3.");
        $level_over_3->addChild("max_before_del", null, null, "Max before deletion for level over 3.")
            ->addArchiveChildren(ArchiveState::ENABLED, ArchiveUnit::DAY, "1");
        //$level_over_3_max_before_del->addChild("unit", "day", "string", "Unit for Max before deletion for levels over 3.");
        //$level_over_3_max_before_del->addChild("value", "1", "integer", "Value for Max before deletion for levels over 3.");
    }
}
