<?php
namespace ImmediateSolutions\Support\Core\Options;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait PaginationAwareTrait
{
	/**
	 * @var PaginationOptions
	 */
	private $pagination;

	/**
	 * @param PaginationOptions $options
	 */
	public function setPagination(PaginationOptions $options)
	{
		$this->pagination = $options;
	}

	/**
	 * @return PaginationOptions
	 */
	public function getPagination()
	{
		if ($this->pagination === null){
			$this->pagination = new PaginationOptions();
		}

		return $this->pagination;
	}
}