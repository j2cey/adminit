<?php

namespace App\Models\RetrieveAction;

use App\Models\ReportFile\ReportFile;
use Illuminate\Support\Facades\Storage;
use App\Models\ReportFile\CollectedReportFile;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Contracts\RetrieveAction\IRetrieveAction;

class ByWildcard implements IRetrieveAction
{
    public static function execAction(Filesystem $disk, ReportFile $file): array {
        // récupère le chemin du répertoire des CollectedReportFile
        $collectedreportfiles_folder = config('app.collectedreportfiles_folder');

        // variable du nom en local avec nom , temps , extension
        $local_file_name = md5($file->name . '_' . time()) . '.' . $file->extension;

        try{
            //stocker dans la base de données
            $result = Storage::disk('public')->put('/' . $collectedreportfiles_folder . '/'. $local_file_name, $disk->readStream($file->fileRemotePath));
            if ($result) {
                //crée un nouveau fichier
                $collectedreportfile = CollectedReportFile::createNew($file, $file->fileRemotePath, $local_file_name, $disk->size($file->fileRemotePath));
                return [true, "succès"];
            } else {
                return [false, "erreur download"];
            }
        }
        catch (\Exception $e){
            return [false, $e->getMessage()];
        }
    }
}
