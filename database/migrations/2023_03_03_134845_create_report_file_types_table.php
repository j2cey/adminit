<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReportFileTypesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'report_file_types';
    public $table_comment = 'liste des types de fichiers';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment("nom du type de fichier");
            $table->string('extension')->unique()->comment("extension du type de fichier");
            $table->string('description', 500)->nullable()->comment("description du type de fichier");

            $table->foreignId('file_mime_type_id')->nullable()
                ->comment('clé reférence du file_mime_type')
                ->constrained('file_mime_types')->onDelete('set null');

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
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropBaseForeigns();

                $table->dropForeign(['file_mime_type_id']);
            }
        });
        Schema::dropIfExists($this->table_name);
    }
}
