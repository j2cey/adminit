<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReportTreatmentWorkflowsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'report_treatment_workflows';
    public string $table_comment = 'treatment workflow for a Report';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable()->comment('workflow name');
            $table->string('description', 500)->nullable()->comment('workflow description');

            $table->foreignId('report_id')->nullable()
                ->comment('report reference')
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
            $table->dropForeign(['report_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
