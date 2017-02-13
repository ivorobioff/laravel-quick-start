<?php
namespace ImmediateSolutions\Support\Permissions;

use Illuminate\Contracts\Container\Container;
use RuntimeException;

/**
 * Provides access to the permissions layer within controllers
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Permissions implements PermissionsInterface
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var array
     */
    private $globals = [];

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string|array $protectors
     * @return bool
     * @throws RuntimeException
     */
    public function has($protectors)
    {
        if (!is_array($protectors)) {
            $protectors = [$protectors];
        }

        foreach ($protectors as $protector) {

            $options = [];

            if (is_array($protector)){
                $options = array_get($protector, 1, []);
                $protector = $protector[0];
            }

            if (class_exists($protector)){
                $class = $protector;
            } else{
                $class = array_get($this->globals, $protector);
            }

            if (!$class){
                throw new RuntimeException('Unable to retrieve class for the "'.$protector.'" protector.');
            }

            $instance = $this->container->make($class);

            if (!$instance instanceof ProtectorInterface){
                throw new RuntimeException('The instance of "'.$class.'" must be instance of ProtectorInterface.');
            }

            if ($instance instanceof OptionsExpectableInterface){
                $instance->setOptions($options);
            }

            if ($instance->grants()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $protectors
     */
    public function globals(array $protectors)
    {
        $this->globals = $protectors;
    }
}