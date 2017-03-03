<?php
namespace ImmediateSolutions\Support\Api;

use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class Processor extends AbstractProcessor
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var array
     */
    private $data;

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
            $data = $this->request->getContent();

            $data = json_decode($data, true);

            if ($data === null){
                $this->data = [];
            } else {
                $this->data = $data;
            }
        }

        return $this->data;
    }
}