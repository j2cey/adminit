<?php

namespace App\Models;

use Symfony\Component\Console\Output\ConsoleOutput;

class ConsoleLog
{
    private static function output(string $message) {
        $output = new ConsoleOutput();
        $output->writeln($message);
    }
    public static function info(string $message) {
        self::output($message);
    }
    public static function warning(string $message) {
        self::output("<warning>" . $message . "</warning>");
    }
    public static function error(string $message) {
        self::output("<error>" . $message . "</error>");
    }
}
