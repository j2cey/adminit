<?php

namespace App\Models\ReportFile;

use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportFile extends Model
{
    use HasFactory;


    public static function defaultRules() {
        return [
            'name' => ['required'],
            'wildcard' => [
                'without_spaces'
            ],
            'reportfiletype' => ['required'],
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
            'wildcard' => "Prière de renseigner le caractère générique",
            'reportfiletype.required' => "Prière de renseigner un type de fichier",
        ];

}

#endregion

    #region Eloquent Relationships

    public function reportfiletype() {
        return $this->belongsTo(ReportFileType::class, 'report_file_type_id');
    }

    #endregion

    #region Custom Functions

    /**
     * Sert à créer (et stocker dans la base de données) un nouvel objet de type ReportFile
     * @param ReportFileType $reportfiletype
     * @param Status $status
     * @param $name
     * @param null $wildcard
     * @param bool $retrieve_by_name
     * @param bool $retrieve_by_wildcard
     * @return ReportFile
     */
    public static function createNew(ReportFileType $reportfiletype, Status $status, $name, $wildcard = null, bool $retrieve_by_name = false, bool $retrieve_by_wildcard = false) : ReportFile
    {
        $reportfile = ReportFile::create([
            'name' => $name,
            'wildcard' => $wildcard,
            'retrieve_by_name' => $retrieve_by_name,
            'retrieve_by_wildcard' => $retrieve_by_wildcard,
        ]);

        // associate reportfiletype
        $reportfiletype->reportfiletype()->associate($reportfiletype);
        // associate status
        $status->status()->associate($status)->save();
        return $reportfile;
    }

    public function updateOne(ReportFileType $reportfiletype, Status $status, $name, $wildcard=null, $retrieve_by_name=false, $retrieve_by_wildcard=false)
    {
        $this->name = $name;
        $this->wildcard = $wildcard;
        $this->retrieve_by_name = $retrieve_by_name;
        $this->retrieve_by_wildcard = $retrieve_by_wildcard;

        //Assignation  du type de rapport de fichier
        $this->reportfiletype()->associate($reportfiletype);

        $this->save();

        return $this;
    }



    public function setFormalizedExtension() {
        return $this->wildcard = trim($this->wildcard);
    }

    protected static function boot(){
        parent::boot();

        // Pendant la création de ce Model
        static::creating(function ($model) {
            $model->setFormalizedWildcard();
        });

        // Pendant la modification de ce Model
        static::updating(function ($model) {
            $model->setFormalizedWildcard();
        });
    }



    #endregion
}
