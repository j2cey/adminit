<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateGoalsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'goals';
    public $table_comment = 'list of goals';

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

            $table->string('title')->comment('title of the category');
            $table->string('code')->unique()->comment('unique code');
            $table->integer('value')->comment('goal value');
            $table->string('description')->nullable()->comment('description of the category');

            $table->foreignId('goal_type_id')->nullable()
                ->comment('goal type reference')
                ->constrained('goal_types')->onDelete('set null');
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
            $table->dropForeign(['goal_type_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
