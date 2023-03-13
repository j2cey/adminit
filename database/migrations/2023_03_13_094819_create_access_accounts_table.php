<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;

class CreateAccessAccountsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = "access_accounts";
    public $table_comment = "liste des comptes d accès aux ressources IT (serveurs)";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('login')->comment("login du compte");
            $table->string('pwd', 500)->comment("mot de passe du compte");
            $table->string('email')->comment("email du compte");
            $table->string('username')->unique()->comment("nom utilisateur du compte, UNIQUE pour la distinction des acomptes ayant le même login");

            $table->string('description', 500)->nullable()->comment("description du compte");

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
