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
 * @property integer|null $queuecode_index
 * @property string|null $queue_name
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

    #endregion

    #region Custom Functions

    public static function createNew(QueueEnum $queuecode, int $queuecode_index): JobLauncher {
        return JobLauncher::create([
            'queuecode' => $queuecode->value,
            'queuecode_index' => $queuecode_index,
            'queue_name' => self::getQueueName($queuecode, $queuecode_index),
        ]);
    }

    /**
     * @return $this
     */
    public function increaseJobsCount() {
        /*$this->jobs_count++;
        $this->save();*/

        return $this;
    }
    public function decreaseJobsCount() {
        /*if ($this->jobs_count > 0) {
            $this->jobs_count--;
            $this->save();
        }*/

        return $this;
    }

    public static function getLauncher(QueueEnum $queuecode): JobLauncher
    {
        $queuecode_value = $queuecode->value;
        $worker_bounds = Settings::Queues()->workerbounds()->$queuecode_value()->get();
        $launchers = JobLauncher::where('queuecode', $queuecode->value)
            ->orderBy('total', 'asc')
            ->select('queuecode','queuecode_index', DB::raw('count(*) as total'))
            ->groupBy('queuecode','queuecode_index')
            ->pluck('total', 'queuecode_index')->all();

        if ( count( $launchers ) == 0 ) {
            return JobLauncher::createNew($queuecode, $worker_bounds[0]);
        }

        $current_sel[0] = $worker_bounds[0];
        if ( array_key_exists($current_sel[0], $launchers) ) {
            $current_sel[1] = $launchers[$current_sel[0]];
        } else {
            $current_sel[1] = 0;
        }

        for ($i = $worker_bounds[0]; $i <= $worker_bounds[1]; $i++) {
            if ( array_key_exists($i, $launchers) ) {
                $current_sel = self::selectNextLauncherIndex($current_sel, [$i,$launchers[$i]], false, false);
            } else {
                $current_sel = self::selectNextLauncherIndex($current_sel, [$i,0], false, false);
            }
        }

        return JobLauncher::createNew($queuecode, $current_sel[0]);
    }

    /**
     * @param array $current_sel current selected [index, count]
     * @param array $to_sel next to select [index, count]
     * @param bool $index_greater determine if the greater or the lesser have to be selected
     * @param bool $count_greater
     * @return array
     */
    private static function selectNextLauncherIndex(array $current_sel, array $to_sel, bool $index_greater, bool $count_greater): array
    {
        if ( $count_greater ) {
            if ($to_sel[1] > $current_sel[1]) {
                return $to_sel;
            }
        } else {
            if ($to_sel[1] < $current_sel[1]) {
                return $to_sel;
            }
        }

        if ( $index_greater ) {
            return $to_sel[0] > $current_sel[0] ? $to_sel : $current_sel;
        }

        return $to_sel[0] < $current_sel[0] ? $to_sel : $current_sel;
    }

    /**
     * @param QueueEnum $queuecode
     * @return JobLauncher
     */
    public static function getLauncher_old(QueueEnum $queuecode)
    {
        $queuecode_value = $queuecode->value;
        $worker_bounds = Settings::Queues()->workerbounds()->$queuecode_value()->get();
        $query = JobLauncher::query()
            ->where('queuecode', $queuecode->value)
            ->whereBetween('queuecode_index', [$worker_bounds[0], $worker_bounds[1]])
            ->orderBy('jobs_count', 'asc');

        $launcher = null;

        $launcher = self::getLauncherWithoutTransactionLock($query, $queuecode);

        //return $launcher->increaseJobsCount();

        return $launcher;
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

    private static function getLauncherWithoutTransactionLock($query, $queuecode): JobLauncher
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

    private static function getQueueName(QueueEnum $queuecode, int $queuecode_index): string
    {
        return $queuecode->value . "_" . $queuecode_index;
    }

    /**
     * @param $id
     * @return JobLauncher|null
     */
    public static function getById($id): ?JobLauncher
    {
        return JobLauncher::where('id', $id)->first();
    }

    #endregion

    public static function boot()
    {
        parent::boot();

        /*self::deleting(function ($model) {
            $model->launchedjobs()->each(function($launchedjob) {
                $launchedjob->delete(); // <-- direct deletion
            });
        });*/
    }
}
