<?php

namespace App\Enums\Settings\Branches;

use App\Enums\Settings\SettingNode;

/**
 * Class Files. Files settings
 * @package App\Enums\Settings\Branches
 *
 * @method uploads()
 */
class Files extends SettingNode
{
    public function __construct()
    {
        parent::__construct("files",null,null,null,null,"settings Files.");

        $uploads_maxsize = $this->addChild("uploads", null, null, "Uploads.")
            ->addChild("max_size", null, null, "Max Size.");
        $uploads_maxsize->addChild("any", "10", "integer", "Any file Max size.");
        $uploads_maxsize->addChild("image", "5", "integer", "Image file Max size.");
        $uploads_maxsize->addChild("video", "5", "integer", "Video file Max size.");
    }
}
