<?php

namespace App\Contracts\FileHeader;

use App\Models\Status;
use App\Models\FileHeader\FileHeader;

interface IHasFileHeader
{
    public function fileheader();
    public function setFileheader(string $title = null, Status $status = null, string $description = null): ?FileHeader;
}
