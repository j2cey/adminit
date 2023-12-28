<?php

namespace App\Contracts\ReportTreatment;

use App\Models\Treatments\Treatment;

interface IHasMainTreatments
{
    public function addMainTreatment(string $name, bool $dispatch_on_creation, array $payloads, string|null $description): ?Treatment;
    public function firstTreatmentWaiting(): Treatment;
    public function exec();
}
