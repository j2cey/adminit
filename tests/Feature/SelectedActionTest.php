<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Models\Setting;
use App\Enums\ValueTypeEnum;
use Illuminate\Testing\TestResponse;
use App\Models\ReportFile\ReportFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use App\Models\RetrieveAction\RetrieveAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\RetrieveAction\SelectedRetrieveAction;
use App\Contracts\SelectedRetrieveAction\IHasSelectedRetrieveActions;

class SelectedActionTest extends TestCase
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
        SelectedRetrieveAction::truncate();
        Schema::enableForeignKeyConstraints();
    }

    public function test_aSelectedRetrieveAction_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_selectedretrieveaction(
            $this->create_new_reportfile(),
            ReportFile::class,
            RetrieveAction::retrieveByName()->first()
        );

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, SelectedRetrieveAction::all());
    }

    public function test_aSelectedRetrieveAction_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_selectedretrieveaction(
            $this->create_new_reportfile(),
            ReportFile::class,
            null);

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['retrieveaction']);
    }

    public function test_aSelectedRetrieveAction_can_be_updated_from_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_selectedretrieveaction(
            $this->create_new_reportfile(),
            ReportFile::class,
            RetrieveAction::retrieveByName()->first(),
            "new_selected_retrieve_action",
            ValueTypeEnum::BOOLEAN->value,
            null,
            Status::inactive()->first(),
            "new selected retrieve action desc"
        );

        $selectedretrieveaction = SelectedRetrieveAction::first();

        $retrieveaction_another = RetrieveAction::renameFile()->first();
        $status_inactive = Status::active()->first();

        $this->update_existing_selectedretrieveaction(
            $selectedretrieveaction,
            $retrieveaction_another,
            "new_selected_retrieve_action_upd",
            ValueTypeEnum::INT->value,
            null,
            $status_inactive,
            "new selected retrieve action desc upd"
        );

        $selectedretrieveaction->refresh();

        $this->assertEquals($status_inactive->id, $selectedretrieveaction->status->id);
        $this->assertEquals($retrieveaction_another->id, $selectedretrieveaction->retrieveaction->id);
        $this->assertEquals("new selected retrieve action desc upd", $selectedretrieveaction->description);
    }

    public function test_aSelectedRetrieveAction_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_selectedretrieveaction(
            $this->create_new_reportfile(),
            ReportFile::class,
            RetrieveAction::retrieveByName()->first()
        );

        $selectedretrieveaction = SelectedRetrieveAction::first();

        $this->delete('selectedretrieveactions/' . $selectedretrieveaction->uuid);

        $this->assertCount(0, SelectedRetrieveAction::all());
    }



    #region Private Functions

    private function add_new_selectedretrieveaction(IHasSelectedRetrieveActions $model, $model_type, $retrieveaction, $label = null, $valuetype = null, $actionvalue = null, $status = null, $description = null): TestResponse
    {
        return $this->post('selectedretrieveactions',
            array_merge([
                'model_id' => $model->id,
                'model_type' => $model_type
            ],$this->new_data($retrieveaction, $label, $valuetype, $actionvalue, $status, $description)));
    }

    private function update_existing_selectedretrieveaction($existing_selectedretrieveaction, $retrieveaction, $label = null, $valuetype = null, $actionvalue = null, $status = null, $description = null): TestResponse
    {
        return $this->put('selectedretrieveactions/' . $existing_selectedretrieveaction->uuid, $this->new_data($retrieveaction, $label, $valuetype, $actionvalue, $status, $description));
    }

    private function new_data($retrieveaction, $label = null, $valuetype = null, $actionvalue = null, $status = null, $description = null): array
    {
        return [
            'retrieveaction' => $retrieveaction,
            'label'=> $label,
            'valuetype' => $valuetype,
            'actionvalue' => $actionvalue,
            'status' => $status,
            'description' => $description,
        ];
    }

    #endregion
}
