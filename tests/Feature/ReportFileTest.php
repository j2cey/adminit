<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Models\Setting;
use App\Models\Reports\Report;
use App\Models\Reports\ReportType;
use App\Models\ReportFile\ReportFile;
use Illuminate\Support\Facades\Config;
use App\Models\ReportFile\ReportFileType;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReportFileTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');
        // alternatively you can call
        // $this->seed();

        // Custom Configs
        Config::set('Settings', Setting::getAllGrouped());
    }

    /**
     * Test la création d'un nouveau ReportFile
     *
     * @return void
     */
    public function test_aReportFile_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfile(
            $this->add_new_report("new report"),
            ReportFileType::csv()->first(),
            Status::active()->first(),
            "new report file"
        );

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, ReportFile::all());
    }

    /**
     * Test la validation d'un nouveau ReportFile avant création
     *
     * @return void
     */
    public function test_aReportFile_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfile(
            null,
            null,
            Status::active()->first(),
            ""
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['report','reportfiletype','name']);
    }

    /**
     * Test la validation d'un nouveau ReportFile avant création
     *
     * @return void
     */
    public function test_aReportFile_without_spaces_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfile(
            $this->add_new_report("new report"),
            ReportFileType::csv()->first(),
            Status::active()->first(),
            "new report file",
            "rerre reerre"
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['wildcard']);
    }

    /**
     * Test la modification d'un ReportFile
     *
     * @return void
     */
    public function test_aReportFile_can_be_updated_from_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfile(
            $this->add_new_report("new report"),
            ReportFileType::csv()->first(),
            Status::active()->first(),
            "new report file",
            "rerre_reerre",
            true,
            false,
            "new report desc"
        );

        $newreportfile = ReportFile::first();

        $reportfiletype_txt = ReportFileType::txt()->first();
        $status_inactive = Status::inactive()->first();
        $another_report = $this->add_new_report("another report");

        $this->update_existing_reportfile(
            $newreportfile,
            $another_report,
            $reportfiletype_txt,
            $status_inactive,"new report file edited",
            "new_wildcard",
            false,
            true,
            "new report desc edited"
        );

        $newreportfile->refresh();

        $this->assertEquals('new report file edited',$newreportfile->name);
        $this->assertEquals('new_wildcard', $newreportfile->wildcard);
        $this->assertEquals('new report desc edited', $newreportfile->description);
        $this->assertEquals(false, $newreportfile->retrieve_by_name);
        $this->assertEquals(true, $newreportfile->retrieve_by_wildcard);
        $this->assertEquals($status_inactive->code, $newreportfile->status->code);
        $this->assertEquals($reportfiletype_txt->id, $newreportfile->reportfiletype->id);
        $this->assertEquals($another_report->id, $newreportfile->report->id);
    }

    /**
     * Test la suppression d'un ReportFile
     *
     * @return void
     */
    public function test_aReportFile_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfile(
            $this->add_new_report("new report"),
            ReportFileType::csv()->first(),
            Status::active()->first(),
            "new report file"
        );

        $newreportfile = ReportFile::first();

        $this->delete('reportfiles/' . $newreportfile->uuid);

        $this->assertCount(0, ReportFile::all());
    }



    #region Private Functions

    private function add_new_reportfile($report, $reportfiletype, $status, $name, $wildcard = null, $retrieve_by_name = false, $retrieve_by_wildcard = false, $description = "")
    {
        return $this->post('reportfiles', $this->new_data($report, $reportfiletype, $status, $name, $wildcard, $retrieve_by_name, $retrieve_by_wildcard, $description));
    }

    private function update_existing_reportfile($existingreportfile, $report, $reportfiletype, $status, $name, $wildcard = null, $retrieve_by_name = false, $retrieve_by_wildcard = false, $description = "")
    {
        $this->put('reportfiles/' . $existingreportfile->uuid, $this->new_data($report, $reportfiletype, $status, $name, $wildcard, $retrieve_by_name, $retrieve_by_wildcard, $description));
    }

    private function add_new_report($title)
    {
        $reporttype = ReportType::defaultReport()->first();
        return Report::createNew($title,$reporttype,"sdsd");
    }

    private function new_data($report, $reportfiletype, $status, $name, $wildcard = null, $retrieve_by_name = false, $retrieve_by_wildcard = false, $description = "") {
        return [
            'report' => $report,
            'reportfiletype' => $reportfiletype,
            'status' => $status,

            'name' => $name,
            'wildcard' => $wildcard,
            'retrieve_by_name' => $retrieve_by_name,
            'retrieve_by_wildcard' => $retrieve_by_wildcard,
            'description' => $description,
        ];
    }

    #endregion
}
