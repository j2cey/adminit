<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Status;
use App\Models\Reports\Report;
use App\Models\Reports\ReportType;
use App\Models\ReportFile\ReportFile;
use Illuminate\Support\Facades\Artisan;
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
    }

    /**
     * Test la création d'un nouveau ReportFile
     *
     * @return void
     */
    public function test_a_ReportFile_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfile("gutuu");

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
    public function test_a_ReportFile_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfile("");

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test la modification d'un ReportFile
     *
     * @return void
     */
    public function test_a_ReportFile_can_be_updated_from_the_database()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfile("new report file");

        $newreportfile = ReportFile::first();

        $reportfiletype_txt = ReportFileType::txt()->first();
        $status_inactive = Status::inactive()->first();
        $report_new = $this->add_new_report("new report test");

        $this->put('reportfiles/' . $newreportfile->uuid, [
            'report' => $report_new->toJson(),
            'reportfiletype' => $reportfiletype_txt->toJson(),
            'status' => $status_inactive->toJson(),
            'name' => "new report file edited",
            'wildcard' => "new-wilcard",
            'description' => "new-description",
        ]);

        $newreportfile->refresh();

        $this->assertEquals('new report file edited',$newreportfile->name);
        $this->assertEquals('new-wilcard', $newreportfile->wildcard);
        $this->assertEquals('new-description', $newreportfile->description);
        $this->assertEquals($status_inactive->code, $newreportfile->status->code);
        $this->assertEquals($reportfiletype_txt->id, $newreportfile->reportfiletype->id);
        $this->assertEquals($report_new->id, $newreportfile->report->id);
    }

    /**
     * Test la suppression d'un ReportFile
     *
     * @return void
     */
    public function test_a_ReportFile_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfile("new report file");

        $newreportfile = ReportFile::first();

        $this->delete('reportfiles/' . $newreportfile->uuid);

        $this->assertCount(0, ReportFile::all());
    }

    #region Private Functions

    private function add_new_reportfile($name, $wildcard = "",$description="")
    {
        // on essaie d'insérer un nouvel objet ReportFile dans la base de données
        // et on récupère le résultat dans une variable $response

        $reportfiletype = ReportFileType::csv()->first();
        $report = $this->add_new_report("test");
        $status = Status::active()->first();

        return $this->post('reportfiles', [
                'report' => $report->toJson(),
                'reportfiletype' => $reportfiletype->toJson(),
                'status' => $status->toJson(),
                'name' => $name,
                'wildcard' => $wildcard,
                'description' => $description,
            ]
        );
    }

    private function add_new_report($title)
    {
        $reporttype = ReportType::defaultReport()->first();

        return Report::createNew($title,$reporttype,"sdsd");
    }

    #endregion
}
