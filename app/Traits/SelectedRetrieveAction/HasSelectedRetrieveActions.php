<?php

namespace App\Traits\SelectedRetrieveAction;

use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\DynamicAttributes\DynamicAttribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\RetrieveAction\SelectedRetrieveAction;

/**
 * @property mixed selectedretrieveactions
 * @method HasMany selectedretrieveactions()
 * @method refresh()
 */
trait HasSelectedRetrieveActions
{
    public function setDefaultActionsFromSettings() {
        $scopes = config('Settings.selretrieveaction.default_actions_scopes');
        foreach ($scopes as $scope) {
            $this->addSelectedAction( RetrieveAction::$scope()->first() );
        }
        $this->refresh();
    }

    public function dynamicattributes()
    {
        return $this->morphMany(DynamicAttribute::class, 'hasdynamicattribute');
    }
    /**
     * Crée et Ajoute un objet SelectedRetrieveAction au modèle qui utilise ce trait et implémente l'interface y rattachée (HasSelectedRetrieveActions)
     * @param Model|RetrieveAction $retrieveaction L'Action sélectionnée
     * @param string|null $label Le libellé de la valeur rattachée (le cas échéant)
     * @param string|null $valuetype Le type de la valeur rattachée (le cas échéant)
     * @param mixed|null $actionvalue La valeur rattachée (le cas échéant)
     * @param string|null $description La description de l'action sélectionnée
     * @return SelectedRetrieveAction
     */
    public function addSelectedAction(Model|RetrieveAction $retrieveaction, string $label = null, string $valuetype = null, mixed $actionvalue = null, string $description = null): SelectedRetrieveAction
    {
        $selectedretrieveaction = SelectedRetrieveAction::createNew($retrieveaction,null, Status::active()->first(),$description);

        if ( !is_null($label) && !is_null($valuetype) ) {
            $selectedretrieveaction->addActionValue($label, $valuetype, $actionvalue);
        }

        $this->selectedretrieveactions()->save(
            $selectedretrieveaction
        );

        $this->refresh();

        return $selectedretrieveaction;
    }

    /**
     * Retire et supprime un objet SelectedRetrieveAction du modèle qui utilise ce trait et implémente l'interface y rattachée (HasSelectedRetrieveActions)
     * @param Model|SelectedRetrieveAction $selectedaction
     * @param bool $delete
     * @return bool|null
     */
    public function removeSelectedAction(Model|SelectedRetrieveAction $selectedaction, bool $delete = false): ?bool
    {
        $this->dissociateSelectedActions($selectedaction);
        $this->refresh();

        return $delete ? $selectedaction->delete() : true;
    }

    public function removeAllSelectedActions(bool $delete = false): ?bool
    {
        foreach ($this->selectedretrieveactions as $selectedaction) {
            $this->removeSelectedAction($selectedaction);
        }
        return true;
    }
}
