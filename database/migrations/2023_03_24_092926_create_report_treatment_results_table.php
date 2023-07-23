<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReportTreatmentResultsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'report_treatment_results';
    public string $table_comment = 'report treatment results';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable()->comment('treatment name');
            $table->timestamp('start_at')->nullable()->comment('treatment start date');
            $table->timestamp('end_at')->nullable()->comment('treatment end date');
            $table->string('result')->nullable()->index()->comment('treatment result: [none, success, failed]');
            $table->string('state')->nullable()->index()->comment('treatment state: [waiting, queued, running, completed]');
            $table->string('criticality_level')->nullable()->index()->comment('treatment criticality level: [High, Medium, Low]');
            $table->string('message', 500)->nullable()->comment('treatment last message');
            $table->integer('attempts')->default(0)->comment('number of attempts');

            $table->string('description', 500)->nullable()->comment('treatment description');
            $table->integer('currentstep_num')->default(0)->comment('current step number');

            $table->foreignId('report_id')->nullable()
                ->comment('report reference')
                ->constrained()->onDelete('set null');

            $table->string('hasreporttreatmentresults_type')->nullable()->comment('referenced ReportTreatmentResult owner s model (class name)');
            $table->bigInteger('hasreporttreatmentresults_id')->nullable()->comment('referenced ReportTreatmentResult owner s model id (object id)');

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
            $table->dropForeign(['report_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
