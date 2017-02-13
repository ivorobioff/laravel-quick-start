<?php
namespace ImmediateSolutions\Support\Infrastructure\Doctrine\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface MetadataProviderInterface
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder);
}