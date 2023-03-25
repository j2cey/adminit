<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateComparisonTypesTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'comparison_types';
    public string $table_comment = 'comparison types';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('label')->comment('the comparison type label');
            $table->string('code')->comment('the comparison type code');
            $table->string('inner_comparison_class')->comment('the inner comparison class name');
            $table->string('description')->nullable()->comment('the comparison type description');

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
