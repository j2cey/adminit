<?php

namespace App\Enums\Settings\Branches;

use App\Enums\Settings\SettingNode;

/**
 * Class LogTreatments. LogTreatments settings
 * @package App\Enums\Settings\Branches
 *
 * @method maintype()
 * @method maintreatment()
 * @method steptype()
 * @method operationtype()
 * @method treatmentstarting()
 * @method treatmentending()
 * @method rawtreatment()
 * @method reportfile()
 * @method treatmentjob()
 * @method treatmentservice()
 * @method modelpicker()
 * @method formattedvalue()
 */
class LogTreatments extends SettingNode
{
    public function __construct()
    {
        parent::__construct("logtreatments",null,null,null,null,"settings for Treatments Logging");

        $maintype = $this->addChild("maintype", null, null, "Settings sur les LOGs des traitement de Type Main");
        $this->setCanbelogged("info", $maintype, "false");
        $this->setCanbelogged("error", $maintype, "true");

        $maintreatment = $this->addChild("maintreatment", null, null, "Settings sur les LOGs des MainTreatment");
        $this->setCanbelogged("info", $maintreatment, "false");
        $this->setCanbelogged("error", $maintreatment, "true");

        $steptype = $this->addChild("steptype", null, null, "Settings sur les LOGs des traitement de Type STEP");
        $this->setCanbelogged("info", $steptype, "false");
        $this->setCanbelogged("error", $steptype, "true");

        $operationtype = $this->addChild("operationtype", null, null, "Settings sur les LOGs des traitement de Type OPERATION");
        $this->setCanbelogged("info", $operationtype, "false");
        $this->setCanbelogged("error", $operationtype, "true");

        $treatmentstarting = $this->addChild("treatmentstarting", null, null, "Settings sur les LOGs des Starting traitement");
        $this->setCanbelogged("info", $treatmentstarting, "false");
        $this->setCanbelogged("error", $treatmentstarting, "true");

        $treatmentending = $this->addChild("treatmentending", null, null, "Settings sur les LOGs des Ending traitement");
        $this->setCanbelogged("info", $treatmentending, "false");
        $this->setCanbelogged("error", $treatmentending, "true");

        $rawtreatment = $this->addChild("rawtreatment", null, null, "Settings sur les LOGs de RawTreatment");
        $this->setCanbelogged("info", $rawtreatment, "false");
        $this->setCanbelogged("error", $rawtreatment, "true");

        $reportfile = $this->addChild("reportfile", null, null, "Settings sur les LOGs de reportfile");
        $this->setCanbelogged("info", $reportfile, "false");
        $this->setCanbelogged("error", $reportfile, "true");

        $treatmentjob = $this->addChild("treatmentjob", null, null, "Settings sur les LOGs de TreatmentJob");
        $this->setCanbelogged("info", $treatmentjob, "false");
        $this->setCanbelogged("error", $treatmentjob, "true");

        $treatmentservice = $this->addChild("treatmentservice", null, null, "Settings sur les LOGs de TreatmentService");
        $this->setCanbelogged("info", $treatmentservice, "false");
        $this->setCanbelogged("error", $treatmentservice, "true");

        $modelpicker = $this->addChild("modelpicker", null, null, "Settings sur les LOGs du ModelPicker");
        $this->setCanbelogged("info", $modelpicker, "false");
        $this->setCanbelogged("error", $modelpicker, "true");

        $formattedvalue = $this->addChild("formattedvalue", null, null, "Settings sur les LOGs des FormattedValue");
        $this->setCanbelogged("info", $formattedvalue, "false");
        $this->setCanbelogged("error", $formattedvalue, "true");
    }

    private function setCanbelogged(string $log_type, SettingNode $node, string $value) {
        $description = "Détermine si les logs " . strtoupper($log_type) . " peuvent etre effectuees pour le module " . strtoupper($node->getName());
        $node->addChild($log_type, $value, "bool", $description);
    }
}
