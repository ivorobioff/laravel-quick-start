<?php
namespace ImmediateSolutions\Support\Permissions;

/**
 * Abstract class for all permissions classes.
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected abstract function permissions();

    /**
     * @param string $action
     * @return array|string
     */
    public function getProtectors($action)
    {
        return array_get($this->permissions(), $action, []);
    }
} 