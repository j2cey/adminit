<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReportTreatmentStepsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'report_treatment_steps';
    public string $table_comment = 'report treatment steps';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable()->comment('treatment step name');
            $table->timestamp('start_at')->nullable()->comment('treatment step start date');
            $table->timestamp('end_at')->nullable()->comment('treatment step end date');
            $table->string('code')->nullable()->index()->comment('treatment step code: [downloadfile, importfile, formatdata, notifyreport]');
            $table->string('result')->nullable()->index()->comment('treatment step result: [none, success, failed]');
            $table->string('state')->nullable()->index()->comment('treatment step state: [waiting, queued, running, completed]');
            $table->string('criticality_level')->nullable()->index()->comment('treatment step criticality level: [High, Medium, Low]');
            $table->string('message', 500)->nullable()->comment('treatment step last message');
            $table->integer('attempts')->default(0)->comment('number of attempts');

            $table->string('description', 500)->nullable()->comment('treatment step description');

            $table->foreignId('report_treatment_id')->nullable()
                ->comment('report treatment reference')
                ->constrained()->onDelete('set null');

            $table->timestamp('retry_start_at')->nullable()->comment('treatment retry start date');
            $table->integer('retries_session_count')->nullable()->comment('retry count for current session');
            $table->timestamp('retry_end_at')->nullable()->comment('treatment retry end date');

            $table->string('hasreporttreatmentsteps_type')->nullable()->comment('referenced report treatment step owner s model (class name)');
            $table->bigInteger('hasreporttreatmentsteps_id')->nullable()->comment('referenced report treatment step owner s model id (object id)');

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

            $table->dropForeign(['report_treatment_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
