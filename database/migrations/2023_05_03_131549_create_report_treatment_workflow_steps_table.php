<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReportTreatmentWorkflowStepsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'report_treatment_workflow_steps';
    public string $table_comment = 'treatment workflow steps for a treatment workflow';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('code')->comment('workflow step code');
            $table->string('name')->nullable()->comment('workflow step name');
            $table->string('description', 500)->nullable()->comment('workflow step description');

            $table->foreignId('workflow_id')->nullable()
                ->comment('report treatment workflow reference')
                ->constrained('report_treatment_workflows')->onDelete('set null');

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
            $table->dropForeign(['workflow_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
