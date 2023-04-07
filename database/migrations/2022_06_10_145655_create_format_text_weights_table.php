<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateFormatTextWeightsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'format_text_weights';
    public string $table_comment = 'format rule text weight';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->json('format_value')->nullable()->comment('the format value');

            $table->boolean('format_bold')->default(0)->comment('the format bold value');
            $table->boolean('format_italic')->default(0)->comment('the format italic value');
            $table->boolean('format_underline')->default(0)->comment('the format underline value');
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
