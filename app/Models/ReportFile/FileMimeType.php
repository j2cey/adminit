<?php

namespace App\Models\ReportFile;

use App\Models\BaseModel;
use App\Traits\Code\HasCode;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FileMimeType
 * @package App\Models\ReportFile
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 *
 * @property string $code
 * @property string $name
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class FileMimeType extends BaseModel implements Auditable
{
    use HasFactory, HasCode, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'name' => ['required'],
            'code' => ['required'],
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
            'name.required' => 'Prière de renseigner le nom',
            'code.required' => 'Prière de renseigner le code',
        ];
    }




    #endregion

    #region Scopes
    public function scopePng($query) {
        return $query
            ->where('name', "png");
    }

    public function scope($query) {
        return $query
            ->where('name', "bmp");
    }
    #endregion



    #endregion

    #region Eloquent Relationships

    public function reportfiletypes() {
        return $this->hasMany(ReportFileType::class, 'report_file_type_id');
    }

    #endregion

    #region Custom Functions

    /**
     * Sert à créer (et stocker dans la base de données) un nouvel objet de type FileMimeType
     * @param $name
     * @param $code
     * @param null $description
     * @return FileMimeType
     */
    public static function createNew($name, $code, $description = null) : FileMimeType
    {
        return FileMimeType::create([
            'name' => $name,
            'code' => $code,
            'description' => $description,
        ]);
    }


    #endregion
}
