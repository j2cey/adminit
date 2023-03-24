<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Migrations\BaseMigrationTrait;

class CollectedReportFile extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'collected_report_files';
    public $table_comment = 'liste des rapports de fichiers collectés';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('initial_file_name')->comment("nom initial du rapport du fichier");
            $table->string('local_file_name')->comment("nom local du rapport du fichier collecté");
            $table->string('file_size')->comment("Taille du rapport du fichier collecté");
            $table->string('description', 500)->nullable()->comment("description du type de fichier");

            $table->foreignId('report_file_id')->nullable()
                ->comment('clé reférence du report_file')
                ->constrained('report_files')->onDelete('set null');

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

                $table->dropForeign(['report_file_id']);
            }
        });
        Schema::dropIfExists($this->table_name);
    }
}
