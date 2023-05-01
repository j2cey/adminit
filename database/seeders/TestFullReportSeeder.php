<?php

namespace Database\Seeders;

use App\Enums\HtmlTagKey;
use App\Enums\RuleResultEnum;
use App\Models\Reports\Report;
use Illuminate\Database\Seeder;
use App\Models\Reports\ReportType;
use App\Models\Access\AccessAccount;
use App\Models\Access\AccessProtocole;
use App\Models\OsAndServer\ReportServer;
use App\Models\ReportFile\ReportFileType;
use App\Models\FormatRule\FormatRuleType;
use App\Models\FormatRule\FormatTextColor;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\AnalysisRule\AnalysisRuleType;
use App\Models\ReportFile\CollectedReportFile;
use App\Models\DynamicAttributes\DynamicAttribute;
use App\Models\DynamicAttributes\DynamicAttributeType;
use App\Models\AnalysisRuleThreshold\AnalysisRuleThreshold;

class TestFullReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Rapport IME01
        $ime01_report = Report::createNew(
            "IME01 - OUTPUT DATA PORTAL",
            ReportType::defaultReport()->first(),
            "Rapport des Files pour le OUTPUT DATA PORTAL de IME01"
        );

        $attribute_label = $this->addAttributes($ime01_report);
        $this->addDefaultFiles($ime01_report, $attribute_label, ReportServer::where('name',"ime01")->first(), "reportsmonitor/output_data_portal", "cgi");


        // Rapport IME02
        $ime02_report = Report::createNew(
            "IME02 - OUTPUT DATA PORTAL",
            ReportType::defaultReport()->first(),
            "Rapport des Files pour le OUTPUT DATA PORTAL de IME02"
        );
        $ime02_report->deactivate();

        $attribute_label = $this->addAttributes($ime02_report);
        $this->addDefaultFiles($ime02_report, $attribute_label, ReportServer::where('name',"ime02")->first(), "reportsmonitor/output_data_portal", "cgi");


        // Rapport IME03
        $ime03_report = Report::createNew(
            "IME03 - OUTPUT DATA PORTAL",
            ReportType::defaultReport()->first(),
            "Rapport des Files pour le OUTPUT DATA PORTAL de IME03"
        );

        $attribute_label = $this->addAttributes($ime03_report);
        $this->addDefaultFiles($ime03_report, $attribute_label, ReportServer::where('name',"ime03")->first(), "reportsmonitor/output_data_portal", "CGI IME03");


        // Rapport IME04
        $ime04_report = Report::createNew(
            "IME04 - OUTPUT DATA PORTAL",
            ReportType::defaultReport()->first(),
            "Rapport des Files pour le OUTPUT DATA PORTAL de IME04"
        );

        $attribute_label = $this->addAttributes($ime04_report);
        $this->addDefaultFiles($ime04_report, $attribute_label, ReportServer::where('name',"ime04")->first(), "reportsmonitor/output_data_portal", "cgi");

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

    private function addAttributes(Report $the_report) {
        $type_string = DynamicAttributeType::string()->first();
        $type_int = DynamicAttributeType::int()->first();
        $type_datetime = DynamicAttributeType::datetime()->first();

        $attribute_label = $the_report->addDynamicAttribute("label",$type_string, "Libellé", null,"Libellé");
        //$attribute_label->addFormatRule(FormatRuleType::textSize()->first(),"set size");
        $attribute_label->addFormatRule(FormatRuleType::textColor()->first(),"set color");
        $attribute_label->addFormatRule(FormatRuleType::textWeight()->first(),"set weight");

        $attribute_data = $the_report->addDynamicAttribute("data",$type_int, "Donnée",null,"La donnée");

        $attribute_data_analysis_rule = $attribute_data->addAnalysisRule(AnalysisRuleType::threshold()->first(),"max data", ['threshold' => 500],RuleResultEnum::BROKEN->value);

        $red_color = new FormatTextColor();
        $red_color->format_value = "#ff0000";
        $red_color->red = 255;
        $red_color->green = 0;
        $red_color->blue = 0;
        $red_color->hue = 0;
        $red_color->alpha = 0;
        $red_color->lightness = 50;
        $red_color->saturation = 100;
        $red_color->comment = "";
        $attribute_data_analysis_rule->addFormatRule(FormatRuleType::textColor()->first(), "red colored", $red_color->toJson());

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

        return $attribute_label;
    }

    private function addDefaultFiles($the_report, $attribute_label, $report_server, $remotedir_relative_path, $username) {
        $this->addFile($the_report, "files", $report_server, "Fichiers par Portal", $remotedir_relative_path, $attribute_label, $username);
        $this->addFile($the_report, "kbytes", $report_server, "Data (KB) par Portal", $remotedir_relative_path, $attribute_label, $username);
        $this->addFile($the_report, "records", $report_server, "Records par Portal", $remotedir_relative_path, $attribute_label, $username);
    }

    private function addFile(Report $the_report, $filename, $report_server, $label, $remotedir_relative_path, DynamicAttribute $attribute_label, $username) {
        $the_report_file = $the_report->addReportFile(
            ReportFileType::csv()->first(),
            $filename, $label,null,null,$remotedir_relative_path
        );

        $the_report_file->setLastRowConfig(false,null,true,$attribute_label,"TOTAL");

        $the_report_file_access = $the_report_file->addReportFileAccess(
            AccessAccount::where('username', $username)->first(),
            $report_server,
            AccessProtocole::ftp()->first()
        );

        // update account pwd
        /*$the_report_file_access->accessaccount->updateOne(
            $the_report_file_access->accessaccount->login,
            config('app.ftp_password'),
            $the_report_file_access->accessaccount->email,
            $the_report_file_access->accessaccount->username,
            $the_report_file_access->accessaccount->status,
            $the_report_file_access->accessaccount->description
        );*/

        // retrieve actions
        $the_report_file_access->addSelectedAction(RetrieveAction::retrieveByName()->first());
        $the_report_file_access->addSelectedAction(RetrieveAction::deleteFile()->first());
    }
}
