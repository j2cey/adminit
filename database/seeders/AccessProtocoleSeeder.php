<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Access\FtpProtocole;
use App\Models\Access\SftpProtocole;
use App\Models\Access\LocalProtocole;
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
        AccessProtocole::createNew("LOCAL",22, "local", LocalProtocole::class);
        AccessProtocole::createNew("FTP",21, "ftp", FtpProtocole::class);
        AccessProtocole::createNew("SFTP",22, "sftp", SftpProtocole::class);
    }
}
