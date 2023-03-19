<?php

namespace App\Traits\Permissions;

use App\Enums\Permissions;

trait HasPermissions
{
    public function __call($name, $args)
    {
        $class = get_class();
        $class = basename(str_replace('\\', '/', $class));
        $action = str_replace('can_', '', $name);
        return Permissions::$class()->$action();
    }
}
