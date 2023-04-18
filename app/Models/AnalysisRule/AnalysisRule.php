<?php

namespace App\Models\AnalysisRule;

use App\Models\Status;
use App\Models\BaseModel;
use App\Enums\RuleResultEnum;
use Illuminate\Support\Carbon;
use App\Models\FormatRule\FormatRule;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\FormatRule\HasFormatRules;
use App\Models\DynamicValue\DynamicValue;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\FormatRule\IHasFormatRules;
use App\Models\DynamicAttributes\DynamicAttribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Contracts\AnalysisRules\IInnerAnalysisRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\AnalysisRules\IHasMatchedAnalysisRules;

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
 * @property string $rule_result_for_notification
 * @property integer $num_ord
 * @property string $description
 *
 * @property string $inneranalysisrule_type
 * @property integer $inneranalysisrule_id
 *
 *
 * @property integer|null $analysis_rule_type_id
 * @property integer|null $dynamic_attribute_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property DynamicAttribute $dynamicattributes
 * @property IInnerAnalysisRule $inneranalysisrule
 * @property AnalysisRuleType $analysisruletype
 *
 * @method static AnalysisRule first()
 */
class AnalysisRule extends BaseModel implements Auditable, IHasFormatRules
{
    use HasFactory, HasFormatRules, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ["inneranalysisrule"];
    protected $casts = [
        'rule_result_for_notification' => RuleResultEnum::class,
    ];

    #region Validation Rules

    public static function defaultRules()
    {
        return [
            'title' => ['required'],
            'rule_result_for_notification' => ['required'],
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
            'rule_result_for_notification.required' => "Sélectionner le Résultat attendu pour Notification",
            'analysisruletype.required' => "Prière de renseigner le Type de Règle d'analyse",
        ];
    }

    #endregion

    #region Eloquent Relationships

    public function analysisruletype() {
        return $this->belongsTo(AnalysisRuleType::class,"analysis_rule_type_id");
    }

    /*public function dynamicattribute() {
        return $this->belongsTo(DynamicAttribute::class,"dynamic_attribute_id");
    }*/

    /**
     * @return MorphTo
     * Get the parent inner rule model.
     */
    public function inneranalysisrule()
    {
        return $this->morphTo();
    }

    #endregion

    #region Custom Functions

    /**
     * Crée (et stocke dans la base de données) une nouvelle Règle d'Analyse (AnalysisRule)
     * @param Model|AnalysisRuleType $analysisruletype Le Type de Règle d'Analyse
     * @param string $title Le Titre
     * @param string|null $rule_result_for_notification Résulat d'analyse attendu pour notification
     * @param array $inneranalysisrule_attributes
     * @param Status|null $status Le Statut
     * @param string|null $description La Description
     * @param int|null $num_ord
     * @return AnalysisRule
     */
    public static function createNew(Model|AnalysisRuleType $analysisruletype, string $title, string $rule_result_for_notification = null, array $inneranalysisrule_attributes = [], Status $status = null, string $description = null, int $num_ord = null): AnalysisRule
    {
        $inneranalysisrule = self::createInnerRule($analysisruletype);
        $inneranalysisrule->updateOne($inneranalysisrule_attributes);

        $data = [
            'title' => $title,
            'description' => $description,
        ];
        if ( ! is_null($rule_result_for_notification) ) $data['rule_result_for_notification'] = $rule_result_for_notification;
        if ( ! is_null($num_ord) ) $data['num_ord'] = $num_ord;

        $analysisrule = $inneranalysisrule->analysisrule()->create($data);

        //$analysisrule->dynamicattribute()->associate($dynamicattribute);
        $analysisrule->analysisruletype()->associate($analysisruletype);

        $analysisrule->status()->associate( $status ?? Status::default()->first() );

        $analysisrule->save();

        return $analysisrule;
    }

    /**
     * Modifie (et stocke dans la base de données) cette Règle d'Analyse (AnalysisRule)
     * @param Model|AnalysisRuleType $analysisruletype Le Type de Règle d'Analyse
     * @param string $title Le Titre
     * @param string|null $rule_result_for_notification Résulat d'analyse attendu pour notification
     * @param array $inneranalysisrule_attributes
     * @param Status|null $status Le Statut
     * @param string|null $description La Description
     * @param int|null $num_ord
     * @return $this
     */
    public function updateOne(Model|AnalysisRuleType $analysisruletype, string $title, string $rule_result_for_notification = null, array $inneranalysisrule_attributes = [], Status $status = null, string $description = null, int $num_ord = null): AnalysisRule {

        $this->syncInnerRule($analysisruletype, $this->inneranalysisrule);
        $this->inneranalysisrule->updateOne($inneranalysisrule_attributes);

        $this->title = $title;
        $this->rule_result_for_notification = $rule_result_for_notification ?? $this->rule_result_for_notification;
        $this->num_ord = $num_ord ?? $this->num_ord;
        $this->description = $description;

        $this->status()->associate( $status ?? Status::default()->first() );

        $this->save();

        return $this;
    }

    public static function createInnerRule(AnalysisRuleType $ruletype) : IInnerAnalysisRule {
        return $ruletype->model_type::createNew();
    }

    private function syncInnerRule(AnalysisRuleType $ruletype, IInnerAnalysisRule $inneranalysisrule) : IInnerAnalysisRule {

        if ( $this->analysisruletype->id !== $ruletype->id ) {
            // remove the old inneranalysisrule
            $this->removeInnerRule();

            // and we have to create a new one from new type
            $inneranalysisrule = $this->createInnerRule($ruletype);

            $inneranalysisrule->attachUpperRule($this);
            $this->analysisruletype()->associate($ruletype);

            $this->save();
        }

        return $inneranalysisrule;
    }

    public function removeFormatRules() {
        $this->formatrules()->each(function($formatrule) {
            $formatrule->delete();
        });
    }

    public function removeInnerRule()
    {
        $this->inneranalysisrule->delete();
    }

    public function applyRule(DynamicValue $dynamicValue): RuleResultEnum
    {
        return $this->inneranalysisrule->applyRule($dynamicValue->getValue());
    }

    /**
     * @param DynamicValue $dynamicvalue
     * @return array|Collection|FormatRule[]
     */
    public function getFormatRulesForNotification(DynamicValue $dynamicvalue, IHasMatchedAnalysisRules $ihasmatchedanalysisrules) {
        $formatrules = new \Illuminate\Database\Eloquent\Collection;
        $ruleresult = $this->applyRule($dynamicvalue);

        if ( $ruleresult == $this->rule_result_for_notification ) {
            if ( ! empty($this->formatrules) ) {
                foreach ($this->formatrules as $formatrule) {
                    if ( $formatrule->rule_result == $ruleresult ||  $formatrule->rule_result == RuleResultEnum::ALLWAYS ) {
                        $formatrules = $formatrules->add($formatrule);
                    }
                }
            }
            $ihasmatchedanalysisrules->addMatchedAnalysisRule($this);
        }
        return $formatrules;
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
