<?php

namespace App\Models\ReportFile;

use App\Models\Status;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\AuditDriver;
use App\Models\RetrieveAction\SelectedRetrieveAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\SelectedRetrieveAction\HasSelectedRetrieveActions;
use App\Contracts\SelectedRetrieveAction\IHasSelectedRetrieveActions;

/**
 * Class CollectedReportFile
 * @package App\Models\ReportFile
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $initial_file_name
 * @property string $local_file_name
 * @property string|null $file_size
 *
 * @property string|null $description
 *
 * @property integer|null $report_file_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property int $nb_rows
 * @property int $nb_rows_import_success
 * @property int $nb_rows_import_failed
 * @property int $nb_rows_import_processing
 * @property int $nb_rows_import_processed
 * @property int $row_last_import_processed
 * @property int $nb_import_try
 *
 * @property ReportFile $reportfile
 * @method static CollectedReportFile first()
 */
class CollectedReportFile extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $with = ['reportfile'];

    public static function defaultRules() {
        return [
            'initial_file_name' => ['required'],
            'local_file_name' => ['required'],
            'file_size' => ['required'],
            'reportfile' => ['required'],
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
            'initial_file_name.required' => "Prière de renseigner le nom initial",
            'local_file_name.required' => "Prière de renseigner le nom de fichier en local",
            'file_size.required' => "Prière de renseigner la taille de ce fichier",
            'reportfile.required' => "Prière de renseigner le rapport de fichier",
        ];
    }


    #region Eloquent Relationships

    public function reportfile() {
        return $this->belongsTo(ReportFile::class, 'report_file_id');
    }

    #endregion

    #region Custom Functions

    /**
     * Sert à créer (et stocker dans la base de données) un nouvel objet de type CollectedReportFile
     * @param ReportFile $reportfile
     * @param string $initial_file_name
     * @param string $local_file_name
     * @param string $file_size
     * @param Status|null $status
     * @param null $description
     * @return CollectedReportFile
     */
    public static function createNew(ReportFile $reportfile, string $initial_file_name, string $local_file_name, string $file_size, Status $status = null, $description = null) : CollectedReportFile
    {
        $collectedreportfile = CollectedReportFile::create([
            'initial_file_name' => $initial_file_name,
            'local_file_name' => $local_file_name,
            'file_size' => $file_size,
            'description' => $description,
        ]);

        // Assignation du type de report file
        $collectedreportfile->reportfile()->associate($reportfile);

        // Assignation du statut du report file
        $collectedreportfile->status()->associate(is_null($status) ? Status::default()->first() : $status);

        $collectedreportfile->save();

        return $collectedreportfile;
    }

    /**
     * @param ReportFile $reportfile
     * @param string $initial_file_name
     * @param string $local_file_name
     * @param string $file_size
     * @param Status|null $status
     * @param null $description
     * @return $this
     */
    public function updateOne(ReportFile $reportfile, string $initial_file_name, string $local_file_name, string $file_size, Status $status = null, $description = null): CollectedReportFile
    {
        $this->initial_file_name = $initial_file_name;
        $this->local_file_name = $local_file_name;
        $this->file_size = $file_size;
        $this->description = $description;

        //Assignation  du type de report file
        $this->reportfile()->associate($reportfile);

        // Assignation du statut de report file
        $this->status()->associate( is_null($status) ? Status::default()->first() : $status );

        $this->save();

        return $this;
    }




    /*protected static function boot(){
        parent::boot();

        // Pendant la création de ce Model
        static::creating(function ($model) {
            $model->setFormalizedExtension();
        });

        // Pendant la modification de ce Model
        static::updating(function ($model) {
            $model->setFormalizedExtension();
        });
    }*/

    #endregion
}
