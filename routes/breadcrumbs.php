<?php

use Tabuna\Breadcrumbs\Trail;
use App\Models\Reports\Report;
use Tabuna\Breadcrumbs\Breadcrumbs;
use App\Models\ReportFile\ReportFile;
use App\Models\ReportFile\CollectedReportFile;
use App\Models\DynamicAttributes\DynamicAttribute;
use App\Models\DynamicAttributes\DynamicAttributeType;
use App\Models\ReportTreatments\ReportTreatmentResult;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

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

#region ReportTreatmentResults
// ReportTreatmentResults
Breadcrumbs::for('reporttreatmentresults.index', function (Trail $trail) {
    $trail->parent('home')->push('Traitements Rapports', route('reporttreatmentresults.index'));
});
// ReportTreatmentResults.show
Breadcrumbs::for('reporttreatmentresults.show', function (Trail $trail, ReportTreatmentResult $reporttreatmentresult) {
    $trail->parent('reporttreatmentresults.index')
        ->push($reporttreatmentresult->name, route('reporttreatmentresults.show', $reporttreatmentresult->uuid));
});
// ReportTreatmentStepResults.show
Breadcrumbs::for('reporttreatmentstepresults.show', function (Trail $trail, ReportTreatmentStepResult $reporttreatmentstepresult) {
    $trail->parent('reporttreatmentresults.show', $reporttreatmentstepresult->reporttreatmentresult)
        ->push($reporttreatmentstepresult->name, route('reporttreatmentstepresults.show', $reporttreatmentstepresult->uuid));
});
