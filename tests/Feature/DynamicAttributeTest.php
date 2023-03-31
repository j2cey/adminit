<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Models\Setting;
use App\Models\Reports\Report;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Tests\Feature\Traits\HasFormatRulesTest;
use App\Contracts\FormatRule\IHasFormatRules;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\DynamicAttributes\DynamicAttribute;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\DynamicAttributes\DynamicAttributeType;
use App\Contracts\DynamicAttribute\IHasDynamicAttributes;

class DynamicAttributeTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
    use HasFormatRulesTest;

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
        DynamicAttribute::truncate();
        Schema::enableForeignKeyConstraints();
    }


    /**
     * Test la création d'un nouveau DynamicAttribute
     *
     * @return void
     */
    public function test_aDynamicAttribute_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_dynamicattribute(
            $this->create_new_report(),
            Report::class,
            DynamicAttributeType::string()->first(),
            "New Dynamic Attribute",
            null,
            "New Dynamic Attribute desc"
        );

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, DynamicAttribute::all());
    }

    /**
     * Test la validation d'un nouveau ReportFile avant création
     *
     * @return void
     */
    public function test_aDynamicAttribute_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_dynamicattribute(
            $this->create_new_report(),
            Report::class,
            null,
            null,
            null,
            null
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['dynamicattributetype','name']);
    }

    /**
     * Test la modification d'un ReportFile
     *
     * @return void
     */
    public function test_aDynamicAttribute_can_be_updated_from_the_database()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_dynamicattribute(
            $this->create_new_report(),
            Report::class,
            DynamicAttributeType::string()->first(),
            "New Dynamic Attribute",
            Status::active()->first(),
            "New Dynamic Attribute desc"
        );

        $dynamicattribute = DynamicAttribute::first();

        $dynamicattributetype_another = DynamicAttributeType::int()->first();
        $status_inactive = Status::inactive()->first();

        $response = $this->update_existing_dynamicattribute(
            $dynamicattribute,
            $dynamicattributetype_another,
            "New Dynamic Attribute upd",
            $status_inactive,
            "New Dynamic Attribute desc upd"
        );

        $dynamicattribute->refresh();

        $this->assertEquals("New Dynamic Attribute upd", $dynamicattribute->name);
        $this->assertEquals($dynamicattributetype_another->id, $dynamicattribute->dynamicattributetype->id);
        $this->assertEquals($status_inactive->id, $dynamicattribute->status->id);
        $this->assertEquals($dynamicattributetype_another->id, $dynamicattribute->dynamicattributetype->id);
        $this->assertEquals("New Dynamic Attribute desc upd", $dynamicattribute->description);
    }

    /**
     * Test la suppression d'un ReportFile
     *
     * @return void
     */
    public function test_aDynamicAttribute_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_dynamicattribute(
            $this->create_new_report(),
            Report::class,
            DynamicAttributeType::string()->first(),
            "New Dynamic Attribute",
            Status::active()->first(),
            "New Dynamic Attribute desc"
        );

        $dynamicattribute = DynamicAttribute::first();

        $this->delete('dynamicattributes/' . $dynamicattribute->uuid);

        $this->assertCount(0, DynamicAttribute::all());
    }



    #region Private Functions

    private function add_new_dynamicattribute(IHasDynamicAttributes $model, $model_type, $dynamicattributetype, $name, $status = null, $description = null): TestResponse
    {
        return $this->post('dynamicattributes/',
            array_merge([
                'model_id' => $model->id,
                'model_type' => $model_type
            ], $this->new_data($dynamicattributetype, $name, $status, $description)));
    }

    private function update_existing_dynamicattribute($existing_dynamicattribute, $dynamicattributetype, $name, $status = null, $description = null): TestResponse
    {
        return $this->put('dynamicattributes/' . $existing_dynamicattribute->uuid, $this->new_data($dynamicattributetype, $name, $status, $description));
    }

    private function new_data($dynamicattributetype, $name, $status = null, $description = null): array
    {
        return [
            'name' => $name,
            'description' => $description,

            'dynamicattributetype' => $dynamicattributetype,
            'status' => $status,
        ];
    }

    #endregion
    public function getModel(): IHasFormatRules
    {
        return $this->create_new_dynamicattribute();
    }
}
