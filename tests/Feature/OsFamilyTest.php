<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Setting;
use App\Models\OsAndServer\OsFamily;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OsFamilyTest extends TestCase
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
        OsFamily::truncate();
        Schema::enableForeignKeyConstraints();
    }


    /**
     * Test la création d'un nouveau OsFamily
     *
     * @return void
     */
    public function test_anOsFamily_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osfamily("new os fam","new_os_fam","os fam desc");

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, OsFamily::all());
    }

    /**
     * Test la validation d'un nouveau OsFamily avant création
     *
     * @return void
     */
    public function test_anOsFamily_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osfamily("","","");

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['name','code']);
    }

    /**
     * Test la validation des champs uniques d'un nouveau OsFamily avant création
     *
     * @return void
     */
    public function test_anOsFamily_unique_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osfamily("new os fam","new_os_fam","os fam desc");
        $response = $this->add_new_osfamily("new os fam 2","new_os_fam","os fam desc 2");

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['code']);
    }

    /**
     * Test la validation des champs uniques d'un nouveau OsFamily avant mis à jour
     *
     * @return void
     */
    public function test_anOsFamily_unique_fields_can_be_updated_with_same_values()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osfamily("new os fam","new_os_fam","os fam desc");
        $newosfamily = OsFamily::first();
        $response = $this->update_existing_osfamily($newosfamily, "new os fam upd","new_os_fam","os fam desc upd");

        // on test si l'assertion s'est bien passée
        $response->assertStatus(200);
    }

    /**
     * Test la modification d'un OsFamily
     *
     * @return void
     */
    public function test_anOsFamily_can_be_updated_from_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osfamily("new os fam","new_os_fam","os fam desc");

        $newosfamily = OsFamily::first();

        $this->update_existing_osfamily($newosfamily, "new os fam upd","new_os_fam_upd","os fam desc upd");

        $newosfamily->refresh();

        $this->assertEquals('new os fam upd',$newosfamily->name);
        $this->assertEquals('new_os_fam_upd', $newosfamily->code);
        $this->assertEquals('os fam desc upd', $newosfamily->description);
    }

    /**
     * Test la suppression d'un AccessAccount
     *
     * @return void
     */
    public function test_anOsFamily_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osfamily("new os fam","new_os_fam","os fam desc");

        $newosfamily = OsFamily::first();

        $this->delete('osfamilies/' . $newosfamily->uuid);

        $this->assertCount(0, OsFamily::all());
    }


    #region Private Functions

    private function add_new_osfamily($name, $code, $description = "", $status = null)
    {
        $new_data = [
            'name' => $name,
            'code' => $code,
            'description' => $description,
            'status' => $status
        ];

        return $this->post('osfamilies', $new_data);
    }

    private function update_existing_osfamily($existing_osfamily, $name, $code, $description = "", $status = null)
    {
        $new_data = [
            'name' => $name,
            'code' => $code,
            'description' => $description,
            'status' => $status
        ];

        return $this->put('osfamilies/' . $existing_osfamily->uuid, $new_data);
    }

    #endregion
}
