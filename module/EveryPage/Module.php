<?php

namespace EveryPage;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface, AutoloaderProviderInterface
{
	public function onBootstrap(MvcEvent $e)
	{
		$em = $e->getApplication()->getEventManager();

		$em->attach('dispatch', array($this, 'preDispatch'));
	}

	public function preDispatch(MvcEvent $e)
	{
		$sm = $e->getApplication()->getServiceManager();
		$every_page = $sm->get('controller_plugin_manager')->get('every_page');
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}