<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrentOperationForeignToReportTreatmentStepResultsTable extends Migration
{
    public string $table_name = 'report_treatment_step_results';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->foreignId('current_operation_id')->nullable()
                ->comment('current operation result reference')
                ->constrained('operation_results')->onDelete('set null');
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
            $table->dropForeign(['current_operation_id']);
        });
    }
}
