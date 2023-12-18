<?php

namespace App\Contracts\Import;

use App\Models\Import\ImportResult;

/**
 * @property bool $isImported
 * @property bool $isImportDone
 * @property ImportResult $importresult
 */
interface IIsImportable
{
    public function startingImport(int $nb_to_import, IIsImportable|null $upper_importable): ImportResult;
    public function itemImportSucceed(int $item);
    public function itemImportFailed(int $item, string $message);
    public function allImportSucceed();
    public function allImportFailed(string $message);
}
