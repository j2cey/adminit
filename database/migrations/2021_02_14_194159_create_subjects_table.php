<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateSubjectsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'subjects';
    public $table_comment = 'list of subjects';

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

            $table->string('title')->comment('title of the subject');
            $table->string('full_path')->nullable()->comment('full path of the subject');
            $table->string('code')->unique()->comment('subject unique code');
            $table->string('description')->nullable()->comment('description of the subject');

            $table->foreignId('subject_parent_id')->nullable()
                ->comment('subject parent reference')
                ->constrained('subjects')->onDelete('set null');

            $table->integer('subsubject_posi')->default(0)->comment('subject position in sub subjects s subjects list');

            $table->foreignId('category_id')->nullable()
                ->comment('category reference')
                ->constrained('categories')->onDelete('set null');

            $table->integer('category_posi')->default(0)->comment('subject position in category subjects list');
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
            $table->dropForeign(['subject_parent_id']);
            $table->dropForeign(['category_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
