<?php

namespace App\Services\Operations;

use Illuminate\Support\Facades\Artisan;
use App\Models\ReportTreatments\Treatment;
use App\Services\Steps\ImportFileStepService;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Traits\ReportTreatment\Operation\TreatmentOperationService;
use App\Contracts\ReportTreatment\Operation\ITreatmentOperationService;

class ImportFileDoImportService extends ImportFileStepService implements ITreatmentOperationService
{
    use TreatmentOperationService;

    public static function launch(Treatment $treatment): ?Treatment {
        return self::exec($treatment);
    }

    public static function exec(Treatment $treatment): ?Treatment
    {
        //Artisan::call('reportfile:import', ['treatmentId' => $treatment->id]);
        return null;
    }

    public static function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

    }
}
