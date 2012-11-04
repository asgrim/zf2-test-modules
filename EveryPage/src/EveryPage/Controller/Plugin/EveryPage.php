<?php

namespace EveryPage\Controller\Plugin;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class EveryPage extends AbstractPlugin implements ServiceLocatorAwareInterface
{
	protected $foo;

	protected $serviceLocator;

	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 * @see Zend\ServiceManager.ServiceLocatorAwareInterface::getServiceLocator()
	 * @return Zend\Mvc\Controller\PluginManager
	 */
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}

	public function __construct()
	{
		$this->foo = "If you see this, EveryPage ran!";
	}

	public function getFoo()
	{
		return $this->foo;
	}
}