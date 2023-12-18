<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateLaunchedJobsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'launched_jobs';
    public string $table_comment = 'launched jobs';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string('job_id')->nullable()->comment('the job ID');

            $table->foreignId('job_launcher_id')->nullable()
                ->comment('job_launcher reference')
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

            $table->dropForeign(['job_launcher_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
