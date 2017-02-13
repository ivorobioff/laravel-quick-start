<?php
namespace ImmediateSolutions\Support\Pagination;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface DescriberInterface
{
    /**
     * @return int
     */
    public function getCurrentPage();
    public function getPerPage();
}