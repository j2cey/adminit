<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateOperationResultsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'operation_results';
    public string $table_comment = '(inner) treatment s operations';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment('operation name');
            $table->integer('operation_no')->default(1)->comment('operation num');
            $table->timestamp('start_at')->nullable()->comment('operation start date');
            $table->timestamp('end_at')->nullable()->comment('operation end date');
            $table->integer('operation_duration')->nullable()->comment('operation duration');
            $table->string('state')->nullable()->comment('operation state: [waiting, running, success, failed]');
            $table->string('message', 500)->nullable()->comment('operation message');

            $table->string('description', 500)->nullable()->comment('operation description');

            $table->foreignId('report_treatment_step_result_id')->nullable()
                ->comment('report treatment step result reference')
                ->constrained()->onDelete('set null');

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

            $table->dropForeign(['report_treatment_step_result_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
