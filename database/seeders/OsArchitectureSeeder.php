<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OsAndServer\OsArchitecture;

class OsArchitectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OsArchitecture::createNew("Undefined", "undefined");
        OsArchitecture::createNew("Monolithic", "monolithic");
        OsArchitecture::createNew("Layered", "layered");
        OsArchitecture::createNew("Microkernel", "microkernel");
        OsArchitecture::createNew("Hybrid", "hybrid");
    }
}
