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
            "New Dynamic Attribute Name",
            "New Dynamic Attribute Title",
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
    public function test_DynamicAttribute_required_fields_must_be_validated_before_creation()
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

    public function test_DynamicAttribute_unique_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_dynamicattribute(
            $this->create_new_report(),
            Report::class,
            DynamicAttributeType::string()->first(),
            "New Dynamic Attribute",
            "New Dynamic Attribute Title",
            null,
            "New Dynamic Attribute desc"
        );
        $response = $this->add_new_dynamicattribute(
            $this->create_new_report(),
            Report::class,
            DynamicAttributeType::string()->first(),
            "New Dynamic Attribute",
            "New Dynamic Attribute Title",
            null,
            "New Dynamic Attribute desc"
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['name']);
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
            "New Dynamic Attribute Name",
            "New Dynamic Attribute Title",
            Status::active()->first(),
            "New Dynamic Attribute desc",
            0,
            1,
            true,
            true,
            true
        );

        $dynamicattribute = DynamicAttribute::first();

        $dynamicattributetype_another = DynamicAttributeType::int()->first();
        $status_inactive = Status::inactive()->first();

        $response = $this->update_existing_dynamicattribute(
            $dynamicattribute,
            $dynamicattributetype_another,
            "New Dynamic Attribute Name upd",
            "New Dynamic Attribute Title upd",
            $status_inactive,
            "New Dynamic Attribute desc upd",
            2,
            3,
            false,
            false,
            false
        );

        $dynamicattribute->refresh();

        $this->assertEquals("New Dynamic Attribute Name upd", $dynamicattribute->name);
        $this->assertEquals("New Dynamic Attribute Title upd", $dynamicattribute->title);
        $this->assertEquals($dynamicattributetype_another->id, $dynamicattribute->dynamicattributetype->id);
        $this->assertEquals($status_inactive->id, $dynamicattribute->status->id);
        $this->assertEquals($dynamicattributetype_another->id, $dynamicattribute->dynamicattributetype->id);
        $this->assertEquals("New Dynamic Attribute desc upd", $dynamicattribute->description);
        $this->assertEquals(2, $dynamicattribute->offset);
        $this->assertEquals(3, $dynamicattribute->max_length);
        $this->assertEquals(false, $dynamicattribute->searchable);
        $this->assertEquals(false, $dynamicattribute->sortable);
        $this->assertEquals(false, $dynamicattribute->can_be_notified);
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
            "New Dynamic Attribute Name",
            "New Dynamic Attribute Title",
            Status::active()->first(),
            "New Dynamic Attribute desc"
        );

        $dynamicattribute = DynamicAttribute::first();

        $this->delete('dynamicattributes/' . $dynamicattribute->uuid);

        $this->assertCount(0, DynamicAttribute::all());
    }



    #region Private Functions

    private function add_new_dynamicattribute(IHasDynamicAttributes $model, $model_type, $dynamicattributetype, $name, $title = null, $status = null, $description = null, $offset = null, $max_length = null, $searchable = null, $sortable = null, $can_be_notified = null): TestResponse
    {
        return $this->post('dynamicattributes/',
            array_merge([
                'model_id' => $model->id,
                'model_type' => $model_type
            ], $this->new_data($dynamicattributetype, $name, $title, $status, $description, $offset, $max_length, $searchable, $sortable, $can_be_notified)));
    }

    private function update_existing_dynamicattribute($existing_dynamicattribute, $dynamicattributetype, $name, $title = null, $status = null, $description = null, $offset = null, $max_length = null, $searchable = null, $sortable = null, $can_be_notified = null): TestResponse
    {
        return $this->put('dynamicattributes/' . $existing_dynamicattribute->uuid, $this->new_data($dynamicattributetype, $name, $title, $status, $description, $offset, $max_length, $searchable, $sortable, $can_be_notified));
    }

    private function new_data($dynamicattributetype, $name, $title = null, $status = null, $description = null, $offset = null, $max_length = null, $searchable = null, $sortable = null, $can_be_notified = null): array
    {
        return [
            'name' => $name,
            'title' => $title,
            'description' => $description,

            'dynamicattributetype' => $dynamicattributetype,
            'status' => $status,
            'offset' => $offset,
            'max_length' => $max_length,
            'searchable' => $searchable,
            'sortable' => $sortable,
            'can_be_notified' => $can_be_notified
        ];
    }

    #endregion
    public function getModel(): IHasFormatRules
    {
        return $this->create_new_dynamicattribute();
    }
}
