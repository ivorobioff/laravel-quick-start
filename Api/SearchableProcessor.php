<?php
namespace ImmediateSolutions\Support\Api;

use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use ImmediateSolutions\Support\Api\Searchable\AbstractSearchableProcessor;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class SearchableProcessor extends AbstractSearchableProcessor
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->request = $container->make(Request::class);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if ($this->data === null){
            $this->data = $this->request->query->all();
        }

        return $this->data;
    }
}