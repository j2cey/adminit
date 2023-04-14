<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Models\Setting;
use App\Enums\RuleResultEnum;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use App\Models\AnalysisRule\AnalysisRule;
use Tests\Feature\Traits\HasFormatRulesTest;
use App\Models\AnalysisRule\AnalysisRuleType;
use App\Contracts\FormatRule\IHasFormatRules;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AnalysisRuleTest extends TestCase
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
        AnalysisRule::truncate();
        Schema::enableForeignKeyConstraints();
    }


    /**
     * Test la création d'un nouveau AnalysisRule
     *
     * @return void
     */
    public function test_anAnalysisRule_can_be_stored_to_the_database()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_analysisrule(
            AnalysisRuleType::threshold()->first(),
            "new analysis rule"
        );

        // on test si l'assertion s'est bien passée
        $response->assertStatus(201);

        // on test qu'il y a bien 1 objet dans la base de données
        $this->assertCount(1, AnalysisRule::all());
    }

    /**
     * Test la validation d'un nouveau ReportFile avant création
     *
     * @return void
     */
    public function test_anAnalysisRule_required_fields_must_be_validated_before_creation()
    {
        //$this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_analysisrule(null, null, null, null);

        // on doit avoir une erreur de validation des champs ci-dessous
        $response->assertSessionHasErrors(['analysisruletype','title']);
    }

    /**
     * Test la modification d'un ReportFile
     *
     * @return void
     */
    public function test_anAnalysisRule_can_be_updated_from_the_database()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_analysisrule(
            AnalysisRuleType::threshold()->first(),
            "new analysis rule",
            Status::active()->first(),
            RuleResultEnum::ALLOWED->value,
            "new analysis rule desc"
        );

        $analysisrule = AnalysisRule::first();

        $analysisruletype_another = AnalysisRuleType::comparison()->first();
        $status_inactive = Status::inactive()->first();

        $this->update_existing_analysisrule(
            $analysisrule,
            $analysisruletype_another,
            "new analysis rule upd",
            $status_inactive,
            RuleResultEnum::BROKEN->value,
            "new analysis rule desc upd"
        );

        $analysisrule->refresh();

        $this->assertEquals("new analysis rule upd", $analysisrule->title);
        $this->assertEquals(RuleResultEnum::BROKEN, $analysisrule->rule_result_for_notification);
        $this->assertEquals($status_inactive->id, $analysisrule->status->id);
        $this->assertEquals($analysisruletype_another->id, $analysisrule->analysisruletype->id);
        $this->assertEquals("new analysis rule desc upd", $analysisrule->description);
    }

    /**
     * Test la suppression d'un ReportFile
     *
     * @return void
     */
    public function test_anAnalysisRule_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $user = $this->authenticated_user_admin();

        $response = $this->add_new_analysisrule(
            AnalysisRuleType::threshold()->first(),
            "new analysis rule"
        );

        $analysisrule = AnalysisRule::first();

        $this->delete('analysisrules/' . $analysisrule->uuid);

        $this->assertCount(0, AnalysisRule::all());
    }



    #region Private Functions

    private function add_new_analysisrule($analysisruletype, $title, $status = null, $rule_result_for_notification = null, $description = null): TestResponse
    {
        return $this->post('analysisrules', array_merge(
            [ 'dynamicattribute' => $this->create_new_dynamicattribute("new dynamicattribute") ],
            $this->new_data($analysisruletype, $title, $status, $rule_result_for_notification, $description) )
        );
    }

    private function update_existing_analysisrule($existing_analysisrule, $analysisruletype, $title, $status = null, $rule_result_for_notification = null, $description = null): TestResponse
    {
        return $this->put('analysisrules/' . $existing_analysisrule->uuid, $this->new_data($analysisruletype, $title, $status, $rule_result_for_notification, $description));
    }

    private function new_data($analysisruletype, $title, $status = null, $rule_result_for_notification = null, $description = null): array
    {
        return [
            'title' => $title,
            'rule_result_for_notification' => $rule_result_for_notification,
            'description' => $description,

            'analysisruletype' => $analysisruletype,
            'status' => $status,
        ];
    }

    #endregion
    public function getModel(): IHasFormatRules
    {
        return $this->create_new_analysisrule();
    }
}
