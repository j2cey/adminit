<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateFormatTextSizesTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'format_text_sizes';
    public string $table_comment = 'format rule for text size';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->integer('format_value')->default(7)->comment('the (size) format');
            $table->integer('min_value')->default(7)->comment('the min (size) value');
            $table->integer('max_value')->default(30)->comment('the max (size) value');

            $table->string('comment')->nullable()->comment('format comment');

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
