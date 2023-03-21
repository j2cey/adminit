<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileAndAccessForeignToSelectedRetrieveActionsTable extends Migration
{
    public string $table_name = "selected_retrieve_actions";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->foreignId('report_file_id')->nullable()
                ->comment('clé de reférence du fichier')
                ->constrained('report_files')->onDelete('set null');

            $table->foreignId('report_file_access_id')->nullable()
                ->comment('clé de reférence de l accès')
                ->constrained('report_file_accesses')->onDelete('set null');
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
            /** Make sure to put this condition to check if driver is SQLite */
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['report_file_id']);
                $table->dropForeign(['report_file_access_id']);
            }
        });
    }
}
