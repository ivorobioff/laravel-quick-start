<?php
namespace ImmediateSolutions\Support\Infrastructure\Doctrine;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Container\Container;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use ImmediateSolutions\Support\Infrastructure\Doctrine\Metadata\SimpleDriver;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;
use ImmediateSolutions\Support\Infrastructure\Doctrine\Metadata\CompositeDriver;
use ImmediateSolutions\Support\Infrastructure\Doctrine\Metadata\PackageDriver;
use DoctrineExtensions\Query\Mysql\Year as MysqlYear;
use DoctrineExtensions\Query\Sqlite\Year as SqliteYear;
use DoctrineExtensions\Query\Mysql\Month as MysqlMonth;
use DoctrineExtensions\Query\Sqlite\Month as SqliteMonth;
use RuntimeException;
use Illuminate\Config\Repository as Config;


/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class EntityManagerFactory
{
    /**
     * @param Container $container
     * @return EntityManagerInterface
     */
    public function __invoke(Container $container)
    {
        $config = $container->make(Config::class)->get('doctrine');
        $packages = $container->make(Config::class)->get('app.packages');

        $em = EntityManager::create(
            $config['connections'][$config['db']],
            $this->createConfiguration($config, $packages)
        );

        $this->registerTypes(
            $em->getConnection(),
            $packages,
            array_get($config, 'types', [])
        );

        return $em;
    }

    /**
     * @param array $config
     * @param array $packages
     * @return Configuration
     */
    private function createConfiguration(array $config, array $packages)
    {
        $setup = Setup::createConfiguration();

        $cache = new $config['cache']();

        $setup->setMetadataCacheImpl($cache);
        $setup->setQueryCacheImpl($cache);

        $setup->setProxyDir($config['proxy']['dir']);
        $setup->setProxyNamespace($config['proxy']['namespace']);
        $setup->setAutoGenerateProxyClasses(array_get($config, 'proxy.auto', false));

        $setup->setMetadataDriverImpl(new CompositeDriver([
            new PackageDriver($packages),
            new SimpleDriver(array_get($config, 'entities', []))
        ]));

        $setup->setNamingStrategy(new UnderscoreNamingStrategy());
        $setup->setDefaultRepositoryClassName(DefaultRepository::class);

        $driver = $config['connections'][$config['db']]['driver'];

        if ($driver == 'pdo_sqlite'){
            $setup->addCustomDatetimeFunction('YEAR', SqliteYear::class);
            $setup->addCustomDatetimeFunction('MONTH', SqliteMonth::class);
        } else if ($driver == 'pdo_mysql'){
            $setup->addCustomDatetimeFunction('YEAR', MysqlYear::class);
            $setup->addCustomDatetimeFunction('MONTH', MysqlMonth::class);
        } else {
            throw new RuntimeException('Unable to add functions under unknown driver "'.$driver.'".');
        }

        return $setup;
    }

    /**
     *
     * @param Connection $connection
     * @param array $packages
     * @param array $extra
     */
    private function registerTypes(Connection $connection, array $packages, array $extra = [])
    {
        foreach ($packages as $package) {
            $path = app_path('Infrastructure/DAL/' . str_replace('\\', '/', $package) . '/Types');
            $typeNamespace = 'ImmediateSolutions\Infrastructure\DAL\\' . $package . '\Types';

            if (! file_exists($path)) {
                continue;
            }

            $finder = new Finder();

            /**
             *
             * @var SplFileInfo[] $files
             */
            $files = $finder->in($path)
                ->files()
                ->name('*.php');

            foreach ($files as $file) {
                $name = cut_string_right($file->getFilename(), '.php');

                $typeClass = $typeNamespace . '\\' . $name;

                if (! class_exists($typeClass)) {
                    continue;
                }

                if (Type::hasType($typeClass)) {
                    Type::overrideType($typeClass, $typeClass);
                } else {
                    Type::addType($typeClass, $typeClass);
                }

                $connection->getDatabasePlatform()->registerDoctrineTypeMapping($typeClass, $typeClass);
            }
        }

        foreach ($extra as $type){
            if (Type::hasType($type)) {
                Type::overrideType($type, $type);
            } else {
                Type::addType($type, $type);
            }
        }
    }
}