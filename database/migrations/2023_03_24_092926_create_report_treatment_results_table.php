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

            $table->timestamp('start_at')->nullable()->comment('treatment start date');
            $table->timestamp('end_at')->nullable()->comment('treatment end date');
            $table->string('state')->nullable()->comment('treatment state: [waiting, running, success, failed]');

            $table->string('description', 500)->nullable()->comment('treatment description');

            $table->integer('currentstep_num')->default(0)->comment('current step number');
            $table->foreignId('currentstep_id')->nullable()
                ->comment('report treatment (current) step result reference')
                ->constrained('report_treatment_step_results')->onDelete('set null');

            $table->foreignId('report_id')->nullable()
                ->comment('report reference')
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

            $table->dropForeign(['report_id']);
            $table->dropForeign(['currentstep_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
