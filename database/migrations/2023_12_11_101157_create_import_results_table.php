<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateImportResultsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'import_results';
    public string $table_comment = 'import results';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->timestamp('start_at')->nullable()->comment('import start date');

            $table->integer('posi')->nullable()->comment("import item position");
            $table->integer('nb_to_import')->default(0)->comment("number of items to be imported");
            $table->integer('nb_import_success')->default(0)->comment("number of items successfully imported");
            $table->decimal('import_success_rate')->default(0)->comment("rate of items successfully imported");
            $table->integer('last_import_success')->nullable()->comment("last item successfully imported");
            $table->integer('nb_import_failed')->default(0)->comment("number of items import failed");
            $table->decimal('import_failed_rate')->default(0)->comment("number of items import failed");
            $table->integer('last_import_failed')->nullable()->comment("last item import failed");
            $table->integer('last_import')->nullable()->comment("last item imported");
            $table->integer('nb_being_imported')->nullable()->comment("number of items being imported");
            $table->integer('nb_imported')->nullable()->comment("number of items imported");

            $table->integer('attempts')->default(0)->comment("number of import attempts");
            $table->integer('attempts_session_count')->nullable()->comment('attempts number for current session');

            $table->decimal('min_imported_success_rate')->default(false)->comment("(min) success rate to determine if whole import is success");
            $table->boolean('imported')->default(false)->comment("determine if whole import have been done with success");
            $table->boolean('import_done')->default(false)->comment("determine if whole import have already been done");
            $table->timestamp('end_at')->nullable()->comment('import end date');
            $table->integer('duration')->nullable()->comment('import duration');
            $table->string('duration_hhmmss')->nullable()->comment('import duration in hh:mm:ss format');

            $table->string('last_failed_message')->nullable()->comment('last failed message');

            $table->string('importable_type')->nullable()->comment('referenced Imported object model (class name)');
            $table->bigInteger('importable_id')->nullable()->comment('referenced Imported object model id (object id)');

            $table->baseFields();
        });
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
