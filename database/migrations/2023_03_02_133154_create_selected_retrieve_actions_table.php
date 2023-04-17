<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateSelectedRetrieveActionsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = "selected_retrieve_actions";
    public $table_comment = "liste actions (en rapport à la récupération) selectionnées pour un fichier et/ou un accès.";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique()->comment("code de la selection");
            $table->string('description', 500)->nullable()->comment("description de la selection");

            $table->foreignId('retrieve_action_id')->nullable()
                ->comment('clé de reférence de l action')
                ->constrained('retrieve_actions')->onDelete('set null');

            $table->string('hasselectedretrieveaction_type')->nullable()->comment('referenced selected retrieve action owner s model (class name)');
            $table->bigInteger('hasselectedretrieveaction_id')->nullable()->comment('referenced selected retrieve action owner s model id (object id)');

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
