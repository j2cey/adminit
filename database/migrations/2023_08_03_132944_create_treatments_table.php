<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateTreatmentsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'treatments';
    public string $table_comment = 'report treatments';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable()->comment('treatment name');
            $table->string('type')->nullable()->index()->comment('treatment type: [main, step, operation]');
            $table->string('treatmenttype_class')->comment('chemin complet de la classe TreatmentType (qui va implémenter l interface ITreatmentType)');
            $table->string('code')->nullable()->index()->comment('treatment code: [downloadfile, importfile, formatdata, notifyreport, ...]');
            $table->integer('level')->default(0)->comment('treatment level');
            $table->integer('exec_id')->comment('execution id');
            $table->longText('exectrace')->nullable();
            $table->integer('num_ord')->default(0)->comment('order number');
            $table->string('criticality_level')->nullable()->index()->comment('treatment criticality level: [High, Medium, Low]');
            $table->string('prev_state')->nullable()->index()->comment('treatment previous state: [waiting, queued, starting, running, ending, completed]');
            $table->string('state')->nullable()->index()->comment('treatment state: [waiting, queued, starting, running, ending, completed]');

            $table->boolean('is_last_subtreatment')->default(false)->comment('determine if all sub-treatments are launched');
            $table->boolean('can_end_uppertreatment')->default(false)->comment('determine if this treatment can end upper (parent) treatment');
            $table->boolean('all_subtreatments_launched')->default(false)->comment('determine if all sub-treatments are launched');
            $table->boolean('all_subtreatments_completed')->default(false)->comment('determine if all sub-treatments are completed');
            $table->boolean('dispatch_on_creation')->default(false)->comment('determine if the treatment must be dispatched on creation');
            $table->boolean('launch_exec_operation_on_creation')->default(false)->comment('determine if the treatment (step) must launch exec operation on creation');
            $table->boolean('dispatch_exec_operation_on_creation')->default(false)->comment('determine if the treatment (step) must dispatch exec operation on creation');
            //$table->string('subs_dispatch_mode')->nullable()->index()->comment('queue mode for subs dispatching');

            $table->longText('payload')->nullable();
            $table->longText('innertreatments')->nullable();
            $table->string('description', 500)->nullable()->comment('treatment description');

            /**
             * Start end End Treatment
             */
            $table->timestamp('start_at')->nullable()->comment('treatment start date');
            $table->timestamp('end_at')->nullable()->comment('treatment end date');
            $table->integer('duration')->nullable()->comment('treatment duration');
            $table->string('duration_hhmmss')->nullable()->comment('treatment duration in hh:mm:ss format');

            /**
             * Attempts
             */

            $table->integer('attempts')->default(0)->comment('number of attempts');
            $table->timestamp('retry_start_at')->nullable()->comment('treatment retry start date');
            $table->integer('retries_session_count')->nullable()->comment('retry count for current session');
            $table->timestamp('retry_end_at')->nullable()->comment('treatment retry end date');

            /**
             * Stages
             */

            $table->integer('current_stage')->nullable()->comment('current stage');
            $table->integer('stages_count')->nullable()->comment('number of stages to be executed by this treatment');
            $table->string('full_path')->nullable()->comment('treatment full path');

            /**
             * Relationships
             */

            $table->foreignId('report_file_id')->nullable()
                ->comment('report file reference')
                ->constrained()->onDelete('set null');

            $table->foreignId('current_result_id')->nullable()
                ->comment('treatment (last) result reference')
                ->constrained('treatment_results')->onDelete('set null');

            $table->foreignId('treatment_service_id')->nullable()
                ->comment('treatment service reference')
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
            $table->dropForeign(['current_result_id']);
            $table->dropForeign(['treatment_service_id']);

            $table->dropForeign(['collected_report_file_id']);
            $table->dropForeign(['dynamic_row_id']);
            $table->dropForeign(['dynamic_value_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
