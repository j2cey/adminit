<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateFormattedValueHtmlsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'formatted_value_htmls';
    public string $table_comment = 'Values in html format';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->longText('rawvalue')->nullable()->comment('raw value');
            $table->longText('htmlvalue')->nullable()->comment('html value');
            $table->string('maintag')->nullable()->comment('main html tag');
            $table->json('applied_style_attributes')->nullable()->comment('applied style attributes values');
            $table->json('applied_weight_tags')->nullable()->comment('applied weight tags');
            $table->string('comment', 500)->nullable()->comment('the value s comment.');

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
