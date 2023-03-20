<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use App\Models\ReportFile\FileMimeType;
use App\Models\ReportFile\ReportFileType;

class ReportFileTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv_mime_type = FileMimeType::csv()->first();
        $status_active = Status::active()->first();
        // Création de type de fichier csv
        ReportFileType::createNew($csv_mime_type, "CSV","csv", $status_active,"type de fichier csv.");
        // Création de type de fichier texte
        ReportFileType::createNew($csv_mime_type, "TXT","txt", $status_active,"type de fichier texte.");
    }
}
