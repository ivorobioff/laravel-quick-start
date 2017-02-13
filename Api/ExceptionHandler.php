<?php
namespace ImmediateSolutions\Support\Api;

use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ImmediateSolutions\Support\Validation\Error;
use ImmediateSolutions\Support\Validation\ErrorsThrowableCollection;
use ImmediateSolutions\Support\Validation\PresentableException;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ExceptionHandler extends Handler
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        PresentableException::class
    ];

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->responseFactory = $container->make(ResponseFactoryInterface::class);
    }

    /**
     * @param Request $request
     * @param Exception $exception
     * @return Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof HttpException){
            return $this->writeHttpException($exception);
        }

        if ($exception instanceof ErrorsThrowableCollection){

            $data = [];

            /**
             * @var Error[] $e
             */
            foreach ($exception as $property => $error){
                $data[$property] = $this->prepareError($error);
            }

            return $this->responseFactory->create(['errors' => $data], 422);
        }

        if ($exception instanceof PresentableException){
            return $this->writeException(400, $exception->getMessage());
        }

        if ($this->isDebug()){
            return parent::render($request, $exception);
        }

        return $this->writeException(500, 'Internal Server Error');
    }

    /**
     * @param HttpException $exception
     * @return Response
     */
    private function writeHttpException(HttpException $exception)
    {
        return $this->writeException($exception->getStatusCode(), $exception->getMessage());
    }

    /**
     * @param int $code
     * @param string $message
     * @return Response
     */
    private function writeException($code, $message)
    {
        return $this->responseFactory->create([
            'code' => $code,
            'message' => $message
        ], $code);
    }


    /**
     * @param Error $error
     * @return array
     */
    private function prepareError(Error $error)
    {
        $data = [
            'identifier' => $error->getIdentifier(),
            'message' => $error->getMessage(),
            'extra' => []
        ];

        if ($error->hasExtra()){
            foreach ($error->getExtra() as $name => $extra){
                $data['extra'][$name] = $this->prepareError($extra);
            }
        }

        return $data;
    }

    /**
     * @return bool
     */
    protected function isDebug()
    {
        return $this->container->make('config')->get('app.debug');
    }
}