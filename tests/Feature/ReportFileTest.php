<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Status;
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
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfile("new report file");

        $newreportfile = ReportFile::first();

        $reportfiletype_txt = ReportFileType::txt()->first();
        $status_inactive = Status::inactive()->first();

        $this->put('reportfiles/' . $newreportfile->uuid, [
            'reportfiletype' => $newreportfile->reportfiletype->toJson(),
            'status' => $newreportfile->status->toJson(),
            'name' => "new report file edited",
            'wildcard' => "new-wilcard",
        ]);

        $newreportfile->refresh();
        $newreportfile->load(['reportfiletype','status']);

        $this->assertEquals('new report file edited',$newreportfile->name);
        $this->assertEquals('new-wilcard', $newreportfile->wildcard);
        $this->assertEquals($status_inactive->code, $newreportfile->status->code);
        $this->assertEquals($reportfiletype_txt->id, $newreportfile->reportfiletype->id);
    }

    /**
     * Test la modification d'un ReportFile
     *
     * @return void
     */
    public function test_a_ReportFile_can_be_delated()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_reportfile("new report file");

        $newreportfile = ReportFile::first();

        $this->delete('reportfiles/' . $newreportfile->uuid);

        $this->assertCount(0, ReportFile::all());
    }

    #region Private Functions

    private function authenticated_user_admin() : ?User {
        // authentification du user
        $user = User::find(1);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'admin123',
        ]);

        $this->assertAuthenticated();

        return $user;
    }

    private function add_new_reportfile($name, $wildcard = "")
    {
        // on essaie d'insérer un nouvel objet ReportFile dans la base de données
        // et on récupère le résultat dans une variable $response
        $reportfiletype = ReportFileType::csv()->first();
        $status = Status::active()->first();

        return $this->post('reportfiles', [
                'reportfiletype' => $reportfiletype->toJson(),
                'status' => $status->toJson(),
                'name' => $name,
                'wildcard' => $wildcard,
            ]
        );
    }

    #endregion
}
