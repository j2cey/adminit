<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;

class CreateAccessProtocoleTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = "access_protocoles";
    public $table_comment = "liste des protocoles d accès aux ressources IT (serveurs)";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment("Nom du protocole");

            $table->string('description', 500)->nullable()->comment("description du protocole");

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
