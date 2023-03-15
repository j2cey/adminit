<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReportServersTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'report_servers';
    public $table_comment = 'liste des rapports de serveurs';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment("nom du rapport de serveur");
            $table->string('ip_address')->unique()->comment("adresse ip du rapport de serveur");
            $table->string('domain_name')->unique()->comment("nom de domaine du rapport de serveur");
            $table->string('description', 500)->nullable()->comment("description du rapport de serveur");

            $table->foreignId('os_server_id')->nullable()
                ->comment('clé reférence du os_serveur')
                ->constrained('os_servers')->onDelete('set null');

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

                $table->dropForeign(['os_server_id']);
            }
        });
        Schema::dropIfExists($this->table_name);
    }
}
