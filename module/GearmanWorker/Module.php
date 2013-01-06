<?php

namespace GearmanWorker;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;

class Module implements ConfigProviderInterface, AutoloaderProviderInterface, ConsoleUsageProviderInterface, ServiceProviderInterface
{
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

    public function getConsoleUsage(Console $console)
    {
    	return array(
    		'work'    => 'Start a worker',
    	);
    }

    public function getServiceConfig()
    {
    	return array(
    		'factories' => array(
    			'GearmanWorker' => function($sm) {
    				$gm = new Service\Worker();

    				$worker = new \GearmanWorker();
    				$worker->addServer('127.0.0.1');

    				$gm->setGearmanWorker($worker);
    				$gm->addJob(new Job\TestJob());
    				$gm->addJob(new Job\TestJob(), 'foo');

    				return $gm;
    			},
    		),
    	);
    }
}