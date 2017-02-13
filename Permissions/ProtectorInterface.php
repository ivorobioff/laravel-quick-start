<?php
namespace ImmediateSolutions\Support\Permissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ProtectorInterface
{
    /**
     * @return bool
     */
    public function grants();
}