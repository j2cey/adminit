<?php


namespace App\Traits\Request;

use App\Models\User;
use App\Models\Status;
use App\Models\Reports\Report;
use Spatie\Permission\Models\Role;
use App\Models\Reports\ReportType;
use App\Models\Access\AccessAccount;
use App\Models\OsAndServer\OsServer;
use App\Models\OsAndServer\OsFamily;
use App\Models\ReportFile\ReportFile;
use App\Models\Access\AccessProtocole;
use App\Models\ReportFile\FileMimeType;
use App\Models\OsAndServer\ReportServer;
use App\Models\ReportFile\ReportFileType;
use App\Models\AnalysisRules\AnalysisRule;
use App\Models\OsAndServer\OsArchitecture;
use App\Models\AnalysisRules\ThresholdType;
use App\Models\AnalysisRules\AnalysisRuleType;
use App\Models\RetrieveAction\RetrieveActionType;
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
        return is_string($value) ? json_decode($value, true) : $value;
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

    /**
     * Retourne un objet FileMimeType en fonction d'un champs donné
     * @param $value
     * @param string $field
     * @param bool $json_decode_before
     * @return FileMimeType|null
     */
    public function setRelevantFileMimeType($value, string $field = 'íd', bool $json_decode_before = false): ?FileMimeType
    {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? FileMimeType::where($field, $value[$field])->first() : null;
    }

    /**
     * Retourne un objet ReportFileType en fonction d'un champs donné
     * @param $value
     * @param string $field
     * @param bool $json_decode_before
     * @return ReportFileType|null
     */
    public function setRelevantReportFileType($value, string $field = 'íd', bool $json_decode_before = false): ?ReportFileType
    {
        if (is_null($value)) {
            return null;
        }

        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? ReportFileType::where($field, $value[$field])->first() : null;
    }

    /**
     * Retourne un objet ReportFileType en fonction d'un champs donné
     * @param $value
     * @param string $field
     * @param bool $json_decode_before
     * @return ReportFile|null
     */
    public function setRelevantReportFile($value, string $field = 'íd', bool $json_decode_before = false): ?ReportFile
    {
        if (is_null($value)) {
            return null;
        }

        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? ReportFile::where($field, $value[$field])->first() : null;
    }

    /**
     * Retourne un objet Report en fonction d'un champs donné
     * @param $value
     * @param string $field
     * @param bool $json_decode_before
     * @return Report|null
     */
    public function setRelevantReport($value, string $field = 'íd', bool $json_decode_before = false): ?Report
    {
        if (is_null($value)) {
            return null;
        }

        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? Report::where($field, $value[$field])->first() : null;
    }

    /**
     * Retourne un objet Report en fonction d'un champs donné
     * @param $value
     * @param string $field
     * @param bool $json_decode_before
     * @return ReportServer|null
     */
    public function setRelevantReportServer($value, string $field = 'íd', bool $json_decode_before = false): ?ReportServer
    {
        if (is_null($value)) {
            return null;
        }

        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? ReportServer::where($field, $value[$field])->first() : null;
    }

    /**
     * Retourne un objet OsArchitecture en fonction d'un champs donné
     * @param $value
     * @param string $field
     * @param bool $json_decode_before
     * @return OsArchitecture|null
     */
    public function setRelevantOsArchitecture($value, string $field = 'íd', bool $json_decode_before = false): ?OsArchitecture
    {
        if (is_null($value)) {
            return null;
        }

        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? OsArchitecture::where($field, $value[$field])->first() : null;
    }

    /**
     * Retourne un objet OsServer en fonction d'un champs donné
     * @param $value
     * @param string $field
     * @param bool $json_decode_before
     * @return OsServer|null
     */
    public function setRelevantOsServer($value, string $field = 'íd', bool $json_decode_before = false): ?OsServer
    {
        if (is_null($value)) {
            return null;
        }

        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? OsServer::where($field, $value[$field])->first() : null;
    }

    /**
     * Retourne un objet OsFamily en fonction d'un champs donné
     * @param $value
     * @param string $field
     * @param bool $json_decode_before
     * @return OsFamily|null
     */
    public function setRelevantOsFamily($value, string $field = 'íd', bool $json_decode_before = false): ?OsFamily
    {
        if (is_null($value)) {
            return null;
        }

        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? OsFamily::where($field, $value[$field])->first() : null;
    }

    /**
     * Retourne un objet OsFamily en fonction d'un champs donné
     * @param $value
     * @param string $field
     * @param bool $json_decode_before
     * @return AccessProtocole|null
     */
    public function setRelevantAccessProtocole($value, string $field = 'íd', bool $json_decode_before = false): ?AccessProtocole
    {
        if (is_null($value)) {
            return null;
        }

        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? AccessProtocole::where($field, $value[$field])->first() : null;
    }

    /**
     * Retourne un objet OsFamily en fonction d'un champs donné
     * @param $value
     * @param string $field
     * @param bool $json_decode_before
     * @return AccessAccount|null
     */
    public function setRelevantAccessAccount($value, string $field = 'íd', bool $json_decode_before = false): ?AccessAccount
    {
        if (is_null($value)) {
            return null;
        }

        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? AccessAccount::where($field, $value[$field])->first() : null;
    }

    /**
     * Retourne un objet OsFamily en fonction d'un champs donné
     * @param $value
     * @param string $field
     * @param bool $json_decode_before
     * @return RetrieveActionType|null
     */
    public function setRelevantRetrieveActionType($value, string $field = 'íd', bool $json_decode_before = false): ?RetrieveActionType
    {
        if (is_null($value)) {
            return null;
        }

        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? RetrieveActionType::where($field, $value[$field])->first() : null;
    }
}
