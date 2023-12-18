<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;

class CreateDynamicValuesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'dynamic_values';
    public $table_comment = 'dynamic values wrapper.';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('raw_value')->nullable()->comment('the raw value');

            $table->foreignId('dynamic_row_id')->nullable()
                ->comment('dynamic value row reference')
                ->constrained()->onDelete('set null');

            $table->foreignId('dynamic_attribute_id')->nullable()
                ->comment('dynamic attribute reference')
                ->constrained()->onDelete('set null');

            $table->string('innerdynamicvalue_type')->nullable()->comment('referenced value');
            $table->bigInteger('innerdynamicvalue_id')->nullable()->comment('referenced value id');

            $table->boolean('is_imported')->default(0)->comment('determine whether the value is imported');
            $table->boolean('is_formatted')->default(0)->comment('determine whether the value is formatted');
            $table->boolean('is_merged')->default(0)->comment('determine whether the value is merged');
            $table->boolean('is_next_to_merge')->default(0)->comment('determine whether the value is the next one to be merged');

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
            $table->dropForeign(['dynamic_row_id']);
            $table->dropForeign(['dynamic_attribute_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
