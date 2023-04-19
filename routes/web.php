<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubTaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\ExecutionController;
use App\Http\Controllers\GradeUnitController;
use App\Http\Controllers\SubSubjectController;
use App\Http\Controllers\DifficultyController;
use App\Http\Controllers\AppreciationController;
use App\Http\Controllers\Reports\ReportController;
use App\Http\Controllers\Reports\ReportTypeController;
use App\Http\Controllers\Authorization\RoleController;
use App\Http\Controllers\Access\AccessAccountController;
use App\Http\Controllers\OsAndServer\OsFamilyController;
use App\Http\Controllers\OsAndServer\OsServerController;
use App\Http\Controllers\ReportFile\ReportFileController;
use App\Http\Controllers\Access\AccessProtocoleController;
use App\Http\Controllers\ReportFile\FileMimeTypeController;
use App\Http\Controllers\OsAndServer\ReportServerController;
use App\Http\Controllers\ReportFile\ReportFileTypeController;
use App\Http\Controllers\AnalysisRules\AnalysisRuleController;
use App\Http\Controllers\OsAndServer\OsArchitectureController;
use App\Http\Controllers\AnalysisRules\ThresholdMinController;
use App\Http\Controllers\AnalysisRules\ThresholdMaxController;
use App\Http\Controllers\AnalysisRules\ThresholdTypeController;
use App\Http\Controllers\Reportsetting\ReportsettingController;
use App\Http\Controllers\ReportFile\ReportFileAccessController;
use App\Http\Controllers\AnalysisRules\AnalysisRuleTypeController;
use App\Http\Controllers\ReportFile\CollectedReportFileController;
use App\Http\Controllers\ReportTreatments\OperationResultController;
use App\Http\Controllers\AnalysisRules\AnalysisRuleThresholdController;
use App\Http\Controllers\AnalysisRuleComparison\ComparisonTypeController;
use App\Http\Controllers\ReportTreatments\ReportTreatmentResultController;
use App\Http\Controllers\AnalysisRuleComparison\ComparisonEqualController;
use App\Http\Controllers\AnalysisRuleComparison\ComparisonNotEqualController;
use App\Http\Controllers\AnalysisRuleComparison\ComparisonLessThanController;
use App\Http\Controllers\ReportTreatments\ReportTreatmentStepResultController;
use App\Http\Controllers\AnalysisRuleComparison\ComparisonGreaterThanController;
use App\Http\Controllers\AnalysisRuleComparison\AnalysisRuleComparisonController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return view('admin02');
    }
    return redirect('/login');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

#region System Settings

Route::get('systems.index',[SystemController::class,'index'])
    ->name('systems.index')
    ->middleware('auth');

Route::resource('settings',SettingController::class);
Route::get('settings.fetch',[SettingController::class,'fetch'])
    ->name('settings.fetch')
    ->middleware('auth');

Route::get('settings.test', function () {
    dd(config('Settings.selretrieveaction.default_actions_scopes'));
});

Route::get('reportsetting.index',[ReportsettingController::class,'index'])
    ->name('reportsetting.index')
    ->middleware('auth');

#endregion

#region permissions & roles

Route::get('permissions.test', function () {
    dd(\App\Enums\Permissions::AnalysisHighlight()->create());
    //dd(App\Models\RetrieveAction\RetrieveAction::can_create());
});

Route::get('permissions',[RoleController::class, 'permissions'])->middleware('auth');

Route::resource('roles',RoleController::class)->middleware('auth');
Route::get('roles.fetch',[RoleController::class,'fetch'])
    ->name('roles.fetch')
    ->middleware('auth');
Route::get('hasrole/{roleid}',[RoleController::class, 'hasrole'])->middleware('auth');

Route::resource('users',UserController::class)->middleware('auth');
Route::get('users.fetch',[UserController::class,'fetch'])
    ->name('users.fetch')
    ->middleware('auth');
Route::get('users.fetchall',[UserController::class,'fetchall'])
    ->name('users.fetchall')
    ->middleware('auth');

#endregion

Route::resource('statuses',StatusController::class);
Route::get('statuses.fetch',[StatusController::class,'fetch'])
    ->name('statuses.fetch')
    ->middleware('auth');
Route::get('statuses.fetchone/{id}',[StatusController::class,'fetchone'])
    ->name('statuses.fetchone')
    ->middleware('auth');
Route::match(['post'],'statuses.modelupdate',[StatusController::class, 'modelupdate'])
    ->name('statuses.modelupdate')
    ->middleware('auth');

#region subjects

