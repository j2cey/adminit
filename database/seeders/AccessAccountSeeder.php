<?php

namespace Database\Seeders;

use App\Models\AccessAccount;
use Illuminate\Database\Seeder;

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
        AccessAccount::createNew("cgi","cgi","cgi@ime.com","CGI");
    }
}
