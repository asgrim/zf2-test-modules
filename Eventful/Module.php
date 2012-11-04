<?php

namespace Eventful;

use Eventful\Something\SomeClass;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface, AutoloaderProviderInterface
{
	public function onBootstrap(MvcEvent $e)
	{
		$em = $e->getApplication()->getEventManager();
		$em->attach(MvcEvent::EVENT_DISPATCH, array($this, 'postDispatch'), -1000);
	}

	public function postDispatch(MvcEvent $e)
	{
		$sm = $e->getApplication()->getServiceManager();
		$blah = $sm->get('some_class');
		$log = $blah->goGoGo();

		$e->getResult()->setVariable('eventful_log', $log);
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