<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\RetrieveAction\SelectedRetrieveAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SelectedRetrieveActionTest extends TestCase
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
        SelectedRetrieveAction::truncate();
        Schema::enableForeignKeyConstraints();
    }


    /**
     * Test la création d'un nouveau selectedretrieveaction
     *
     * @return void
     */
    public function test_an_SelectedRetrieveAction_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_selectedretrieveaction(
            RetrieveAction::retrieveByName()->first(),
            null,
            null,
            null
        );

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, SelectedRetrieveAction::all());
    }

    /**
     * Test la validation d'un nouveau ReportFile avant création
     *
     * @return void
     */
    public function test_a_SelectedRetrieveAction_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_selectedretrieveaction(
            null,
            null,
            null,
            null
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['retrieveaction']);
    }

    public function test_a_SelectedRetrieveAction_unique_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_selectedretrieveaction(
            RetrieveAction::retrieveByName()->first(),
            "new_selected_retrieve_action_code",
            null,
            null
        );
        $response = $this->add_new_selectedretrieveaction(
            RetrieveAction::retrieveByName()->first(),
            "new_selected_retrieve_action_code",
            null,
            null
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['code']);
    }

    /**
     * Test la modification d'un ReportFile
     *
     * @return void
     */
    public function test_a_SelectedRetrieveAction_can_be_updated_from_the_database()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_selectedretrieveaction(
            RetrieveAction::retrieveByName()->first(),
            "new_selected_retrieve_action_code",
            Status::active()->first(),
            "new selected retrieve action desc"
        );

        $selectedretrieveaction = SelectedRetrieveAction::first();

        $retrieveaction_another = RetrieveAction::renameFile()->first();
        $status_inactive = Status::inactive()->first();

        $this->update_existing_selectedretrieveaction(
            $selectedretrieveaction,
            $retrieveaction_another,
            "new_selected_retrieve_action_code_upd",
            $status_inactive,
            "new selected retrieve action desc upd"
        );

        $selectedretrieveaction->refresh();

        $this->assertEquals($status_inactive->id, $selectedretrieveaction->status->id);
        $this->assertEquals($retrieveaction_another->id, $selectedretrieveaction->retrieveaction->id);
        $this->assertEquals("new_selected_retrieve_action_code_upd", $selectedretrieveaction->code);
        $this->assertEquals("new selected retrieve action desc upd", $selectedretrieveaction->description);
    }

    /**
     * Test la suppression d'un ReportFile
     *
     * @return void
     */
    public function test_a_SelectedRetrieveAction_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_selectedretrieveaction(
            RetrieveAction::retrieveByName()->first(),
            null,
            null,
            null
        );

        $selectedretrieveaction = SelectedRetrieveAction::first();

        $this->delete('selectedretrieveactions/' . $selectedretrieveaction->uuid);

        $this->assertCount(0, SelectedRetrieveAction::all());
    }


    #region Private Functions

    private function add_new_selectedretrieveaction($retrieveaction, $code = null, $status = null, $description = null): TestResponse
    {
        return $this->post('selectedretrieveactions', $this->new_data($retrieveaction, $code, $status, $description));
    }

    private function update_existing_selectedretrieveaction($existing_selectedretrieveaction, $retrieveaction, $code = null, $status = null, $description = null): TestResponse
    {
        return $this->put('selectedretrieveactions/' . $existing_selectedretrieveaction->uuid, $this->new_data($retrieveaction, $code, $status, $description));
    }

    private function new_data($retrieveaction, $code = null, $status = null, $description = null): array
    {
        return [
            'code' => $code,
            'description' => $description,

            'retrieveaction' => $retrieveaction,
            'status' => $status,
        ];
    }

    #endregion
}
