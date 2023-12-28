<?php

namespace App\Services\Operations;

use Illuminate\Support\Facades\Artisan;
use App\Models\Treatments\Treatment;
use App\Services\Steps\ImportFileStepService;
use App\Enums\Treatments\TreatmentResultEnum;
use App\Traits\ReportTreatment\Operation\TreatmentOperationService;
use App\Contracts\ReportTreatment\Operation\ITreatmentOperationService;

class ImportFileDoImportService extends ImportFileStepService implements ITreatmentOperationService
{
    use TreatmentOperationService;

    public function launch(Treatment $treatment): ?Treatment {
        return self::exec($treatment);
    }

    public function exec(): ?Treatment
    {
        //Artisan::call('reportfile:import', ['treatmentId' => $treatment->id]);
        return null;
    }

    public function postEnding(Treatment $treatment, TreatmentResultEnum $treatmentresultenum, Treatment $child_treatment = null, string $message = null, bool $complete_treatment = false) {

    }
}
