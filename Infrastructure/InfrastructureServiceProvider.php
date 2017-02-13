<?php
namespace ImmediateSolutions\Support\Infrastructure;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\ServiceProvider;
use ImmediateSolutions\Support\Core\Interfaces\ContainerInterface;
use ImmediateSolutions\Support\Core\Interfaces\PasswordEncryptorInterface;
use ImmediateSolutions\Support\Core\Interfaces\TokenGeneratorInterface;
use ImmediateSolutions\Support\Infrastructure\Doctrine\EntityManagerFactory;
use Psr\Log\LoggerInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class InfrastructureServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(EntityManagerInterface::class, function(){
            return (new EntityManagerFactory())($this->app);
        });

        $this->app->singleton(PasswordEncryptorInterface::class, PasswordEncryptor::class);
        $this->app->singleton(TokenGeneratorInterface::class, TokenGenerator::class);
        $this->app->singleton(ContainerInterface::class, Container::class);
        $this->app->alias('log', LoggerInterface::class);
    }
}