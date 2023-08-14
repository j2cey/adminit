<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrentOperationForeignToReportTreatmentStepsTable extends Migration
{
    public string $table_name = 'report_treatment_steps';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->foreignId('current_operation_id')->nullable()
                ->comment('current treatment operation reference')
                ->constrained('treatment_operations')->onDelete('set null');
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
