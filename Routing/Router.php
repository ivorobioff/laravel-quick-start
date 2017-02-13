<?php
namespace ImmediateSolutions\Support\Routing;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Router extends \Illuminate\Routing\Router
{
    /**
     * @var array
     */
    private $aliases;

    /**
     * @return array
     */
    public function getAliases()
    {
        if ($this->aliases === null){
            $this->aliases = $this->container->make('config')->get('app.routing.patterns', []);
        }

        return $this->aliases;
    }

    /**
     * Create a new Route object.
     *
     * @param  array|string $methods
     * @param  string $uri
     * @param  mixed $action
     * @return \Illuminate\Routing\Route
     */
    protected function newRoute($methods, $uri, $action)
    {
        $route = new Route($methods, $uri, $action);
        $route->setAliases($this->getAliases());
        $route->setContainer($this->container);
        return $route;
    }

    /**
     * Add the necessary where clauses to the route based on its initial registration.
     *
     * @param  \Illuminate\Routing\Route $route
     * @return \Illuminate\Routing\Route
     */
    protected function addWhereClausesToRoute($route)
    {
        $nameConstraints = array_get($route->getAction(), 'where', []);

        foreach (array_diff($route->parameterNames(), array_keys($nameConstraints)) as $name) {
            $nameConstraints[$name] = '\\d+';
        }

        $route->where(array_merge(
            $nameConstraints,
            $this->patterns,
            array_get($route->getAction(), 'where', [])
        ));

        return $route;
    }

    /**
     * Route a resource to a controller.
     *
     * @param  string $name
     * @param  string $controller
     * @param  array $options
     * @return void
     */
    public function resource($name, $controller, array $options = [])
    {
        $registrar = new ResourceRegistrar($this);
        $registrar->register($name, $controller, $options);
    }
}