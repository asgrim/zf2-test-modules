<?php

namespace Eventful\Something;

use Zend\ServiceManager\ServiceManager;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\EventManager\StaticEventManager;
use Zend\EventManager\Event;

class SomeClass implements ServiceManagerAwareInterface
{
	/**
	 * @var ServiceManager;
	 */
	protected $serviceManager;

	/**
	 * This is *automatically* called by ZF2 because we implement the
	 * ServiceManagerAwareInterface which allows us to get the eventful_class
	 * object in goGoGo function.
	 *
	 * @param ServiceManager $sm
	 */
	public function setServiceManager(ServiceManager $sm)
	{
		$this->serviceManager = $sm;
		return $this;
	}

	/**
	 * Retrieve the service manager
	 *
	 * @throws \Exception
	 * @return ServiceManager
	 */
	public function getServiceManager()
	{
		if (!$this->serviceManager)
		{
			throw new \Exception("Service Manager was not injected?");
		}

		return $this->serviceManager;
	}

	/**
	 * Create our eventful object and attach ourselves to a couple of it's events
	 */
	public function goGoGo()
	{
		$eventful = $this->getServiceManager()->get('eventful_class');
		/* @var $eventful EventfulClass */

		$callable = array($this, 'somethingFooCallback');

		// Attach attach to an event where we have direct access to the object
		$eventful->events()->attach(array('first.pre', 'first.post'), $callable);

		// Attach to the global event - this looks for any identifier
		// So ANY class that fires "someGenericEvent" after we've attached will
		// trigger this callback
		$sharedEventManager = StaticEventManager::getInstance();

		// We can attach to this event two ways, using a * for the identifier
		// which will look for "second" triggered by ANY class...
		$sharedEventManager->attach('*', 'second', $callable);

		// ... or by specifying the identifer specifically, which I think only
		// listens to that ONE class you ask for. Note for this to work, the
		// event manager with that identifier must be instantiated with an
		// identifier (e.g. $em = new EventManager(__CLASS__);) in theory, the
		// identifier can be anything, but it makes sense to make it the class!
		# $sharedEventManager->attach('Eventful\Something\EventfulClass', 'second', $callable);

		// Listen to a custom event
		$eventful->events()->attach('third', $callable);

		// You can listen to every single event (after this is attached) do this:
		// Warning - you'll get LOTS of events ;)
		# $sharedEventManager->attach('*', '*', $callable);

		// Now we've attached all our listeners, call the 3 functions that
		// trigger our various events
		$eventful->first('bar');
		$eventful->second('omg');
		$eventful->third('cute ewoks');
	}

	/**
	 * I listen for events and suchlike
	 * @param Event $e
	 */
	public function somethingFooCallback(Event $e)
	{
		printf("<em>%s</em>: <strong>%s</strong> called in target <strong>%s</strong> with params <strong>%s</strong><br />", get_class($e), $e->getName(), get_class($e->getTarget()), json_encode($e->getParams()));
	}
}