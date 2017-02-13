<?php
namespace ImmediateSolutions\Support\Routing;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ResourceRegistrar extends \Illuminate\Routing\ResourceRegistrar
{
    /**
     * Get the action array for a resource route.
     *
     * @param  string $resource
     * @param  string $controller
     * @param  string $method
     * @param  array $options
     * @return array
     */
    protected function getResourceAction($resource, $controller, $method, $options)
    {
        $action = parent::getResourceAction($resource, $controller, $method, $options);

        $action['where'] = [];

        foreach (array_get($options, 'where', []) as $key => $regex) {
            $action['where'][snake_case($key)] = $regex;
        }

        return $action;
    }
}