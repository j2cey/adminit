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
            ['reportfiletype-delete', 1]
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission[0], 'level' => $permission[1]]);
        }
    }
}
