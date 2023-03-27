<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReportTreatmentStepResultsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'report_treatment_step_results';
    public string $table_comment = 'report treatment step results';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->timestamp('start_at')->nullable()->comment('treatment step start date');
            $table->timestamp('end_at')->nullable()->comment('treatment step end date');
            $table->string('state')->nullable()->comment('treatment step state: [waiting, running, success, failed]');
            $table->string('message', 500)->nullable()->comment('treatment step last message');

            $table->string('description', 500)->nullable()->comment('treatment step description');

            $table->foreignId('report_treatment_result_id')->nullable()
                ->comment('report treatment result reference')
                ->constrained()->onDelete('set null');

            $table->integer('retry_no')->default(1)->comment('retry number');
            $table->integer('retry_session_count')->default(0)->comment('retry count for current session');

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

            $table->dropForeign(['report_treatment_result_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
