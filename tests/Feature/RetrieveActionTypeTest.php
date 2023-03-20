<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Schema;
use App\Models\RetrieveAction\RetrieveActionType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveActionTypeTest extends TestCase
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
        RetrieveActionType::truncate();
        Schema::enableForeignKeyConstraints();
    }


    /**
     * Test la création d'un nouveau retrieveactiontype
     *
     * @return void
     */
    public function test_aRetrieveActionType_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_retrieveactiontype("new retrieve action type","retrive_type_code");

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, RetrieveActionType::all());
    }

    /**
     * Test la validation d'un nouveau ReportFile avant création
     *
     * @return void
     */
    public function test_aRetrieveActionType_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_retrieveactiontype(null, null);

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['name','code']);
    }

    public function test_aRetrieveActionType_unique_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_retrieveactiontype(
            "new retrieve action type",
            "new_retrieve_action_type"
        );
        $response = $this->add_new_retrieveactiontype(
            "another with same code",
            "new_retrieve_action_type"
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['code']);
    }

    /**
     * Test la modification d'un ReportFile
     *
     * @return void
     */
    public function test_aRetrieveActionType_can_be_updated_from_the_database()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_retrieveactiontype(
            "new retrieve action type",
            "retrive_type_code",
            Status::active()->first(),
            "new retrieve action type desc"
        );

        $retrieveactiontype = RetrieveActionType::first();

        $status_inactive = Status::inactive()->first();

        $this->update_existing_retrieveactiontype(
            $retrieveactiontype,
            "new retrieve action type upd",
            "retrive_type_code_upd",
            $status_inactive,
            "new retrieve action type desc upd"
        );

        $retrieveactiontype->refresh();

        $this->assertEquals("new retrieve action type upd", $retrieveactiontype->name);
        $this->assertEquals("retrive_type_code_upd", $retrieveactiontype->code);
        $this->assertEquals($status_inactive->id, $retrieveactiontype->status->id);
        $this->assertEquals("new retrieve action type desc upd", $retrieveactiontype->description);
    }

    /**
     * Test la suppression d'un ReportFile
     *
     * @return void
     */
    public function test_aRetrieveActionType_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_retrieveactiontype("new retrieve action type","retrive_type_code");

        $retrieveactiontype = RetrieveActionType::first();

        $this->delete('retrieveactiontypes/' . $retrieveactiontype->uuid);

        $this->assertCount(0, RetrieveActionType::all());
    }



    #region Private Functions

    private function add_new_retrieveactiontype($name, $code = null, $status = null, $description = null): TestResponse
    {
        return $this->post('retrieveactiontypes', $this->new_data($name, $code, $status, $description));
    }

    private function update_existing_retrieveactiontype($existing_retrieveactiontype, $name, $code = null, $status = null, $description = null): TestResponse
    {
        return $this->put('retrieveactiontypes/' . $existing_retrieveactiontype->uuid, $this->new_data($name, $code, $status, $description));
    }

    private function new_data($name, $code = null, $status = null, $description = null): array
    {
        return [
            'name' => $name,
            'code' => $code,
            'description' => $description,

            'status' => $status,
        ];
    }

    #endregion
}
