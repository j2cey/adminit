<?php

namespace App\Enums\Settings\Branches;

use App\Enums\Settings\SettingNode;

/**
 * Class Queues. Queues settings
 * @package App\Enums\Settings\Branches
 *
 * @method workerbounds()
 */
class Queues extends SettingNode
{
    public function __construct()
    {
        parent::__construct("queues",null,null,null,null,"settings for Queues.");

        $workerbounds = $this->addChild("workerbounds", null, null, "Min-utilisable, Max-utilisable et Max-disponible du nombre de workers par type de traitement.");
        $workerbounds->addChild("exectrace", "1,1,1", "array", "workers bounds pour exectrace.");
        $workerbounds->addChild("systemlog", "1,3,3", "array", "workers bounds pour systemlog.");
        $workerbounds->addChild("treatmentstartend", "1,1,1", "array", "workers bounds pour treatmentstartend.");
        $workerbounds->addChild("listener", "1,4,4", "array", "workers bounds pour listeners.");
        $workerbounds->addChild("main", "1,4,4", "array", "workers bounds pour main.");
        $workerbounds->addChild("downloadfile", "1,4,4", "array", "workers bounds pour downloadfile.");
        $workerbounds->addChild("importfile", "1,5,5", "array", "workers bounds pour importfile.");
        //$workerbounds->addChild("formatdata", "1,5,5", "array", "workers bounds pour formatdata.");
        $workerbounds->addChild("mergefile", "1,4,4", "array", "workers bounds pour mergefile.");
        $workerbounds->addChild("notifyfile", "1,4,4", "array", "workers bounds pour notifyfile.");
        //$workerbounds->addChild("importdata", "1,5,5", "array", "workers bounds pour importdata.");
        //$workerbounds->addChild("mergecolumns", "1,5,5", "array", "workers bounds pour mergecolumns.");
        //$workerbounds->addChild("mergerows", "1,5,5", "array", "workers bounds pour mergerows.");
    }
}
