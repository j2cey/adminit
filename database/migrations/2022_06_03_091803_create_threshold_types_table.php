<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateThresholdTypesTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'threshold_types';
    public string $table_comment = 'threshold analysis rule types';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('label')->comment('the threshold type label');
            $table->string('code')->comment('the threshold type code');
            $table->string('inner_threshold_class')->comment('the inner threshold class name');
            $table->string('description')->nullable()->comment('the threshold type description');

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
