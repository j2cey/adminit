<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\ReportFile\ReportFile;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SettingController;
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
use App\Http\Controllers\OsAndServer\OsArchitectureController;
use App\Http\Controllers\AnalysisRules\ThresholdTypeController;
use App\Http\Controllers\Reportsetting\ReportsettingController;
use App\Http\Controllers\ReportFile\ReportFileAccessController;
use App\Http\Controllers\ReportFile\CollectedReportFileController;

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

Route::get('test', function () {
    $reporttreatment = \App\Models\Treatments\ReportTreatment::getById(1);
    dd($reporttreatment);
    //$queuecode_value = "listeners";
    //dd( ( \App\Enums\Settings::Queues()->workerbounds()->$queuecode_value()->get() ));
    /*$class_methods = get_class_methods(\App\Enums\Settings::class);

    foreach ($class_methods as $class_method) {
        $branch = \App\Enums\Settings::$class_method();
        dump("branch: ", $branch);
        foreach ($branch->getChildren() as $child) {
            dump("child: ", $child);
        }
    }*/
});

#region System Settings

Route::get('systems.index',[SystemController::class,'index'])
    ->name('systems.index')
    ->middleware('auth');

Route::resource('settings',SettingController::class);
Route::get('settings.fetch',[SettingController::class,'fetch'])
    ->name('settings.fetch')
    ->middleware('auth');

Route::get('settings.types',[SettingController::class,'settingtypes'])
    ->name('settings.types')
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
Route::get('users.fetchone/{id}',[UserController::class,'fetchone'])
    ->name('users.fetchone')
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

Route::resource('thresholdtypes',ThresholdTypeController::class)->middleware('auth');
Route::get('thresholdtypes.fetch',[ThresholdTypeController::class,'fetch'])
    ->name('thresholdtypes.fetch')
    ->middleware('auth');
Route::get('thresholdtypes.fetchall',[ThresholdTypeController::class,'fetchall'])
    ->name('thresholdtypes.fetchall')
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
    $reportfile = ReportFile::getById(1);
    $reportfileaccess = $reportfile->getActiveReportFileAccess();
    if (count(\App\Models\Treatments\ReportTreatment::get()) == 0) {
        $step = $reportfile->createNewTreatment()->stepAddOrGet(\App\Enums\Treatments\TreatmentCodeEnum::DOWNLOADFILE);
    } else {
        $step = \App\Models\Treatments\ReportTreatmentStep::getById(1);
    }
    $disk = $reportfileaccess->getDisk($step, \App\Enums\CriticalityLevelEnum::HIGH);
    //dd($reportfile->localName, $reportfile->fileRemotePath, $disk->readStream("/" . $reportfile->fileRemotePath));
    $collectedreportfiles_folder = config('app.collectedreportfiles_folder');
    $result = Storage::disk('public')->put('/' . $collectedreportfiles_folder . '/' . $reportfile->localName, $disk->readStream($reportfile->fileRemotePath));
});

Route::resource('accessaccounts',AccessAccountController::class)->middleware('auth');
Route::get('accessaccounts.fetch',[AccessAccountController::class,'fetch'])
    ->name('accessaccounts.fetch')
    ->middleware('auth');


