<?php
namespace ImmediateSolutions\Support\Api;
use Illuminate\Http\Response;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ResponseFactoryInterface
{
    /**
     * @param mixed $content
     * @param int $status
     * @return Response
     */
    public function create($content, $status);
}