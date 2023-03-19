<?php

namespace Database\Seeders;

use App\Enums\Permissions;
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
        $permissions_old = [
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
            ['osserver-delete', 1],

            ['accessprotocole-list', 4],
            ['accessprotocole-create', 3],
            ['accessprotocole-update', 1],
            ['accessprotocole-delete', 1],

            ['reportfileaccess-list', 4],
            ['reportfileaccess-create', 3],
            ['reportfileaccess-update', 1],
            ['reportfileaccess-delete', 1],

            ['reportserver-list', 4],
            ['reportserver-create', 3],
            ['reportserver-update', 1],
            ['reportserver-delete', 1],

            ['retrieveactiontype-list', 4],
            ['retrieveactiontype-create', 3],
            ['retrieveactiontype-update', 1],
            ['retrieveactiontype-delete', 1],

            ['retrieveaction-list', 4],
            ['retrieveaction-create', 3],
            ['retrieveaction-update', 1],
            ['retrieveaction-delete', 1],

            ['selectedretrieveaction-list', 4],
            ['selectedretrieveaction-create', 3],
            ['selectedretrieveaction-update', 1],
            ['selectedretrieveaction-delete', 1]
        ];

        $permissions = array_merge([],
            Permissions::Role()->getAllPermissions(),
            Permissions::Report()->getAllPermissions(),
            Permissions::ReportType()->getAllPermissions(),
            Permissions::ThresholdType()->getAllPermissions(),
            Permissions::FileMimeType()->getAllPermissions(),

            Permissions::DynamicAttributeType()->getAllPermissions(),
            Permissions::DynamicAttribute()->getAllPermissions(),
            Permissions::AnalysisRuleType()->getAllPermissions(),
            Permissions::AnalysisRule()->getAllPermissions(),
            Permissions::AnalysisHighlightType()->getAllPermissions(),
            Permissions::AnalysisHighlight()->getAllPermissions(),

            Permissions::ReportFileType()->getAllPermissions(),
            Permissions::ReportFile()->getAllPermissions(),
            Permissions::AccessAccount()->getAllPermissions(),
            Permissions::OsArchitecture()->getAllPermissions(),
            Permissions::OsFamily()->getAllPermissions(),
            Permissions::OsServer()->getAllPermissions(),
            Permissions::AccessProtocole()->getAllPermissions(),
            Permissions::ReportFileAccess()->getAllPermissions(),
            Permissions::ReportServer()->getAllPermissions(),
            Permissions::RetrieveActionType()->getAllPermissions(),
            Permissions::RetrieveAction()->getAllPermissions(),
            Permissions::SelectedRetrieveAction()->getAllPermissions(),
            Permissions::RetrieveActionValue()->getAllPermissions(),
        );

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission[0], 'level' => $permission[1]]);
        }
    }
}
