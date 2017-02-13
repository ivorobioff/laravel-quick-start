<?php
namespace ImmediateSolutions\Support\Core\Service;

use Doctrine\ORM\EntityManagerInterface;
use ImmediateSolutions\Support\Core\Interfaces\ContainerInterface;
use Psr\Log\LoggerInterface;
use ImmediateSolutions\Support\Validation\Source\ClearableAwareInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractService
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**container
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->entityManager = $container->get(EntityManagerInterface::class);

        if ($container->has(LoggerInterface::class)){
            $this->logger = $container->get(LoggerInterface::class);
        }

        if (method_exists($this, 'initialize')) {
            $this->container->call([$this, 'initialize']);
        }
    }

    /**
     * @param object $source
     * @param object $target
     * @param string $property
     * @param callable $modifier
     */
    protected function transfer($source, $target, $property, callable $modifier = null)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $value = $accessor->getValue($source, $property);

        if ($value !== null
            || ($source instanceof ClearableAwareInterface && $source->isClearable($property))){

            if ($modifier !== null){
                $value = $modifier($value);
            }

            $accessor->setValue($target, $property, $value);
        }
    }
}