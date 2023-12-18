<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateModelPickersTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'model_pickers';
    public $table_comment = 'model to safly pick and lock a model in the system';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_pickers', function (Blueprint $table) {
            $table->id();

            $table->string('model_type')->comment('model type, class path');
            $table->bigInteger('model_id')->nullable()->comment('model id');
            $table->string('description', 500)->nullable()->comment('description, if any');

            $table->json('selection_criteria')->default(new Expression('(JSON_ARRAY())'))->comment('array of pair of [field,value] for selection criteria if any');

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
