<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateRetrieveActionsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = "retrieve_actions";
    public $table_comment = "liste actions qui peuvent être effectues (en rapport a la recuperation) pour un fichier.";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment("nom de l action");
            $table->string('code')->unique()->comment("code de l action");
            $table->string('action_class')->comment("chemin complet de la classe de l Action (qui va implémenter l interface IRetrieveAction)");
            $table->string('description', 500)->nullable()->comment("description de l action");

            $table->unsignedBigInteger('selected_retrieve_action_id');
            $table->string('selected_retrieve_action_type');

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
                $table->dropForeign(['retrieve_action_type_id']);
            }
        });
        Schema::dropIfExists($this->table_name);
    }
}
