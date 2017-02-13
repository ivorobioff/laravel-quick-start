<?php
namespace ImmediateSolutions\Support\Core\Criteria;

use Doctrine\ORM\QueryBuilder;
use RuntimeException;
use ImmediateSolutions\Support\Core\Criteria\Sorting\Sorter;
use ImmediateSolutions\Support\Core\Criteria\Sorting\ResolverInterface as SortingResolverInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Filter extends Mutator
{
    /**
     * @param QueryBuilder $builder
     * @param Criteria[] $criteria
     * @param ResolverInterface $resolver
	 * @return $this
     */
    public function apply(QueryBuilder $builder, array $criteria, ResolverInterface $resolver)
    {
        foreach ($criteria as $single) {
            $this->resolve($builder, $single, $resolver);
        }

        $this->applyJoins($builder);

		return $this;
    }

    /**
     * @param QueryBuilder $builder
     * @param Criteria $criteria
     * @param ResolverInterface $resolver
     */
    private function resolve(QueryBuilder $builder, Criteria $criteria, ResolverInterface $resolver)
    {
		if ($resolver->canResolve($criteria)) {
			$result = $resolver->resolve($builder, $criteria);

			$this->processResult($result);

			return;
		}

        throw new RuntimeException(
			'Unable to resolve the criteria with the "'.$criteria->getConstraint()
			.'" constraint and the "'.$criteria->getProperty().'" property.'
		);
    }

	/**
	 * @param QueryBuilder $builder
	 * @param array $sortables
	 * @param SortingResolverInterface $resolver
	 */
	public function withSorter(QueryBuilder $builder, array $sortables, SortingResolverInterface $resolver)
	{
		(new Sorter($this->context))->apply($builder, $sortables, $resolver);
	}
}