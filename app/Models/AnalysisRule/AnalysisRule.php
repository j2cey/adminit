<?php

namespace App\Models\AnalysisRule;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\FormatRule\HasFormatRules;
use App\Contracts\AnalysisRules\IInnerRule;
use App\Contracts\FormatRule\IHasFormatRules;
use App\Models\DynamicAttributes\DynamicAttribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AnalysisRule
 * @package App\Models\AnalysisRules
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $title
 * @property string $description
 *
 * @property string $innerrule_type
 * @property integer $innerrule_id
 *
 * @property boolean $alert_when_allowed
 * @property boolean $alert_when_broken
 *
 * @property integer|null $analysis_rule_type_id
 * @property integer|null $dynamic_attribute_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property DynamicAttribute $dynamicattributes
 * @property IInnerRule $innerrule
 * @property AnalysisRuleType $analysisruletype
 *
 * @method static AnalysisRule first()
 */
class AnalysisRule extends BaseModel implements IHasFormatRules
{
    use HasFactory, HasFormatRules, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ["innerrule"];

    #region Validation Rules

    public static function defaultRules()
    {
        return [
            'title' => ['required'],
            'analysisruletype' => ['required'],
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function updateRules($model)
    {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function messagesRules()
    {
        return [
            'title.required' => "Prière de renseigner le Titre",
            'analysisruletype.required' => "Prière de renseigner le Type de Règle d'analyse",
        ];
    }

    #endregion

    #region Eloquent Relationships

    public function analysisruletype() {
        return $this->belongsTo(AnalysisRuleType::class,"analysis_rule_type_id");
    }

    public function dynamicattribute() {
        return $this->belongsTo(DynamicAttribute::class,"dynamic_attribute_id");
    }

    /**
     * @return MorphTo
     * Get the parent inner rule model.
     */
    public function innerrule()
    {
        return $this->morphTo();
    }

    #endregion

    #region Custom Functions

    /**
     * Crée (et stocke dans la base de données) une nouvelle Règle d'Analyse (AnalysisRule)
     * @param Model|DynamicAttribute $dynamicattribute L'Attribut
     * @param Model|AnalysisRuleType $analysisruletype Le Type de Règle d'Analyse
     * @param string $title Le Titre
     * @param Status|null $status Le Statut
     * @param bool $alert_when_allowed Détermine si l'alerte doit être déclenchée si cette règle est respectée
     * @param bool $alert_when_broken Détermine si l'alerte doit être déclenchée si cette règle est brisée
     * @param string|null $description La Description
     * @return AnalysisRule
     */
    public static function createNew(Model|DynamicAttribute $dynamicattribute, Model|AnalysisRuleType $analysisruletype, string $title, Status $status = null, bool $alert_when_allowed = false, bool $alert_when_broken = true, string $description = null): AnalysisRule
    {
        $innerrule = self::createInnerRule($analysisruletype);

        $analysisrule = $innerrule->analysisrule()->create([
            'title' => $title,
            'alert_when_allowed' => $alert_when_allowed,
            'alert_when_broken' => $alert_when_broken,
            'description' => $description,
        ]);

        $analysisrule->dynamicattribute()->associate($dynamicattribute);
        $analysisrule->analysisruletype()->associate($analysisruletype);

        $analysisrule->status()->associate( $status ?? Status::default()->first() );

        $analysisrule->save();

        return $analysisrule;
    }

    /**
     * Modifie (et stocke dans la base de données) cette Règle d'Analyse (AnalysisRule)
     * @param Model|AnalysisRuleType $analysisruletype Le Type de Règle d'Analyse
     * @param string $title Le Titre
     * @param Status|null $status Le Statut
     * @param bool $alert_when_allowed Détermine si l'alerte doit être déclenchée si cette règle est respectée
     * @param bool $alert_when_broken Détermine si l'alerte doit être déclenchée si cette règle est brisée
     * @param string|null $description La Description
     * @return $this
     */
    public function updateOne(Model|AnalysisRuleType $analysisruletype, string $title, Status $status = null, bool $alert_when_allowed = false, bool $alert_when_broken = true, string $description = null): AnalysisRule {

        $this->syncInnerRule($analysisruletype, $this->innerrule);

        $this->title = $title;
        $this->alert_when_allowed = $alert_when_allowed;
        $this->alert_when_broken = $alert_when_broken;
        $this->description = $description;

        $this->status()->associate( $status ?? Status::default()->first() );

        $this->save();

        return $this;
    }

    public static function createInnerRule(AnalysisRuleType $ruletype) : IInnerRule {
        return $ruletype->model_type::createNew();
    }

    private function syncInnerRule(AnalysisRuleType $ruletype, IInnerRule $innerrule) : IInnerRule {

        if ( $this->analysisruletype->id !== $ruletype->id ) {
            // remove the old innerrule
            $this->removeInnerRule();

            // and we have to create a new one from new type
            $innerrule = $this->createInnerRule($ruletype);

            $innerrule->attachUpperRule($this);
            $this->analysisruletype()->associate($ruletype);

            $this->save();
        }

        return $innerrule;
    }

    public function removeFormatRules() {
        $this->formatrules()->each(function($formatrule) {
            $formatrule->delete();
        });
    }

    public function removeInnerRule()
    {
        $this->innerrule->delete();
    }

    // Analysis Rule broken

    // Analysis Rule followed

    #endregion

    public static function boot(){
        parent::boot();

        static::deleting(function ($model) {
            $model->removeInnerRule();
            $model->removeFormatRules();
        });
    }
}
