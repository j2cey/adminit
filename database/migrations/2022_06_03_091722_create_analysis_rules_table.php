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
            $table->string('rule_result_for_notification')->default("allways")->comment('résulat d analyse attendu pour notification');
            $table->integer('num_ord')->nullable()->comment('format rule s num order');
            $table->string('description')->nullable()->comment('analysis rule description');

            $table->foreignId('analysis_rule_type_id')->nullable()
                ->comment('analysis rules type reference')
                ->constrained()->onDelete('set null');

            $table->string('hasanalysisrule_type')->nullable()->comment('referenced analysis rule owner s model (class name)');
            $table->bigInteger('hasanalysisrule_id')->nullable()->comment('referenced analysis rule owner s model id (object id)');

            $table->string('inneranalysisrule_type')->comment('referenced inner analysis rule model (class name)');
            $table->bigInteger('inneranalysisrule_id')->comment('referenced inner analysis rule model id (object id)');

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
        });
        Schema::dropIfExists($this->table_name);
    }
}
