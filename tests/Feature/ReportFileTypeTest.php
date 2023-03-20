<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use Illuminate\Support\Facades\Schema;
use App\Models\ReportFile\FileMimeType;
use App\Models\ReportFile\ReportFileType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReportFileTypeTest extends TestCase
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

        // on tronque la table du modèle ReportFileType dans la base de données
        Schema::disableForeignKeyConstraints();
        ReportFileType::truncate();
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Test la création d'un nouveau ReportFileType
     *
     * @return void
     */
    public function test_aReportFileType_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        //$reportfiletype_count_before_test = ReportFileType::all()->count();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfiletype(
            FileMimeType::txt()->first(),
            "txt",
            "csv"
        );

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, ReportFileType::all());
    }


    /**
     * Test la validation d'un nouveau ReportFileType avant création
     *
     * @return void
     */
    public function test_aReportFileType_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfiletype(
            null,
            null,
            null
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['filemimetype','name','extension']);
    }
    public function test_aReportFileType_spaced_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfiletype(
            FileMimeType::png()->first(),
            "png",
            "p n g"
        );

        // on s'assure que les espaces ne sont pas autorisés dans l'extension
        $response->assertSessionHasErrors(['extension']);
    }


    /**
     * Test la modification d'un ReportFileType
     *
     * @return void
     */
    public function test_aReportFileType_can_be_updated_from_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfiletype(
            FileMimeType::txt()->first(),
            "txt",
            "csv",
            Status::active()->first(),
            "csv desc"
        );

        $newreportfiletype = ReportFileType::first();

        $filemimetype_png = FileMimeType::png()->first();
        $status_another = Status::inactive()->first();

        $response = $this->update_existing_reportfiletype(
            $newreportfiletype,
            $filemimetype_png,
            "png",
            "csv",
            $status_another,
            "png desc"
        );

        $newreportfiletype->refresh();

        $this->assertEquals('png',$newreportfiletype->name);
        $this->assertEquals('csv', $newreportfiletype->extension);
        $this->assertEquals($filemimetype_png->id, $newreportfiletype->filemimetype->id);
        $this->assertEquals($status_another->id, $newreportfiletype->status->id);
    }

    /**
     * Test la suppression d'un ReportFile
     *
     * @return void
     */
    public function test_aReportFileType_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfiletype(
            FileMimeType::txt()->first(),
            "txt",
            "csv"
        );

        $newreportfiletype = ReportFileType::first();

        $this->delete('reportfiletypes/' . $newreportfiletype->uuid);

        $this->assertCount(0, ReportFileType::all());
    }



    #region Private Functions

    private function add_new_reportfiletype($filemimetype, $name, $extension, $status = null, $description = null)
    {
        return $this->post('reportfiletypes', $this->new_data($filemimetype, $name, $extension, $status, $description));
    }
    private function update_existing_reportfiletype($reportfiletype, $filemimetype, $name, $extension, $status = null, $description = null)
    {
        return $this->put('reportfiletypes/' . $reportfiletype->uuid, $this->new_data($filemimetype, $name, $extension, $status, $description));
    }

    private function new_data($filemimetype, $name, $extension, $status = null, $description = null) {
        return [
            'filemimetype' => $filemimetype,
            'name' => $name,
            'extension' => $extension,
            'status' => $status,
            'description' => $description,
        ];
    }

    #endregion

}
