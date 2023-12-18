<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUpperFormattingresultToFormattingResultsTable extends Migration
{
    public string $table_name = 'formatting_results';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->foreignId('upper_formattingresult_id')->nullable()
                ->comment('upper formatting_results reference')
                ->constrained('formatting_results')->onDelete('set null');
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
            $table->dropForeign(['upper_formattingresult_id']);
        });
    }
}
