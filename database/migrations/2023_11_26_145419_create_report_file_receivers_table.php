<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReportFileReceiversTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'report_file_receivers';
    public string $table_comment = 'report file receivers';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->foreignId('report_file_id')->nullable()
                ->comment('report file reference')
                ->constrained()->onDelete('set null');

            $table->foreignId('person_id')->nullable()
                ->comment('person reference')
                ->constrained()->onDelete('set null');

            $table->foreignId('email_address_id')->nullable()
                ->comment('email address reference')
                ->constrained()->onDelete('set null');

            $table->foreignId('phone_number_id')->nullable()
                ->comment('phone number reference')
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
            $table->dropForeign(['report_file_id']);
            $table->dropForeign(['person_id']);
            $table->dropForeign(['email_address_id']);
            $table->dropForeign(['phone_number_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
