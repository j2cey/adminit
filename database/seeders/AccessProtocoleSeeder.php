<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Access\FtpProtocole;
use App\Models\Access\SftpProtocole;
use App\Models\Access\AccessProtocole;

class AccessProtocoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccessProtocole::createNew("FTP", "ftp", FtpProtocole::class);
        AccessProtocole::createNew("SFTP", "sftp", SftpProtocole::class);
    }
}