Route::resource('subjects',SubjectController::class)->middleware('auth');
Route::resource('subsubjects',SubSubjectController::class)->middleware('auth');
Route::get('/subject/fetch', [SubjectController::class, 'fetch'])->name('subject.fetch');

#endregion

Route::resource('categories',CategoryController::class)->middleware('auth');
Route::resource('tasks',TaskController::class)->middleware('auth');
Route::resource('subtasks',SubTaskController::class)->middleware('auth');

Route::resource('comments',CommentController::class)->middleware('auth');
Route::match(['put', 'patch'],'comments/remove/{comment}', [CommentController::class, 'remove'])
    ->name('comments.remove')
    ->middleware('auth');

Route::resource('difficulties',DifficultyController::class)->middleware('auth');
Route::post('difficulties/add', [DifficultyController::class, 'add'])
    ->name('difficulties.add')
    ->middleware('auth');

Route::resource('priorities',PriorityController::class)->middleware('auth');
Route::post('priorities/add', [PriorityController::class, 'add'])
    ->name('priorities.add')
    ->middleware('auth');

Route::resource('appreciations',AppreciationController::class)->middleware('auth');
Route::post('appreciations/add', [AppreciationController::class, 'add'])
    ->name('appreciations.add')
    ->middleware('auth');

Route::resource('executions',ExecutionController::class)->middleware('auth');
Route::post('executions/add', [ExecutionController::class, 'add'])
    ->name('executions.add')
    ->middleware('auth');

Route::resource('gradeunits',GradeUnitController::class)->middleware('auth');


/*
|--------------------------------------------------------------------------
| Report (Admin IT) Routes
|--------------------------------------------------------------------------
|
|
*/
Route::resource('reporttypes',ReportTypeController::class)->middleware('auth');
Route::get('reporttypes.fetch',[ReportTypeController::class,'fetch'])
    ->name('reporttypes.fetch')
    ->middleware('auth');
Route::get('reporttypes.fetchall',[ReportTypeController::class,'fetchall'])
    ->name('reporttypes.fetchall')
    ->middleware('auth');

Route::resource('reports',ReportController::class)->middleware('auth');
Route::get('reports.fetch',[ReportController::class,'fetch'])
    ->name('reports.fetch')
    ->middleware('auth');
Route::get('reports.reportfiles/{uuid}',[ReportController::class,'reportfiles'])
    ->name('reports.reportfiles')
    ->middleware('auth');
Route::get('reports.dynamicattributes/{uuid}',[ReportController::class,'attributes'])
    ->name('reports.dynamicattributes')
    ->middleware('auth');

Route::resource('analysisruletypes',AnalysisRuleTypeController::class)->middleware('auth');
Route::get('analysisruletypes.fetch',[AnalysisRuleTypeController::class,'fetch'])
    ->name('analysisruletypes.fetch')
    ->middleware('auth');
Route::get('analysisruletypes.fetchall',[AnalysisRuleTypeController::class,'fetchall'])
    ->name('analysisruletypes.fetchall')
    ->middleware('auth');

Route::resource('thresholdtypes',ThresholdTypeController::class)->middleware('auth');
Route::get('thresholdtypes.fetch',[ThresholdTypeController::class,'fetch'])
    ->name('thresholdtypes.fetch')
    ->middleware('auth');
Route::get('thresholdtypes.fetchall',[ThresholdTypeController::class,'fetchall'])
    ->name('thresholdtypes.fetchall')
    ->middleware('auth');

Route::resource('analysisrules',AnalysisRuleController::class)->middleware('auth');
Route::get('analysisrules.fetch',[AnalysisRuleController::class,'fetch'])
    ->name('analysisrules.fetch')
    ->middleware('auth');
Route::get('analysisrules.fetchall',[AnalysisRuleController::class,'fetchall'])
    ->name('analysisrules.fetchall')
    ->middleware('auth');
Route::get('analysisrules.fetchone/{id}',[AnalysisRuleController::class,'fetchone'])
    ->name('analysisrules.fetchone')
    ->middleware('auth');

Route::resource('analysisrulethresholds',AnalysisRuleThresholdController::class)->middleware('auth');
Route::get('analysisrulethresholds.fetch',[AnalysisRuleThresholdController::class,'fetch'])
    ->name('analysisrulethresholds.fetch')
    ->middleware('auth');
Route::get('analysisrulethresholds.fetchall',[AnalysisRuleThresholdController::class,'fetchall'])
    ->name('analysisrulethresholds.fetchall')
    ->middleware('auth');

