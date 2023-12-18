<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateTreatmentResultsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'treatment_results';
    public string $table_comment = '(common) treatment result';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->integer('num_ord')->default(0)->comment('order number');
            $table->boolean('last_result')->default(0)->comment('determine if this is the last result');

            /**
             * Duration
            */
            $table->timestamp('start_at')->nullable()->comment('treatment start date');
            $table->timestamp('last_exec_end_at')->nullable()->comment('treatment s last execution end date');
            $table->timestamp('end_at')->nullable()->comment('treatment end date');
            $table->integer('duration')->nullable()->comment('treatment duration');
            $table->string('duration_hhmmss')->nullable()->comment('treatment duration in hh:mm:ss format');

            /**
             * Result
             */
            $table->string('result')->nullable()->index()->comment('treatment result: [none, success, failed]');
            $table->string('message', 500)->nullable()->comment('treatment last message');

            //$table->string('hastreatmentresults_type')->nullable()->comment('referenced treatment result owner s model (class name)');
            //$table->bigInteger('hastreatmentresults_id')->nullable()->comment('referenced treatment result owner s model id (object id)');

            //$table->string('currenttreatmentresult_type')->nullable()->comment('referenced current treatment result owner s model (class name)');
            //$table->bigInteger('currenttreatmentresult_id')->nullable()->comment('referenced current treatment result owner s model id (object id)');

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
