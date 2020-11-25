<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Departement
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $intitule
 * @property string|null $chemin_complet
 * @property string|null $description
 *
 * @property integer|null $type_departement_id
 * @property integer|null $departement_parent_id
 * @property integer|null $employe_responsable_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Departement extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'intitule' => ['required','string','min:3','max:100',],
            'type_departement_id' => ['required',],
        ];
    }
    public static function createRules()  {
        return array_merge(self::defaultRules(), [
            'chemin_complet' => ['unique:departements,chemin_complet,NULL,id,deleted_at,NULL'],
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
            'chemin_complet' => ['unique:departements,chemin_complet,'.$model->id.',id,deleted_at,NULL',],
        ]);
    }
    public static function validationMessages() {
        return [
            'type_departement_id.required' => 'Prière de sélectionner un Type Département',
            'chemin_complet.unique' => 'Il existe déjà un département de même intitulé pour ce Parent',
        ];
    }

    #region Eloquent Relationships

    /**
     * Renvoie l'employe responsable du Departement.
     */
    public function typedepartement() {
        return $this->belongsTo('App\TypeDepartement', 'type_departement_id');
    }

    /**
     * Renvoie le Departement du Departement.
     */
    public function parent() {
        return $this->belongsTo('App\Departement', 'departement_parent_id');
    }

    /**
     * Renvoie les employés de ce Departement.
     */
    public function employes() {
        return $this->hasMany('App\Employe');
    }

    /**
     * Renvoie les departement departementenfants du Departement.
     */
    public function departementenfants() {
        return $this->hasMany('App\Departement', 'departement_parent_id');
    }

    /**
     * Renvoie l'employe responsable du Departement.
     */
    public function employeResponsable() {
        return $this->belongsTo('App\Employe', 'employe_responsable_id');
    }

    #endregion

    public static function getCheminComplet($intitule, $parent_id) {
        if (is_null($parent_id)) {
            return $intitule;
        } else {
            $parent = Departement::find($parent_id);

            return $parent->chemin_complet . ' > ' . $intitule;
        }
    }

    /**
     * Reconstruit le chemin complet du Depatement
     * @return void
     */
    private function rebuildCheminComplet() {
        $new_chemin_complet = Departement::getCheminComplet($this->intitule, $this->departement_parent_id);
        if ($this->chemin_complet == $new_chemin_complet) {
            // nothing to do
        } else {
            // we set the new one
            $this->chemin_complet = $new_chemin_complet;
            $this->save();
        }
    }

    public static function boot(){
        parent::boot();

        // Après chaque modification
        self::updated(function($model){
            // On reconstruit le chemin complet
            $model->rebuildCheminComplet();
            // On reconstruit les chemins complet de tous les enfants
            foreach ($model->departementenfants as $departementenfant) {
                $departementenfant->rebuildCheminComplet();
            }
        });
    }

    #endregion
}
