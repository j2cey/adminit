<?php

use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicRowsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'dynamic_rows';
    public $table_comment = 'dynamic rows.';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->integer('line_num')->comment('line number');

            $table->timestamp('firstinserted_at')->comment('first value inserted date');
            $table->timestamp('lastinserted_at')->nullable()->comment('last value inserted date');

            $table->string('hasdynamicrow_type')->comment('referenced value row');
            $table->bigInteger('hasdynamicrow_id')->comment('referenced value row id');

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
