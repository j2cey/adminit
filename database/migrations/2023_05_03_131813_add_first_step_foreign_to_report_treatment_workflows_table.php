<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirstStepForeignToReportTreatmentWorkflowsTable extends Migration
{
    public string $table_name = 'report_treatment_workflows';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->foreignId('first_step_id')->nullable()
                ->comment('first report treatment workflow step reference')
                ->constrained('report_treatment_workflow_steps')->onDelete('set null');
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
            $table->dropForeign(['first_step_id']);
        });
    }
}
