<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['role-list', 2],
            ['role-create', 1],
            ['role-update', 1],
            ['role-delete', 1],

            ['workflow-list', 4],
            ['workflow-create', 3],
            ['workflow-update', 3],
            ['workflow-delete', 3],

            ['reportfiletype-list', 4],
            ['reportfiletype-create', 3],
            ['reportfiletype-update', 1],
            ['reportfiletype-delete', 1],

            ['reportfile-list', 4],
            ['reportfile-create', 3],
            ['reportfile-update', 1],
            ['reportfile-delete', 1],

            ['accessaccount-list', 4],
            ['accessaccount-create', 3],
            ['accessaccount-update', 1],
            ['accessaccount-delete', 1],

            ['osarchitecture-list', 4],
            ['osarchitecture-create', 3],
            ['osarchitecture-update', 1],
            ['osarchitecture-delete', 1],

            ['osfamily-list', 4],
            ['osfamily-create', 3],
            ['osfamily-update', 1],
            ['osfamily-delete', 1],

            ['osserver-list', 4],
            ['osserver-create', 3],
            ['osserver-update', 1],
            ['osserver-delete', 1]
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission[0], 'level' => $permission[1]]);
        }
    }
}
