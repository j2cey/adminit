<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Schema;
use App\Models\OsAndServer\OsArchitecture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OsArchitectureTest extends TestCase
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

        // on tronque la table du modèle AccessAccount dans la base de données
        Schema::disableForeignKeyConstraints();
        OsArchitecture::truncate();
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Test la création d'un nouveau OsArchitecture
     *
     * @return void
     */
    public function test_anOsArchitecture_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osarchitecture("new os arch","new_os_arch","os arch desc");

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, OsArchitecture::all());
    }

    /**
     * Test la validation d'un nouveau OsArchitecture avant création
     *
     * @return void
     */
    public function test_anOsArchitecture_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osarchitecture("","","");

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['name','code']);
    }

    /**
     * Test la validation des champs uniques d'un nouveau OsArchitecture avant création
     *
     * @return void
     */
    public function test_anOsArchitecture_unique_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osarchitecture("new os arch","new_os_arch","os arch desc");
        $response = $this->add_new_osarchitecture("new os arch 2","new_os_arch","os arch desc 2");

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['code']);
    }

    /**
     * Test la validation des champs uniques d'un nouveau OsArchitecture avant mis à jour
     *
     * @return void
     */
    public function test_anOsArchitecture_unique_fields_can_updated_with_same_values()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osarchitecture("new os arch","new_os_arch","os arch desc");
        $newosarchitecture = OsArchitecture::first();
        $response = $this->update_existing_osarchitecture($newosarchitecture, "new os arch upd","new_os_arch","os arch desc upd");

        // on test si l'assertion s'est bien passée
        $response->assertStatus(200);
    }

    /**
     * Test la modification d'un OsArchitecture
     *
     * @return void
     */
    public function test_anOsArchitecture_can_be_updated_from_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osarchitecture("new os arch","new_os_arch","os arch desc");

        $newosarchitecture = OsArchitecture::first();

        $this->update_existing_osarchitecture($newosarchitecture, "new os arch upd","new_os_arch_upd","os arch desc upd");

        $newosarchitecture->refresh();

        $this->assertEquals('new os arch upd',$newosarchitecture->name);
        $this->assertEquals('new_os_arch_upd', $newosarchitecture->code);
        $this->assertEquals('os arch desc upd', $newosarchitecture->description);
    }

    /**
     * Test la suppression d'un AccessAccount
     *
     * @return void
     */
    public function test_anOsArchitecture_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_osarchitecture("new os arch","new_os_arch","os arch desc");

        $newosarchitecture = OsArchitecture::first();

        $this->delete('osarchitectures/' . $newosarchitecture->uuid);

        $this->assertCount(0, OsArchitecture::all());
    }



    #region Private Functions

    private function add_new_osarchitecture($name, $code, $description = null, $status = null)
    {
        return $this->post('osarchitectures', $this->new_data($name,$code,$status,$description));
    }

    private function update_existing_osarchitecture($existing_osarchitecture, $name, $code, $description = null, $status = null)
    {
        return $this->put('osarchitectures/' . $existing_osarchitecture->uuid, $this->new_data($name,$code,$status,$description));
    }

    private function new_data($name,$code,$status = null,$description = null) {
        return [
            'name' => $name,
            'code' => $code,
            'description' => $description,
            'status' => $status
        ];
    }

    #endregion
}
