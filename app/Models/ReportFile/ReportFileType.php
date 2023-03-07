<?php

namespace App\Models\ReportFile;

use App\Models\BaseModel;
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
 * @property string $name
 * @property string $extension
 * @property string|null $description
 *
 * @property integer|null $file_mime_type_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ReportFileType extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    //protected $with = ['filemimetype'];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'name' => ['required'],
            'extension' => [
                'required',
                'without_spaces'
            ],
            'filemimetype' => ['required'],
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
            'name.required' => "Prière de renseigner le nom",
            'extension.required' => "Prière de renseigner l'extension",
            'filemimetype.required' => "Prière de renseigner un mime type",
            'extension.without_spaces' => "L'extension ne doit pas comporter d'espace.",
        ];
    }

    #endregion

    #region Eloquent Relationships

    public function filemimetype() {
        return $this->belongsTo(FileMimeType::class, 'file_mime_type_id');
    }

    #endregion

    #region Custom Functions

    /**
     * Sert à créer (et stocker dans la base de données) un nouvel objet de type ReportFileType
     * @param FileMimeType $filemimetype
     * @param $name
     * @param $extension
     * @param null $description
     * @return ReportFileType
     */
    public static function createNew(FileMimeType $filemimetype, $name, $extension, $description = null) : ReportFileType
    {
        $reportfiletype = ReportFileType::create([
            'name' => $name,
            'extension' => $extension,
            'description' => $description,
        ]);

        // Assignation du type de mime type
        $reportfiletype->filemimetype()->associate($filemimetype)->save();

        return $reportfiletype;
    }

    public function updateOne(FileMimeType $filemimetype, $name, $extension, $description)
    {
        $this->name = $name;
        $this->extension = $extension;
        $this->description = $description;

        //Assignation  du type de mime type
        $this->filemimetype()->associate($filemimetype);

        $this->save();

        return $this;
    }



    public function setFormalizedExtension() {
        return $this->extension = trim($this->extension);
    }

    protected static function boot(){
        parent::boot();

        // Pendant la création de ce Model
        static::creating(function ($model) {
            $model->setFormalizedExtension();
        });

        // Pendant la modification de ce Model
        static::updating(function ($model) {
            $model->setFormalizedExtension();
        });
    }



    #endregion
}
