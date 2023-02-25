<?php


namespace App\Traits\Request;

use App\Models\User;
use App\Models\Status;
use Spatie\Permission\Models\Role;
use App\Models\Reports\ReportType;
use App\Models\AnalysisRules\AnalysisRule;
use App\Models\AnalysisRules\ThresholdType;
use App\Models\AnalysisRules\AnalysisRuleType;
use App\Models\DynamicAttributes\DynamicAttribute;
use App\Models\AnalysisRules\AnalysisHighlightType;
use App\Models\DynamicAttributes\DynamicAttributeType;

trait RequestTraits
{
    public function getCheckValue($field) {
        $formInput = $this->all();
        if (array_key_exists($field, $formInput)) {
            if (is_null($formInput[$field])) {
                return 0;
            } else {
                return ($formInput[$field] === "true" || $formInput[$field] === "1" || $formInput[$field] === true) ? 1 : 0;
            }
        } else {
            return 0;
        }
    }

    /**
     * @param $value
     * @return mixed
     */
    public function decodeJsonField($value) {
        return json_decode($value, true);
    }

    public function setRelevantRole($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? Role::where('id', $value['id'])->first() : null;
    }

    public function setCheckOrOptionValue($value) {
        if (is_null($value) || $value === "null") {
            $value = null;
        }
        if ($value === "true") {
            $value = true;
        }
        if ($value === "false") {
            $value = false;
        }
        return intval($value);
    }

    public function setRelevantUser($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? User::where('id', $value['id'])->first() : null;
    }

    public function setRelevantReportType($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? ReportType::where('id', $value['id'])->first() : null;
    }

    public function setRelevantDynamicAttributeType($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? DynamicAttributeType::where('id', $value['id'])->first() : null;
    }

    public function setRelevantDynamicAttribute($value, $field = 'íd', $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? DynamicAttribute::where($field, $value[$field])->first() : null;
    }

    public function setAnalysisRuleType($value, $field = 'íd', $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? AnalysisRuleType::where($field, $value[$field])->first() : null;
    }

    public function setAnalysisRule($value, $field = 'íd', $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? AnalysisRule::where($field, $value[$field])->first() : null;
    }

    public function setRelevantThresholdType($value, $field = 'íd', $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? ThresholdType::where($field, $value[$field])->first() : null;
    }

    public function setAnalysisHighlightType($value, $field = 'íd', $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? AnalysisHighlightType::where($field, $value[$field])->first() : null;
    }

    public function setRelevantStatus($value, $field = 'íd', $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? Status::where($field, $value[$field])->first() : null;
    }

    public function setRelevantIdsList($value, $json_decode_before = false) {
        if (is_null($value) || empty($value)) {
            return null;
        }

        if ($json_decode_before) {
            $value = $this->decodeJsonField($value);
        }
        if (is_null($value) || empty($value)) {
            return null;
        }

        $ids = [];
        foreach ($value as $item) {
            $ids[] = $item['id'];
        }
        return $ids;
    }
}
