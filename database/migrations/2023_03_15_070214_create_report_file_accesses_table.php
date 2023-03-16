<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReportFileAccessesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = "report_file_accesses";
    public $table_comment = "liste des accès configurés pour un fichier donné.";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment("nom de l accès");
            $table->string('code')->unique()->comment("code de l accès");

            $table->boolean('retrieve_by_name')->default(false)->comment("Indique si le fichier doit être retrouvé par/ou en utilisant le nom");
            $table->boolean('retrieve_by_wildcard')->default(false)->comment("Indique si le fichier doit être retrouvé par/ou en utilisant le caractère générique");

            $table->string('description', 500)->nullable()->comment("description de l accès");

            $table->foreignId('report_file_id')->nullable()
                ->comment('clé de reférence du fichier')
                ->constrained('report_files')->onDelete('set null');

            $table->foreignId('access_account_id')->nullable()
                ->comment('clé de reférence du compte')
                ->constrained('access_accounts')->onDelete('set null');

            $table->foreignId('report_server_id')->nullable()
                ->comment('clé de reférence du server')
                ->constrained('report_servers')->onDelete('set null');

            $table->foreignId('access_protocole_id')->nullable()
                ->comment('clé de reférence du protocole')
                ->constrained('access_protocoles')->onDelete('set null');

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

                $table->dropForeign(['report_file_id']);
                $table->dropForeign(['access_account_id']);
                $table->dropForeign(['report_server_id']);
                $table->dropForeign(['access_protocole_id']);
            }
        });
        Schema::dropIfExists($this->table_name);
    }
}
