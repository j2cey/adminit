<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Models\Setting;
use App\Enums\ValueTypeEnum;
use App\Models\Reports\Report;
use App\Models\Reports\ReportType;
use Illuminate\Testing\TestResponse;
use App\Models\ReportFile\ReportFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use App\Models\ReportFile\ReportFileType;
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

        Config::set('Settings', Setting::getAllGrouped());

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
    public function test_aSelectedRetrieveAction_can_be_stored_to_the_database()
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
    public function test_aSelectedRetrieveAction_required_fields_must_be_validated_before_creation()
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

    public function test_aSelectedRetrieveAction_unique_fields_must_be_validated_before_creation()
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
    public function test_aSelectedRetrieveAction_can_be_updated_from_the_database()
    {
        //$this->withoutExceptionHandling();

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
    public function test_aSelectedRetrieveAction_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

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

    public function test_aSelectedRetrieveAction_can_be_added_to_model()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $report_file = $this->create_new_reportfile("new reportfile");
        $report_file->removeAllSelectedActions(true);

        $response = $this->put('selectedretrieveactions.addtomodel/',
            [
                'model_type' => ReportFile::class,
                'model' => $report_file,
                'retrieveaction' => RetrieveAction::retrieveByName()->first(),
                'label' => null,
                'valuetype' => null,
                'actionvalue' => null,
                'description' => null,
            ]
        );

        $report_file->refresh();

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, $report_file->selectedretrieveactions);
    }

    public function test_aSelectedRetrieveAction_can_be_added_to_model_with_RetrieveActionValue()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $report_file = $this->create_new_reportfile("new reportfile");
        $report_file->removeAllSelectedActions(true);

        $response = $this->put('selectedretrieveactions.addtomodel/',
            [
                'model_type' => ReportFile::class,
                'model' => $report_file,
                'retrieveaction' => RetrieveAction::renameFile()->first(),
                'label' => "new file name",
                'valuetype' => ValueTypeEnum::STRING->value,
                'actionvalue' => "file_downloaded",
                'description' => null,
            ]
        );

        $report_file->refresh();

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        $this->assertCount(1, $report_file->selectedretrieveactions);
        $this->assertCount(1, $report_file->selectedretrieveactions[0]->retrieveactionvalues);
    }

    public function test_aSelectedRetrieveAction_can_be_removed_from_model()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $report_file = $this->create_new_reportfile("new reportfile");
        $report_file->removeAllSelectedActions(true);

        $selectedretrieveaction = $report_file->addSelectedAction(RetrieveAction::retrieveByName()->first());

        $response = $this->put('selectedretrieveactions.removefrommodel/',
            [
                'model_type' => ReportFile::class,
                'model' => $report_file,
                'selectedretrieveaction' => $selectedretrieveaction,
            ]
        );

        $report_file->refresh();

        // on test si l'assertion s'est bien passée
        $response->assertStatus(200);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(0, $report_file->selectedretrieveactions);
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
