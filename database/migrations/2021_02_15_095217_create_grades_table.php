<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateGradesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'grades';
    public $table_comment = 'list of grades';

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

            $table->foreignId('grade_unit_id')->nullable()
                ->comment('grade unit reference')
                ->constrained('grade_units')->onDelete('set null');

            $table->integer('value')->nullable()->comment('grade value expressed in the unit');

            $table->foreignId('execution_id')->nullable()
                ->comment('execution reference')
                ->constrained('executions')->onDelete('set null');

            $table->integer('grade_posi')->default(0)->comment('grade position in execution grades list');

            $table->string('description')->nullable()->comment('description of the grade');
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
            $table->dropForeign(['grade_unit_id']);
            $table->dropForeign(['execution_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
