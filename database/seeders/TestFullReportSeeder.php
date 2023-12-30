<?php

namespace Database\Seeders;

use App\Enums\RuleResultEnum;
use App\Models\Person\Person;
use App\Models\Reports\Report;
use Illuminate\Database\Seeder;
use App\Models\Reports\ReportType;
use App\Models\Access\AccessAccount;
use App\Models\ReportFile\ReportFile;
use App\Models\Access\AccessProtocole;
use App\Models\OsAndServer\ReportServer;
use App\Models\ReportFile\ReportFileType;
use App\Models\FormatRule\FormatRuleType;
use App\Models\FormatRule\FormatTextColor;
use App\Models\FormatRule\FormatTextWeight;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\AnalysisRule\AnalysisRuleType;
use App\Models\ReportFile\ReportFileReceiver;
use App\Models\DynamicAttributes\DynamicAttribute;
use App\Models\AnalysisRuleThreshold\ThresholdType;
use App\Models\DynamicAttributes\DynamicAttributeType;

class TestFullReportSeeder extends Seeder
{
    private Person $person;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->person = Person::createNew("Jude Parfait", "Ngom Nze");
        $this->person->addNewPhoneNumber("065300354");
        $this->person->addNewEmailAddress("J.NGOMNZE@moov-africa.ga");
        $this->person->addNewEmailAddress("jud10parfait@gmail.com");

        // Rapport IME01
        $ime01_report = Report::createNew(
            "IME01 - OUTPUT DATA PORTAL",
            ReportType::defaultReport()->first(),
            "Rapport des Files pour le OUTPUT DATA PORTAL de IME01"
        );

        $this->addDefaultFiles($ime01_report, ReportServer::where('name',"ime01")->first(), "reportsmonitor/output_data_portal", "cgi");

        // Rapport IME02
        $ime02_report = Report::createNew(
            "IME02 - OUTPUT DATA PORTAL",
            ReportType::defaultReport()->first(),
            "Rapport des Files pour le OUTPUT DATA PORTAL de IME02"
        );
        $ime02_report->deactivate();

        $this->addDefaultFiles($ime02_report, ReportServer::where('name',"ime02")->first(), "reportsmonitor/output_data_portal", "cgi");

        // Rapport IME03
        $ime03_report = Report::createNew(
            "IME03 - OUTPUT DATA PORTAL",
            ReportType::defaultReport()->first(),
            "Rapport des Files pour le OUTPUT DATA PORTAL de IME03"
        );
        $ime03_report->deactivate();

        $this->addDefaultFiles($ime03_report, ReportServer::where('name',"ime03")->first(), "reportsmonitor/output_data_portal", "CGI IME03");

        // Rapport IME04
        $ime04_report = Report::createNew(
            "IME04 - OUTPUT DATA PORTAL",
            ReportType::defaultReport()->first(),
            "Rapport des Files pour le OUTPUT DATA PORTAL de IME04"
        );
        $ime04_report->deactivate();

        $this->addDefaultFiles($ime04_report, ReportServer::where('name',"ime04")->first(), "reportsmonitor/output_data_portal", "cgi");

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

