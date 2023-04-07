<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateFormatTextColorsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'format_text_colors';
    public string $table_comment = 'format rule text color';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('format_value')->default("#000000")->comment('the format value');
            $table->integer('alpha')->default(255)->comment('the alpha value');
            $table->integer('blue')->default(0)->comment('the blue value');
            $table->integer('green')->default(0)->comment('the green value');
            $table->integer('hue')->default(0)->comment('the hue value');
            $table->integer('lightness')->default(0)->comment('the lightness value');
            $table->integer('red')->default(0)->comment('the red value');
            $table->integer('saturation')->default(0)->comment('the saturation value');

            $table->string('comment')->nullable()->comment('format comment');

            $table->baseFields();
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
            $table->dropBaseForeigns();
        });
        Schema::dropIfExists($this->table_name);
    }
}
