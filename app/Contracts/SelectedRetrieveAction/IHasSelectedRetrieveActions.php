<?php

namespace App\Contracts\SelectedRetrieveAction;

use App\Models\Status;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\RetrieveAction\SelectedRetrieveAction;

interface IHasSelectedRetrieveActions
{
    //Liste les actions sélectionnées ( liste des SelectedRetrieveAction)
    public function selectedretrieveactions();

    public function setDefaultActionsFromSettings();
    public function addSelectedAction(RetrieveAction $retrieveaction, string $label = null, string $valuetype = null, $actionvalue = null, Status $status = null, string $description = null): SelectedRetrieveAction;
    public function removeSelectedAction(SelectedRetrieveAction $selectedretrieveaction, bool $delete = false): ?bool;
    public function removeAllSelectedActions(bool $delete = false): ?bool;
}
