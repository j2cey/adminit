<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Models\Setting;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use App\Models\FormattedValue\FormatType;
use App\Models\FormattedValue\FormattedValue;
use App\Models\ReportFile\CollectedReportFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Contracts\FormattedValue\IHasFormattedValues;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FormattedValueTest extends TestCase
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
        FormattedValue::truncate();
        Schema::enableForeignKeyConstraints();
    }


    /**
     * Test la création d'un nouveau FormattedValue
     *
     * @return void
     */
    public function test_aFormattedValue_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_formattedvalue(
            $this->create_new_collected_reportfile(),
            CollectedReportFile::class,
            FormatType::html()->first(),
            "New Formatted Value",
            Status::default()->first(),
            "New Formatted Value desc"
        );

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, FormattedValue::all());
    }

    /**
     * Test la validation d'un nouveau ReportFile avant création
     *
     * @return void
     */
    public function test_FormattedValue_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_formattedvalue(
            $this->create_new_collected_reportfile(),
            CollectedReportFile::class,
            null,
            null,
            null
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['formattype']);
    }

    /**
     * Test la modification d'un ReportFile
     *
     * @return void
     */
    public function test_aFormattedValue_can_be_updated_from_the_database()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_formattedvalue(
            $this->create_new_collected_reportfile(),
            CollectedReportFile::class,
            FormatType::html()->first(),
            "New Formatted Value",
            Status::default()->first(),
            "New Formatted Value desc"
        );

        $formattedvalue = FormattedValue::first();

        $formattype_another = FormatType::sms()->first();
        $status_inactive = Status::inactive()->first();

        $response = $this->update_existing_formattedvalue(
            $formattedvalue,
            $formattype_another,
            "New Formatted Value upd",
            $status_inactive,
            "New Formatted Value desc upd"
        );

        $formattedvalue->refresh();

        $this->assertEquals("New Formatted Value upd", $formattedvalue->title);
        $this->assertEquals($formattype_another->id, $formattedvalue->formattype->id);
        $this->assertEquals($status_inactive->id, $formattedvalue->status->id);
        $this->assertEquals("New Formatted Value desc upd", $formattedvalue->description);
    }

    /**
     * Test la suppression d'un ReportFile
     *
     * @return void
     */
    public function test_aFormattedValue_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_formattedvalue(
            $this->create_new_collected_reportfile(),
            CollectedReportFile::class,
            FormatType::html()->first(),
            "New Formatted Value",
            Status::default()->first(),
            "New Formatted Value desc"
        );

        $formattedvalue = FormattedValue::first();

        $this->delete('formattedvalues/' . $formattedvalue->uuid);

        $this->assertCount(0, FormattedValue::all());
    }



    #region Private Functions

    private function add_new_formattedvalue(IHasFormattedValues $model, $model_type, $formattype, $title, $status = null, $description = null): TestResponse
    {
        return $this->post('formattedvalues/',
            array_merge([
                'model_id' => $model->id,
                'model_type' => $model_type
            ], $this->new_data($formattype, $title, $status, $description)));
    }

    private function update_existing_formattedvalue($existing_formattedvalue, $formattype, $title, $status = null, $description = null): TestResponse
    {
        return $this->put('formattedvalues/' . $existing_formattedvalue->uuid, $this->new_data($formattype, $title, $status, $description));
    }

    private function new_data($formattype, $title, $status = null, $description = null): array
    {
        return [
            'title' => $title,
            'description' => $description,

            'formattype' => $formattype,
            'status' => $status,
        ];
    }

    #endregion
}
