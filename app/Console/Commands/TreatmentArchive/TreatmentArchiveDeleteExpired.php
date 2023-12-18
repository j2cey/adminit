<?php

namespace App\Console\Commands\TreatmentArchive;

use Illuminate\Console\Command;
use App\Traits\ReportTreatment\Administration\TreatmentArchive;

class TreatmentArchiveDeleteExpired extends Command
{
    use TreatmentArchive;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'treatmentarchive:deleteexpired {level?}';

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
        $level = $this->argument('level');

        if ( empty($level) ) {
            $this->warn("Delete expired Treatments ALL Levels executing...");
            for ($i = 0; $i <= 3; $i++) {
                $this->expiredTreatmentWithLevelDelete($i);
            }
            $this->expiredTreatmentWithLevelGreaterDelete( 3 );
        } else {
            $this->warn("Delete expired Treatment level " . $level . " executing...");

            $this->expiredTreatmentWithLevelDelete($level);

            $this->info("Execution done...");
        }
        return 0;
    }
}
