<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ModelPicker
 * @package App\Models\ModelPickers
 *
 * @property integer $id
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 *
 * @property string $model_type
 * @property integer|null $model_id
 * @property string|null $description
 * @property string|null $selection_criteria
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int|null $status_id status reference
 * @property int|null $created_by user creator reference
 * @property int|null $updated_by user updator reference
 */
class ModelPicker extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    public static string $MODELPICKER_LOG_INFO_PART = "modelpicker";

    #region Validation Rules

    public static function defaultRules() {
        return [
            'model_type' => ['required'],
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

    #region Custom Functions

    /**
     * @param $model_type
     * @param $selection_criteria
     * @return ModelPicker|null
     */
    public static function pickModel($model_type, $selection_criteria)
    {
        $models_already_picked = ModelPicker::where('model_type', $model_type)->whereNotNull('model_id')->get()->pluck('model_id');

        $models_picker = new ModelPicker([
            'model_type' => $model_type,
            'selection_criteria' => json_encode($selection_criteria)
        ]);

        $query = $model_type::query()->whereNotIn('id', $models_already_picked);

        foreach ($selection_criteria as $criterion) {
            $query->where($criterion['field'], $criterion['value']);
        }

        DB::transaction(function () use ($query, $models_picker) {
            // get random model
            // TODO: setting pickup order (random, asc, desc)
            $new_model_picked = $query->inRandomOrder()->first();
            if ($new_model_picked) {
                $models_picker->model_id = $new_model_picked->id;
                $models_picker->save();
            } else {
                $models_picker->model_id = null;
            }
        });

        SystemLog::infoTreatments("pickModel " . $model_type . " - models_already_picked: " . $models_already_picked . " - picked: " . ( is_null($models_picker->model_id) ? "NO" : $models_picker->model_id ), self::$MODELPICKER_LOG_INFO_PART);

        return $models_picker->model_id == null ? null : $models_picker;
    }

    public function unpickModel() {
        return $this->delete();
    }

    /**
     * @param $model_type
     * @param $model_id
     * @return ModelPicker|null
     */
    public static function getPicker($model_type, $model_id) {
        return ModelPicker::where('model_type', $model_type)->where('model_id', $model_id)->first();
    }

    #endregion
}
