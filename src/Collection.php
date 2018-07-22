<?php


namespace Arvelyon\Service;


/**
 * Class Collection
 * @package Arvelyon\Service
 * @version 0.1
 * @author Michael M Langitan <michaelmlangitan@gmail.com>
 */
class Collection
{
	public $className;
	private $instance;

	/**
	 * Collection constructor.
	 * @param      $className
	 * @param null $instance
	 * @since 0.1
	 */
	function __construct($className, $instance = null)
	{
		$this->className = $className;
		if(null !== $instance){
			$this->instance = $instance;
		}
	}

	/**
	 * @return bool
	 * @since 0.1
	 */
	function hasInstance()
	{
		return null !== $this->instance;
	}

	/**
	 * @return mixed
	 * @since 0.1
	 */
	function getInstance()
	{
		return $this->instance;
	}

	/**
	 * @param $instance
	 * @return Collection
	 * @since 0.1
	 */
	function setInstance($instance):Collection
	{
		$this->instance = $instance;
		return $this;
	}
}