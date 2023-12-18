<?php

namespace App\Models;

use App\Enums\Settings;
use App\Jobs\SystemLogJob;

class SystemLog
{
    private static function launchLog(string $logtype, string $message, bool $can_log) {
        dispatch(new SystemLogJob($logtype, $message, $can_log));
    }

    public static function execLog(string $logtype, string $message, bool $can_log) {
        if ($can_log) {
            switch ($logtype) {
                case "info":
                    \Log::info($message);
                    break;
                case "warning":
                    \Log::warning($message);
                    break;
                case "error":
                    \Log::error($message);
                    break;
                default:
                    \Log::error("ERROR SystemLog. Bad log type !");
            }
        }
    }

    public static function info(string $message, bool $can_log) {
        self::launchLog("info", $message, $can_log);
    }
    public static function warning(string $message, bool $can_log) {
        self::launchLog("warning", $message, $can_log);
    }
    public static function error(string $message, bool $can_log) {
        self::launchLog("error", $message, $can_log);
    }

    public static function infoTreatments(string $message, $part) {
        self::info($message, Settings::LogTreatments()->$part()->info()->get());
    }

    public static function errorTreatments(string $message, $part) {
        self::error($message, Settings::LogTreatments()->$part()->error()->get());
    }
}
