<?php
namespace ImmediateSolutions\Support\Infrastructure\Doctrine;
use ImmediateSolutions\Support\Infrastructure\Doctrine\Metadata\DescriberInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Describer implements DescriberInterface
{
	/**
	 * @param string $package
	 * @return string
	 */
	public function getEntityNamespace($package)
	{
		return 'ImmediateSolutions\\Core\\' . $package . '\\Entities';
	}

	/**
	 * @param string $package
	 * @return string
	 */
	public function getMetadataNamespace($package)
	{
		return 'ImmediateSolutions\Infrastructure\DAL\\' . $package . '\Metadata';
	}

	/**
	 * @param string $package
	 * @return string
	 */
	public function getEntityPath($package)
	{
		return app_path('Core/' . str_replace('\\', '/', $package) . '/Entities');
	}

    /**
     * @param string $package
     * @return string
     */
    public function getTypeNamespace($package)
    {
        return 'ImmediateSolutions\Infrastructure\DAL\\' . $package . '\Types';
    }

    /**
     * @param string $package
     * @return string
     */
    public function getTypePath($package)
    {
        return app_path('Infrastructure/DAL/' . str_replace('\\', '/', $package) . '/Types');
    }
}