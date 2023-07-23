<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastOperationForeignToOperationResultsTable extends Migration
{
    public string $table_name = 'operation_results';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('', function (Blueprint $table) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->foreignId('last_operation_id')->nullable()
                    ->comment('last operation result reference')
                    ->constrained('operation_results')->onDelete('set null');
            });
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
            $table->dropForeign(['last_operation_id']);
        });
    }
}
