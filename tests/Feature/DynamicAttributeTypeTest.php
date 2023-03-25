<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Models\Setting;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\DynamicAttributes\DynamicAttributeType;

class DynamicAttributeTypeTest extends TestCase
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
        DynamicAttributeType::truncate();
        Schema::enableForeignKeyConstraints();
    }


    /**
     * Test la création d'un nouveau dynamicattributetype
     *
     * @return void
     */
    public function test_aDynamicAttributeType_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_dynamicattributetype(
            "new dynamic attribute type",
            "dynamic_attribute_code",
            "dynamic_attribute_model_type"
        );

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, DynamicAttributeType::all());
    }

    /**
     * Test la validation d'un nouveau ReportFile avant création
     *
     * @return void
     */
    public function test_aDynamicAttributeType_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_dynamicattributetype(null, null, null);

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['name','code','model_type']);
    }

    public function test_aDynamicAttributeType_unique_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_dynamicattributetype(
            "new dynamic attribute type",
            "dynamic_attribute_code",
            "dynamic_attribute_model_type"
        );
        $response = $this->add_new_dynamicattributetype(
            "new dynamic attribute type",
            "dynamic_attribute_code",
            "dynamic_attribute_model_type"
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['code']);
    }

    /**
     * Test la modification d'un ReportFile
     *
     * @return void
     */
    public function test_aDynamicAttributeType_can_be_updated_from_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_dynamicattributetype(
            "new dynamic attribute type",
            "dynamic_attribute_code",
            "dynamic_attribute_model_type",
            Status::active()->first(),
            "new dynamic attribute desc"
        );

        $dynamicattributetype = DynamicAttributeType::first();

        $status_inactive = Status::inactive()->first();

        $this->update_existing_dynamicattributetype(
            $dynamicattributetype,
            "new dynamic attribute type upd",
            "dynamic_attribute_code_upd",
            "dynamic_attribute_model_type_upd",
            $status_inactive,
            "new dynamic attribute desc upd"
        );

        $dynamicattributetype->refresh();

        $this->assertEquals("new dynamic attribute type upd", $dynamicattributetype->name);
        $this->assertEquals("dynamic_attribute_code_upd", $dynamicattributetype->code);
        $this->assertEquals("dynamic_attribute_model_type_upd", $dynamicattributetype->model_type);
        $this->assertEquals($status_inactive->id, $dynamicattributetype->status->id);
        $this->assertEquals("new dynamic attribute desc upd", $dynamicattributetype->description);
    }

    /**
     * Test la suppression d'un ReportFile
     *
     * @return void
     */
    public function test_aDynamicAttributeType_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_dynamicattributetype(
            "new dynamic attribute type",
            "dynamic_attribute_code",
            "dynamic_attribute_model_type"
        );

        $dynamicattributetype = DynamicAttributeType::first();

        $this->delete('dynamicattributetypes/' . $dynamicattributetype->uuid);

        $this->assertCount(0, DynamicAttributeType::all());
    }



    #region Private Functions

    private function add_new_dynamicattributetype($name, $code, $model_type, $status = null, $description = null): TestResponse
    {
        return $this->post('dynamicattributetypes', $this->new_data($name, $code, $model_type, $status, $description));
    }

    private function update_existing_dynamicattributetype($existing_dynamicattributetype, $name, $code, $model_type, $status = null, $description = null): TestResponse
    {
        return $this->put('dynamicattributetypes/' . $existing_dynamicattributetype->uuid, $this->new_data($name, $code, $model_type, $status, $description));
    }

    private function new_data($name, $code, $model_type, $status = null, $description = null): array
    {
        return [
            'name' => $name,
            'code' => $code,
            'model_type' => $model_type,
            'description' => $description,

            'status' => $status,
        ];
    }

    #endregion
}
