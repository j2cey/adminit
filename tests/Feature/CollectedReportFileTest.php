<?php

namespace Tests\Feature;

use App\Models\Status;
use App\Models\Setting;
use App\Models\ReportFile\ReportFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use App\Models\ReportFile\CollectedReportFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CollectedReportFileTest extends TestCase
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

        Config::set('Settings', Setting::getAllGrouped());

        // on tronque la table du modèle CollectedReportFile dans la base de données
        Schema::disableForeignKeyConstraints();
        CollectedReportFile::truncate();
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Test la création d'un nouveau ReportFileType
     *
     * @return void
     */
    public function test_aCollectedReportFile_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        //$collectedreportfile_count_before_test = CollectedReportFile::all()->count();

        $user = $this->authenticated_user_admin();
        $reportfile = $this->get_new_reportfile("new report", "new file");

        $response = $this->add_new_collectedreportfile($reportfile,
            "new i name",
            "new l name",
            "size",
            status::default()->first(),
            "new desc");

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, CollectedReportFile::all());
    }
    /**
     * Test la validation d'un nouveau CollectedReportFile avant création
     *
     * @return void
     */
    public function test_anCollectedReportFile_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_collectedreportfile("","", "", "",Status::default()->first(),"desc");

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['reportfile','initial_file_name','local_file_name','file_size']);
    }

    /**
     * Test la modification d'un CollectedReportFile
     *
     * @return void
     */
    public function test_anCollectedReportFile_can_be_updated_from_the_database()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $reportfile = $this->get_new_reportfile("new report", "new file");
        $response = $this->add_new_collectedreportfile($reportfile,
            "new initial name",
            "new local name",
            "new size",
            status::default()->first(),
            "new desc"
        );

        $newcollectedreportfile = CollectedReportFile::first();

        $status_another = Status::inactive()->first();

        $response = $this->update_existing_collectedreportfile(
            $newcollectedreportfile,
            $reportfile,
            "new initial name",
            "new local name",
            "new size",
            $status_another,
            "new description"
        );

        $newcollectedreportfile->refresh();

        $this->assertEquals($reportfile->id, $newcollectedreportfile->reportfile->id);
        $this->assertEquals('new initial name',$newcollectedreportfile->initial_file_name);
        $this->assertEquals('new local name',$newcollectedreportfile->local_file_name);
        $this->assertEquals('new size', $newcollectedreportfile->file_size);
        $this->assertEquals($status_another, $newcollectedreportfile->status);
    }

/**
* Test la suppression d'un CollectedReportFile
     *
     * @return void
     */
    public function test_aCollectedReportFile_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();
        $reportfile = $this->get_new_reportfile("new report", "new file");

        $response = $this->add_new_collectedreportfile($reportfile,
            "new initial name",
            "new local name",
            "new size",

        );

        $newcollectedreportfile = CollectedReportFile::first();

        $this->delete('collectedreportfiles/' . $newcollectedreportfile->uuid);

        $this->assertCount(0, CollectedReportFile::all());
    }

    #region Private Functions


    private function add_new_collectedreportfile($reportfile, $initial_file_name, $local_file_name, $file_size, $status = null, $description = null)
    {
        return $this->post('collectedreportfiles', $this->new_data($reportfile, $initial_file_name, $local_file_name, $file_size, $status, $description));
    }
    private function update_existing_collectedreportfile($collectedreportfile, $reportfile, $initial_file_name,$local_file_name, $file_size, $status = null, $description = null)
    {
        return $this->put('collectedreportfiles/' . $collectedreportfile->uuid, $this->new_data($reportfile, $initial_file_name,$local_file_name, $file_size, $status, $description));
    }

    private function new_data($reportfile, $initial_file_name,$local_file_name, $file_size, $status = null, $description = null) {
        return [
            'reportfile' => $reportfile,
            'initial_file_name' => $initial_file_name,
            'local_file_name' => $local_file_name,
            'file_size' => $file_size,
            'status' => $status,
            'description' => $description,
        ];
    }

    #endregion
}
