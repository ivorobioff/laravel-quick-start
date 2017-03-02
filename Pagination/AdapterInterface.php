<?php
namespace ImmediateSolutions\Support\Pagination;

/**
 * A common interface for all pagination adapters
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface AdapterInterface
{
    /**
     * Gets all items according to the provided parameters
     *
     * @param int $page
     * @param int $perPage
     * @return object[]
     */
    public function getAll($page, $perPage);
    /**
     * Counts the total number of items
     *
     * @return int
     */
    public function getTotal();
}