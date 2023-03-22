<?php

namespace Database\Seeders;

use App\Models\Reports\Report;
use Illuminate\Database\Seeder;
use App\Models\Reports\ReportType;
use App\Models\Access\AccessProtocole;
use App\Models\OsAndServer\ReportServer;
use App\Models\ReportFile\ReportFileType;
use App\Models\Access\AccessAccount;
use App\Models\DynamicAttributes\DynamicAttributeType;

class TestFullReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Le Rapport
        $the_report = Report::createNew(
            "IME01 OUTPUT DATA PORTAL FILES",
            ReportType::defaultReport()->first(),
            "Rapport des Files pour le OUTPUT DATA PORTAL de IME01"
        );

        $type_string = DynamicAttributeType::string()->first();
        $type_int = DynamicAttributeType::int()->first();
        $type_datetime = DynamicAttributeType::datetime()->first();

        $the_report->addDynamicAttributeMany([
            ['name' => "label", 'type' => $type_string],
            ['name' => "data", 'type' => $type_int],
            ['name' => "trend", 'type' => $type_string],
            ['name' => "trend_date", 'type' => $type_datetime],
            ['name' => "trend_times", 'type' => $type_int],
            ['name' => "trend_step", 'type' => $type_int],
            ['name' => "trend_cumul", 'type' => $type_int],
            ['name' => "trend_age", 'type' => $type_string],
            ['name' => "data_treated", 'type' => $type_int],
            ['name' => "trend_hourOfWeek", 'type' => $type_string],
            ['name' => "trend_hourOfWeek_date", 'type' => $type_datetime],
            ['name' => "trend_hourOfWeek_times", 'type' => $type_int],
            ['name' => "trend_hourOfWeek_step", 'type' => $type_int],
            ['name' => "report_date", 'type' => $type_datetime],
        ]);

        $the_report_file = $the_report->addReportFile(
            ReportFileType::csv()->first(),
            "output_data_portal_files"
        );
        $the_report_file_access = $the_report_file->addReportFileAccess(
            AccessAccount::where('username', "cgi")->first(),
            ReportServer::where('name',"ime01")->first(),
            AccessProtocole::ftp()->first()
        );

        // update account pwd
        $the_report_file_access->accessaccount->updateOne(
            $the_report_file_access->accessaccount->login,
            config('app.ftp_password'),
            $the_report_file_access->accessaccount->email,
            $the_report_file_access->accessaccount->username,
            $the_report_file_access->accessaccount->status,
            $the_report_file_access->accessaccount->description
        );
    }
}
