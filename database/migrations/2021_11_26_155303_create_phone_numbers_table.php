<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreatePhoneNumbersTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'phone_numbers';
    public $table_comment = 'List of telephone numbers in the System';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('number')->comment('the phone number');
            $table->integer('posi')->default(0)->comment('the phone number position in phobne number s list.');

            $table->string('hasphonenumber_type')->comment('referenced phone number owner class');
            $table->bigInteger('hasphonenumber_id')->comment('referenced phone number owner objet ID');

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
