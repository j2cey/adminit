<?php

namespace App\Models\Person;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use App\Traits\Person\HasPhoneNumbers;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Person\HasEmailAddresses;
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
 * @property string $first_name
 * @property string $last_name
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int|null $created_by user creator reference
 * @property int|null $updated_by user updator reference
 */
class Person extends BaseModel implements Auditable
{
    use HasFactory, HasEmailAddresses, HasPhoneNumbers, \OwenIt\Auditing\Auditable;

    #region Validation Rules

    public static function defaultRules()
    {
        return [
            'last_name' => ['required'],
        ];
    }

    public static function createRules()
    {
        return array_merge(self::defaultRules(), [

        ]);
    }

    public static function updateRules($model)
    {
        return array_merge(self::defaultRules($model), [
        ]);
    }

    public static function messagesRules()
    {
        return [
            'last_name.required' => "Last Name is required",
        ];
    }

    #region Scopes

    #endregion

    /**
     * Create a New Person
     * @param string $first_name First Name
     * @param string $last_name Last Name
     * @param Status|null $status Statut
     * @return Person
     */
    public static function createNew(string $first_name, string $last_name, Status $status = null): Person
    {
        $status = is_null($status) ? Status::default()->first() : $status;

        $person = Person::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
        ]);

        $person->status()->associate($status)->save();

        return $person;
    }
}
