<?php
namespace ImmediateSolutions\Support\Pagination;

/**
 * The interfaces is required to be implemented in order to provide pagination information to the transformer.
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface PaginationInterface
{
    /**
     * The current page
     *
     * @return int
     */
    public function getCurrent();

    /**
     * Gets total items
     *
     * @return int
     */
    public function getTotal();

    /**
     * Gets total pages
     *
     * @return int
     */
    public function getTotalPages();

    /**
     * Gets number of items per page
     *
     * @return int
     */
    public function getPerPage();

    /**
     * Get number of items on the current page
     *
     * @return int
     */
    public function getOnPage();
}