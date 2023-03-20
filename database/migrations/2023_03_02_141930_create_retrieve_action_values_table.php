<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateRetrieveActionValuesTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = "retrieve_action_values";
    public string $table_comment = "valeurs d une action (en rapport a la récupération) selectionné.";

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
            $table->string('type')->comment("type de la valeur");
            $table->string('value_string')->nullable()->comment("valeur string");
            $table->integer('value_int')->nullable()->comment("valeur integer");
            $table->timestamp('value_datetime')->nullable()->comment("valeur DateTime");
            $table->string('description', 500)->nullable()->comment("description de la valeur");

            $table->foreignId('selected_retrieve_action_id')->nullable()
                ->comment('clé de reférence de l action sélectionnée')
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
                $table->dropForeign(['selected_retrieve_action_id']);
            }
        });
        Schema::dropIfExists($this->table_name);
    }
}
