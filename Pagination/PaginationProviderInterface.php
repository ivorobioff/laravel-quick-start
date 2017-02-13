<?php
namespace ImmediateSolutions\Support\Pagination;

/**
 * The interface is required to be implemented by a collection in order to provide the pagination details and tell the transformer to include them to the result.
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface PaginationProviderInterface
{
    /**
     * @return PaginationInterface
     */
    public function getPagination();
}