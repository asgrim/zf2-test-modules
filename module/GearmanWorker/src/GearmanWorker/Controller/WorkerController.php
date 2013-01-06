<?php

namespace GearmanWorker\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;

class WorkerController extends AbstractActionController
{
	public function workAction()
	{
		$request = $this->getRequest();

		if (!$request instanceof ConsoleRequest)
		{
			throw new \RuntimeException('You can only use this action from a console!');
		}

		$sm = $this->getServiceLocator();
		$worker = $sm->get('GearmanWorker');
		$worker->work();
	}
}