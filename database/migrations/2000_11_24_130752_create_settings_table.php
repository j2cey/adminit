<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateSettingsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'settings';
    public $table_comment = 'custom settings of the system.';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('group')->comment('setting entry group');
            $table->string('name')->comment('setting entry key name');
            $table->string('value')->nullable()->comment('setting entry value');
            $table->enum('type', ['string','integer','bool','float','array'])->default("string")->comment('value type');
            $table->string('array_sep')->default(",")->comment('array separator, if any');
            $table->string('description')->nullable()->comment('description');

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
