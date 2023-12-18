<?php

namespace App\Models\FileHeader;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\FormatRule\HasFormatRules;
use App\Contracts\FormatRule\IHasFormatRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FileHeader
 * @package App\Models\FileHeader
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
 * @property string|null $description
 *
 * @property string|null $hasfileheader_type
 * @property integer|null $hasfileheader_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static FileHeader create(array $array)
 */
class FileHeader extends BaseModel implements Auditable, IHasFormatRules
{
    use HasFactory, HasFormatRules, \OwenIt\Auditing\Auditable;

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

    /**
     * @param array|null $array
     * @return FileHeader
     */
    public static function createNew(array $array = null): FileHeader
    {
        return FileHeader::create($array);
    }

    public function updateThis(string $title, Status $status = null, string $description = null): FileHeader
    {
        $this->title = $title;
        $this->description = $description;

        if ( ! is_null($status) ) $this->status()->associate($status);

        $this->save();

        return $this;
    }

    protected static function boot(){
        parent::boot();

        // Pendant la création de ce Model
        static::creating(function ($model) {

        });

        // Pendant la modification de ce Model
        static::updating(function ($model) {

        });
    }

    #endregion
}
