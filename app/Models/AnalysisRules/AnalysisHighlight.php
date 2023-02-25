<?php

namespace App\Models\AnalysisRules;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use App\Contracts\AnalysisRules\IInnerHighlight;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AnalysisHighlight
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
 * @property integer|null $analysis_highlight_type_id
 *
 * @property integer|null $analysis_rule_id
 * @property string $when_rule_result_is
 *
 * @property string|null $innerhighlight_type
 * @property string|null $innerhighlight_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AnalysisHighlight extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ["innerhighlight"];

    #region Validation Rules

    public static function defaultRules()
    {
        return [
            'title' => ['required'],
            'highlighttype' => ['required'],
            'when_rule_result_is' => ['required'],
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

        ];
    }

    #endregion

    #region Eloquent Relationships

    public function analysisrule() {
        return $this->belongsTo(AnalysisRule::class,"analysis_rule_id");
    }

    public function highlighttype() {
        return $this->belongsTo(AnalysisHighlightType::class,"analysis_highlight_type_id");
    }

    /**
     * @return MorphTo|IInnerHighlight
     * Get the parent inner highlight model.
     */
    public function innerhighlight()
    {
        return $this->morphTo();
    }

    #endregion

    #region Custom Functions

    public static function createInnerHighlight(AnalysisHighlightType $highlighttype) : IInnerHighlight {
        return $highlighttype->model_type::createNew();
    }

    private function syncInnerHighlight(AnalysisHighlightType $highlighttype, IInnerHighlight $innerhighlight) : IInnerHighlight {

        if ( $this->highlighttype->id !== $highlighttype->id ) {
            // remove the old innerhighlight
            $this->removeInnerHighlight();

            // and we have to create a new one from new type
            $innerhighlight = $this->createInnerHighlight($highlighttype);

            $innerhighlight->attachUpperHighlight($this);
            $this->highlighttype()->associate($highlighttype);

            $this->save();
        }

        return $innerhighlight;
    }

    public function removeInnerHighlight()
    {
        $this->innerhighlight->delete();
    }

    /**
     * Create a new Highlight and attach the relevant inner Highlight from it
     * @param AnalysisRule $analysisrule
     * @param AnalysisHighlightType $highlighttype
     * @param $title
     * @param $description
     * @return AnalysisHighlight
     */
    public static function createNew(AnalysisRule $analysisrule, AnalysisHighlightType $highlighttype, $title, $when_rule_result_is, $description)
    {
        $innerhighlight = self::createInnerHighlight($highlighttype);

        $analysishighlight = $innerhighlight->analysishighlight()->create([
            'title' => $title,
            'when_rule_result_is' => $when_rule_result_is,
            'description' => $description,
        ]);

        $analysishighlight->analysisrule()->associate($analysisrule);
        $analysishighlight->highlighttype()->associate($highlighttype);

        $analysishighlight->save();

        return $analysishighlight;
    }

    public function updateOne(AnalysisHighlightType $highlighttype, $title, $when_rule_result_is, $description) : AnalysisHighlight
    {
        $this->syncInnerHighlight($highlighttype, $this->innerhighlight);

        $this->update([
            'title' => $title,
            'when_rule_result_is' => $when_rule_result_is,
            'description' => $description,
        ]);

        return $this;
    }

    #endregion

    public static function boot(){
        parent::boot();

        static::deleting(function ($model) {
            $model->removeInnerHighlight();
        });
    }
}
