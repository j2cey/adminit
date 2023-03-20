<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Enums\ValueTypeEnum;
use Illuminate\Support\Carbon;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Schema;
use App\Models\RetrieveAction\RetrieveAction;
use App\Models\RetrieveAction\RetrieveActionValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\RetrieveAction\SelectedRetrieveAction;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RetrieveActionValueTest extends TestCase
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
        RetrieveActionValue::truncate();
        Schema::enableForeignKeyConstraints();
    }


    /**
     * Test la création d'un nouveau retrieveactionvalue
     *
     * @return void
     */
    public function test_aRetrieveActionValue_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();
        $response = $this->add_new_retrieveactionvalue(
            SelectedRetrieveAction::createNew(
                RetrieveAction::retrieveByName()->first()
            ),
            "new retrieve action value",
            ValueTypeEnum::STRING->value,
            "new value string",
            1,
            Carbon::now(),
        );

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, RetrieveActionValue::all());
    }

    /**
     * Test la validation d'un nouveau ReportFile avant création
     *
     * @return void
     */
    public function test_aRetrieveActionValue_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_retrieveactionvalue(
            null,
            null,
            null,
            "new value string",
            1,
            Carbon::now(),
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['selectedretrieveaction','type', 'label']);
    }

    public function test_aRetrieveActionValue_unique_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $selectedretrieveaction = SelectedRetrieveAction::createNew(
            RetrieveAction::retrieveByName()->first()
        );
        $response = $this->add_new_retrieveactionvalue(
            $selectedretrieveaction,
            "new retrieve action value",
            ValueTypeEnum::STRING->value,
            "new value string",
            1,
            Carbon::now(),
        );

        $response = $this->add_new_retrieveactionvalue(
            $selectedretrieveaction,
            "new retrieve action value",
            ValueTypeEnum::STRING->value,
            "new value string",
            1,
            Carbon::now(),
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['label']);
    }

    /**
     * Test la modification d'un ReportFile
     *
     * @return void
     */
    public function test_aRetrieveActionValue_can_be_updated_from_the_database()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $selectedretrieveaction = SelectedRetrieveAction::createNew(
            RetrieveAction::retrieveByName()->first()
        );
        $response = $this->add_new_retrieveactionvalue(
            $selectedretrieveaction,
            "new retrieve action value label",
            ValueTypeEnum::STRING->value,
            "new value string",
            1,
            Carbon::now(),
            Status::active()->first(),
            "new retrieve action value desc"
        );

        $retrieveactionvalue = RetrieveActionValue::first();

        $selectedretrieveaction_another = SelectedRetrieveAction::createNew(
            RetrieveAction::renameFile()->first()
        );
        $status_inactive = Status::inactive()->first();
        $datetime_another = Carbon::now()->addDays(5);

        $this->update_existing_retrieveactionvalue(
            $retrieveactionvalue,
            $selectedretrieveaction_another,
            "new retrieve action value label upd",
            ValueTypeEnum::INT->value,
            "new value string upd",
            2,
            $datetime_another,
            $status_inactive,
            "new retrieve action value desc upd"
        );

        $retrieveactionvalue->refresh();

        $this->assertEquals($selectedretrieveaction_another->id, $retrieveactionvalue->selectedretrieveaction->id);
        $this->assertEquals("new retrieve action value label upd", $retrieveactionvalue->label);
        $this->assertEquals(ValueTypeEnum::INT, $retrieveactionvalue->type);
        $this->assertEquals("new value string upd", $retrieveactionvalue->value_string);
        $this->assertEquals(2, $retrieveactionvalue->value_int);
        $this->assertEquals($datetime_another, $retrieveactionvalue->value_datetime);
        $this->assertEquals($status_inactive->id, $retrieveactionvalue->status->id);
        $this->assertEquals("new retrieve action value desc upd", $retrieveactionvalue->description);
    }

    /**
     * Test la suppression d'un ReportFile
     *
     * @return void
     */
    public function test_aRetrieveActionValue_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_retrieveactionvalue(
            SelectedRetrieveAction::createNew(
                RetrieveAction::retrieveByName()->first()
            ),
            "new retrieve action value",
            ValueTypeEnum::STRING->value,
            "new value string",
            1,
            Carbon::now(),
        );

        $this->delete('retrieveactionvalues/' . RetrieveActionValue::first()->uuid);

        $this->assertCount(0, RetrieveActionValue::all());
    }



    #region Private Functions

    private function add_new_retrieveactionvalue($selectedretrieveaction, $label, $type, $value_string = null, $value_int = null, $value_datetime = null, $status = null, $description = null): TestResponse
    {
        return $this->post('retrieveactionvalues', $this->new_data($selectedretrieveaction, $label, $type, $value_string, $value_int, $value_datetime, $status, $description));
    }

    private function update_existing_retrieveactionvalue($existing_retrieveactionvalue, $selectedretrieveaction, $label, $type, $value_string = null, $value_int = null, $value_datetime = null, $status = null, $description = null): TestResponse
    {
        return $this->put('retrieveactionvalues/' . $existing_retrieveactionvalue->uuid, $this->new_data($selectedretrieveaction, $label, $type, $value_string, $value_int, $value_datetime, $status, $description));
    }

    private function new_data($selectedretrieveaction, $label, $type, $value_string = null, $value_int = null, $value_datetime = null, $status = null, $description = null): array
    {
        return [
            'label' => $label,
            'type' => $type,
            'value_string' => $value_string,
            'value_int' => $value_int,
            'value_datetime' => $value_datetime,

            'description' => $description,

            'selectedretrieveaction' => $selectedretrieveaction,
            'status' => $status,
        ];
    }

    #endregion
}
