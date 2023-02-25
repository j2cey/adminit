<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReportsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'reports';
    public $table_comment = 'list of reports.';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('title')->comment('report title');
            $table->string('description')->nullable()->comment('report description');

            $table->foreignId('report_type_id')->nullable()
                ->comment('report type reference')
                ->constrained()->onDelete('set null');

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
            $table->dropForeign(['report_type_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
