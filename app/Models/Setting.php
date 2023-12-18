<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ReflexiveRelationship\HasReflexivePath;

/**
 * Class Setting
 * @package App\Models
 *
 * @property integer $id
 * @property string $group_id
 * @property string $name
 * @property string|null $full_path
 * @property string|null $value
 * @property string $type
 * @property string $array_sep
 * @property string|null $description
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Setting|null $group
 *
 * @property mixed $typed_value
 *
 * @method static Setting create(array $data)
 */
class Setting extends Model implements Auditable
{
    use HasFactory, HasReflexivePath, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $with = ['maingroup','group'];

    public static $SETTINGTYPES = [
        [
            'label' => "string", 'value' => "string", 'parserFunc' => "getParsedStringValue", 'validationRule' => "required|string"
        ],
        [
            'label' => "integer", 'value' => "integer", 'parserFunc' => "getParsedIntegerValue", 'validationRule' => "required|integer"
        ],
        [
            'label' => "bool", 'value' => "bool", 'parserFunc' => "getParsedBoolValue", 'validationRule' => "required|boolean"
        ],
        [
            'label' => "float", 'value' => "float", 'parserFunc' => "getParsedFloatValue", 'validationRule' => "required|integer"
        ],
        [
            'label' => "array", 'value' => "array", 'parserFunc' => "getParsedArrayValue", 'validationRule' => "required|string"
        ],
    ];

    #region Validation Tools

