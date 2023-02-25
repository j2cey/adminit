<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateAnalysisHighlightsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'analysis_highlights';
    public $table_comment = 'highlight for analysis rule';

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
            $table->string('when_rule_result_is')->comment('analysis rule result for which this highlight is applied: allowed, broken');
            $table->string('description')->nullable()->comment('analysis rule description');

            $table->foreignId('analysis_highlight_type_id')->nullable()
                ->comment('analysis highlight type reference')
                ->constrained()->onDelete('set null');

            $table->foreignId('analysis_rule_id')->nullable()
                ->comment('analysis rules type reference')
                ->constrained()->onDelete('set null');

            $table->string('innerhighlight_type')->comment('referenced inner highlight model (class name)');
            $table->bigInteger('innerhighlight_id')->comment('referenced inner highlight model id (object id)');

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
            $table->dropForeign(['analysis_highlight_type_id']);
            $table->dropForeign(['analysis_rule_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
