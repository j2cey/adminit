<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateJobLaunchersTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'job_launchers';
    public string $table_comment = 'job launcher managers';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('queuecode')->nullable()->index()->comment('the Queue code');
            $table->integer('queuecode_index')->nullable()->comment('the Queue code Index');
            $table->string('queue_name')->nullable()->index()->comment('the Queue name');
            $table->baseFields();
        });
        $this->setTableComment($this->table_name,$this->table_comment);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropBaseForeigns();
        });
        Schema::dropIfExists($this->table_name);
    }
}
