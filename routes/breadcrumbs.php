<?php

use Tabuna\Breadcrumbs\Trail;
use App\Models\Reports\Report;
use Tabuna\Breadcrumbs\Breadcrumbs;
use App\Models\ReportFile\ReportFile;
use App\Models\ReportFile\CollectedReportFile;
use App\Models\Treatments\ReportTreatment;
use App\Models\DynamicAttributes\DynamicAttribute;
use App\Models\Treatments\TreatmentOperation;
use App\Models\Treatments\ReportTreatmentStep;
use App\Models\DynamicAttributes\DynamicAttributeType;
use App\Models\Treatments\ReportTreatmentResult;
use App\Models\Treatments\ReportTreatmentStepResult;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

#region System
// System
Breadcrumbs::for('systems.index', function (Trail $trail) {
    $trail->parent('home')->push('System', route('systems.index'));
});
#endregion

#region Reports
// Reports
Breadcrumbs::for('reports.index', function (Trail $trail) {
    $trail->parent('home')->push('Reports', route('reports.index'));
});
// Reports.show
Breadcrumbs::for('reports.show', function (Trail $trail, Report $report) {
    $trail->parent('reports.index')
        ->push($report->title, route('reports.show', $report->uuid));
});
// Reports.dynamicattributes
Breadcrumbs::for('reports.dynamicattributes', function (Trail $trail, $uuid) {
    $report = Report::where('uuid',$uuid)->first();
    $trail->parent('reports.show', $report)
        ->push("Liste des Champs", route('reports.dynamicattributes', $report->uuid));
});
// CollectedReportFiles.show
Breadcrumbs::for('dynamicattributes.show', function (Trail $trail, DynamicAttribute $dynamicattribute) {
    $trail->parent('reports.dynamicattributes', $dynamicattribute->hasdynamicattribute->uuid)
        ->push($dynamicattribute->id, route('dynamicattributes.show', $dynamicattribute->uuid));
});

// Reports.reportfiles
Breadcrumbs::for('reports.reportfiles', function (Trail $trail, $uuid) {
    $report = Report::where('uuid',$uuid)->first();
    $trail->parent('reports.show', $report)
        ->push("Liste des Fichiers", route('reports.reportfiles', $report->uuid));
});
#endregion

#region ReportFiles
// ReportFiles.show
Breadcrumbs::for('reportfiles.show', function (Trail $trail, ReportFile $reportfile) {
    $trail->parent('reports.show', $reportfile->report)
        ->push($reportfile->name, route('reportfiles.show', $reportfile->uuid));
});
// CollectedReportFiles.show
Breadcrumbs::for('collectedreportfiles.show', function (Trail $trail, CollectedReportFile $collectedreportfile) {
    $trail->parent('reportfiles.show', $collectedreportfile->reportfile)
        ->push($collectedreportfile->id, route('reportfiles.show', $collectedreportfile->uuid));
});
#endregion

#region ReportTreatments
// ReportTreatmentResults
Breadcrumbs::for('reporttreatments.index', function (Trail $trail) {
    $trail->parent('home')->push('Traitements Rapports', route('reporttreatments.index'));
});
// ReportTreatments.show
Breadcrumbs::for('reporttreatments.show', function (Trail $trail, ReportTreatment $reporttreatment) {
    $trail->parent('reporttreatments.index')
        ->push($reporttreatment->name, route('reporttreatments.show', $reporttreatment->uuid));
});
// ReportTreatmentSteps.show
Breadcrumbs::for('reporttreatmentsteps.show', function (Trail $trail, ReportTreatmentStep $reporttreatmentstep) {
    $trail->parent('reporttreatments.show', $reporttreatmentstep->reporttreatment)
        ->push($reporttreatmentstep->name, route('reporttreatmentsteps.show', $reporttreatmentstep->uuid));
});
// TreatmentOperations.show
Breadcrumbs::for('treatmentoperations.show', function (Trail $trail, TreatmentOperation $treatmentoperation) {
    $trail->parent('reporttreatmentsteps.show', $treatmentoperation->reporttreatmentstep)
        ->push($treatmentoperation->name, route('treatmentoperations.show', $treatmentoperation->uuid));
});
