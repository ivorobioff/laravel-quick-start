<?php
namespace ImmediateSolutions\Support\Pagination;

use IteratorAggregate;
use RuntimeException;
use Traversable;
use Countable;
use ArrayIterator;

/**
 * The class represents the collection of items that also provides pagination metadata.
 * Even though the class represents the collection of items it does not work with it directly.
 * Instead, the paginator must be provided with an adapter that in turn will provide
 * the collection and the total number of items through a common interface.
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Paginator implements Countable, IteratorAggregate, PaginationProviderInterface
{
    /**
     * A collection of items retrieved from the adapter
     *
     * @var array|Traversable
     */
    private $items;

    /**
     * The total number of items retrieved from the adapter
     * @var int
     */
    private $total;

    /**
     * Adapter that will provide actual items and the total number of items.
     *
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * @var DescriberInterface
     */
    private $describer;

    /**
     * @param AdapterInterface $adapter
     * @param DescriberInterface $describer
     */
    public function __construct(AdapterInterface $adapter, DescriberInterface $describer)
    {
        $this->adapter = $adapter;
        $this->describer = $describer;
    }

    /**
     * Gets a collection of items thru the provided adapter
     *
     * @return array|Traversable
     */
    private function getItems()
    {
        if ($this->items === null) {

            $this->items = [];

            if ($this->getTotal() > 0) {
                $this->items = $this->adapter->getAll($this->getCurrentPage(), $this->getPerPage());
            }
        }

        return $this->items;
    }

    /**
     * Gets the total number of items thru the provided adapter
     *
     * @return int
     */
    private function getTotal()
    {
        if ($this->total === null) {
            $this->total = $this->adapter->getTotal();
        }

        return $this->total;
    }

    /**
     * Creates and return the pagination object that provides pagination metadata to the transformer
     *
     * @return PaginationInterface
     * @throws RuntimeException
     */
    public function getPagination()
    {
        return new Metadata($this->getCurrentPage(), $this->getTotal(), $this->getPerPage());
    }

    /**
     * Gets number of items per page from the request object or the default number
     *
     * @return int
     */
    private function getPerPage()
    {
       return $this->describer->getPerPage();
    }

    /**
     * Gets the current page from the request object
     *
     * @return int
     */
    private function getCurrentPage()
    {
        return $this->describer->getCurrentPage();
    }

    /**
     * Gets the collection iterator
     *
     * @return Traversable
     */
    public function getIterator()
    {
        $items = $this->getItems();

        if ($items instanceof Traversable) {
            return $items;
        }

        return new ArrayIterator($items);
    }

    /**
     * Counts number of items in the collection
     *
     * @return int
     */
    public function count()
    {
        return count($this->getItems());
    }
}