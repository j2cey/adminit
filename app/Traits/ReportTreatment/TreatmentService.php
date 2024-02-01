<?php

namespace App\Traits\ReportTreatment;

use App\Models\Treatments\Treatment;
use App\Models\ReportFile\CollectedReportFile;

trait TreatmentService
{
    public static string $COLLECTEDREPORTFILE_KEY = "collectedReportFileId";

    public static function addCollectedReportFileToPayload(array $payloads, CollectedReportFile $collectedReportFile): array
    {
        $payloads[self::$COLLECTEDREPORTFILE_KEY] = $collectedReportFile->id;
        return $payloads;
    }

    public static function setCollectedReportFileFromPayload(Treatment $treatment) {
        if ( is_null($treatment->service->dynamicrow) ) {
            $treatment->service->setCollectedReportFile( CollectedReportFile::getById( (int) $treatment->getPayloadEntry(self::$COLLECTEDREPORTFILE_KEY ) ) );
        }
    }
}
