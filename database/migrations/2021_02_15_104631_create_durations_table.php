<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateDurationsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'durations';
    public $table_comment = 'list of durations';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->baseFields();

            $table->timestamp('start_at')->nullable()->comment('duration s start date');
            $table->timestamp('end_at')->nullable()->comment('duration s end date');

            $table->integer('elapsetime_ticks')->nullable()->comment('duration s elapse time ticks');
            $table->integer('elapsetime_years')->nullable()->comment('duration s elapse years');
            $table->integer('elapsetime_months')->nullable()->comment('duration s elapse months');
            $table->integer('elapsetime_days')->nullable()->comment('duration s elapse days');
            $table->integer('elapsetime_hours')->nullable()->comment('duration s elapse hours');
            $table->integer('elapsetime_minutes')->nullable()->comment('duration s elapse minutes');
            $table->integer('elapsetime_seconds')->nullable()->comment('duration s elapse in seconds');
            $table->integer('elapsetime_milliseconds')->nullable()->comment('duration s elapse in milliseconds');

            $table->foreignId('execution_id')->nullable()
                ->comment('execution reference')
                ->constrained('executions')->onDelete('set null');

            $table->integer('duration_posi')->default(0)->comment('duration position in execution durations list');

            $table->string('description')->nullable()->comment('description of the duration');
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
            $table->dropForeign(['execution_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
