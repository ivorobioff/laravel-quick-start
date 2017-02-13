<?php
namespace ImmediateSolutions\Support\Api;
use Illuminate\Support\ServiceProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ResponseFactoryInterface::class, JsonResponseFactory::class);

        $this->app->afterResolving(AbstractProcessor::class, function(AbstractProcessor $processor){
            $processor->validate();
        });
    }
}