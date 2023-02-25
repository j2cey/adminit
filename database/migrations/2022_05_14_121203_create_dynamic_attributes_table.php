<?php

use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicAttributesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'dynamic_attributes';
    public $table_comment = 'list of dynamic attributes.';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment('name of the attribute');
            $table->string('description')->nullable()->comment('description of the attribute');

            $table->foreignId('dynamic_attribute_type_id')->nullable()
                ->comment('dynamic attribute type reference')
                ->constrained()->onDelete('set null');

            $table->string('hasdynamicattribute_type')->comment('referenced model (class name)');
            $table->bigInteger('hasdynamicattribute_id')->comment('referenced model id (object id)');

            $table->string('num_ord')->comment('number order');
            $table->integer('offset')->default(0)->comment('offset if any');
            $table->integer('max_length')->default(0)->comment('max length if any');

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
            $table->dropForeign(['dynamic_attribute_type_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
