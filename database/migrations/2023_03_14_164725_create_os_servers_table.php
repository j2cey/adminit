<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateOsServersTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = "os_servers";
    public $table_comment = "liste des systèmes d exploitation.";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment("nom du système d exploitation");
            $table->string('description', 500)->nullable()->comment("description du système d exploitation");

            $table->foreignId('os_architecture_id')->nullable()
                ->comment('clé de reférence de l os_architecture')
                ->constrained('os_architectures')->onDelete('set null');


            $table->foreignId('os_family_id')->nullable()
                ->comment('clé de reférence de l os_family')
                ->constrained('os_families')->onDelete('set null');

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

                $table->dropForeign(['os_architecture_id']);
                $table->dropForeign(['os_family_id']);
            }
        });
        Schema::dropIfExists($this->table_name);
    }
}
