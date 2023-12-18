<?php

namespace App\Models\Person;

use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class EmailAddress
 *
 * @package App\Models\Person
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $email
 * @property integer $posi
 *
 * @property string $hasemailaddress_type
 * @property integer $hasemailaddress_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int|null $created_by user creator reference
 * @property int|null $updated_by user updator reference
 */
class EmailAddress extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules
    public static function defaultRules($email,$hasemailaddress_type) {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('phone_numbers', 'email')
                    ->where(function ($query) use($email,$hasemailaddress_type) {
                        $query->where('email', $email) ->where('hasemailaddress_type', $hasemailaddress_type);
                    })->ignore($email),
            ],
        ];
    }
    public static function createRules($email,$hasemailaddress_type) {
        return array_merge(self::defaultRules($email,$hasemailaddress_type), [

        ]);
    }
    public static function updateRules($model,$email,$hasemailaddress_type) {
        return array_merge(self::defaultRules($email,$hasemailaddress_type), [

        ]);
    }

    public static function messagesRules() {
        return [
            'email.required' => 'Email required',
            'email.email' => 'Invalid Email',
            'email.unique' => 'Email already used',
        ];
    }

    #endregion

    #region Eloquent Relationships

    /**
     * The Model which has this Attribute
     *
     * @return MorphTo
     */
    public function hasemailaddress()
    {
        return $this->morphTo();
    }

    #endregion
}
