<?php

namespace App\Console\Commands\ReportFile;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportFile\NotifyReport;

class ReportFileFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportfile:format';

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
        Mail::to("J.NGOMNZE@moov-africa.ga")
            ->send(new NotifyReport());
        return 0;
    }
}
