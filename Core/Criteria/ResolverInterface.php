<?php
namespace ImmediateSolutions\Support\Core\Criteria;

use Doctrine\ORM\QueryBuilder;
/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ResolverInterface
{
    /**
     * @param Criteria $criteria
     * @return bool
     */
    public function canResolve(Criteria $criteria);

    /**
     * @param QueryBuilder $builder
     * @param Criteria $criteria
     * @return Join|null
     */
    public function resolve(QueryBuilder $builder, Criteria $criteria);
}