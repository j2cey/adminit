<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateMatchedanalysisrulesTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'matchedanalysisrules';
    public string $table_comment = 'list of matched analysis rules for a given model';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->foreignId('analysis_rule_id')->nullable()
                ->comment('analysis rules reference')
                ->constrained('analysis_rules')->onDelete('set null');

            $table->string('matchedanalysisrule_type')->nullable()->comment('referenced matched analysis rule owner s model (class name)');
            $table->bigInteger('matchedanalysisrule_id')->nullable()->comment('referenced fmatched analysis rule owner s model id (object id)');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropForeign(['analysis_rule_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
