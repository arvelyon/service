<?php


namespace Arvelyon\Service;


/**
 * Class Warehouse
 * @package Arvelyon\Service
 * @version 0.1
 * @author Michael M Langitan <michaelmlangitan@gmail.com>
 */
class Warehouse
{
	/**
	 * @var array
	 */
	private $services = [];

	/**
	 * Check has service
	 * @param string $className
	 * @return bool
	 * @since 0.1
	 */
	function has($className):bool
	{
		return isset($this->services[$className]);
	}

	/**
	 * Set service
	 * @param Collection $collection
	 * @since 0.1
	 */
	function set(Collection $collection)
	{
		$this->services[$collection->className] = $collection;
	}

	/**
	 * Get service
	 * @param string    $className
	 * @return Collection
	 * @since 0.1
	 * @throws \RuntimeException
	 */
	function get($className)
	{
		if($this->has($className)){
			return $this->services[$className];
		}

		throw new \RuntimeException(sprintf('Service "%s" does not exists', $className));
	}

	/**
	 * Remove service
	 * @param string $className
	 * @since 0.1
	 */
	function remove($className)
	{
		unset($this->services[$className]);
	}

	/**
	 * Clear services
	 * @since 0.1
	 */
	function clear()
	{
		$this->services = [];
	}
}