<?php

namespace Database\Seeders;

use App\Enums\Settings;
use App\Enums\QueueEnum;
use Illuminate\Database\Seeder;
use App\Models\Jobs\JobLauncher;

class JobLauncherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $queuecodes = QueueEnum::cases();
        foreach ($queuecodes as $queuecode) {
            $queuecode_value = $queuecode->value;
            if ( is_null(Settings::Queues()->workerbounds()->$queuecode_value()) ) {
                continue;
            }
            $worker_bounds = Settings::Queues()->workerbounds()->$queuecode_value()->get();
            for ($i = $worker_bounds[0]; $i <= $worker_bounds[2]; $i++) {
                JobLauncher::createNew($queuecode,$i,0);
            }
        }
    }
}
