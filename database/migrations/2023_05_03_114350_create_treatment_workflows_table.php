<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateTreatmentWorkflowsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'treatment_workflows';
    public string $table_comment = 'treatment workflow for a Report';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable()->comment('workflow name');
            $table->string('description', 500)->nullable()->comment('workflow description');

            $table->string('hastreatmentworkflow_type')->nullable()->comment('referenced treatment workflow s owner model (class name)');
            $table->bigInteger('hastreatmentworkflow_id')->nullable()->comment('referenced treatment workflow s owner model id (object id)');

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
            //$table->dropForeign(['report_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
