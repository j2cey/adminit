<?php

namespace App\Traits\JobAndBatch;


use App\Helpers\SymphonyProcess;
use App\Traits\Archive\ArchiveDates;

trait JobAndBatch
{
    use ArchiveDates;

    public function reloadWorker(string $queue_name) {
        $command = "sudo systemctl restart adminit-" . $queue_name . ".target";
        return SymphonyProcess::runShellCommand($command);
    }
}
