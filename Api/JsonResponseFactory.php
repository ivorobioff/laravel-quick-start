<?php
namespace ImmediateSolutions\Support\Api;
use Illuminate\Http\Response;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class JsonResponseFactory implements ResponseFactoryInterface
{
    /**
     * @param array $content
     * @param int $status
     * @return Response
     */
    public function create($content, $status)
    {
        return new Response(json_encode($content), $status, ['Content-Type' => 'application/json']);
    }
}