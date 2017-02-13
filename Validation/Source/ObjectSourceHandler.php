<?php
namespace ImmediateSolutions\Support\Validation\Source;

use ImmediateSolutions\Support\Validation\SourceHandlerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ObjectSourceHandler implements SourceHandlerInterface
{
	/**
	 * @var object
	 */
	private $object;


	/**
	 * @param object $object
	 */
	public function __construct($object)
	{
		$this->object = $object;
	}

	/**
	 * @return object
	 */
	public function getSource()
	{
		return $this->object;
	}

	/**
	 * @param string $property
	 * @return mixed
	 */
	public function getValue($property)
	{
        return PropertyAccess::createPropertyAccessor()
            ->getValue($this->object, $property);
    }

	/**
	 * @param string $property
	 * @return bool
	 */
	public function hasProperty($property)
	{
        if ($this->getValue($property) !== null){
            return true;
        }

        if ($this->object === null){
            return false;
        }

        $path = explode('.', $property);

        $property = array_pop($path);

        $accessor = PropertyAccess::createPropertyAccessor();

        $object = $this->object;

        foreach ($path as $segment){
            $object = $accessor->getValue($object, $segment);

            if (!is_object($object)){
                return false;
            }
        }

        if ($object instanceof ClearableAwareInterface){
            return $object->isClearable($property);
        }

        return false;
	}
}