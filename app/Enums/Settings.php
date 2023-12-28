<?php

namespace App\Enums;

use App\Enums\Settings\Branches\App;
use App\Enums\Settings\Branches\Ldap;
use App\Enums\Settings\Branches\Jobs;
use App\Enums\Settings\Branches\Roles;
use App\Enums\Settings\Branches\Files;
use App\Enums\Settings\Branches\Queues;
use App\Enums\Settings\Branches\Treatment;
use App\Enums\Settings\Branches\ReportFile;
use App\Enums\Settings\Branches\JobBatches;
use App\Enums\Settings\Branches\LogTreatments;
use App\Enums\Settings\Branches\ReportFileType;
use App\Enums\Settings\Branches\TreatmentArchive;
use App\Enums\Settings\Branches\CollectedReportFile;
use App\Enums\Settings\Branches\SelectedRetrieveAction;

/**
 * Class Settings. Settings Main Entries
 * @package App\Enums
 *
 */
class Settings
{
    public static function App() {
        return new App();
    }
    public static function Roles() {
        return new Roles();
    }
    public static function Files() {
        return new Files();
    }
    public static function Ldap() {
        return new Ldap();
    }
    public static function ReportFileType() {
        return new ReportFileType();
    }
    public static function ReportFile() {
        return new ReportFile();
    }
    public static function SelectedRetrieveAction() {
        return new SelectedRetrieveAction();
    }
    public static function Treatment() {
        return new Treatment();
    }
    public static function Queues() {
        return new Queues();
    }
    public static function LogTreatments() {
        return new LogTreatments();
    }
    public static function TreatmentArchive() {
        return new TreatmentArchive();
    }
    public static function Jobs() {
        return new Jobs();
    }
    public static function JobBatches() {
        return new JobBatches();
    }
    public static function CollectedReportFile() {
        return new CollectedReportFile();
    }
}
