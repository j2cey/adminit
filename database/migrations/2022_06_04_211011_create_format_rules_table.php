<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateFormatRulesTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'format_rules';
    public string $table_comment = 'format rules';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('title')->comment('title of the format rule');
            $table->integer('num_ord')->nullable()->comment('format rule s num order');
            $table->string('rule_result')->comment('format rule result for which this format rule is applied: [allowed, broken]');
            $table->string('description')->nullable()->comment('format rule description');

            $table->foreignId('format_rule_type_id')->nullable()
                ->comment('rule format type reference')
                ->constrained()->onDelete('set null');

            $table->string('hasformatrule_type')->nullable()->comment('referenced format rule owner s model (class name)');
            $table->bigInteger('hasformatrule_id')->nullable()->comment('referenced format rule owner s model id (object id)');

            $table->string('innerformatrule_type')->nullable()->comment('referenced inner format rule model (class name)');
            $table->bigInteger('innerformatrule_id')->nullable()->comment('referenced inner format rule model id (object id)');

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
            $table->dropForeign(['format_rule_type_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
