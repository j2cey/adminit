<?php

use Tabuna\Breadcrumbs\Trail;
use App\Models\Reports\Report;
use Tabuna\Breadcrumbs\Breadcrumbs;

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
#endregion
