<?php
namespace ImmediateSolutions\Support\Api\Verify;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use RuntimeException;
use ReflectionMethod;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class VerifyServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    private $arguments;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

    public function boot()
    {
        $this->app->afterResolving(VerifiableInterface::class, function ($verifiable) {
            $this->verify($verifiable);
        });
    }

    /**
     * @param VerifiableInterface $verifiable
     */
    private function verify(VerifiableInterface $verifiable)
    {
        if ($this->shouldBypass($verifiable)) {
            return;
        }

        if (!method_exists($verifiable, 'verify')) {
            throw new RuntimeException('The "verify" method is missing even though the controller is verifiable.');
        }

        $method = new ReflectionMethod($verifiable, 'verify');

        $arguments = $this->getArguments();
        /**
         * @var Request $request
         */
        $request = $this->app->make(Request::class);
        $parts = explode('@', $request->route()->getAction()['uses']);
        $name = $parts[1];

        foreach ($method->getParameters() as $index => $argument) {
            $class = $argument->getClass();

            if (!$class) {
                continue;
            }

            $class = $class->getName();

            if ($class === Action::class || is_subclass_of($class, Action::class)) {
                $instance = new Action($name);
            } else {
                $instance = $this->app->make($class);
            }

            array_splice($arguments, $index, 0, [$instance]);
        }

        $result = call_user_func_array([$verifiable, 'verify'], $arguments);

        if (!$result) {
            throw new NotFoundHttpException(VerifiableInterface::NOT_FOUND);
        }
    }

    /**
     * @param  VerifiableInterface $verifiable
     * @return bool
     */
    private function shouldBypass(VerifiableInterface $verifiable)
    {
        if (!$this->getArguments()) {
            return true;
        }

        return $verifiable->shouldVerify() === false;
    }

    /**
     * @return array
     */
    private function getArguments()
    {
        if ($this->arguments !== null){
            return $this->arguments;
        }

        /**
         * @var Request $request
         */
        $request = $this->app->make(Request::class);
        return $this->arguments = array_values($request->route()->parameters());
    }
}