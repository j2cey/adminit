<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateLastRowConfigsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'last_row_configs';
    public string $table_comment = 'list of last row configurations';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->boolean('ref_by_row_num')->default(false)->comment("determine if the last row is referenced by row number");
            $table->integer('row_num')->nullable()->comment("row num value, when referenced by row num");

            $table->boolean('ref_by_attribute_value')->default(false)->comment("determine if the last row is referenced by attribute value");
            $table->string('attribute_value')->nullable()->comment("attribute value, when referenced by attribute value");

            $table->foreignId('dynamic_attribute_id')->nullable()
                ->comment('dynamic attribute reference')
                ->constrained('dynamic_attributes')->onDelete('set null');

            $table->string('haslastrowconfig_type')->nullable()->comment('referenced last row config s owner model (class name)');
            $table->bigInteger('haslastrowconfig_id')->nullable()->comment('referenced last row config s owner model id (object id)');

            $table->string('description', 500)->nullable()->comment('description');

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
            $table->dropForeign(['dynamic_attribute_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
