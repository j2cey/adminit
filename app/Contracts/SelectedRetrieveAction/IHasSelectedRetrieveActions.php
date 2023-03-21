<?php

namespace App\Contracts\SelectedRetrieveAction;

use OwenIt\Auditing\Contracts\Auditable;
use App\Models\RetrieveAction\RetrieveAction;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\RetrieveAction\SelectedRetrieveAction;

interface IHasSelectedRetrieveActions extends Auditable
{
    public function selectedretrieveactions(): HasMany;
    public function setDefaultActionsFromSettings();
    public function addSelectedAction(RetrieveAction $retrieveaction, string $label = null, string $valuetype = null, $actionvalue = null, string $description = null): SelectedRetrieveAction;
    public function removeSelectedAction(SelectedRetrieveAction $selectedretrieveaction, bool $delete = false): ?bool;
    public function removeAllSelectedActions(bool $delete = false): ?bool;
    public function dissociateSelectedActions(SelectedRetrieveAction $selectedretrieveaction): ?bool;
}
