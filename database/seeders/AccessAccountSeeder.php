<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Access\AccessAccount;

class AccessAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccessAccount::createNew("root","root","root@ime.com","Root");
        AccessAccount::createNew("cgi",config('app.ftp_password'),"cgi@ime.com","CGI");
        AccessAccount::createNew("cgi",config('app.cgi2_password'),"cgi@ime.com","CGI IME03");
    }
}
