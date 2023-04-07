<?php

namespace App\Models\FormattedValue;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Models\FormatRule\FormatRule;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Contracts\FormattedValue\IFormattedValueHtml;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\FormattedValue\IInnerFormattedValue;

/**
 * Class FormattedValueHtml
 * @package App\Models\FormattedValue
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 *
 * @property string $title
 *
 * @property string|null $header
 * @property string|null $body
 * @property string|null $footer
 *
 * @property string $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property FormatType $formattype
 * @property IInnerFormattedValue|IFormattedValueHtml $innerformattedvalue
 * @property string $value
 * @method static FormattedValue first()
 */
class FormattedValue extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ["innerformattedvalue"];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'formattype' => ['required']
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function messagesRules() {
        return [
            'formattype.required' => 'Prière de renseigner le Type'
        ];
    }

    #endregion

    #region Accessors

    public function getValueAttribute() {
        return $this->header . $this->body . $this->footer;
    }

    #endregion

    #region Scopes

    #endregion

    #region Eloquent Relationships

    public function formattype() {
        return $this->belongsTo(FormatType::class,"format_type_id");
    }

    /**
     * @return MorphTo
     * Get the format rule owner model.
     */
    public function hasformattedvalue(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return MorphTo|IInnerFormattedValue
     * Get the parent inner format rule model.
     */
    public function innerformattedvalue()
    {
        return $this->morphTo();
    }

    #endregion

    #region Custom Functions

    public static function createInnerFormattedValue(Model|FormatType $formattype) : IInnerFormattedValue {
        return $formattype->formattype_class::createNew();
    }

    private function syncInnerFormattedValue(Model|FormatType $formattype, IInnerFormattedValue $innerformattedvalue) : IInnerFormattedValue {

        if ( $this->formattype->id !== $formattype->id ) {
            // remove the old innerformattedvalue
            $this->removeInnerFormattedValue();

            // and we have to create a new one from new type
            $innerformattedvalue = $this->createInnerFormattedValue($formattype);

            $innerformattedvalue->attachUpperFormattedValue($this);
            $this->formattype()->associate($formattype);

            $this->save();
        }

        return $innerformattedvalue;
    }

    public function removeInnerFormattedValue()
    {
        $this->innerformattedvalue->delete();
    }

    /**
     * Create a new Highlight and attach the relevant inner Highlight from it
     * @param Model|FormatType $formattype
     * @param string $title
     * @param Status|null $status
     * @param string|null $description
     * @return FormattedValue
     */
    public static function createNew(Model|FormatType $formattype, string $title, Status $status = null, string $description = null)
    {
        $innerformattedvalue = self::createInnerFormattedValue($formattype);

        $formattedvalue = $innerformattedvalue->formattedvalue()->create([
            'title' => $title,
            'description' => $description,
        ]);

        $formattedvalue->formattype()->associate($formattype);
        if ( ! is_null($status) ) $formattedvalue->status()->associate($status);

        $formattedvalue->save();

        return $formattedvalue;
    }

    public function updateOne(Model|FormatType $formattype, string $title, Status $status = null, string $description = null) : FormattedValue
    {
        $this->syncInnerFormattedValue($formattype, $this->innerformattedvalue);

        $this->title = $title;
        $this->description = $description;

        if ( ! is_null($status) ) {
            $this->status()->associate($status);      // set status
        }

        $this->save();

        return $this;
    }

    /*
    public function setValue(string $header = null, string $body = null, string $footer = null) {
        $this->innerformattedvalue->setHeader($header);
        $this->innerformattedvalue->setBody($body);
        $this->innerformattedvalue->setFooter($footer);
    }*/

    public function mergeRawValue(FormattedValue $formattedValue, $value_to_merge) {
        $this->innerformattedvalue->mergeRawValue($formattedValue->innerformattedvalue, $value_to_merge);
    }

    #endregion

    public static function boot(){
        parent::boot();

        static::deleting(function ($model) {
            $model->removeInnerFormattedValue();
        });
    }
}
