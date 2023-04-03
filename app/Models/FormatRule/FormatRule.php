<?php

namespace App\Models\FormatRule;

use App\Models\Status;
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

    #region Validation Rules

    public static function defaultRules()
    {
        return [
            'title' => ['required'],
            'formatruletype' => ['required'],
            'rule_result' => ['required'],
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

    public static function messagesRules() {
        return [
            'title.required' => "Prière de renseigner le Titre",
            'formatruletype.required' => "Prière de renseigner le Type",
        ];

    }

    #endregion

    #region Eloquent Relationships

    public function formatruletype() {
        return $this->belongsTo(FormatRuleType::class,"format_rule_type_id");
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
     * @param string $rule_result
     * @param string $description
     * @param int|null $num_ord
     * @return FormatRule
     */
    public static function createNew(Model|FormatRuleType $formatruletype, string $title, string $rule_result, string $description, int $num_ord = null)
    {
        $innerformatrule = self::createInnerFormatRule($formatruletype);

        $formatrule = $innerformatrule->formatrule()->create([
            'num_ord' => $num_ord,
            'title' => $title,
            'rule_result' => $rule_result,
            'description' => $description,
        ]);

        $formatrule->formatruletype()->associate($formatruletype);

        $formatrule->save();

        return $formatrule;
    }

    public function updateOne(Model|FormatRuleType $formatruletype, string $title, string $rule_result, Status $status = null, string $description = null, int $num_ord = null) : FormatRule
    {
        $this->syncInnerFormatRule($formatruletype, $this->innerformatrule);

        $this->num_ord = $num_ord;
        $this->title = $title;
        $this->rule_result = $rule_result;
        $this->description = $description;

        if ( ! is_null($status) ) {
            $this->status()->associate($status);      // set status
        }

        $this->save();

        return $this;
    }

    #endregion

    public static function boot(){
        parent::boot();

        static::deleting(function ($model) {
            $model->removeInnerFormatRule();
        });
    }
}
