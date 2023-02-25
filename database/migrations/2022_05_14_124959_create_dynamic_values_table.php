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

            $table->foreignId('dynamic_row_id')->nullable()
                ->comment('dynamic value row reference')
                ->constrained()->onDelete('set null');

            $table->string('hasdynamicvalue_type')->comment('referenced value');
            $table->bigInteger('hasdynamicvalue_id')->comment('referenced value id');

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
        });
        Schema::dropIfExists($this->table_name);
    }
}
