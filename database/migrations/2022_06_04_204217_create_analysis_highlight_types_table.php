<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateAnalysisHighlightTypesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'analysis_highlight_types';
    public $table_comment = 'highlight type for analysis rule';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment('name of the analysis highlight type');
            $table->string('model_type')->comment('referenced model (class name)');
            $table->string('view_name')->comment('name view of the inner highlight');
            $table->string('description')->nullable()->comment('analysis highlight type description');

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
        });
        Schema::dropIfExists($this->table_name);
    }
}
