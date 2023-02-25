<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateGradeUnitsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'grade_units';
    public $table_comment = 'units of grade';

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

            $table->string('title')->comment('title of the unit');
            $table->string('unit')->unique()->comment('the unit');
            $table->integer('unitvalue')->nullable()->comment('the unit value');
            $table->string('description')->nullable()->comment('description of the goal type');

            $table->foreignId('grade_unit_parent_id')->nullable()
                ->comment('grade unit parent reference')
                ->constrained('grade_units')->onDelete('set null');

            $table->json('relative_expression')->comment('the expression used to get the relative value');

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
            $table->dropForeign(['grade_unit_parent_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
