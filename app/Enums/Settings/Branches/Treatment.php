<?php

namespace App\Enums\Settings\Branches;

use App\Enums\Settings\SettingNode;

/**
 * Class Treatment. Raw Treatment settings
 * @package App\Enums\Settings\Branches
 *
 * @method activate()
 * @method max_retries()
 * @method formatcolumns()
 */
class Treatment extends SettingNode
{
    public function __construct()
    {
        parent::__construct("treatment",null,null,null,null,"settings ReportTreatments.");

        $this->addChild("activate", "0", "bool", "active ou desactive les traitements de Rapports.");
        $this->addChild("max_retries", "10", "integer", "nombre max de tentatives de retraitement.");
        $this->addChild("formatcolumns", null, null, "Formattage des colonnes.")
            ->addChild("append_batch_max", "10", "integer", "nombre max de colonnes a ajouter au batch de traitement de la ligne.");

        $this->addChild("merge_file", null, null, "Merge Files.")
            ->addChild("max_retries", "10", "integer", "nombre max de tentatives de retraitement de Merge de fichier.");
    }
}
