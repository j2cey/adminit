<?php

namespace App\Models\FormattedValue;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Models\FormatRule\FormatRule;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\FormattedValue\FormattedValue;
use App\Contracts\FormattedValue\IFormattedValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SmsFormattedValue
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
 * @method static SmsFormattedValue create(array $array = null)
 * @method static SmsFormattedValue first()
 */
class SmsFormattedValue extends BaseModel implements IFormattedValue
{
    use HasFactory, FormattedValue;

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

    public static function createNew(array $array = null): SmsFormattedValue {
        return SmsFormattedValue::create();
    }

    /**
     * @param mixed|null $value
     * @param Collection|array|FormatRule[]|null $formatrules
     * @param bool $reset
     * @return void
     */
    public function applyFormatFromRaw(mixed $value = null, Collection|array $formatrules = null, bool $reset = false) {

    }

    /**
     * @param mixed|null $value
     * @param Collection|array|FormatRule[]|null $formatrules
     * @param bool $reset
     * @return void
     */
    public function applyFormatFromFormatted(mixed $value = null, Collection|array $formatrules = null, bool $reset = false) {

    }

    /**
     * @param mixed|null $value
     * @param Collection|array|FormatRule[]|null $formatrules
     * @param bool $reset
     * @return void
     */
    public function applyFormat(mixed $value = null, Collection|array $formatrules = null, bool $reset = false) {

    }

    public function insertHeadersRow(array $headers, Collection|array $formatrules = null) {

    }

    public function mergeRawValue(IFormattedValue $innerformattedvalue, $value_to_merge) {

    }

    public function getRawValue() {

    }

    public function resetRawValue() {
        $this->update([
            'rawvalue' => ""
        ]);
    }

    public function getFormattedValue(): string
    {
        return "";
    }

    #endregion
}
