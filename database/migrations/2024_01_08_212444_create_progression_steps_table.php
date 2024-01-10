<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateProgressionStepsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'progression_steps';
    public string $table_comment = 'progression steps';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable()->comment('step name');
            $table->boolean('passed')->nullable()->comment('determine if this step is passed');
            $table->string('description')->nullable()->comment('description');

            $table->foreignId('progression_id')->nullable()
                ->comment('progression reference')
                ->constrained()->onDelete('set null');

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
            $table->dropForeign(['progression_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
