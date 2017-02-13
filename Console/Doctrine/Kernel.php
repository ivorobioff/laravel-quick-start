<?php
namespace ImmediateSolutions\Support\Console\Doctrine;

use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Version;
use Illuminate\Console\Application as Artisan;
use Symfony\Component\Console\Helper\QuestionHelper;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Kernel extends \Illuminate\Foundation\Console\Kernel
{

    protected $commands = [
        CreateCommand::class,
        UpdateCommand::class,
        DropCommand::class,
        GenerateProxiesCommand::class,
        GenerateCommand::class,
        MigrateCommand::class,
        DiffCommand::class,
        ExecuteCommand::class
    ];

    protected function getArtisan()
    {
        if ($this->artisan === null) {

            $this->artisan = new Artisan($this->app, $this->events, Version::VERSION);

            /**
             *
             * @var EntityManagerInterface $entityManager
             */
            $entityManager = $this->app->make(EntityManagerInterface::class);

            $helperSet = ConsoleRunner::createHelperSet($entityManager);

            $helperSet->set(new QuestionHelper(), 'dialog');

            $configuration = new Configuration($entityManager->getConnection());

            $migrationsConfig = $this->app->make('config')->get('doctrine.migrations', []);

            $configuration->setMigrationsDirectory($migrationsConfig['dir']);
            $configuration->setMigrationsNamespace($migrationsConfig['namespace']);
            $configuration->setMigrationsTableName($migrationsConfig['table']);

            $configuration->registerMigrationsFromDirectory($migrationsConfig['dir']);

            $helperSet->set(new ConfigurationHelper($entityManager->getConnection(), $configuration), 'configuration');

            $this->artisan->setHelperSet($helperSet);

            $this->artisan->resolveCommands($this->commands);
        }

        return $this->artisan;
    }
}