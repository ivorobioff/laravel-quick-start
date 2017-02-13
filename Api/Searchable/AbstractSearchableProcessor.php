<?php
namespace ImmediateSolutions\Support\Api\Searchable;

use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use ImmediateSolutions\Support\Core\Criteria\Constraint;
use ImmediateSolutions\Support\Core\Criteria\Criteria;
use ImmediateSolutions\Support\Api\Searchable\Resolvers\BoolResolver;
use ImmediateSolutions\Support\Api\Searchable\Resolvers\DateTimeResolver;
use ImmediateSolutions\Support\Api\Searchable\Resolvers\DayResolver;
use ImmediateSolutions\Support\Api\Searchable\Resolvers\EnumResolver;
use ImmediateSolutions\Support\Api\Searchable\Resolvers\IntResolver;
use RuntimeException;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractSearchableProcessor
{
	/**
	 * @var Criteria[]
	 */
	private $criteria;

    /**
     * @var array
     */
    private $data;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->request = $container->make(Request::class);
    }

    /**
     * @return array
     */
    protected function schema()
    {
        return [];
    }

    /**
     * @param string $path
     * @param mixed $default
     * @return mixed
     */
    public function get($path, $default = null)
    {
        return array_get($this->getData(), $path, $default);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if ($this->data === null){
            $this->data = parse_url_query($this->request->query->all());
        }

        return $this->data;
    }

    /**
     * @return Criteria[]
     */
    public function createCriteria()
    {
        $criteria = [];

        foreach ($this->schema() as $namespace => $fields) {
            if (! in_array($namespace, ['filter', 'search'])) {
                throw new RuntimeException('Unable to determine the namespace of the parameters.');
            }

            foreach ($fields as $field => $config) {

				$value = $this->get($namespace . '.' . $field);

				if (is_array($value)){
					continue ;
				}

				if (is_callable($config)){
					$c = call_user_func($config, $value);
				} else {
					$c = $this->tryCreateCriteriaByConfig($field, $value, $config);
				}

				if ($c === null){
					continue ;
				}

				$criteria[] = $c;
            }
        }

		if ($query = $this->get('query')){
			$criteria[] = new Criteria('query', new Constraint(Constraint::SIMILAR), $query);
		}

        return $criteria;
    }

	/**
	 * @return Criteria[]
	 */
	public function getCriteria()
	{
		if ($this->criteria === null){
			$this->criteria = $this->createCriteria();
		}

		return $this->criteria;
	}

	/**
	 * @param string $field
	 * @param mixed $value
	 * @param array $config
	 * @return Criteria|null
	 */
	private function tryCreateCriteriaByConfig($field, $value, $config)
	{
		$config = $this->resolveConfig($config, $value);
		$type =  array_get($config, 'type');

		if ($value === null && trim($value) === '') {
			return null;
		}

		if (is_array($type) && count($type) === 1 && isset($type[0])){
			$value = $this->resolveCollectionOfValues($value, $type[0]);
		} else {
			$value = $this->resolveValue($value, $type);
		}

		if ($value === null){
			return null ;
		}

		return new Criteria(array_get($config, 'map', $field), new Constraint($config['constraint']), $value);
	}

	/**
	 * @param mixed $value
	 * @param string|array|null $type
	 * @return mixed
	 */
	private function resolveValue($value, $type)
	{
		if ($type === null){
			return $value;
		}

		if (is_string($type)){
			$type = [$type];
		}

		$resolvers = [
			'datetime' => DateTimeResolver::class,
			'enum' => EnumResolver::class,
			'day' => DayResolver::class,
			'bool' => BoolResolver::class,
			'int' => IntResolver::class
		];

		$resolver = new $resolvers[array_shift($type)]();

		array_unshift($type, $value);

		if (!call_user_func_array([$resolver, 'isProcessable'], $type)){
			return null;
		}

		return call_user_func_array([$resolver, 'resolve'], $type);
	}

	/**
	 * @param string $values
	 * @param string|array|null $type
	 * @return array
	 */
	private function resolveCollectionOfValues($values, $type)
	{
		$values = explode(',', $values);

		$result = [];

		foreach ($values as $value){
			$value = $this->resolveValue($value, $type);

			if ($value === null){
				return null;
			}

			$result[] = $value;
		}

		return $result;
	}

	/**
	 * @param array|string|callable $source
	 * @param mixed $value
	 * @return array
	 */
	private function resolveConfig($source, $value)
	{
		if (is_array($source)){
			return $source;
		}

		if (is_string($source)){
			return [
				'constraint' => $source
			];
		}

		return $source($value);
	}
}