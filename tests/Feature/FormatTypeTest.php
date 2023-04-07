<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Models\Setting;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use App\Models\FormattedValue\FormatType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FormatTypeTest extends TestCase
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
        FormatType::truncate();
        Schema::enableForeignKeyConstraints();
    }


    /**
     * Test la création d'un nouveau formattype
     *
     * @return void
     */
    public function test_aFormatType_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_formattype(
            "new format type",
            "format_type_code",
            "format_type_class"
        );

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, FormatType::all());
    }

    /**
     * Test la validation d'un nouveau ReportFile avant création
     *
     * @return void
     */
    public function test_aFormatType_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_formattype(null, null, null);

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['name','code', 'formattype_class']);
    }

    public function test_FormatType_unique_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_formattype(
            "new format type",
            "format_type_code",
            "format_type_class"
        );
        $response = $this->add_new_formattype(
            "new format type",
            "format_type_code",
            "format_type_class"
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['code']);
    }

    /**
     * Test la modification d'un ReportFile
     *
     * @return void
     */
    public function test_aFormatType_can_be_updated_from_the_database()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_formattype(
            "new format type",
            "format_type_code",
            "format_type_class",
            Status::active()->first(),
            "new format type desc"
        );

        $formattype = FormatType::first();

        $status_inactive = Status::inactive()->first();

        $this->update_existing_formattype(
            $formattype,
            "new format type upd",
            "format_type_code_upd",
            "format_type_class_upd",
            $status_inactive,
            "new format type desc upd"
        );

        $formattype->refresh();

        $this->assertEquals("new format type upd", $formattype->name);
        $this->assertEquals("format_type_code_upd", $formattype->code);
        $this->assertEquals("format_type_class_upd", $formattype->formattype_class);
        $this->assertEquals($status_inactive->id, $formattype->status->id);
        $this->assertEquals("new format type desc upd", $formattype->description);
    }

    /**
     * Test la suppression d'un ReportFile
     *
     * @return void
     */
    public function test_aFormatType_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_formattype(
            "new format type",
            "format_type_code",
            "format_type_class"
        );

        $formattype = FormatType::first();

        $this->delete('formattypes/' . $formattype->uuid);

        $this->assertCount(0, FormatType::all());
    }



    #region Private Functions

    private function add_new_formattype($name, $code, $formattype_class, $status = null, $description = null): TestResponse
    {
        return $this->post('formattypes', $this->new_data($name, $code, $formattype_class, $status, $description));
    }

    private function update_existing_formattype($existing_formattype, $name, $code, $formattype_class, $status = null, $description = null): TestResponse
    {
        return $this->put('formattypes/' . $existing_formattype->uuid, $this->new_data($name, $code, $formattype_class, $status, $description));
    }

    private function new_data($name, $code, $formattype_class, $status = null, $description = null): array
    {
        return [
            'name' => $name,
            'code' => $code,
            'formattype_class' => $formattype_class,
            'description' => $description,

            'status' => $status,
        ];
    }

    #endregion
}
