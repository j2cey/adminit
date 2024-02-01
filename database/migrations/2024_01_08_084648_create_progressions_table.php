<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateProgressionsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'progressions';
    public string $table_comment = 'progressions';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('process_name')->nullable()->comment('progression s process name');
            $table->integer('nb_todo')->default(0)->comment('number of steps to be executed');
            $table->integer('nb_done')->default(0)->comment('number of steps executed');
            $table->integer('nb_passed')->default(0)->comment('number of steps passed');
            $table->decimal('rate')->nullable()->comment('execution rate');
            $table->decimal('rate_passed')->nullable()->comment('execution passed rate');
            $table->boolean('exec_done')->default(false)->comment('execution rate');
            $table->string('current_step')->nullable()->comment('current progression step');
            $table->string('description')->nullable()->comment('description');
            $table->longText('todos')->nullable();

            $table->string('hasprogression_type')->nullable()->comment('referenced progression holder object model (class name)');
            $table->bigInteger('hasprogression_id')->nullable()->comment('referenced progression holder object model id (object id)');

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
