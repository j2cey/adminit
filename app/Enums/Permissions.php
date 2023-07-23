<?php

namespace App\Enums;

abstract class Permissions
{
    public static function Role() : PermissionAction {
        $customlevels = ['create' => 1,'update' => 1,'delete' => 1];
        $additionalactions = null;
        return new PermissionAction("role", $customlevels, $additionalactions);
    }
    public static function Permission() : PermissionAction {
        $customlevels = ['create' => 1,'update' => 1,'delete' => 1];
        $additionalactions = null;
        return new PermissionAction("permission", $customlevels, $additionalactions);
    }

    public static function Report() : PermissionAction {
        return new PermissionAction("report");
    }
    public static function ReportType() : PermissionAction {
        return new PermissionAction("reporttype");
    }
    public static function DynamicAttributeType() : PermissionAction {
        return new PermissionAction("dynamicattributetype");
    }
    public static function DynamicAttribute() : PermissionAction {
        return new PermissionAction("dynamicattributes");
    }
    public static function AnalysisRuleType() : PermissionAction {
        return new PermissionAction("analysisruletype");
    }
    public static function AnalysisRule() : PermissionAction {
        return new PermissionAction("analysisrule");
    }
    public static function FileMimeType() : PermissionAction {
        return new PermissionAction("filemimetype");
    }
    public static function ReportFileType() : PermissionAction {
        return new PermissionAction("reportfiletype");
    }
    public static function ReportFile() : PermissionAction {
        return new PermissionAction("reportfile");
    }

    public static function ThresholdType() : PermissionAction {
        return new PermissionAction("thresholdtype");
    }
    public static function AnalysisRuleThreshold() : PermissionAction {
        return new PermissionAction("analysisrulethreshold");
    }
    public static function ThresholdMax() : PermissionAction {
        return new PermissionAction("thresholdmax");
    }
    public static function ThresholdMin() : PermissionAction {
        return new PermissionAction("thresholdmin");
    }

    public static function AccessAccount() : PermissionAction {
        return new PermissionAction("accessaccount");
    }
    public static function OsArchitecture() : PermissionAction {
        return new PermissionAction("osarchitecture");
    }
    public static function OsFamily() : PermissionAction {
        return new PermissionAction("osfamily");
    }
    public static function OsServer() : PermissionAction {
        return new PermissionAction("osserver");
    }
    public static function AccessProtocole() : PermissionAction {
        return new PermissionAction("accessprotocole");
    }
    public static function ReportFileAccess() : PermissionAction {
        return new PermissionAction("reportfileaccess");
    }
    public static function reportserver() : PermissionAction {
        return new PermissionAction("reportserver");
    }
    public static function RetrieveActiontype() : PermissionAction {
        return new PermissionAction("retrieveactiontype");
    }
    public static function RetrieveAction() : PermissionAction {
        return new PermissionAction("retrieveaction");
    }
    public static function SelectedRetrieveAction() : PermissionAction {
        return new PermissionAction("selectedretrieveaction");
    }
    public static function RetrieveActionValue() : PermissionAction {
        return new PermissionAction("retrieveactionvalue");
    }

    public static function ComparisonType() : PermissionAction {
        return new PermissionAction("comparisontype");
    }
    public static function AnalysisRuleComparison() : PermissionAction {
        return new PermissionAction("analysisrulecomparison");
    }
    public static function ComparisonLessThan() : PermissionAction {
        return new PermissionAction("comparisonlessthan");
    }
    public static function ComparisonGreaterThan() : PermissionAction {
        return new PermissionAction("comparisongreaterthan");
    }
    public static function ComparisonEqual() : PermissionAction {
        return new PermissionAction("comparisonequal");
    }
    public static function ComparisonNotEqual() : PermissionAction {
        return new PermissionAction("comparisonnotequal");
    }
    public static function CollectedReportFile() : PermissionAction {
        return new PermissionAction("collectedreportfile");
    }
    public static function ReportTreatmentResult() : PermissionAction {
        return new PermissionAction("reporttreatmentresult");
    }
    public static function ReportTreatmentStepResult() : PermissionAction {
        return new PermissionAction("reporttreatmentstepresult");
    }
    public static function OperationResult() : PermissionAction {
        return new PermissionAction("operationresult");
    }
    public static function FormatRuleType() : PermissionAction {
        return new PermissionAction("formatruletype");
    }
    public static function FormatRule() : PermissionAction {
        return new PermissionAction("formatrule");
    }
    public static function FormatType() : PermissionAction {
        return new PermissionAction("formattype");
    }
    public static function FormattedValueHtml() : PermissionAction {
        return new PermissionAction("formattedvaluehtml");
    }
    public static function FormattedValueSms() : PermissionAction {
        return new PermissionAction("formattedvaluesms");
    }
    public static function FormattedValue() : PermissionAction {
        return new PermissionAction("formattedvalue");
    }
    public static function FileHeader() : PermissionAction {
        return new PermissionAction("fileheader");
    }
    public static function LastRowConfig() : PermissionAction {
        return new PermissionAction("lastrowconfig");
    }
    public static function ReportTreatmentWorkflow() : PermissionAction {
        return new PermissionAction("reporttreatmentworkflow");
    }
    public static function ReportTreatmentWorkflowStep() : PermissionAction {
        return new PermissionAction("reporttreatmentworkflowstep");
    }
}
