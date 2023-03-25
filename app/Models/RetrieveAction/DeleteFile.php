<?php

namespace App\Models\RetrieveAction;

use App\Models\ReportFile\ReportFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Contracts\RetrieveAction\IRetrieveAction;

/**
 * Class ByName Logique de Suppression du ReportFile
 * @package App\Models\RetrieveAction
 *
 */
class DeleteFile implements IRetrieveAction
{
    public static function execAction(Filesystem $disk, ReportFile $file): array {
        try{
            $result = $disk->delete($file->fileRemotePath);

            if($result) {
                return [true, "succès"];
            } else{
                return [false, "erreur de suppression du fichier distant."];
            }
        }
        catch (\Exception $e){
            return [false, $e->getMessage()];
        }
    }

}
