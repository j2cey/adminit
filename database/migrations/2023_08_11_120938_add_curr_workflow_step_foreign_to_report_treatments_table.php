<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrWorkflowStepForeignToReportTreatmentsTable extends Migration
{
    public string $table_name = 'report_treatments';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->foreignId('workflow_step_id')->nullable()
                ->comment('current report treatment workflow step reference')
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
            $table->dropForeign(['workflow_step_id']);
        });
    }
}
