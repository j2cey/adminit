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
            $this->create_new_report("new report"),
            ReportFileType::csv()->first(),
            Status::active()->first(),
            "new report file",
            "new report file label"
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
            "",
            ""
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['report','reportfiletype','name','label']);
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
            $this->create_new_report("new report"),
            ReportFileType::csv()->first(),
            Status::active()->first(),
            "new report file",
            "new report file label"
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
            $this->create_new_report("new report"),
            ReportFileType::csv()->first(),
            Status::active()->first(),
            "new report file",
            "new report file label",
            "rerre_reerre",
            "new report desc",
            "remotedir_relative",
            "remotedir_absolute",
            true,
            true
        );

        $newreportfile = ReportFile::first();

        $reportfiletype_txt = ReportFileType::txt()->first();
        $status_inactive = Status::inactive()->first();
        $another_report = $this->create_new_report("another report");

        $this->update_existing_reportfile(
            $newreportfile,
            $another_report,
            $reportfiletype_txt,
            $status_inactive,"new report file edited",
            "new report file label edited",
            "new_wildcard",
            "new report desc upd",
            "remotedir_relative_upd",
            "remotedir_absolute_upd",
            false,
            false
        );

        $newreportfile->refresh();

        $this->assertEquals('new report file edited',$newreportfile->name);
        $this->assertEquals('new report file label edited',$newreportfile->label);
        $this->assertEquals('new_wildcard', $newreportfile->wildcard);
        $this->assertEquals('new report desc upd', $newreportfile->description);
        $this->assertEquals("remotedir_relative_upd", $newreportfile->remotedir_relative_path);
        $this->assertEquals("remotedir_absolute_upd", $newreportfile->remotedir_absolute_path);
        $this->assertEquals(false, $newreportfile->use_file_extension);
        $this->assertEquals(false, $newreportfile->has_headers);
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
            $this->create_new_report("new report"),
            ReportFileType::csv()->first(),
            Status::active()->first(),
            "new report file",
            "new report file label"
        );

        $newreportfile = ReportFile::first();

        $this->delete('reportfiles/' . $newreportfile->uuid);

        $this->assertCount(0, ReportFile::all());
    }



    #region Private Functions

    private function add_new_reportfile($report, $reportfiletype, $status, $name, $label, $wildcard = null, $description = null, $remotedir_relative_path = null, $remotedir_absolute_path = null, $use_file_extension = true, $has_headers = true)
    {
        return $this->post('reportfiles', $this->new_data($report, $reportfiletype, $status, $name, $label, $wildcard, $description, $remotedir_relative_path, $remotedir_absolute_path, $use_file_extension, $has_headers));
    }

    private function update_existing_reportfile($existingreportfile, $report, $reportfiletype, $status, $name, $label, $wildcard = null, $description = null, $remotedir_relative_path = null, $remotedir_absolute_path = null, $use_file_extension = true, $has_headers = true)
    {
        $this->put('reportfiles/' . $existingreportfile->uuid, $this->new_data($report, $reportfiletype, $status, $name, $label, $wildcard, $description, $remotedir_relative_path, $remotedir_absolute_path, $use_file_extension, $has_headers));
    }

    private function new_data($report, $reportfiletype, $status, $name, $label, $wildcard = null, $description = null, $remotedir_relative_path = null, $remotedir_absolute_path = null, $use_file_extension = true, $has_headers = true) {
        return [
            'report' => $report,
            'reportfiletype' => $reportfiletype,
            'status' => $status,

            'name' => $name,
            'label' => $label,
            'wildcard' => $wildcard,
            'remotedir_relative_path' => $remotedir_relative_path,
            'remotedir_absolute_path' => $remotedir_absolute_path,
            'use_file_extension' => $use_file_extension,
            'has_headers' => $has_headers,

            'description' => $description,
        ];
    }

    #endregion
}
