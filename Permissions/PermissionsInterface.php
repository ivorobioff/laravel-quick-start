<?php
namespace ImmediateSolutions\Support\Permissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface PermissionsInterface
{
    /**
     * @param string|array $protectors
     * @return bool
     */
    public function has($protectors);

    /**
     * @param array $protectors
     */
    public function globals(array $protectors);
}