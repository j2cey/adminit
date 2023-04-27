<?php

namespace Database\Seeders;

use App\Enums\HtmlTagKey;
use App\Models\Reports\Report;
use Illuminate\Database\Seeder;
use App\Models\Reports\ReportType;
use App\Models\Access\AccessAccount;
use App\Models\Access\AccessProtocole;
use App\Models\OsAndServer\ReportServer;
use App\Models\ReportFile\ReportFileType;
use App\Models\FormatRule\FormatRuleType;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\ReportFile\CollectedReportFile;
use App\Models\DynamicAttributes\DynamicAttribute;
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
            "IME01 - OUTPUT DATA PORTAL",
            ReportType::defaultReport()->first(),
            "Rapport des Files pour le OUTPUT DATA PORTAL de IME01"
        );

        $type_string = DynamicAttributeType::string()->first();
        $type_int = DynamicAttributeType::int()->first();
        $type_datetime = DynamicAttributeType::datetime()->first();

        $attribute_label = $the_report->addDynamicAttribute("label",$type_string, "Libellé", null,"Libellé");
        //$attribute_label->addFormatRule(FormatRuleType::textSize()->first(),"set size");
        $attribute_label->addFormatRule(FormatRuleType::textColor()->first(),"set color");
        $attribute_label->addFormatRule(FormatRuleType::textWeight()->first(),"set weight");

        $attribute_data = $the_report->addDynamicAttribute("data",$type_int, "Donnée",null,"La donnée");

        $the_report->addDynamicAttributeMany([
            ['name' => "trend", 'title' => "Tendance", 'type' => $type_string, 'status' => null,'description' => "La Tendance des changements de la donnée"],
            ['name' => "trend_date", 'title' => "Date Tendance", 'type' => $type_datetime, 'status' => null, 'description' => "Date de la Tendance"],
            ['name' => "trend_times", 'title' => "Rep. Tendance", 'type' => $type_int, 'status' => null, 'description' => "Nombre de repétition de la Tendance actuelle"],
            ['name' => "trend_step", 'title' => "Pas Tendance", 'type' => $type_int, 'status' => null, 'description' => "Différence (bond) vis-à-vis de la dernière donnée"],
            ['name' => "trend_cumul", 'title' => "Cumule", 'type' => $type_int, 'status' => null, 'description' => "Cumule de données dans la tendance actuelle"],
            ['name' => "trend_age", 'title' => "Age Tendance", 'type' => $type_string, 'status' => null, 'description' => "Age de la Tendance hh:mm:ss (différence entre ce date et le début de la Tendance actuelle)"],
            ['name' => "data_treated", 'title' => "Date Traitement", 'type' => $type_int, 'status' => null, 'description' => "Cumule de Données traitées"],
            ['name' => "trend_hourOfWeek", 'title' => "Tendance H. Sne", 'type' => $type_string, 'status' => null, 'description' => "Tendance sur cette heure du jour dans la semaine", "can_be_notified" => false],
            ['name' => "trend_hourOfWeek_date", 'title' => "Date Tendance H. Sne", 'type' => $type_datetime, 'status' => null, 'description' => "Date de Tendance sur cette heure du jour dans la semaine", "can_be_notified" => false],
            ['name' => "trend_hourOfWeek_times", 'title' => "Rep. Tendance H. Sne", 'type' => $type_int, 'status' => null, 'description' => "Nombre de repétition ce cette Tendance sur cette heure du jour dans la semaine", "can_be_notified" => false],
            ['name' => "trend_hourOfWeek_step", 'title' => "Pas Tendance H. Sne", 'type' => $type_int, 'status' => null, 'description' => "Différence (bond) vis-à-vis de la dernière donnée sur cette heure du jour dans la semaine", "can_be_notified" => false],
            ['name' => "report_date", 'title' => "Date Rapport", 'type' => $type_datetime, 'status' => null, 'description' => "Date de génération du Rapport"],
        ]);

        $this->addFile($the_report, "files", "Fichiers par Portal", "reportsmonitor/output_data_portal", $attribute_label);
        $this->addFile($the_report, "kbytes", "Data (KB) par Portal", "reportsmonitor/output_data_portal", $attribute_label);
        $this->addFile($the_report, "records", "Records par Portal", "reportsmonitor/output_data_portal", $attribute_label);

        // insert Collected File
        /*$the_report_file_collected = CollectedReportFile::createNew(
            $the_report_file,
            "//output_data_portal_files.csv",
            "40dae48d3ef7bf73850d5250afc86043.csv",
            1801
        );*/

        //$the_report_file_collected->fresh();
        //dd($the_report_file_collected);

        //$the_report_file_collected->setFormattedValue(HtmlTagKey::TABLE_ROW);
        //$the_report_file_collected->formattedvalues->setValue();
    }

    private function addFile(Report $the_report, $filename, $label, $remotedir_relative_path, DynamicAttribute $attribute_label) {
        $the_report_file = $the_report->addReportFile(
            ReportFileType::csv()->first(),
            $filename, $label,null,null,$remotedir_relative_path
        );

        $the_report_file->setLastRowConfig(false,null,true,$attribute_label,"TOTAL");

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

        // retrieve actions
        $the_report_file_access->addSelectedAction(RetrieveAction::retrieveByName()->first());
        $the_report_file_access->addSelectedAction(RetrieveAction::deleteFile()->first());
    }
}
