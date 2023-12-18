<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateEmailAddressesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'email_addresses';
    public $table_comment = 'List of email addresses in the System';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('email')->comment('the email address');
            $table->integer('posi')->default(0)->comment('the email address position in email address s list.');

            $table->string('hasemailaddress_type')->comment('referenced email address owner class');
            $table->bigInteger('hasemailaddress_id')->comment('referenced email address owner objet ID');

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
