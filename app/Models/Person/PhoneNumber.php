<?php

namespace App\Models\Person;

use App\Models\User;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PhoneNumber
 *
 * @package App\Models\Person
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $number
 * @property integer $posi
 *
 * @property string $hasphonenumber_type
 * @property integer $hasphonenumber_id
 * @property integer|null $esim_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int|null $created_by user creator reference
 * @property int|null $updated_by user updator reference
 */
class PhoneNumber extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules
    public static function defaultRules($number,$hasphonenumber_type) {
        return [
            'number' => [
                'required',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                'min:8',
                Rule::unique('phone_numbers', 'number')
                    ->where(function ($query) use($number,$hasphonenumber_type) {
                        $query->where('number', $number) ->where('hasphonenumber_type', $hasphonenumber_type);
                    })->ignore($number),
            ],
        ];
    }
    public static function createRules($number,$hasphonenumber_type) {
        return array_merge(self::defaultRules($number,$hasphonenumber_type), [

        ]);
    }
    public static function updateRules($model,$number,$hasphonenumber_type) {
        return array_merge(self::defaultRules($number,$hasphonenumber_type), [

        ]);
    }

    public static function messagesRules() {
        return [
            'number.required' => 'Phone Number required',
            'number.regex' => 'Invalid Phone Number',
            'number.min' => 'Phone Number must have at least 8 digits',
            'number.unique' => 'Phone Number already used',
        ];
    }

    #endregion

    #region Eloquent Relationships

    /**
     * The Model which has this Attribute
     *
     * @return MorphTo
     */
    public function hasphonenumber()
    {
        return $this->morphTo();
    }

    #endregion
}
