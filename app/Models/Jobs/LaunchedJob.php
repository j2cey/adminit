<?php

namespace App\Models\Jobs;

use App\Enums\QueueEnum;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class JobLauncher
 * @package App\Models\Jobs
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $job_id
 * @property integer|null $job_launcher_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property JobLauncher $joblauncher
 */
class LaunchedJob extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $casts = [
        'queuecode' => QueueEnum::class,
    ];

    #region Validation Rules

    public static function defaultRules() {
        return [
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [
        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [
        ]);
    }

    public static function messagesRules() {
        return [
        ];
    }

    #endregion

    #region Eloquent Relationships

    public function joblauncher() {
        return $this->belongsTo(JobLauncher::class, "job_launcher_id");
    }

    #endregion

    #region Custom Functions

    public static function createNew(string $job_id, JobLauncher|Model $joblauncher = null): LaunchedJob {
        $launchedjob = LaunchedJob::create([
            'job_id' => $job_id,
        ]);

        if ( ! is_null($joblauncher) ) $launchedjob->joblauncher()->associate($joblauncher)->save();

        return $launchedjob;
    }

    public function removeFromLauncher() {
        $this->joblauncher->decreaseJobsCount();
        $this->joblauncher()->dissociate();
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            $model->removeFromLauncher();
        });
    }
}
