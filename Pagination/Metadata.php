<?php
namespace ImmediateSolutions\Support\Pagination;

/**
 * A simple implementation of the PaginationInterface to be used by Paginator
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Metadata implements PaginationInterface
{
    /**
     * The current page
     * @var int
     */
    private $page;

    /**
     * The total number of items
     *
     * @var int
     */
    private $total;

    /**
     * The number of items per page
     *
     * @var int
     */
    private $perPage;

    /**
     * @param int $page
     * @param int $total
     * @param int $perPage
     */
    public function __construct($page, $total, $perPage)
    {
        $this->page = $page;
        $this->total = $total;
        $this->perPage = $perPage;
    }

    /**
     * Gets the current page
     * @return int
     */
    public function getCurrent()
    {
        return $this->page;
    }

    /**
     * Gets the total number of items
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Calculates total pages based on the total number of items and the number of items per page
     * @return int
     */
    public function getTotalPages()
    {
        return ceil($this->total / $this->perPage);
    }

    /**
     * Gets the number of items per page
     *
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * Calculates number of items are shown on the page
     * @return int
     */
    public function getOnPage()
    {
        $all = $this->perPage * $this->page;

        if ($all <= $this->total) {
            return $this->perPage;
        }

        return $this->perPage - ($all - $this->total);
    }
}