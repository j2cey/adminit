<?php

namespace App\Enums\Settings\Branches;

use App\Enums\Settings\SettingNode;

/**
 * Class ReportFile. Raw ReportFile settings
 * @package App\Enums\Settings\Branches
 *
 * @method retrieve_by_wildcard_label()
 * @method retrieve_by_name_label()
 */
class ReportFile extends SettingNode
{
    public function __construct()
    {
        parent::__construct("reportfile",null,null,null,null,"settings ReportFile.");

        $this->addChild("retrieve_by_wildcard_label", "Par Wildcard", "string", "Libellé pour le champs 'retrieve_by_wildcard'.");
        $this->addChild("retrieve_by_name_label", "Par Nom", "string", "Libellé pour le champs 'retrieve_by_name_label'.");
    }
}
