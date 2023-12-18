<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPreviousAndNextStepForeignsToTreatmentWorkflowStepsTable extends Migration
{
    public string $table_name = 'treatment_workflow_steps';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->foreignId('previous_step_id')->nullable()
                ->comment('previous report treatment workflow step reference')
                ->constrained('treatment_workflow_steps')->onDelete('set null');

            $table->foreignId('next_step_id')->nullable()
                ->comment('next treatment workflow step reference')
                ->constrained('treatment_workflow_steps')->onDelete('set null');
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
            $table->dropForeign(['previous_step_id']);
            $table->dropForeign(['next_step_id']);
        });
    }
}
