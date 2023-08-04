<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;

class CreateTreatmentOperationsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'treatment_operations';
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
            $table->string('result')->nullable()->index()->comment('operation result: [none, success, failed]');
            $table->string('state')->nullable()->index()->comment('operation state: [waiting, queued, running, completed]');
            $table->string('criticality_level')->index()->nullable()->comment('operation criticality level: [High, Medium, Low]');
            $table->string('code')->nullable()->index()->comment('treatment code: [downloadfile, importfile, formatdata, notifyreport]');
            $table->string('message', 1000)->nullable()->comment('operation message');
            $table->integer('attempts')->default(0)->comment('number of attempts');

            $table->string('description', 500)->nullable()->comment('operation description');

            $table->foreignId('report_treatment_id')->nullable()
                ->comment('report treatment step reference')
                ->constrained()->onDelete('set null');

            $table->timestamp('retry_start_at')->nullable()->comment('treatment retry start date');
            $table->integer('retries_session_count')->nullable()->comment('retry count for current session');
            $table->timestamp('retry_end_at')->nullable()->comment('treatment retry end date');

            $table->longText('payload')->nullable();

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

            $table->dropForeign(['report_treatment_step_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
