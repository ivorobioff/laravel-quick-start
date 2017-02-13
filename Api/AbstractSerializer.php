<?php
namespace ImmediateSolutions\Support\Api;
use Illuminate\Contracts\Container\Container;
use DateTime;
use ImmediateSolutions\Support\Other\Enum;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractSerializer
{
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
    }

    /**
     * @param string $serializer
     * @param object $object
     * @param $initializer
     */
    protected function delegate($serializer, $object, callable $initializer = null)
    {
        $serializer = $this->container->make($serializer);

        if ($initializer){
            $initializer($serializer);
        }

        return $serializer($object);
    }

    /**
     * @param DateTime $datetime
     * @return string
     */
    protected function datetime(DateTime $datetime = null)
    {
        if ($datetime === null){
            return $datetime;
        }

        return $datetime->format(DateTime::ATOM);
    }

    /**
     * @param Enum $enum
     * @return string|integer
     */
    protected function enum(Enum $enum = null)
    {
        if ($enum === null){
            return $enum;
        }

        return $enum->value();
    }
}