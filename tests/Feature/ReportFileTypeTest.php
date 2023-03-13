<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\ReportFile\FileMimeType;
use App\Models\ReportFile\ReportFileType;
use Illuminate\Foundation\Testing\WithFaker;
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
    public function test_a_ReportFileType_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        //$reportfiletype_count_before_test = ReportFileType::all()->count();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfiletype("txt","sv");

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
    public function test_a_ReportFileType_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfiletype("","");

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['name']);        // le champs 'name' doit être requis
        $response->assertSessionHasErrors(['extension']);   // le champs 'extension' doit être requis

        // on s'assure que les espaces ne sont pas autorisés dans l'extension
        $response = $this->add_new_reportfiletype("new-type","aad gege");
        $response->assertSessionHasErrors(['extension']);
    }


    /**
     * Test la modification d'un ReportFileType
     *
     * @return void
     */
    public function test_a_ReportFileType_can_be_updated_from_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfiletype("new report file type","new_extension");

        $newreportfiletype = ReportFileType::first();

        $filemimetype_png = FileMimeType::png()->first();


        $this->put('reportfiletypes/' . $newreportfiletype->uuid, [
            'filemimetype' => $filemimetype_png->toJson(),
            'name' => "new report file type edited",
            'extension' => "new-extension",
        ]);
        $newreportfiletype->refresh();

        $this->assertEquals('new report file type edited',$newreportfiletype->name);
        $this->assertEquals('new-extension', $newreportfiletype->extension);
        $this->assertEquals($filemimetype_png->id, $newreportfiletype->filemimetype->id);
    }

    /**
     * Test la suppression d'un ReportFile
     *
     * @return void
     */
    public function test_a_ReportFileType_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        //$reportfiletype_count_before_test = ReportFileType::all()->count();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfiletype("new report file type","new_extension");

        $newreportfiletype = ReportFileType::first();

        $this->delete('reportfiletypes/' . $newreportfiletype->uuid);

        $this->assertCount(0, ReportFileType::all());
    }



    #region Private Functions

    private function add_new_reportfiletype($name, $extension)
    {
        // on essaie d'insérer un nouvel objet ReportFileType dans la base de données
        // et on récupère le résultat dans une variable $response
        $filemimetype = FileMimeType::png()->first();

        return $this->post('reportfiletypes', [
                'filemimetype' => $filemimetype->toJson(),
                'name' => $name,
                'extension' => $extension,
            ]
        );
    }

    #endregion

}
