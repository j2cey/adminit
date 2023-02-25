<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateAnalysisRuleThresholdsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'analysis_rule_thresholds';
    public $table_comment = 'threshold analysis rules';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->integer('threshold')->nullable()->comment('the threshold');

            $table->foreignId('threshold_type_id')->nullable()
                ->comment('threshold types reference')
                ->constrained()->onDelete('set null');

            $table->string('comment')->nullable()->comment('analysis threshold rule comment');

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
            $table->dropForeign(['threshold_type_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