    public static function defaultRules($type,$value) {
        $rules = [
            'name' => ['required'],
            'type' => ['required'],
            'value' => "",
        ];
        if ( ! is_null($value) ) {
            $settingtype = self::getSettingType($type);
            $rules['value'] = $settingtype['validationRule'];
        }
        return $rules;
    }
    public static function createRules($type,$value)  {
        return array_merge(self::defaultRules($type,$value), [

        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules($model->type,$model->value), [

        ]);
    }
    public static function validationMessages() {
        return [];
    }

    #endregion

    #region Relationships

    public function maingroup() {
        return $this->belongsTo(Setting::class, "main_group_id");
    }

    public function group() {
        return $this->belongsTo(Setting::class, "group_id");
    }

    public function mainsubsettings() {
        return $this->hasMany(Setting::class, 'main_group_id');
    }

    public function subsettings() {
        return $this->hasMany(Setting::class, 'group_id');
    }

    #endregion

    #region Custom Functions

    /**
     * @param string $name
     * @param Setting|null $group
     * @param $value
     * @param $type
     * @param string $array_sep
     * @param $description
     * @return Setting
     */
    public static function createNew(string $name, Setting $group = null, $value = null, $type = null, string $array_sep = ",", $description = null): Setting
    {
        $data = ['name' => $name, 'array_sep' => $array_sep];

        if (!is_null($value)) {
            $data['value'] = $value;
        }
        if (!is_null($type)) {
            $data['type'] = $type;
        }
        if (!is_null($description)) {
            $data['description'] = $description;
        }
        $setting = Setting::create($data);

        if (!is_null($group)) {
            $setting->setGroup($group);
            $setting->setMainGroup($group);
        }

        return $setting;
    }

    public function updateThis($value, $type, $array_sep, $group, $description) {
        $this->value = $value;
        $this->type = $type;
        $this->array_sep = $array_sep;
        $this->description = $description;

        $this->setGroup($group);
        $this->setMainGroup($group);
        $this->save();

        return $this;
    }

    public static function getAllGrouped() {
        try {
            /*$collection = Setting::all()->groupBy('group');
            foreach ($collection as $group => $coll) {
                foreach ($coll as $sett) {
                    $final_array[$group][$sett->name] = self::getParsedValue($sett);
                }
            }*/

            $all_settings = Setting::all()->toArray();
            $tree_settings = self::buildTree($all_settings);
            $final_array = self::cleanTree($tree_settings);

            return $final_array;
        } catch (\Exception $e) {
            return [];
        }
    }

    public static function buildTree(array $elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['group_id'] == $parentId) {
                $children = self::buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element['name']] = $element;
            }
        }

        return $branch;
    }

    public static function cleanTree($tree) {
        $final_tree = [];
        foreach ($tree as $key => $item) {
            if (isset($item['children'])) {
                $final_tree[$key]['default'] = $item['value'];
                $final_tree[$item['name']] = self::cleanTree($item['children']);
            } else {
                $final_tree[$key] = isset($item['value']) ? self::getParsedValue($item) : $item;
            }
        }
        return $final_tree;
    }

    public function getTypedValueAttribute() {
        return $this->getParsedValue($this);
    }

    public static function getParsedValue($setting) {
        $type = self::getSettingType($setting['type']);
        // call the type parser function from a string stored in the variable 'parserFunc'
        return self::{$type['parserFunc']}($setting);
    }

    private static function getParsedStringValue($setting) {
        if ($setting['value'] === null) {
            return $setting['value'];
        }
        return $setting['value'];
    }
    private static function getParsedIntegerValue($setting) {
        if ($setting['value'] === null) {
            return $setting['value'];
        }
        return (int)$setting['value'];
    }
    private static function getParsedBoolValue($setting) {
        if ($setting['value'] === null) {
            return $setting['value'];
        }
        if ($setting['value'] == "true") {
            return true;
        }
        if ($setting['value'] == "false") {
            return false;
        }
        return (bool)$setting['value'];
    }
    private static function getParsedFloatValue($setting) {
        if ($setting['value'] === null) {
            return $setting['value'];
        }
        return (float)$setting['value'];
    }
    private static function getParsedArrayValue($setting) {
        if ($setting['value'] === null) {
            return $setting['value'];
        }
        return explode($setting['array_sep'], $setting['value']);
    }

    public static function getSettingType($type) {
        foreach (self::$SETTINGTYPES as $SETTINGTYPE) {
            if ($SETTINGTYPE['value'] === $type) {
                return $SETTINGTYPE;
            }
        }
        return null;
    }

    public function setMainGroup(Setting $group = null, $save = true) : Setting {

        $maingroup = $this->getMainGroup($group);

        if ( is_null($maingroup) ) {
            $this->maingroup()->disassociate();
        } else {
            $this->maingroup()->associate($maingroup);
        }

        if ($save) { $this->save(); }

        return $this;
    }

    public function setGroup(Setting $group = null, $save = true) : Setting {
        if ( is_null($group) ) {
            $this->group()->disassociate();
        } else {
            $this->group()->associate($group);
        }

        if ($save) { $this->save(); }

        return $this;
    }

    /**
     * @param Setting|null $group
     * @return Setting|mixed|null
     */
    public function getMainGroup(Setting $group = null) {
        if ( is_null($group) ) {
            return null;
        }
        $maingroup = $group;
        $next_group = $group->group;
        while ( ! is_null($next_group) ) {
            $maingroup = $next_group;
            $next_group = $maingroup->group;
        }
        return $maingroup;
    }

    /**
     * @return Setting|null
     */
    public static function getByFullPath(string $value) {
        return Setting::where('full_path', $value)->first();
    }

    /**
     * @return Setting|null
     */
    public static function getTreatmentActivate() {
        return Setting::where('full_path', "reporttreatment.activate")->first();
    }

    /**
     * @return Setting|null
     */
    public static function getQueueWorkerBounds(string $queuecode) {
        return Setting::where('full_path', 'queues.workersbounds.' . $queuecode)->first();
    }

    public static function setTreatmentActivate(bool $activate) {
        $setting = Setting::getTreatmentActivate();
        if ($setting) {
            $value = $activate ? "1" : "0";
            $setting->update([
                'value' => $value
            ]);
        }
    }

    #endregion

    public function getReflexiveChildrenRelationName(): string
    {
        return "subsettings";
    }

    public static function getReflexiveParentIdField(): string
    {
        return "group_id";
    }

    public static function getTitleField(): string
    {
        return "name";
    }

    public static function getReflexiveFullPathField(): string
    {
        return "full_path";
    }

    public static function getReflexivePathSeparator(): string
    {
        return ".";
    }
}
