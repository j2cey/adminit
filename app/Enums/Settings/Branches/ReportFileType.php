<?php

namespace App\Enums\Settings\Branches;

use App\Enums\Settings\SettingNode;

/**
 * Class ReportFileType. ReportFileType settings
 * @package App\Enums\Settings\Branches
 *
 * @method extension_is_unique()
 */
class ReportFileType extends SettingNode
{
    public function __construct()
    {
        parent::__construct("reportfiletype",null,null,null,null,"settings ReportFileType.");

        $this->addChild("extension_is_unique", "0", "bool", "Détermine si l'extension d'un ReportFileType doit être UNIQUE.");
    }
}
