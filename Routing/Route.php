<?php
namespace ImmediateSolutions\Support\Routing;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Route extends \Illuminate\Routing\Route
{
    /**
     * @var array
     */
    private $aliases = [];

    /**
     * Set a regular expression requirement on the route.
     *
     * @param  array|string $name
     * @param  string $expression
     * @return $this
     */
    public function where($name, $expression = null)
    {
        foreach ($this->parseWhere($name, $expression) as $name => $expression) {
            $this->wheres[$name] = $this->getExpression($expression);
        }

        return $this;
    }

    /**
     * @param string $expression
     * @return string
     */
    private function getExpression($expression)
    {
        $matches = [];

        if (preg_match('/^\.\.\.(.+)/', $expression, $matches)) {
            $alias = $matches[1];

            return array_get($this->aliases, $alias, $expression);
        }

        return $expression;
    }

    /**
     * @param array $aliases
     */
    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
    }
}