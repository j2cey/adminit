<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateFormattedValuesTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'formatted_values';
    public string $table_comment = 'formatted values';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable()->comment('title of the formatted value');
            $table->longText('header')->nullable()->comment('the header value');
            $table->longText('body')->nullable()->comment('the body value');
            $table->longText('footer')->nullable()->comment('the footer value');
            $table->string('description')->nullable()->comment('formatted value description');

            $table->foreignId('format_type_id')->nullable()
                ->comment('format type reference')
                ->constrained()->onDelete('set null');

            $table->string('hasformattedvalue_type')->nullable()->comment('referenced formatted value owner s model (class name)');
            $table->bigInteger('hasformattedvalue_id')->nullable()->comment('referenced formatted value owner s model id (object id)');

            $table->string('innerformattedvalue_type')->nullable()->comment('referenced inner formatted value model (class name)');
            $table->bigInteger('innerformattedvalue_id')->nullable()->comment('referenced inner formatted value model id (object id)');

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
            $table->dropForeign(['format_type_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
