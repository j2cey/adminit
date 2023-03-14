<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateOsArchitecturesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = "os_architectures";
    public $table_comment = "liste des architectures de systèmes d exploitation.";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment("nom de l architecture");
            $table->string('code')->unique()->comment("code de l architecture");

            $table->string('description', 500)->nullable()->comment("description l architecture");

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
