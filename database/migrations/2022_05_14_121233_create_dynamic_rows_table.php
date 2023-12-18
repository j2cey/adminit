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

            $table->string('hasdynamicrow_type')->nullable()->comment('referenced value row');
            $table->bigInteger('hasdynamicrow_id')->nullable()->comment('referenced value row id');

            $table->json('columns_values')->nullable()->comment('all columns values for this line');
            $table->json('raw_value')->nullable()->comment('the line raw value');

            $table->boolean('is_imported')->default(0)->comment('determine whether the row is imported');
            $table->boolean('is_formatted')->default(0)->comment('determine whether the row is formatted');
            $table->boolean('is_merged')->default(0)->comment('determine whether the row is merged');
            $table->boolean('is_next_to_merge')->default(0)->comment('determine whether the row is the next one to be merged');

            $table->string('hasdynamicattributes_class')->nullable()->comment('referenced object which hold the attributes collection');
            $table->bigInteger('hasdynamicattributes_id')->nullable()->comment('referenced object ID which hold the attributes collection');

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
