<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use App\Models\RetrieveAction\ByName;
use App\Models\RetrieveAction\ByWildcard;
use App\Models\RetrieveAction\RenameFile;
use App\Models\RetrieveAction\DeleteFile;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\RetrieveAction\RetrieveActionType;

class RetrieveActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actiontype_retrievemode = RetrieveActionType::retrieveMode()->first();
        $actiontype_afterretrieving = RetrieveActionType::toPerformAfterRetrieving()->first();
        RetrieveAction::createNew(
            $actiontype_retrievemode,
            "Par Nom",
            ByName::class,
            "by_name", Status::active()->first(),
            "(Mode de Récupération de Fichier) par Nom"
        );
        RetrieveAction::createNew(
            $actiontype_retrievemode,
            "Par Wildcard",
            ByWildcard::class,
            "by_wildcard", Status::active()->first(),
            "(Mode de Récupération de Fichier) par Nom"
        );

        RetrieveAction::createNew(
            $actiontype_afterretrieving,
            "Renommer le Fichier",
            RenameFile::class,
            "rename_file", Status::active()->first(),
            "(A effectuer après récupération de fichier) Renommer le fichier"
        );
        RetrieveAction::createNew(
            $actiontype_afterretrieving,
            "Supprimer le Fichier",
            DeleteFile::class,
            "delete_file", Status::active()->first(),
            "(A effectuer après récupération de fichier) Supprimer le fichier"
        );
    }
}
