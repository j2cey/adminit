<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateRetrieveActionTypesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = "retrieve_action_types";
    public $table_comment = "liste des types d actions qui peuvent être effectues en rapport a la recuperation d un fichier.";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment("nom du type d actionn");
            $table->string('code')->unique()->comment("code du type d action");
            $table->string('description', 500)->nullable()->comment("description du type d action");

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
            /** Make sure to put this condition to check if driver is SQLite */
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropBaseForeigns();

            }
        });
        Schema::dropIfExists($this->table_name);
    }
}
