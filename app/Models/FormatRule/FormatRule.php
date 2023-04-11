<?php

namespace App\Models\FormatRule;

use App\Models\Status;
use mysql_xdevapi\Table;
use App\Models\BaseModel;
use App\Enums\RuleResultEnum;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Contracts\FormatRule\IInnerFormatRule;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FormatRule
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
 * @property int $num_ord
 * @property string $description
 *
 * @property integer|null $format_rule_type_id
 *
 * @property string $hasformatrule_type
 * @property int $hasformatrule_id
 * @property string $rule_result
 *
 * @property string|null $innerformatrule_type
 * @property int|null $innerformatrule_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property IInnerFormatRule $innerformatrule
 * @property FormatRuleType $formatruletype
 * @method static FormatRule first()
 */
class FormatRule extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ["innerformatrule"];
    protected $casts = [
        'rule_result' => RuleResultEnum::class,
    ];

    const FORMATRULETYPE_FOREIGN_KEY = "format_rule_type_id";

    #region Validation Rules

    public static function defaultRules()
    {
        return [
            'title' => ['required'],
            'formatruletype' => ['required'],
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(), [
            'formatruletype_key' => ['unique:' . (new FormatRule())->getTable() . ',' . self::FORMATRULETYPE_FOREIGN_KEY . ',NULL,id'],
        ]);
    }

    public static function updateRules($model)
    {
        return array_merge(self::defaultRules(), [
            'formatruletype_key' => ['unique:' . (new FormatRule())->getTable() . ',' . self::FORMATRULETYPE_FOREIGN_KEY . ','.$model->id.',id'],
        ]);
    }

    public static function messagesRules() {
        return [
            'title.required' => "Prière de renseigner le Titre",
            'formatruletype.required' => "Prière de renseigner le Type",
            'formatruletype_key.unique' => "Cette règle est déjà appliquée",
        ];
    }

    #endregion

    #region Eloquent Relationships

    public function formatruletype() {
        return $this->belongsTo(FormatRuleType::class,self::FORMATRULETYPE_FOREIGN_KEY);
    }

    /**
     * @return MorphTo
     * Get the format rule owner model.
     */
    public function hasformatrule()
    {
        return $this->morphTo();
    }

    /**
     * @return MorphTo|IInnerFormatRule
     * Get the parent inner format rule model.
     */
    public function innerformatrule()
    {
        return $this->morphTo();
    }

    #endregion

    #region Custom Functions

    public static function createInnerFormatRule(Model|FormatRuleType $formatruletype) : IInnerFormatRule {
        return $formatruletype->model_type::createNew();
    }

    private function syncInnerFormatRule(Model|FormatRuleType $formatruletype, IInnerFormatRule $innerformatrule) : IInnerFormatRule {

        if ( $this->formatruletype->id !== $formatruletype->id ) {
            // remove the old innerformatrule
            $this->removeInnerFormatRule();

            // and we have to create a new one from new type
            $innerformatrule = $this->createInnerFormatRule($formatruletype);

            $innerformatrule->attachUpperFormatRule($this);
            $this->formatruletype()->associate($formatruletype);

            $this->save();
        }

        return $innerformatrule;
    }

    public function removeInnerFormatRule()
    {
        $this->innerformatrule->delete();
    }

    /**
     * Create a new Highlight and attach the relevant inner Highlight from it
     * @param Model|FormatRuleType $formatruletype
     * @param string $title
     * @param string|null $rule_result
     * @param Status|null $status
     * @param string|null $description
     * @param int|null $num_ord
     * @return FormatRule
     */
    public static function createNew(Model|FormatRuleType $formatruletype, string $title, IInnerFormatRule|string $innerformatrule = null, string $rule_result = null, Status $status = null, string $description = null, int $num_ord = null)
    {
        $newinnerformatrule = self::createInnerFormatRule($formatruletype);
        $newinnerformatrule->updateOne($innerformatrule);

        $formatrule = $newinnerformatrule->formatrule()->create([
            'num_ord' => $num_ord,
            'title' => $title,
            'rule_result' => $rule_result ?? RuleResultEnum::ALLWAYS,
            'description' => $description,
        ]);

        $formatrule->formatruletype()->associate($formatruletype);

        if ( ! is_null($status) ) $formatrule->status()->associate($status);

        $formatrule->save();

        return $formatrule;
    }

    public function updateOne(Model|FormatRuleType $formatruletype, string $title, IInnerFormatRule|string $innerformatrule = null, string $rule_result = null, Status $status = null, string $description = null, int $num_ord = null) : FormatRule
    {
        $this->syncInnerFormatRule($formatruletype, $this->innerformatrule);

        $this->innerformatrule->updateOne($innerformatrule);

        $this->num_ord = $num_ord ?? $this->num_ord;
        $this->title = $title;
        $this->rule_result = $rule_result ?? $this->rule_result;
        $this->description = $description;

        if ( ! is_null($status) ) {
            $this->status()->associate($status);      // set status
        }

        $this->save();

        return $this;
    }

    public function getRuleValue() {
        return $this->innerformatrule->getRuleValue();
    }

    #endregion

    public static function boot(){
        parent::boot();

        static::deleting(function ($model) {
            $model->removeInnerFormatRule();
        });
    }
}
