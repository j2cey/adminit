<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use App\Models\RetrieveAction\RetrieveActionType;

class RetrieveActionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status_active = Status::active()->first();

        RetrieveActionType::createNew(
            "Mode de Récupération",
            "retrieve_mode",
            $status_active,
            "Mode de Récupération de Fichier");

        RetrieveActionType::createNew(
            "A Executer avant Récupération",
            "to_perform_before_retrieving",
            $status_active,
            "Action A Executer avant Récupération");

        RetrieveActionType::createNew(
            "A Executer après Récupération",
            "to_perform_after_retrieving",
            $status_active,
            "Action A Executer après Récupération");
    }
}
