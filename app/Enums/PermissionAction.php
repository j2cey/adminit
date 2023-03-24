<?php

namespace App\Enums;

/**
 * @method list()
 * @method create()
 * @method update()
 * @method delete()
 */
class PermissionAction
{

    private array $_actions = [
        'list' => 4,
        'create' => 3,
        'update' => 1,
        'delete' => 1,
    ];
    private string $_permissionkey;

    /**
     * @param string $permissionkey La clé de la permission
     * @param array|null $customlevels Levels modifiés: ['nom action' => level]
     * @param array|null $additionalactions Actions supplémentaires: ['nom action' => level]
     */
    public function __construct(string $permissionkey, array $customlevels = null, array $additionalactions = null)
    {
        $this->_permissionkey = $permissionkey;
        $this->setCustomLevels($customlevels);
        if ( ! is_null($additionalactions) ) {
            $this->_actions = array_merge( $this->_actions, $additionalactions );
        }
    }

    private function setCustomLevels($customlevels)
    {
        if ( ! empty($customlevels) ) {
            foreach ($this->_actions as $action => $level) {
                if (array_key_exists($action, $customlevels)) {
                    $this->_actions[$action] = $customlevels[$action];
                }
            }
        }
    }

    private function getPermission($action, $full_permission)
    {
        $permission = $this->_permissionkey . "-" . $action;
        if ($full_permission) {
            $action_level = $this->_actions[$action];
            return [$permission, $action_level];
        } else {
            return $permission;
        }
    }

    /**
     * @return array
     */
    public function getAllPermissions(): array
    {
        $permissions = [];
        foreach (array_keys($this->_actions) as $action) {
            $permissions[] = $this->getPermission($action, true);
        }
        return $permissions;
    }

    public function __call($name, $args)
    {
        if (in_array($name, array_keys($this->_actions))) {
            return $this->getPermission($name, false);
        }
    }
}
