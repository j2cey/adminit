<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Models\Setting;
use App\Models\OsAndServer\OsServer;
use App\Models\OsAndServer\OsFamily;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use App\Models\OsAndServer\OsArchitecture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OsServerTest extends TestCase
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

        // on tronque la table du modèle AccessAccount dans la base de données
        Schema::disableForeignKeyConstraints();
        OsServer::truncate();
        Schema::enableForeignKeyConstraints();
    }


    /**
     * Test la création d'un nouveau OsFamily
     *
     * @return void
     */
    public function test_anOsServer_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osserver("new os","new os desc", Status::default()->first(), OsArchitecture::first(), OsFamily::first());

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, OsServer::all());
    }

    /**
     * Test la validation d'un nouveau OsFamily avant création
     *
     * @return void
     */
    public function test_anOsServer_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osserver("","new os desc", Status::default()->first(), null, null);

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['name','osarchitecture','osfamily']);
    }

    /**
     * Test la modification d'un OsFamily
     *
     * @return void
     */
    public function test_anOsServer_can_be_updated_from_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osserver("new os","new os desc", Status::active()->first(), OsArchitecture::first(), OsFamily::first());

        $newosserver = OsServer::first();

        $osarchitecture = OsArchitecture::orderBy('id', 'DESC')->first();
        $osfamily = OsFamily::orderBy('id', 'DESC')->first();
        $status = Status::inactive()->first();

        $this->update_existing_osserver($newosserver, "new os upd","new os desc upd", $status, $osarchitecture, $osfamily);

        $newosserver->refresh();

        $this->assertEquals('new os upd',$newosserver->name);
        $this->assertEquals('new os desc upd', $newosserver->description);
        $this->assertEquals($status->id, $newosserver->status->id);
        $this->assertEquals($osarchitecture->id, $newosserver->osarchitecture->id);
        $this->assertEquals($osfamily->id, $newosserver->osfamily->id);
    }

    /**
     * Test la suppression d'un AccessAccount
     *
     * @return void
     */
    public function test_anOsServer_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osserver("new os","new os desc", Status::default()->first(), OsArchitecture::first(), OsFamily::first());

        $newosserver = OsServer::first();

        $this->delete('osservers/' . $newosserver->uuid);

        $this->assertCount(0, OsServer::all());
    }


    #region Private Functions

    private function add_new_osserver($name, $description = "", $status = null, $osarchitecture = null, $osfamily = null): TestResponse
    {
        return $this->post('osservers', $this->new_data($name, $description, $status, $osarchitecture, $osfamily));
    }

    private function update_existing_osserver($existing_osfamily, $name, $description = "", $status = null, $osarchitecture = null, $osfamily = null): TestResponse
    {
        return $this->put('osservers/' . $existing_osfamily->uuid, $this->new_data($name, $description, $status, $osarchitecture, $osfamily));
    }

    private function new_data($name, $description = "", $status = null, $osarchitecture = null, $osfamily = null) {
        return [
            'name' => $name,
            'description' => $description,
            'status' => $status,
            'osarchitecture' => $osarchitecture,
            'osfamily' => $osfamily
        ];
    }

    #endregion
}
