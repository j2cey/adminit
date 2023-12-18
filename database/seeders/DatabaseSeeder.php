<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\UserResource::factory(10)->create();
        $this->call(SettingSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(DynamicAttributeTypeSeeder::class);

        $this->call(ThresholdTypeSeeder::class);
        $this->call(ComparisonTypeSeeder::class);
        $this->call(AnalysisRuleTypeSeeder::class);
        $this->call(FormatRuleTypeSeeder::class);

        $this->call(ReportTypeSeeder::class);
        $this->call(FileMimeTypeSeeder::class);
        $this->call(ReportFileTypeSeeder::class);

        $this->call(OsArchitectureSeeder::class);
        $this->call(OsFamilySeeder::class);
        $this->call(OsServerSeeder::class);
        $this->call(AccessProtocoleSeeder::class);

        $this->call(AccessAccountSeeder::class);
        $this->call(ReportServerSeeder::class);

        $this->call(RetrieveActionTypeSeeder::class);
        $this->call(RetrieveActionSeeder::class);
        $this->call(FormatTypeSeeder::class);

        $this->call(JobLauncherSeeder::class);

    }
}
