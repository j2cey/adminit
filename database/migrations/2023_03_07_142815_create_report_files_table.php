<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReportFilesTable extends Migration
{

    use BaseMigrationTrait;

    public $table_name = 'report_files';
    public $table_comment = 'liste des fichiers';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment("nom du fichier");
            $table->string('wildcard')->nullable()->comment("caractère générique du fichier");
            $table->boolean('retrieve_by_name')->default(false)->comment("Indique si le fichier doit être retrouvé par/ou en utilisant le nom");
            $table->boolean('retrieve_by_wildcard')->default(false)->comment("Indique si le fichier doit être retrouvé par/ou en utilisant le caractère générique");

            $table->string('description', 500)->nullable()->comment("description du fichier");

            $table->foreignId('report_file_type_id')->nullable()
                ->comment('clé reférence du report_file_type')
                ->constrained('report_file_types')->onDelete('set null');

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
            //$table->dropForeign(['report_file_type_id']);

            /** Make sure to put this condition to check if driver is SQLite */
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropBaseForeigns();
                $table->dropForeign(['report_file_type_id']);
            }

            //$table->dropColumn(['report_file_type_id']);
        });

        Schema::dropIfExists($this->table_name);
    }

}
