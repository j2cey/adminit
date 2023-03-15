<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OsAndServer\OsFamily;

class OsFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OsFamily::createNew("Macintosh operating systems", "macos");
        OsFamily::createNew("Microsoft Windows", "windows");
        OsFamily::createNew("Microsoft Windows Server", "windowsserver");
        OsFamily::createNew("Linux", "linux");
    }
}
