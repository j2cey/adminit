<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRetryofForeignToReportTreatmentStepResultsTable extends Migration
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
            $table->foreignId('retryof_id')->nullable()
                ->comment('report treatment step (for what this step is a retry) result reference')
                ->constrained('report_treatment_step_results')->onDelete('set null');
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
            $table->dropForeign(['retryof_id']);
        });
    }
}
