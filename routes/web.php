<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\StatusController;
use App\Models\OsAndServer\OsArchitecture;
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
use App\Http\Controllers\AccessAccountController;
use App\Http\Controllers\Reports\ReportController;
use App\Http\Controllers\Reports\ReportTypeController;
use App\Http\Controllers\Authorization\RoleController;
use App\Http\Controllers\OsAndServer\OsFamilyController;
use App\Http\Controllers\ReportFile\ReportFileController;
use App\Http\Controllers\ReportFile\FileMimeTypeController;
use App\Http\Controllers\ReportFile\ReportFileTypeController;
use App\Http\Controllers\AnalysisRules\AnalysisRuleController;
use App\Http\Controllers\OsAndServer\OsArchitectureController;
use App\Http\Controllers\AnalysisRules\ThresholdTypeController;
use App\Http\Controllers\Reportsetting\ReportsettingController;
use App\Http\Controllers\AnalysisRules\AnalysisRuleTypeController;
use App\Http\Controllers\AnalysisRules\AnalysisHighlightController;
use App\Http\Controllers\AnalysisRules\HighlightTextSizeController;
use App\Http\Controllers\AnalysisRules\HighlightTextColorController;
use App\Http\Controllers\AnalysisRules\HighlightTextWeightController;
use App\Http\Controllers\DynamicAttributes\DynamicAttributeController;
use App\Http\Controllers\AnalysisRules\AnalysisRuleThresholdController;
use App\Http\Controllers\AnalysisRules\AnalysisHighlightTypeController;
use App\Http\Controllers\DynamicAttributes\DynamicAttributeTypeController;

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

Route::get('/tests', function () {
    $report = App\Models\Reports\Report::where("title","Report 01")->first();
    if ( is_null($report) ) {
        $report = App\Models\Reports\Report::createNew("Report 01", App\Models\Reports\ReportType::first(), "");
        $report->addDynamicAttribute("Att Dyn. 01", App\Models\DynamicAttributes\DynamicAttributeType::find(1)->first(), "");
        $report->latestDynamicattribute->addValue("Test for Add value xxx 1", true);
        $report->addDynamicAttribute("Att Dyn. 02", App\Models\DynamicAttributes\DynamicAttributeType::find(2)->first(), "");
        $report->latestDynamicattribute->addValue("241");
        $report->addDynamicAttribute("Att Dyn. 02", App\Models\DynamicAttributes\DynamicAttributeType::find(4)->first(), "");
        $report->latestDynamicattribute->addValue("0");

        $report->dynamicattributes[0]->addValue("Test for the new row", true);
    }
    //$report->dynamicattributes[0]->addValue("Test for the latest row", true);
    //dd($report->latestDynamicattribute());
    //$report->latestDynamicattribute()->addValue("Test for Add value xxx 1", true);
    //dd($report->oldestDynamicattribute->hasdynamicattribute->latestDynamicvaluerow);
    dd($report);
    $first_report = App\Models\Reports\Report::first();
    dd("first_report: ", $first_report, $first_report->dynamicattributes, $first_report->dynamicattributes[0]->values());
});

#region System Settings

Route::get('systems.index',[SystemController::class,'index'])
    ->name('systems.index')
    ->middleware('auth');

Route::resource('settings',SettingController::class);
Route::get('settings.fetch',[SettingController::class,'fetch'])
    ->name('settings.fetch')
    ->middleware('auth');

Route::get('reportsetting.index',[ReportsettingController::class,'index'])
    ->name('reportsetting.index')
    ->middleware('auth');

#endregion

#region permissions & roles

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

Route::resource('dynamicattributes',DynamicAttributeController::class)->middleware('auth');
Route::get('dynamicattributes.fetch',[DynamicAttributeController::class,'fetch'])
    ->name('dynamicattributes.fetch')
    ->middleware('auth');

Route::resource('dynamicattributetypes',DynamicAttributeTypeController::class)->middleware('auth');
Route::get('dynamicattributetypes.fetch',[DynamicAttributeTypeController::class,'fetch'])
    ->name('dynamicattributetypes.fetch')
    ->middleware('auth');
Route::get('dynamicattributetypes.fetchall',[DynamicAttributeTypeController::class,'fetchall'])
    ->name('dynamicattributetypes.fetchall')
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

Route::resource('analysishighlighttypes',AnalysisHighlightTypeController::class)->middleware('auth');
Route::get('analysishighlighttypes.fetch',[AnalysisHighlightTypeController::class,'fetch'])
    ->name('analysishighlighttypes.fetch')
    ->middleware('auth');
Route::get('analysishighlighttypes.fetchall',[AnalysisHighlightTypeController::class,'fetchall'])
    ->name('analysishighlighttypes.fetchall')
    ->middleware('auth');

Route::resource('analysishighlights',AnalysisHighlightController::class)->middleware('auth');
Route::get('analysishighlights.fetch',[AnalysisHighlightController::class,'fetch'])
    ->name('analysishighlights.fetch')
    ->middleware('auth');
Route::get('analysishighlights.fetchall',[AnalysisHighlightController::class,'fetchall'])
    ->name('analysishighlights.fetchall')
    ->middleware('auth');

Route::resource('highlighttextcolors',HighlightTextColorController::class)->middleware('auth');
Route::get('highlighttextcolors.fetch',[HighlightTextColorController::class,'fetch'])
    ->name('highlighttextcolors.fetch')
    ->middleware('auth');
Route::get('highlighttextcolors.fetchall',[HighlightTextColorController::class,'fetchall'])
    ->name('highlighttextcolors.fetchall')
    ->middleware('auth');

Route::resource('highlighttextsizes',HighlightTextSizeController::class)->middleware('auth');
Route::get('highlighttextsizes.fetch',[HighlightTextSizeController::class,'fetch'])
    ->name('highlighttextsizes.fetch')
    ->middleware('auth');
Route::get('highlighttextsizes.fetchall',[HighlightTextSizeController::class,'fetchall'])
    ->name('highlighttextsizes.fetchall')
    ->middleware('auth');

Route::resource('highlighttextweights',HighlightTextWeightController::class)->middleware('auth');

Route::get('highlighttextweights.fetch',[HighlightTextWeightController::class,'fetch'])
    ->name('highlighttextweights.fetch')
    ->middleware('auth');
Route::get('highlighttextweights.fetchall',[HighlightTextWeightController::class,'fetchall'])
    ->name('highlighttextweights.fetchall')
    ->middleware('auth');

Route::resource('filemimetypes',FileMimeTypeController::class)->middleware('auth');
Route::get('filemimetypes.fetch',[FileMimeTypeController::class,'fetch'])
    ->name('filemimetypes.fetch')
    ->middleware('auth');

Route::resource('reportfiletypes',ReportFileTypeController::class)->middleware('auth');
Route::get('reportfiletypes.fetch',[ReportFileTypeController::class,'fetch'])
    ->name('reportfiletypes.fetch')
    ->middleware('auth');



Route::resource('reportfiles',ReportFileController::class)->middleware('auth');

Route::resource('accessaccounts',AccessAccountController::class)->middleware('auth');

Route::resource('osarchitectures',OsArchitectureController::class)->middleware('auth');
Route::get('osarchitectures.fetch',[OsArchitectureController::class,'fetch'])
    ->name('osarchitectures.fetch')
    ->middleware('auth');

Route::resource('osfamilies',OsFamilyController::class)->middleware('auth');
Route::get('osfamilies.fetch',[OsFamilyController::class,'fetch'])
    ->name('osfamilies.fetch')
    ->middleware('auth');

//Route::resource('reportservers',ReportServerController::class)->middleware('auth');

