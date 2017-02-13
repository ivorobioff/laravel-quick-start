<?php
namespace ImmediateSolutions\Support\Infrastructure;
use ImmediateSolutions\Support\Core\Interfaces\ContainerInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Container implements ContainerInterface
{
    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    private $source;

    /**
     * @param \Illuminate\Contracts\Container\Container $source
     */
    public function __construct(\Illuminate\Contracts\Container\Container $source)
    {
        $this->source = $source;
    }

    /**
     * @param string $abstract
     * @return object
     */
    public function get($abstract)
    {
        return $this->source->make($abstract);
    }

    /**
     * @param string $abstract
     * @return bool
     */
    public function has($abstract)
    {
        return $this->source->bound($abstract);
    }

    /**
     * @param callable $callback
     * @param array $parameters
     * @return mixed
     */
    public function call($callback, array $parameters = [])
    {
        return $this->source->call($callback, $parameters);
    }
}