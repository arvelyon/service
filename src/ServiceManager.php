<?php


namespace Arvelyon\Service;


/**
 * Class ServiceManager
 * @package Arvelyon\Service
 * @version 0.1
 * @author Michael M Langitan <michaelmlangitan@gmail.com>
 */
class ServiceManager
{
	/**
	 * @var Warehouse
	 */
	private $warehouse;

	function __construct()
	{
		$this->warehouse = new Warehouse;
	}

	/**
	 * @param string $className
	 * @return bool
	 * @since 0.1
	 */
	function hasService(string $className):bool
	{
		return $this->warehouse->has($className);
	}

	/**
	 * @param Collection $collection
	 * @return ServiceManager
	 * @since 0.1
	 */
	function setService(Collection $collection):ServiceManager
	{
		$this->warehouse->set($collection);
		return $this;
	}

	/**
	 * @param $className
	 * @return mixed
	 * @since 0.1
	 */
	function getService($className)
	{
		if(!$this->warehouse->has($className)){
			throw new \RuntimeException(sprintf('Service %s does not exists', $className));
		}

		$collection = $this->warehouse->get($className);
		if($collection->hasInstance()){
			return $collection->getInstance();
		}

		try{
			$reflector = new \ReflectionClass($className);
		}catch(\Exception $e){
			throw new \RuntimeException($e->getMessage());
		}

		if($reflector->hasMethod('__construct')){
			$constructor = $reflector->getConstructor();
			$args = [];
			foreach($constructor->getParameters() as $parameter){
				if(is_object($parameter->getClass()) && !$parameter->getClass()->isInterface()){
					$args[] = $this->getService($parameter->getClass()->getName());
				}
				else{
					if($parameter->isOptional() || $parameter->isDefaultValueAvailable()){
						$args[] = $parameter->getDefaultValue();
					}
					else{
						throw new \RuntimeException(sprintf('Unknown parameter value for %s service', $className));
					}
				}
			}

			$service = $reflector->newInstanceArgs($args);
		}
		else{
			$service = $reflector->newInstanceWithoutConstructor();
		}

		return $collection->setInstance($service)->getInstance();
	}
}