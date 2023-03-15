<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OsAndServer\OsServer;
use App\Models\OsAndServer\OsFamily;
use App\Models\OsAndServer\OsArchitecture;

class OsServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $osarch_hybrid = OsArchitecture::where('code', "hybrid")->first();

        $osfam_linux = OsFamily::where('code', "linux")->first();
        $osfam_windows = OsFamily::where('code', "windows")->first();
        $osfam_windowsserver = OsFamily::where('code', "windowsserver")->first();

        OsServer::createNew($osarch_hybrid,$osfam_linux,"UBUNTU 20");
        OsServer::createNew($osarch_hybrid,$osfam_windows,"WINDOWS 10");
        OsServer::createNew($osarch_hybrid,$osfam_windowsserver,"WINDOWS SERVER 12");
    }
}
