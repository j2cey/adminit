<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateTasksTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'tasks';
    public $table_comment = 'list of tasks';

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

            $table->string('title')->comment('title of the task');
            $table->string('full_path')->nullable()->comment('full path of the task');
            $table->string('code')->unique()->comment('task s unique code');
            $table->string('description')->nullable()->comment('description of the task');

            $table->foreignId('task_parent_id')->nullable()
                ->comment('task parent reference')
                ->constrained('tasks')->onDelete('set null');

            $table->integer('subtask_posi')->default(0)->comment('task position in sub tasks s tasks list');

            $table->foreignId('subject_id')->nullable()
                ->comment('subject reference')
                ->constrained('subjects')->onDelete('set null');

            $table->integer('subject_posi')->default(0)->comment('task position in subject tasks list');
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
            $table->dropForeign(['task_parent_id']);
            $table->dropForeign(['subject_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
