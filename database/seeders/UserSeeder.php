<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Status;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(
            ['name' => "admin",'username' => "admin",'email' => "admin@sheundani.net",'password' => bcrypt( config('app.admin_password') ), 'status_id' => Status::active()->first()->id]);

        $adminrole = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $adminrole->syncPermissions($permissions);

        $user->assignRole([$adminrole->id]);
    }
}
