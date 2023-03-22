<?php

namespace App\Models\RetrieveAction;

use App\Models\ReportFile\ReportFile;
use Illuminate\Support\Facades\Storage;
use App\Contracts\RetrieveAction\IRetrieveAction;

/**
 * Class ByName Logique de Récupération du ReportFile par Nom
 * @package App\Models\RetrieveAction
 *
 */
class ByName implements IRetrieveAction
{
    public static function execRetrieveAction(ReportFile $file) {

        $collectedreportfiles_folder = config('app.collectedreportfiles_folder');

        try{
            $result = Storage::disk('public')->put('/' . $collectedreportfiles_folder . '/'. $local_file_name, $remoteDisk->readStream($file_path_from));
        }
        catch (\Exception $e){
            dd($e->getMessage());
        }
    }
}
