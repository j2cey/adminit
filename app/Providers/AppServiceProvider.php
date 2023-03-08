<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\Eloquent\SubjectRepository;
use App\Repositories\Contracts\IUserRepositoryContract;
use App\Repositories\Eloquent\ReportRepositoryContract;
use App\Repositories\Contracts\IReportRepositoryContract;
use App\Repositories\Contracts\ISubjectRepositoryContract;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\ParallelTesting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUserRepositoryContract::class, UserRepository::class);
        $this->app->bind(ISubjectRepositoryContract::class, SubjectRepository::class);
        $this->app->bind(IReportRepositoryContract::class, ReportRepositoryContract::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Laravel Macros are great way of extending Laravel's core classes and add extra functionality
         * required for our application.
         * It is a way to add somme missing functionality to Laravel's internal component with a piece of code
         * that doesn't exist in the Laravel class.
         *
         * Blueprint is macroable, so we can just define a macro on it in this service provider to get base fields
         */
        Blueprint::macro('baseFields', function () {
            $this->uuid('uuid');
            //$this->string('tags')->nullable()->comment('Tags, if any');
            $this->foreignId('status_id')->nullable()
                ->comment('status reference')
                ->constrained('statuses')->onDelete('set null');
            $this->boolean('is_default')->default(false)->comment('determine whether is the default one.');

            // foreign creator & updator user
            $this->foreignId('created_by')->nullable()
                ->comment('user creator reference')
                ->constrained('users')->onDelete('set null');

            $this->foreignId('updated_by')->nullable()
                ->comment('user updator reference')
                ->constrained('users')->onDelete('set null');

            $this->timestamps();
        });
        Blueprint::macro('dropBaseForeigns', function () {

            /** Make sure to put this condition to check if driver is SQLite */
            if (DB::getDriverName() !== 'sqlite') {
                $this->dropForeign(['status_id']);
                $this->dropForeign(['created_by']);
                $this->dropForeign(['updated_by']);
            }

            //$this->dropColumn(['status_id']);
            //$this->dropColumn(['created_by']);
            //$this->dropColumn(['updated_by']);
        });

        JsonResource::withoutWrapping();

        /**
         * tell Laravel that, when the App boots,
         * which is after all other Services are already registered,
         * we are gonna add to the config array our own settings
         */
        config([
            'Settings' => Setting::getAllGrouped()
        ]);

        /*Validator::extend('stepcanexpire_if', function($attribute, $value, $parameters, $validator) {
            $rule = new StepCanExpire($parameters[0]);

            return $rule->passes($attribute, $value);
        });*/

        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });

        // Executed when a test database is created...
        /*
        ParallelTesting::setUpTestDatabase(function ($database, $token) {
            Artisan::call('db:seed');
        });
        */
    }
}
