<?php

namespace App\Models\ReportFile;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ReportFileType
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
 *
 * @method static csv()
 * @method static txt()
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

    #region Scopes
    public function scopeCsv($query) {
        return $query
            ->where('extension', "csv");
    }

    public function scopeTxt($query) {
        return $query
            ->where('extension', "txt");
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
     * @param string $name
     * @param string $extension
     * @param Status|null $status
     * @param null $description
     * @return ReportFileType
     */
    public static function createNew(FileMimeType $filemimetype, string $name, string $extension, Status $status = null, $description = null) : ReportFileType
    {
        $reportfiletype = ReportFileType::create([
            'name' => $name,
            'extension' => $extension,
            'description' => $description,
        ]);

        // Assignation du type de mime type
        $reportfiletype->filemimetype()->associate($filemimetype);

        // Assignation du statut de mime type
        $reportfiletype->status()->associate( is_null($status) ? Status::default()->first() : $status );

        $reportfiletype->save();

        return $reportfiletype;
    }

    /**
     * @param FileMimeType $filemimetype
     * @param string $name
     * @param string $extension
     * @param Status|null $status
     * @param null $description
     * @return $this
     */
    public function updateOne(FileMimeType $filemimetype, string $name, string $extension, Status $status = null, $description = null): ReportFileType
    {
        $this->name = $name;
        $this->extension = $extension;
        $this->description = $description;

        //Assignation  du type de mime type
        $this->filemimetype()->associate($filemimetype);

        // Assignation du statut de mime type
        $this->status()->associate( is_null($status) ? Status::default()->first() : $status );

        $this->save();

        return $this;
    }



    public function setFormalizedExtension() {
        // on trime l'extension
        $this->extension = trim($this->extension);
        // on lower case l'extension
        return strtolower($this->extension);
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
