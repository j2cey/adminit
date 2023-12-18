<?php

namespace App\Enums\Settings\Branches;

use App\Enums\Settings\ArchiveUnit;
use App\Enums\Settings\SettingNode;
use App\Enums\Settings\ArchiveState;

/**
 * Class CollectedReportFile. CollectedReportFile settings
 * @package App\Enums\Settings\Branches
 *
 * @method delete_expired()
 */
class CollectedReportFile extends SettingNode
{
    public function __construct()
    {
        parent::__construct("collectedreportfile",null,null,null,null,"settings Job Batches.");

        $delete_expired = $this->addChild("delete_expired", null, null, "delete expired CollectedReportFile");
        $delete_expired->addArchiveChildren(ArchiveState::ENABLED, ArchiveUnit::DAY, "6");

        $delete_expired->addChild("rows", null, null, "delete expired CollectedReportFile rows")
            ->addArchiveChildren(ArchiveState::ENABLED, ArchiveUnit::DAY, "5");

        $delete_expired->addChild("values", null, null, "delete expired CollectedReportFile values")
            ->addArchiveChildren(ArchiveState::ENABLED, ArchiveUnit::DAY, "2");
    }
}
