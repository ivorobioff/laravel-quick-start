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

	public function getMetadataNamespace($package)
	{
		return 'ImmediateSolutions\Infrastructure\DAL\\' . $package . '\Metadata';
	}

	public function getEntityPath($package)
	{
		app_path('Core/' . str_replace('\\', '/', $package) . '/Entities');
	}
}