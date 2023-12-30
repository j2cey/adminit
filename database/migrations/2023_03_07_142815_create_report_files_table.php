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
            $table->string('label')->comment("libellé du fichier");
            $table->string('wildcard')->nullable()->comment("caractère générique du fichier");

            $table->string('remotedir_relative_path')->nullable()->comment("chemin relatif du fichier sur le serveur distant");
            $table->string('remotedir_absolute_path')->nullable()->comment("chemin absolu du fichier sur le serveur distant");
            $table->string('use_file_extension')->default(true)->comment("détermine si l extension du fichier doit être utilisé");
            $table->string('has_headers')->default(true)->comment("détermine si le fichier a les en-têtes en première ligne");

            $table->json('attributes_list')->nullable()->comment('all report dynamicattributes');

            $table->string('description', 500)->nullable()->comment("description du fichier");

            $table->foreignId('report_file_type_id')->nullable()
                ->comment('clé reférence du report_file_type')
                ->constrained('report_file_types')->onDelete('set null');


            $table->foreignId('report_id')->nullable()
                ->comment('clé reférence du report')
                ->constrained('reports')->onDelete('set null');

            $table->bigInteger('hasselectedretrieveaction_id')->nullable()->comment('referenced elected retrieve action owner s model id (object id)');
            $table->string('hasselectedretrieveaction_type')->nullable()->comment('referenced selected retrieve action owner s model (class name)');

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
                $table->dropForeign(['report_file_type_id']);
                $table->dropForeign(['report_id']);
            }
        });
        Schema::dropIfExists($this->table_name);
    }

}
