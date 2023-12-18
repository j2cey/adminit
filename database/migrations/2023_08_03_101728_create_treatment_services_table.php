<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateTreatmentServicesTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'treatment_services';
    public string $table_comment = 'treatment services';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->integer('exec_id')->default(0)->comment('execution id');
            $table->string('queue_code')->nullable()->index()->comment('queue code');
            $table->string('serviceactions_class')->comment('chemin complet de la classe ServiceActions (qui va implémenter l interface IServiceActions)');
            $table->string('description', 500)->nullable()->comment('description');

            $table->foreignId('report_file_id')->nullable()
                ->comment('report_file reference')
                ->constrained()->onDelete('set null');

            $table->foreignId('collected_report_file_id')->nullable()
                ->comment('collected_report_file reference')
                ->constrained()->onDelete('set null');

            $table->foreignId('dynamic_row_id')->nullable()
                ->comment('dynamic_row reference')
                ->constrained()->onDelete('set null');

            $table->foreignId('dynamic_value_id')->nullable()
                ->comment('dynamic_value reference')
                ->constrained()->onDelete('set null');

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
            $table->dropBaseForeigns();

            $table->dropForeign(['report_file_id']);
            $table->dropForeign(['collected_report_file_id']);
            $table->dropForeign(['dynamic_row_id']);
            $table->dropForeign(['dynamic_value_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
