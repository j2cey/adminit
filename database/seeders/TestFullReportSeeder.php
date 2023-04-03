<?php

namespace Database\Seeders;

use App\Models\Reports\Report;
use Illuminate\Database\Seeder;
use App\Models\Reports\ReportType;
use App\Models\Access\AccessAccount;
use App\Models\Access\AccessProtocole;
use App\Models\OsAndServer\ReportServer;
use App\Models\ReportFile\ReportFileType;
use App\Models\ReportFile\CollectedReportFile;
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

        $the_report->addDynamicAttribute("label",$type_string, null,"Libellé");
        $attribute_data = $the_report->addDynamicAttribute("data",$type_int,null,"La donnée");

        $the_report->addDynamicAttributeMany([
            ['name' => "trend", 'type' => $type_string, 'status' => null,'description' => "La Tendance des changements de la donnée"],
            ['name' => "trend_date", 'type' => $type_datetime, 'status' => null, 'description' => "Date de la Tendance"],
            ['name' => "trend_times", 'type' => $type_int, 'status' => null, 'description' => "Nombre de repétition de la Tendance actuelle"],
            ['name' => "trend_step", 'type' => $type_int, 'status' => null, 'description' => "Différence (bond) vis-à-vis de la dernière donnée"],
            ['name' => "trend_cumul", 'type' => $type_int, 'status' => null, 'description' => "Cumule de données dans la tendance actuelle"],
            ['name' => "trend_age", 'type' => $type_string, 'status' => null, 'description' => "Age de la Tendance hh:mm:ss (différence entre ce date et le début de la Tendance actuelle)"],
            ['name' => "data_treated", 'type' => $type_int, 'status' => null, 'description' => "Cumule de Données traitées"],
            ['name' => "trend_hourOfWeek", 'type' => $type_string, 'status' => null, 'description' => "Tendance sur cette heure du jour dans la semaine"],
            ['name' => "trend_hourOfWeek_date", 'type' => $type_datetime, 'status' => null, 'description' => "Date de Tendance sur cette heure du jour dans la semaine"],
            ['name' => "trend_hourOfWeek_times", 'type' => $type_int, 'status' => null, 'description' => "Nombre de repétition ce cette Tendance sur cette heure du jour dans la semaine"],
            ['name' => "trend_hourOfWeek_step", 'type' => $type_int, 'status' => null, 'description' => "Différence (bond) vis-à-vis de la dernière donnée sur cette heure du jour dans la semaine"],
            ['name' => "report_date", 'type' => $type_datetime, 'status' => null, 'description' => "Date de génération du Rapport"],
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

        // insert Collected File
        $the_report_file_collected = CollectedReportFile::createNew(
            $the_report_file,
            "//output_data_portal_files.csv",
            "40dae48d3ef7bf73850d5250afc86043.csv",
            1801
        );
    }
}
