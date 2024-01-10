<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateFormattingResultsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'formatting_results';
    public string $table_comment = 'formatting results';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->timestamp('start_at')->nullable()->comment('formatting start date');

            $table->integer('posi')->nullable()->comment("formatting item position");
            $table->integer('nb_to_format')->nullable()->comment("number of items to be formatted");
            $table->integer('nb_formatting_success')->default(0)->comment("number of items successfully formatted");
            $table->decimal('formatting_success_rate')->default(0)->comment("rate of items successfully formatted");
            $table->integer('last_formatting_success')->nullable()->comment("last item successfully formatted");
            $table->integer('nb_formatting_failed')->nullable()->comment("number of items formatting failed");
            $table->decimal('formatting_failed_rate')->nullable()->comment("rate of items formatting failed");
            $table->integer('last_formatting_failed')->default(0)->comment("last item formatting failed");
            $table->integer('last_formatted')->nullable()->comment("last item formatted");
            $table->integer('nb_being_formatted')->nullable()->comment("number of items being formatted");
            $table->integer('nb_formatted')->nullable()->comment("number of items formatted");

            $table->integer('attempts')->default(0)->comment("number of formatting attempts");
            $table->integer('attempts_session_count')->nullable()->comment('attempts number for current session');

            $table->decimal('min_formatted_success_rate')->default(false)->comment("(min) success rate to determine if whole formatting is success");
            $table->boolean('formatted')->default(false)->comment("determine if formatting have been done with success");
            $table->boolean('formatting_done')->default(false)->comment("determine if whole formatting have already been done");
            $table->timestamp('end_at')->nullable()->comment('formatting end date');
            $table->integer('duration')->nullable()->comment('formatting duration');
            $table->string('duration_hhmmss')->nullable()->comment('formatting duration in hh:mm:ss format');

            $table->string('last_failed_message')->nullable()->comment('last failed message');
            $table->boolean('merging_ready')->default(false)->comment("determine if merging ready");

            $table->string('formattable_type')->nullable()->comment('referenced formatted object model (class name)');
            $table->bigInteger('formattable_id')->nullable()->comment('referenced formatted object model id (object id)');

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
        });
        Schema::dropIfExists($this->table_name);
    }
}
