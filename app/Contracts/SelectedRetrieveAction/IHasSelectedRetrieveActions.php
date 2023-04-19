<?php

namespace App\Contracts\SelectedRetrieveAction;

use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\RetrieveAction\SelectedRetrieveAction;

interface IHasSelectedRetrieveActions
{
    //Liste les actions sélectionnées ( liste des SelectedRetrieveAction)
    public function selectedretrieveactions();

    public function setDefaultActionsFromSettings();
    public function addSelectedAction(Model|RetrieveAction $retrieveaction, Status $status = null, string $description = null, string $actionvalue_label = null, string $actionvalue_valuetype = null, mixed $actionvalue = null): SelectedRetrieveAction;
    public function removeSelectedAction(SelectedRetrieveAction $selectedretrieveaction, bool $delete = false): ?bool;
    public function removeAllSelectedActions(bool $delete = false): ?bool;
}
