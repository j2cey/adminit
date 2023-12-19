<?php

namespace App\Models\Jobs;

use App\Enums\Settings;
use App\Enums\QueueEnum;
use App\Models\BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
 * @property QueueEnum|string $queuecode
 * @property integer|null $jobs_count
 * @property integer|null $queuecode_index
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class JobLauncher extends BaseModel implements Auditable
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

    public function launchedjobs() {
        return $this->hasMany(LaunchedJob::class, "job_launcher_id");
    }

    #endregion

    #region Custom Functions

    public static function createNew(QueueEnum $queuecode, int $queuecode_index, int $jobs_count = null): JobLauncher {
        return JobLauncher::create([
            'queuecode' => $queuecode->value,
            'queuecode_index' => $queuecode_index,
            'jobs_count' => is_null($jobs_count) ? 0 : $jobs_count,
        ]);
    }

    /**
     * @return $this
     */
    public function increaseJobsCount() {
        $this->jobs_count++;
        $this->save();

        return $this;
    }
    public function decreaseJobsCount() {
        if ($this->jobs_count > 0) {
            $this->jobs_count--;
            $this->save();
        }

        return $this;
    }

    /**
     * @param QueueEnum $queuecode
     * @return JobLauncher
     */
    public static function getLauncher(QueueEnum $queuecode)
    {
        $queuecode_value = $queuecode->value;
        $worker_bounds = Settings::Queues()->workerbounds()->$queuecode_value()->get();
        $query = JobLauncher::query()
            ->where('queuecode', $queuecode->value)
            ->whereBetween('queuecode_index', [$worker_bounds[0], $worker_bounds[1]])
            ->orderBy('jobs_count', 'asc');

        $launcher = null;

        $launcher = self::getLauncherWithoutTransactionLock($query, $queuecode, $launcher);

        return $launcher->increaseJobsCount();
    }

    private static function getLauncherWithTransactionLock($query, $queuecode, &$launcher): JobLauncher
    {
        DB::transaction(function () use ($query, $queuecode, &$launcher) {
            $launcher_most_free = $query->first();

            if ($launcher_most_free) {
                $launcher = $launcher_most_free;// = $launcher_most_free->increaseJobsCount();
            } else {
                $queuecode_index = 1;
                $launcher = self::createNew($queuecode, $queuecode_index,1);
            }
        });

        return $launcher;
    }

    private static function getLauncherWithoutTransactionLock($query, $queuecode, &$launcher): JobLauncher
    {
        $launcher_most_free = $query->first();

        if ($launcher_most_free) {
            $launcher = $launcher_most_free;// = $launcher_most_free->increaseJobsCount();
        } else {
            $queuecode_index = 1;
            $launcher = self::createNew($queuecode, $queuecode_index,1);
        }
        return $launcher;
    }

    /**
     * @param string $job_id
     * @return LaunchedJob
     */
    public function addLaunchedJob(string $job_id): LaunchedJob
    {
        return LaunchedJob::createNew($job_id,$this);
    }

    public function removeLaunchedJob() {

    }

    public function getQueueName() {
        return $this->queuecode->value . "_" . $this->queuecode_index;
    }

    /**
     * @return JobLauncher|null
     */
    public static function getById($id) {
        return JobLauncher::where('id', $id)->first();
    }

    #endregion

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            $model->launchedjobs()->each(function($launchedjob) {
                $launchedjob->delete(); // <-- direct deletion
            });
        });
    }
}
