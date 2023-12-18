<?php

namespace App\Helpers;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SymphonyProcess
{
    public static function runBackgroundArtisanCommand($command, $data): Process
    {
        $phpBinaryFinder = new PhpExecutableFinder();

        $phpBinaryPath = $phpBinaryFinder->find();

        $process = new Process([$phpBinaryPath, base_path('artisan'), $command, $data]); // (['php', 'artisan', 'foo:bar', 'json data'])

        //$process->setTimeout(0);
        //$process->disableOutput();

        $process->setoptions(['create_new_console' => true]); //Run process in background

        $process->start();

        return $process;
    }

    public static function runShellCommand(string $command): string
    {
        $process = Process::fromShellCommandline($command);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
