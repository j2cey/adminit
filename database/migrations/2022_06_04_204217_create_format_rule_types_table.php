<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateFormatRuleTypesTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'format_rule_types';
    public string $table_comment = 'format rule types';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment('name of the format rule type');
            $table->string('code')->comment('code of the format rule type');
            $table->string('model_type')->comment('referenced model (class name)');
            $table->string('view_name')->comment('name view of the inner format rule');
            $table->string('description')->nullable()->comment('format rule type description');

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
