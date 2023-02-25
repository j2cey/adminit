<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateModelHasDifficultiesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'model_has_difficulties';
    public $table_comment = 'list of difficulties for a given model';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->foreignId('difficulty_id')->nullable()
                ->comment('difficulty reference')
                ->constrained('difficulties')->onDelete('set null');

            $table->string('model_type')->comment('type of referenced model');
            $table->bigInteger('model_id')->comment('model reference');

            $table->integer('posi')->default(0)->comment('difficulty position in difficulties list.');
            $table->timestamps();
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
            $table->dropForeign(['difficulty_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
