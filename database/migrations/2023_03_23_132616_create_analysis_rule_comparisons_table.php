<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateAnalysisRuleComparisonsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'analysis_rule_comparisons';
    public string $table_comment = 'comparisons analysis rules';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('inner_operand')->default(true)->comment('the inner operand value');
            $table->boolean('use_strict_comparison')->default(true)->comment('determine whether the comparison is strict');
            $table->boolean('use_type_comparison')->default(false)->comment('determine whether the comparison have to be made with same type');
            $table->string('comment')->nullable()->comment('analysis comparison rule comment');

            $table->foreignId('comparison_type_id')->nullable()
                ->comment('comparison types reference')
                ->constrained()->onDelete('set null');


            $table->string('innercomparison_type')->comment('referenced inner comparison model (class name)');
            $table->bigInteger('innercomparison_id')->comment('referenced inner comparison model id (object id)');

            $table->baseFields();
        });
        $this->setTableComment($this->table_name,$this->table_comment);
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
            $table->dropForeign(['comparison_type_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
