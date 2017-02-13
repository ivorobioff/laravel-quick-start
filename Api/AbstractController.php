<?php
namespace ImmediateSolutions\Support\Api;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ImmediateSolutions\Support\Api\Verify\VerifiableInterface;
use ImmediateSolutions\Support\Pagination\AdapterInterface;
use ImmediateSolutions\Support\Pagination\Describer;
use ImmediateSolutions\Support\Pagination\PaginationProviderInterface;
use ImmediateSolutions\Support\Pagination\Paginator;
use ImmediateSolutions\Support\Permissions\ProtectableInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractController extends Controller implements ProtectableInterface, VerifiableInterface
{
    /**
     * @var Reply
     */
    protected $reply;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->reply = $container->make(Reply::class);
        $this->request = $container->make(Request::class);

        if (method_exists($this, 'initialize')){
            $this->container->call([$this, 'initialize']);
        }
    }

    /**
     * @param AdapterInterface $adapter
     * @return object[]|PaginationProviderInterface
     */
    public function paginator(AdapterInterface $adapter)
    {
        return new Paginator($adapter, new Describer($this->request));
    }

    /**
     * @param string $class
     * @return callable
     */
    public function serializer($class)
    {
        return $this->container->make($class);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function show404()
    {
        throw new NotFoundHttpException(VerifiableInterface::NOT_FOUND);
    }

    /**
     * @return bool
     */
    public function shouldVerify()
    {
        return true;
    }
}