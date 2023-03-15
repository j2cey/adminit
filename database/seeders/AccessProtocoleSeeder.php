<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccessProtocole;

class AccessProtocoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccessProtocole::createNew("FTP", "ftp");
        AccessProtocole::createNew("SFTP", "sftp");
    }
}
