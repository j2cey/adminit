<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateFileHeadersTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'file_headers';
    public string $table_comment = 'file headers an object can have';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable()->comment('title');
            $table->string('description', 500)->nullable()->comment('the description .');

            $table->string('hasfileheader_type')->nullable()->comment('referenced file header owner s model (class name)');
            $table->bigInteger('hasfileheader_id')->nullable()->comment('referenced file header owner s model id (object id)');

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
