<?php
namespace ImmediateSolutions\Support\Core\Options;

use ImmediateSolutions\Support\Core\Criteria\Criteria;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait CriteriaAwareTrait
{
	/**
	 * @var Criteria[]
	 */
	private $criteria = [];

	/**
	 * @param Criteria[] $criteria
	 */
	public function setCriteria(array $criteria)
	{
		$this->criteria = $criteria;
	}

	/**
	 * @return Criteria[]
	 */
	public function getCriteria()
	{
		return $this->criteria;
	}
}