Route::resource('filemimetypes',FileMimeTypeController::class)->middleware('auth');
Route::get('filemimetypes.fetch',[FileMimeTypeController::class,'fetch'])
    ->name('filemimetypes.fetch')
    ->middleware('auth');

Route::resource('reportfiletypes',ReportFileTypeController::class)->middleware('auth');
Route::get('reportfiletypes.fetch',[ReportFileTypeController::class,'fetch'])
    ->name('reportfiletypes.fetch')
    ->middleware('auth');

Route::resource('collectedreportfiles',CollectedReportFileController::class)->middleware('auth');
Route::get('collectedreportfiles.fetch',[CollectedReportFileController::class,'fetch'])
    ->name('collectedreportfiles.fetch')
    ->middleware('auth');



Route::resource('reportfiles',ReportFileController::class)->middleware('auth');

Route::resource('osarchitectures',OsArchitectureController::class)->middleware('auth');
Route::get('osarchitectures.fetch',[OsArchitectureController::class,'fetch'])
    ->name('osarchitectures.fetch')
    ->middleware('auth');

Route::resource('osfamilies',OsFamilyController::class)->middleware('auth');
Route::get('osfamilies.fetch',[OsFamilyController::class,'fetch'])
    ->name('osfamilies.fetch')
    ->middleware('auth');

Route::resource('osservers',OsServerController::class)->middleware('auth');
Route::get('osservers.fetch',[OsServerController::class,'fetch'])
    ->name('osservers.fetch')
    ->middleware('auth');

Route::resource('accessprotocoles',AccessProtocoleController::class)->middleware('auth');
Route::get('accessprotocoles.fetch',[AccessProtocoleController::class,'fetch'])
    ->name('accessprotocoles.fetch')
    ->middleware('auth');


Route::resource('reportservers',ReportServerController::class)->middleware('auth');
Route::get('reportservers.fetch',[ReportServerController::class,'fetch'])
    ->name('reportservers.fetch')
    ->middleware('auth');

Route::resource('reportfileaccesses',ReportFileAccessController::class)->middleware('auth');
Route::get('reportfileaccesses.fetch',[ReportFileAccessController::class,'fetch'])
    ->name('reportfileaccesses.fetch')
    ->middleware('auth');
Route::get('reportfileaccesses.download',[ReportFileAccessController::class,'download'])
    ->name('reportfileaccesses.download')
    ->middleware('auth');

Route::get('reportfileaccesses.test', function () {
    //$reportfile = App\Models\ReportFile\ReportFile::createNew( \App\Models\Reports\Report::createNew("new Report", App\Models\Reports\ReportType::defaultReport()->first()) )
    //$reportfileaccess = \App\Models\ReportFile\ReportFileAccess::createNew()
});

Route::resource('accessaccounts',AccessAccountController::class)->middleware('auth');
Route::get('accessaccounts.fetch',[AccessAccountController::class,'fetch'])
    ->name('accessaccounts.fetch')
    ->middleware('auth');

Route::resource('thresholdmins',ThresholdMinController::class)->middleware('auth');
Route::get('thresholdmins.fetch',[ThresholdMinController::class,'fetch'])
    ->name('thresholdmins.fetch')
    ->middleware('auth');

Route::resource('thresholdmaxes',ThresholdMaxController::class)->middleware('auth');
Route::get('thresholdmaxes.fetch',[ThresholdMaxController::class,'fetch'])
    ->name('thresholdmaxes.fetch')
    ->middleware('auth');

Route::resource('comparisontypes',ComparisonTypeController::class)->middleware('auth');
Route::get('comparisontypes.fetchall',[ComparisonTypeController::class,'fetchall'])
    ->name('comparisontypes.fetchall')
    ->middleware('auth');

Route::resource('analysisrulecomparisons',AnalysisRuleComparisonController::class)->middleware('auth');
Route::get('analysisrulecomparisons.fetchall',[AnalysisRuleComparisonController::class,'fetchall'])
    ->name('analysisrulecomparisons.fetchall')
    ->middleware('auth');

Route::resource('comparisonlessthans',ComparisonLessThanController::class)->middleware('auth');

Route::resource('comparisongreaterthans',ComparisonGreaterThanController::class)->middleware('auth');

Route::resource('comparisonequals',ComparisonEqualController::class)->middleware('auth');

Route::resource('comparisonnotequals',ComparisonNotEqualController::class)->middleware('auth');

Route::resource('reporttreatmentresults',ReportTreatmentResultController::class)->middleware('auth');
Route::resource('reporttreatmentstepresults',ReportTreatmentStepResultController::class)->middleware('auth');
Route::resource('operationresults',OperationResultController::class)->middleware('auth');


