<?php

namespace App\Traits\FileHeader;

use App\Models\Status;
use App\Models\FileHeader\FileHeader;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property FileHeader $fileheader
 */
trait HasFileHeader
{
    /**
     * @return MorphOne
     */
    public function fileheader()
    {
        return $this->morphOne(FileHeader::class, 'hasfileheader');
    }

    public function setFileheader(string $title = null, Status $status = null, string $description = null): ?FileHeader {
        $data = [];
        if ( ! is_null($title) ) $data['title'] = $title;
        if ( ! is_null($description) ) $data['description'] = $description;
        if ( is_null( $this->fileheader ) ) {
            $fileheader = FileHeader::createNew($data);

            $this->fileheader()->save($fileheader);

            if ( ! is_null($status) ) $fileheader->status()->associate($status);

            return $fileheader;
        }
        return null;
    }
}
