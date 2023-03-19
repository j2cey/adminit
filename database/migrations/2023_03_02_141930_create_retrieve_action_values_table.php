<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateRetrieveActionValuesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = "retrieve_action_values";
    public $types_de_valeur = ["string","int","DateTime"];
    public $table_comment = "valeurs d une action (en rapport a la récupération) selectionné.";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('label')->unique()->comment("libellé de la valeur");
            $table->enum('type', $this->types_de_valeur)->comment("type de la valeur");
            $table->string('description', 500)->nullable()->comment("description de la valeur");

            $table->foreignId('retrieve_action_id')->nullable()
                ->comment('clé de reférence de l action')
                ->constrained('retrieve_actions')->onDelete('set null');

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
                $table->dropForeign(['retrieve_action_id']);
            }
        });
        Schema::dropIfExists($this->table_name);
    }
}
