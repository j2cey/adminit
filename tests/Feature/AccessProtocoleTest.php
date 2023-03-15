<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\AccessProtocole;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccessProtocoleTest extends TestCase
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

        // on tronque la table du modèle AccessProtocole dans la base de données
        Schema::disableForeignKeyConstraints();
        AccessProtocole::truncate();
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Test la création d'un nouveau AccessProtocole
     *
     * @return void
     */
    public function test_a_AccessProtocole_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        //$accessprotocole_count_before_test = ReportFileType::all()->count();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessprotocole("Anri","yfuyd-ydy");

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, AccessProtocole::all());
    }

    /**
     * Test la validation d'un nouveau AccessProtocole avant création
     *
     * @return void
     */
    public function test_an_accessprotocole_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessprotocole("","");

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['name']);
    }

    /**
     * Test la modification d'un AccessProtocole
     *
     * @return void
     */
    public function test_an_accessprotocole_can_be_updated_from_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessprotocole("vcibvfuezb","ftpadmin");

        $newaccessprotocole = AccessProtocole::first();

        $this->update_existing_accessprotocole($newaccessprotocole, "new name edited", "new-description");

        $newaccessprotocole->refresh();

        $this->assertEquals('new name edited',$newaccessprotocole->name);
        $this->assertEquals('new-description', $newaccessprotocole->description);
    }

    /**
     * Test la suppression d'un AccessProtocole
     *
     * @return void
     */
    public function test_a_accessprotocole_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_accessprotocole("new access protocole","new-description");

        $newaccessprotocole = AccessProtocole::first();

        $this->delete('accessprotocoles/' . $newaccessprotocole->uuid);

        $this->assertCount(0, AccessProtocole::all());
    }

    #region Private Functions

    private function add_new_accessprotocole($name, $description = "")
    {
        // on essaie d'insérer un nouvel objet AccessProtocole dans la base de données
        // et on récupère le résultat dans une variable $response

        return $this->post('accessprotocoles', [
                'name' => $name,
                'description' => $description,
            ]
        );
    }

    private function update_existing_accessprotocole($existingaccessprotocole, $name, $description = "")
    {
        return $this->put('accessprotocoles/' . $existingaccessprotocole->uuid, [
            'name' => $name,
            'description' => $description,
        ]);
    }
    #endregion
}
