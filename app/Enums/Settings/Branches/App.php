<?php

namespace App\Enums\Settings\Branches;

use App\Enums\Settings\SettingNode;

/**
 * Class App. Raw Application settings
 * @package App\Enums\Settings\Branches
 *
 * @method name()
 * @method version()
 */
class App extends SettingNode
{
    public function __construct()
    {
        parent::__construct("app",null,null,null,null,"Application Settings");

        $this->addChild("name", "GT-Esim", "string", "Application Name.");
        $this->addChild("version", "1.0", "string", "Application Version.");
    }
}
