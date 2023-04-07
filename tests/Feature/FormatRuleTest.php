<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Models\Setting;
use App\Enums\RuleResultEnum;
use Illuminate\Testing\TestResponse;
use App\Models\FormatRule\FormatRule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use App\Models\FormatRule\FormatRuleType;
use App\Contracts\FormatRule\IHasFormatRules;
use App\Models\DynamicAttributes\DynamicAttribute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FormatRuleTest extends TestCase
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
        FormatRule::truncate();
        Schema::enableForeignKeyConstraints();
    }


    /**
     * Test la création d'un nouveau FormatRule
     *
     * @return void
     */
    public function test_aFormatRule_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_formatrule(
            $this->create_new_dynamicattribute(),
            DynamicAttribute::class,
            FormatRuleType::textColor()->first(),
            "New Format Rule",
            null,
            RuleResultEnum::ALLOWED->value,
            Status::default()->first(),
            "New Format Rule desc"
        );

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, FormatRule::all());
    }

    /**
     * Test la validation d'un nouveau ReportFile avant création
     *
     * @return void
     */
    public function test_FormatRule_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_formatrule(
            $this->create_new_dynamicattribute(),
            DynamicAttribute::class,
            null,
            null,
            null,
            null
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['title','formatruletype']);
    }

    public function test_FormatRule_unique_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_formatrule(
            $this->create_new_dynamicattribute(),
            DynamicAttribute::class,
            FormatRuleType::textColor()->first(),
            "New Format Rule",
            null,
            RuleResultEnum::ALLOWED->value,
            Status::default()->first(),
            "New Format Rule desc"
        );
        $response = $this->add_new_formatrule(
            $this->create_new_dynamicattribute(),
            DynamicAttribute::class,
            FormatRuleType::textColor()->first(),
            "New Format Rule",
            null,
            RuleResultEnum::ALLOWED->value,
            Status::default()->first(),
            "New Format Rule desc"
        );

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['formatruletype_key']);
    }

    /**
     * Test la modification d'un ReportFile
     *
     * @return void
     */
    public function test_aFormatRule_can_be_updated_from_the_database()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_formatrule(
            $this->create_new_dynamicattribute(),
            DynamicAttribute::class,
            FormatRuleType::textColor()->first(),
            "New Format Rule",
            null,
            RuleResultEnum::ALLOWED->value,
            Status::active()->first(),
            "New Format Rule desc",
            1
        );

        $formatrule = FormatRule::first();

        $formatruletype_another = FormatRuleType::textSize()->first();
        $status_inactive = Status::inactive()->first();

        $response = $this->update_existing_formatrule(
            $formatrule,
            $formatruletype_another,
            "New Format Rule upd",
            null,
            RuleResultEnum::BROKEN->value,
            $status_inactive,
            "New Format Rule desc upd",
            2
        );

        $formatrule->refresh();

        $this->assertEquals("New Format Rule upd", $formatrule->title);
        $this->assertEquals($formatruletype_another->id, $formatrule->formatruletype->id);
        $this->assertEquals($status_inactive->id, $formatrule->status->id);
        $this->assertEquals("New Format Rule desc upd", $formatrule->description);
        $this->assertEquals(RuleResultEnum::BROKEN, $formatrule->rule_result);
        $this->assertEquals(2, $formatrule->num_ord);
    }

    /**
     * Test la suppression d'un ReportFile
     *
     * @return void
     */
    public function test_aFormatRule_can_be_deleted()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_formatrule(
            $this->create_new_dynamicattribute(),
            DynamicAttribute::class,
            FormatRuleType::textColor()->first(),
            "New Format Rule",
            null,
            RuleResultEnum::ALLOWED->value,
            Status::active()->first(),
            "New Format Rule desc"
        );

        $formatrule = FormatRule::first();

        $this->delete('formatrules/' . $formatrule->uuid);

        $this->assertCount(0, FormatRule::all());
    }



    #region Private Functions

    private function add_new_formatrule(IHasFormatRules $model, $model_type, $formatruletype, $title, $innerformatrule = null, $rule_result = null, $status = null, $description = null, $num_ord = null): TestResponse
    {
        return $this->post('formatrules/',
            array_merge([
                'model_id' => $model->id,
                'model_type' => $model_type
            ], $this->new_data($formatruletype, $title, $innerformatrule, $rule_result, $status, $description, $num_ord)));
    }

    private function update_existing_formatrule($existing_formatrule, $formatruletype, $title, $innerformatrule = null, $rule_result = null, $status = null, $description = null, $num_ord = null): TestResponse
    {
        return $this->put('formatrules/' . $existing_formatrule->uuid, $this->new_data($formatruletype, $title, $innerformatrule, $rule_result, $status, $description, $num_ord));
    }

    private function new_data($formatruletype, $title, $innerformatrule = null, $rule_result = null, $status = null, $description = null, $num_ord = null): array
    {
        $data = [
            'title' => $title,
            'innerformatrule' => $innerformatrule,
            'rule_result' => $rule_result,
            'description' => $description,

            'formatruletype' => $formatruletype,
            'status' => $status,
        ];
        if ( ! is_null($num_ord) ) $data['num_ord'] = $num_ord;
        return $data;
    }

    #endregion
}
