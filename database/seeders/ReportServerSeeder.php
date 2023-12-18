<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OsAndServer\OsServer;
use App\Models\OsAndServer\ReportServer;

class ReportServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $osserver_redhat = OsServer::where('name', "Red Hat")->first();
        $osserver_ubuntu = OsServer::where('name', "Ubuntu 20")->first();
        ReportServer::createNew($osserver_ubuntu,"local01","192.168.33.10","local01");
        ReportServer::createNew($osserver_redhat,"ime01","192.168.40.2","ime01");
        ReportServer::createNew($osserver_redhat,"ime02","192.168.40.3","ime02");
        ReportServer::createNew($osserver_redhat,"ime03","192.168.5.90","ime03");
        ReportServer::createNew($osserver_redhat,"ime04","192.168.5.91","ime04");
    }
}
