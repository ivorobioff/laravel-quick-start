<?php
namespace ImmediateSolutions\Support\Permissions;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Illuminate\Config\Repository as Config;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PermissionsInterface::class, function(){

            /**
             * @var Config $config
             */
            $config = $this->app->make(Config::class);

            $permissions = new Permissions($this->app);
            $permissions->globals($config->get('app.protectors', []));

            return $permissions;
        });
    }

    public function boot()
    {
        $this->app->afterResolving(ProtectableInterface::class, function ($controller) {
            $this->check($controller);
        });
    }

    private function check(ProtectableInterface $protectable)
    {
        /**
         * @var Request $request
         */
        $request = $this->app->make(Request::class);
        $parts = explode('@', $request->route()->getAction()['uses']);
        $method = $parts[1];

        $class = $this->getClass($protectable);

        if (!class_exists($class)) {
            throw new PermissionsException('The permissions class "' . $class . '" has not been found.');
        }

        $definition = $this->app->make($class);

        if (!$definition instanceof AbstractActionsPermissions) {
            throw new PermissionsException('The permissions class "' . $class . '" must be instance of AbstractPermissions.');
        }

        /**
         * @var PermissionsInterface $permissions
         */
        $permissions = $this->app->make(PermissionsInterface::class);

        if (!$permissions->has($definition->getProtectors($method))) {
            throw new AccessDeniedException(ProtectableInterface::ACCESS_DENIED);
        }
    }

    /**
     * @param ProtectableInterface $protectable
     * @return string
     */
    private function getClass(ProtectableInterface $protectable)
    {
        $parts = explode('\\', get_class($protectable));
        $name = array_pop($parts);

        return (implode('\\', $parts).'\Permissions\\'.cut_string_right($name, 'Controller').'Permissions');
    }
}