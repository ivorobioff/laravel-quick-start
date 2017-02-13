<?php
namespace ImmediateSolutions\Support\Core\Interfaces;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ContainerInterface
{
    /**
     * @param string $abstract
     * @return object
     */
    public function get($abstract);

    /**
     * @param string $abstract
     * @return bool
     */
    public function has($abstract);

    /**
     * @param callable $callback
     * @param array $parameters
     * @return mixed
     */
    public function call($callback, array $parameters = []);
}