<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHasbatchColumnsToJobBatchesTable extends Migration
{
    public string $table_name = 'job_batches';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->string('hasbatch_type')->nullable()->comment('referenced batch owner s model (class name)');
            $table->bigInteger('hasbatch_id')->nullable()->comment('referenced batch owner s model id (object id)');
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
            $table->dropColumn(['hasanalysisrule_type']);
            $table->dropColumn(['hasanalysisrule_id']);
        });
    }
}
