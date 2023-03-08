<?php

namespace Database\Seeders;

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
        $csv_mime_type = FileMimeType::where('code', "csv,txt")->first();
        // Création de type de fichier csv
        ReportFileType::createNew($csv_mime_type, "CSV","csv","type de fichier csv.");
        // Création de type de fichier texte
        ReportFileType::createNew($csv_mime_type, "TXT","txt","type de fichier texte.");
    }
}
