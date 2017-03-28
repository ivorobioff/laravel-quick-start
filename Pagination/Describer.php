<?php
namespace ImmediateSolutions\Support\Pagination;
use Illuminate\Http\Request;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Describer implements DescriberInterface
{
	/**
	 * @var Request
	 */
	private $request;

	/**
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	/**
	 * @return int
	 */
	public function getCurrentPage()
	{
		$page = array_get($this->request->query->all(), 'page', 1);

		return (is_numeric($page) && $page > 0) ? (int) $page : 1;
	}

	/**
	 * @return int
	 */
	public function getPerPage()
	{
		$perPage = array_get($this->request->query->all(), 'perPage', 10);

		return (is_numeric($perPage) && $perPage > 0) ? (int) $perPage : 10;
	}
}