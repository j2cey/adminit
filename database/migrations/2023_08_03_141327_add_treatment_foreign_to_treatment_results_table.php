<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * treatment foreign for treatment's results history
 */
class AddTreatmentForeignToTreatmentResultsTable extends Migration
{
    public string $table_name = 'treatment_results';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->foreignId('treatment_id')->nullable()
                ->comment('treatment reference')
                ->constrained()->onDelete('set null');
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
            $table->dropForeign(['treatment_id']);
        });
    }
}
