<?php

namespace App\Models\FormattedValue;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Models\FormatRule\FormatRule;
use App\Traits\FormattedValue\InnerFormattedValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\FormattedValue\IInnerFormattedValue;

/**
 * Class FormattedValueSms
 * @package App\Models\FormattedValue
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $comment
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static FormattedValueSms create(array $array = null)
 * @method static FormattedValueSms first()
 */
class FormattedValueSms extends BaseModel implements IInnerFormattedValue
{
    use HasFactory, InnerFormattedValue;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
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
        ];
    }

    #endregion

    #region Scopes

    #endregion

    #region Eloquent Relationships

    #endregion

    #region Custom Functions

    public static function createNew(array $array = null): FormattedValueSms {
        return FormattedValueSms::create();
    }

    public function applyFormat(mixed $value = null, FormatRule $formatrule = null, bool $reset = false) {

    }

    public function mergeRawValue(IInnerFormattedValue $innerformattedvalue, $value_to_merge) {

    }

    public function getRawValue() {

    }

    public function getFormattedValue() {

    }

    #endregion
}
