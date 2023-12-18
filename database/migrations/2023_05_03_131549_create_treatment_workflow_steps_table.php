<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateTreatmentWorkflowStepsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'treatment_workflow_steps';
    public string $table_comment = 'treatment workflow steps for a treatment workflow';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('code')->comment('workflow step code');
            //$table->string('treatmentservice_class')->comment('chemin complet de la classe service de traitement du step (qui va implémenter l interface ITreatmentStepService)');
            $table->string('name')->nullable()->comment('workflow step name');
            $table->string('criticality_level')->nullable()->index()->comment('treatment step criticality level: [High, Medium, Low]');
            $table->string('description', 500)->nullable()->comment('workflow step description');

            $table->foreignId('workflow_id')->nullable()
                ->comment('report treatment workflow reference')
                ->constrained('treatment_workflows')->onDelete('set null');

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
            $table->dropForeign(['workflow_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
