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
    public function importresult();
    public function setImportResult();

    public function addToImport(int $amount);
    public function startingImport(int|null $nb_to_import): ImportResult;

    public function itemImportSucceed(int $item);
    public function itemImportFailed(int $item, string $message);
    public function allImportSucceed();
    public function allImportFailed(string $message);
}
