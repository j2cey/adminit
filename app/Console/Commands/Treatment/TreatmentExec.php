<?php

namespace App\Console\Commands\Treatment;

use Illuminate\Console\Command;
use App\Models\Treatments\Treatment;

class TreatmentExec extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'treatment:exec {treatmentId}';

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
        $treatmentId = (int) $this->argument('treatmentId');

        if ( empty($treatmentId) ) {
            $this->error("No Treatment ID provided !");
        } else {
            $this->warn("Treatment " . $treatmentId . " executing...");

            $treatment = Treatment::getById($treatmentId);

            $treatment->service->exec();

            $this->info("Reports executed...");
        }
        return 0;
    }
}
