<?php

namespace App\Console\Commands\ReportFile;

use Illuminate\Console\Command;
use App\Imports\ReportFilesImport;
use App\Models\ReportFile\CollectedReportFile;
use App\Models\ReportTreatments\ReportTreatmentStepResult;

class ReportFileImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportfile:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("Importation Fichiers Rapport en cours de traitement...");

        $files_to_import = CollectedReportFile::getFilesToImport();

        $nb_to_import = 1;
        $nb_to_imported = 0;

        foreach ($files_to_import as $file_to_import) {
            if ($nb_to_imported < $nb_to_import) {

                $file_to_import->update([
                    'import_processing' => 1,
                ]);

                $import = new ReportFilesImport($file_to_import,new ReportTreatmentStepResult());
                $import->import($file_to_import->fileLocalAbsolutePath);

                $file_to_import->update([
                    'import_processing' => 0,
                    'imported' => 1
                ]);
            }
            $nb_to_imported++;
        }


        \Log::info("Traitement termine.");
        return 0;
    }
}
