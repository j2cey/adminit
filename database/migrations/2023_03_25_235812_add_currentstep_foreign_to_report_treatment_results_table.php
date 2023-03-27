<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrentstepForeignToReportTreatmentResultsTable extends Migration
{
    public string $table_name = 'report_treatment_results';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table_name, function (Blueprint $table) {

            $table->foreignId('currentstep_id')->nullable()
                ->comment('report treatment (current) step result reference')
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
            $table->dropForeign(['currentstep_id']);
        });
    }
}
