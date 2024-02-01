<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateNotificationResultsTable extends Migration
{
    use BaseMigrationTrait;

    public string $table_name = 'notification_results';
    public string $table_comment = 'notification results';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->timestamp('start_at')->nullable()->comment('notification start date');

            $table->string('notification_type')->nullable()->comment("notification type");
            $table->integer('posi')->nullable()->comment("notification item position");
            $table->integer('nb_to_notify')->default(0)->comment("number of items to be notified");
            $table->integer('nb_notification_success')->default(0)->comment("number of items successfully notified");
            $table->decimal('notification_success_rate')->default(0)->comment("rate of items successfully notified");
            $table->integer('last_notification_success')->nullable()->comment("last item successfully notified");
            $table->integer('nb_notification_failed')->nullable()->comment("number of items notification failed");
            $table->decimal('notification_failed_rate')->nullable()->comment("rate of items notification failed");
            $table->integer('last_notification_failed')->default(0)->comment("last item notification failed");
            $table->integer('last_notified')->nullable()->comment("last item notified");
            $table->integer('nb_being_notified')->nullable()->comment("number of items being notified");
            $table->integer('nb_notified')->nullable()->comment("number of items notified");

            $table->integer('attempts')->default(0)->comment("number of notification attempts");
            $table->integer('attempts_session_count')->nullable()->comment('attempts number for current session');

            $table->decimal('min_notified_success_rate')->default(false)->comment("(min) success rate to determine if whole notification is success");
            $table->boolean('notified')->default(false)->comment("determine if notification have been done with success");
            $table->boolean('notification_done')->default(false)->comment("determine if whole notification have already been done");
            $table->timestamp('end_at')->nullable()->comment('notification end date');
            $table->integer('duration')->nullable()->comment('notification duration');
            $table->string('duration_hhmmss')->nullable()->comment('notification duration in hh:mm:ss format');

            $table->string('last_failed_message')->nullable()->comment('last failed message');

            $table->string('notifiable_type')->nullable()->comment('referenced notified object model (class name)');
            $table->bigInteger('notifiable_id')->nullable()->comment('referenced notified object model id (object id)');

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
