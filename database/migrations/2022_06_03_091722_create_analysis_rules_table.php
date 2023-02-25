<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateAnalysisRulesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'analysis_rules';
    public $table_comment = 'list of analysis rules';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('title')->comment('title of the analysis rule');
            $table->string('description')->nullable()->comment('analysis rule description');

            $table->foreignId('analysis_rule_type_id')->nullable()
                ->comment('analysis rules type reference')
                ->constrained()->onDelete('set null');

            $table->foreignId('dynamic_attribute_id')->nullable()
                ->comment('dynamic attribute reference')
                ->constrained()->onDelete('set null');

            $table->string('innerrule_type')->comment('referenced inner rule model (class name)');
            $table->bigInteger('innerrule_id')->comment('referenced inner rule model id (object id)');

            $table->boolean('alert_when_allowed')->default(false)->comment('determine if an alert have to be sent when this rule is allowed');
            $table->boolean('alert_when_broken')->default(false)->comment('determine if an alert have to be sent when this rule is broken');

            $table->baseFields();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropBaseForeigns();
            $table->dropForeign(['analysis_rule_type_id']);
            $table->dropForeign(['dynamic_attribute_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