    private function addAttributes(ReportFile $the_report_file, int $data_threshold) {
        $type_string = DynamicAttributeType::string()->first();
        $type_int = DynamicAttributeType::int()->first();
        $type_datetime = DynamicAttributeType::datetime()->first();

        $attribute_label = $the_report_file->addDynamicAttribute("label",$type_string, "Libellé", null,"Libellé");
        //$attribute_label->addFormatRule(FormatRuleType::textSize()->first(),"set size");
        $attribute_label->addFormatRule(FormatRuleType::textColor()->first(),"set color");
        $format_text_weight = new FormatTextWeight();
        $format_text_weight->format_bold = true;
        $format_text_weight->format_italic = true;
        $format_text_weight->format_underline = false;
        $format_text_weight->format_value = json_encode( ['bold','italic'] );
        $format_text_weight->comment = "";
        $attribute_label->addFormatRule(FormatRuleType::textWeight()->first(),"set weight", $format_text_weight->toJson());

        $attribute_data = $the_report_file->addDynamicAttribute("data",$type_int, "Donnée",null,"La donnée");

        $attribute_data_analysis_rule = $attribute_data->addAnalysisRule(AnalysisRuleType::threshold()->first(),"max data", [
            'thresholdtype' => json_encode(ThresholdType::max()->first()),
            'threshold' => $data_threshold
        ], RuleResultEnum::BROKEN->value);

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

        $the_report_file->addDynamicAttributeMany([
            ['name' => "trend", 'title' => "Tendance", 'type' => $type_string, 'status' => null,'description' => "La Tendance des changements de la donnée"],
            ['name' => "trend_date", 'title' => "Date Tendance", 'type' => $type_datetime, 'status' => null, 'description' => "Date de la Tendance"],
            ['name' => "trend_times", 'title' => "Rep. Tendance", 'type' => $type_int, 'status' => null, 'description' => "Nombre de repétition de la Tendance actuelle"],
            ['name' => "trend_step", 'title' => "Pas Tendance", 'type' => $type_int, 'status' => null, 'description' => "Différence (bond) vis-à-vis de la dernière donnée"],
            ['name' => "trend_cumul", 'title' => "Cumule", 'type' => $type_int, 'status' => null, 'description' => "Cumule de données dans la tendance actuelle"],
            ['name' => "trend_age", 'title' => "Age Tendance", 'type' => $type_string, 'status' => null, 'description' => "Age de la Tendance hh:mm:ss (différence entre ce date et le début de la Tendance actuelle)"],
            ['name' => "data_treated", 'title' => "Données Traitées", 'type' => $type_int, 'status' => null, 'description' => "Cumule de Données traitées"],
            ['name' => "trend_hourOfWeek", 'title' => "Tendance H. Sne", 'type' => $type_string, 'status' => null, 'description' => "Tendance sur cette heure du jour dans la semaine", "can_be_notified" => false],
            ['name' => "trend_hourOfWeek_date", 'title' => "Date Tendance H. Sne", 'type' => $type_datetime, 'status' => null, 'description' => "Date de Tendance sur cette heure du jour dans la semaine", "can_be_notified" => false],
            ['name' => "trend_hourOfWeek_times", 'title' => "Rep. Tendance H. Sne", 'type' => $type_int, 'status' => null, 'description' => "Nombre de repétition ce cette Tendance sur cette heure du jour dans la semaine", "can_be_notified" => false],
            ['name' => "trend_hourOfWeek_step", 'title' => "Pas Tendance H. Sne", 'type' => $type_int, 'status' => null, 'description' => "Différence (bond) vis-à-vis de la dernière donnée sur cette heure du jour dans la semaine", "can_be_notified" => false],
            ['name' => "report_date", 'title' => "Date Rapport", 'type' => $type_datetime, 'status' => null, 'description' => "Date de génération du Rapport"],
        ]);

        return $attribute_label;
    }

    private function addDefaultFiles($the_report, $report_server, $remotedir_relative_path, $username) {
        $this->addFile($the_report, "files", $report_server, "Fichiers par Portal", 500, $remotedir_relative_path, $username);
        $this->addFile($the_report, "kbytes", $report_server, "Data (KB) par Portal", 10, $remotedir_relative_path, $username);
        $this->addFile($the_report, "records", $report_server, "Records par Portal", 20, $remotedir_relative_path, $username);
    }

    private function addFile(Report $the_report, $filename, $report_server, $label, int $data_threshold, $remotedir_relative_path, $username) {
        $local_report_server = ReportServer::where('name',"local01")->first();
        $local_username = "vagrant";

        $the_report_file = $the_report->addReportFile(
            ReportFileType::csv()->first(),
            $filename, $label,null,null,$remotedir_relative_path
        );

        $attribute_label = $this->addAttributes($the_report_file, $data_threshold);
        $the_report_file->setLastRowConfig(false,null,true,$attribute_label,"TOTAL");

        $the_report_file_access = $the_report_file->addReportFileAccess(
            AccessAccount::where('username', $username)->first(),
            $report_server,
            AccessProtocole::ftp()->first()
        );
        $the_report_file_access->deactivate();

        // retrieve actions
        $the_report_file_access->addSelectedAction(RetrieveAction::retrieveByName()->first());
        $the_report_file_access->addSelectedAction(RetrieveAction::deleteFile()->first());

        // report file access local
        $the_report_file_access_local = $the_report_file->addReportFileAccess(
            AccessAccount::where('username', $local_username)->first(),
            $local_report_server,
            AccessProtocole::local()->first()
        );
        //$the_report_file_access_local->deactivate();
        // retrieve actions for local
        $the_report_file_access_local->addSelectedAction(RetrieveAction::retrieveByName()->first());
        $the_report_file_access_local->addSelectedAction(RetrieveAction::deleteFile()->first());

        ReportFileReceiver::createNew($the_report_file, $this->person, $this->person->emailaddresses[0],$this->person->phonenumbers[0]);
        ReportFileReceiver::createNew($the_report_file, $this->person, $this->person->emailaddresses[1],$this->person->phonenumbers[0]);
    }
}
