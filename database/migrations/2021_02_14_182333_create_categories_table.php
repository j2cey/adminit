<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateCategoriesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'categories';
    public $table_comment = 'categories of subjects';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->baseFields();

            $table->string('title')->comment('title of the category');
            $table->string('full_path')->nullable()->comment('full path of the category');
            $table->string('code')->unique()->comment('unique code');
            $table->string('description')->nullable()->comment('description of the category');

            $table->foreignId('category_parent_id')->nullable()
                ->comment('category parent reference')
                ->constrained('categories')->onDelete('set null');

            $table->integer('posi')->default(0)->comment('category position in sub categories list');
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
            $table->dropForeign(['category_parent_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
