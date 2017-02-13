<?php
namespace ImmediateSolutions\Support\Infrastructure\Doctrine;

use Doctrine\DBAL\Types\Type;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractType extends Type
{
    /**
     * @return string
     */
    public function getName()
    {
        return get_called_class();
    }
}