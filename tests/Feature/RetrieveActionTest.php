<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Schema;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\RetrieveAction\RetrieveActionType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveActionTest extends TestCase
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
        RetrieveAction::truncate();
        Schema::enableForeignKeyConstraints();
    }


    /**
     * Test la création d'un nouveau retrieveaction
     *
     * @return void
     */
    public function test_an_RetrieveAction_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_retrieveaction(
            RetrieveActionType::retrieveMode()->first(),
            "new retrieve action",
            "new_action_class",
            "retrive_action_code"
        );

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, RetrieveAction::all());
    }

    /**
     * Test la validation d'un nouveau ReportFile avant création
     *
     * @return void
     */
    public function test_a_RetrieveAction_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_retrieveaction(null, null, null, null);

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['retrieveactiontype','name', 'action_class','code']);
    }

    public function test_a_RetrieveAction_unique_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_retrieveaction(
            RetrieveActionType::retrieveMode()->first(),
            "new retrieve action",
            "new_action_class",
            "retrive_action_code"
        );
        $response = $this->add_new_retrieveaction(
            RetrieveActionType::retrieveMode()->first(),
            "another retrieve action",
            "new_action_class",
            "retrive_action_code"
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['code']);
    }

    /**
     * Test la modification d'un ReportFile
     *
     * @return void
     */
    public function test_a_RetrieveAction_can_be_updated_from_the_database()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_retrieveaction(
            RetrieveActionType::retrieveMode()->first(),
            "new retrieve action",
            "new_action_class",
            "retrive_action_code",
            Status::active()->first(),
            "new retrieve action desc"
        );

        $retrieveaction = RetrieveAction::first();

        $retrieveactiontype_another = RetrieveActionType::toPerformBeforeRetrieving()->first();
        $status_inactive = Status::inactive()->first();

        $this->update_existing_retrieveaction(
            $retrieveaction,
            $retrieveactiontype_another,
            "new retrieve action upd",
            "new_action_class_upd",
            "retrive_action_code_upd",
            $status_inactive,
            "new retrieve action desc upd"
        );

        $retrieveaction->refresh();

        $this->assertEquals("new retrieve action upd", $retrieveaction->name);
        $this->assertEquals("new_action_class_upd", $retrieveaction->action_class);
        $this->assertEquals("retrive_action_code_upd", $retrieveaction->code);
        $this->assertEquals($status_inactive->id, $retrieveaction->status->id);
        $this->assertEquals($retrieveactiontype_another->id, $retrieveaction->retrieveactiontype->id);
        $this->assertEquals("new retrieve action desc upd", $retrieveaction->description);
    }

    /**
     * Test la suppression d'un ReportFile
     *
     * @return void
     */
    public function test_a_RetrieveAction_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_retrieveaction(
            RetrieveActionType::retrieveMode()->first(),
            "new retrieve action",
            "new_action_class",
            "retrive_action_code",
            Status::active()->first(),
            "new retrieve action desc"
        );

        $retrieveaction = RetrieveAction::first();

        $this->delete('retrieveactions/' . $retrieveaction->uuid);

        $this->assertCount(0, RetrieveAction::all());
    }



    #region Private Functions

    private function add_new_retrieveaction($retrieveactiontype, $name, $action_class, $code = null, $status = null, $description = null): TestResponse
    {
        return $this->post('retrieveactions', $this->new_data($retrieveactiontype, $name, $action_class, $code, $status, $description));
    }

    private function update_existing_retrieveaction($existing_retrieveaction, $retrieveactiontype, $name, $action_class, $code = null, $status = null, $description = null): TestResponse
    {
        return $this->put('retrieveactions/' . $existing_retrieveaction->uuid, $this->new_data($retrieveactiontype, $name, $action_class, $code, $status, $description));
    }

    private function new_data($retrieveactiontype, $name, $action_class, $code = null, $status = null, $description = null): array
    {
        return [
            'name' => $name,
            'action_class' => $action_class,
            'code' => $code,
            'description' => $description,

            'retrieveactiontype' => $retrieveactiontype,
            'status' => $status,
        ];
    }

    #endregion
}
