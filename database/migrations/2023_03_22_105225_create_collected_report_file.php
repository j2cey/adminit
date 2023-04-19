<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateCollectedReportFile extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'collected_report_files';
    public string $table_comment = 'liste des rapports de fichiers collectés';

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

            $table->integer('nb_rows')->default(0)->comment("total rows");
            $table->integer('nb_rows_import_success')->default(0)->comment("total number of rows successfully imported");
            $table->integer('nb_rows_import_failed')->default(0)->comment("total number of rows import failed");
            $table->integer('nb_rows_import_processing')->default(0)->comment("total number of rows import processing");
            $table->integer('nb_rows_import_processed')->default(0)->comment("total number of rows import processed");
            $table->integer('row_last_import_processed')->default(0)->comment("last line import processed");
            $table->integer('nb_import_try')->default(0)->comment("number of import processing attempts");

            $table->boolean('imported')->default(false)->comment("determine if the file has already been imported into DB");
            $table->integer('import_processing')->default(0)->comment("determine if the file import is processing");

            $table->json('lines_values')->nullable()->comment('all lines values for this file');

            $table->integer('nb_rows_format_success')->default(0)->comment("total number of rows successfully formatted");
            $table->integer('nb_rows_format_failed')->default(0)->comment("total number of rows format failed");
            $table->integer('nb_rows_format_processing')->default(0)->comment("total number of rows format processing");
            $table->integer('nb_rows_format_processed')->default(0)->comment("total number of rows format processed");
            $table->integer('row_last_format_processed')->default(0)->comment("last line format processed");
            $table->integer('nb_format_try')->default(0)->comment("number of format processing attempts");

            $table->boolean('formatted')->default(false)->comment("determine if the file has already been formatted");
            $table->integer('format_processing')->default(0)->comment("determine if the file format is processing");

            $table->integer('notification_processing')->default(0)->comment("determine if the file notification is processing");
            $table->integer('nb_notification_try')->default(0)->comment("number of notification processing attempts");
            $table->boolean('notified')->default(false)->comment("determine if the file has already been notified");
            $table->timestamp('last_notification_success')->nullable()->comment("last notification success date");
            $table->timestamp('last_notification_failed')->nullable()->comment("last notification failed date");

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
