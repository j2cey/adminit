<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateProgressionsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'progressions';
    public $table_comment = 'list of progressions';

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

            $table->integer('nb_todo')->default(0)->comment('number of things to do');
            $table->integer('nb_done')->default(0)->comment('number of things done');
            $table->integer('curr_value')->default(0)->comment('current value');
            $table->boolean('exec_done')->default(false)->comment('determine if the execution is done');
            $table->integer('rate')->default(0)->comment('the rate of the progression');

            $table->foreignId('execution_id')->nullable()
                ->comment('execution reference')
                ->constrained('executions')->onDelete('set null');

            $table->string('description')->nullable()->comment('description of the progression');
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
