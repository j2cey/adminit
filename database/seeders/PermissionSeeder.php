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
        /*
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
        */

        $class_methods = get_class_methods(Permissions::class);

        foreach ($class_methods as $class_method) {
            $permissions = Permissions::$class_method()->getAllPermissions();
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission[0], 'level' => $permission[1]]);
            }
        }

        /*
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission[0], 'level' => $permission[1]]);
        }
        */
    }
}
