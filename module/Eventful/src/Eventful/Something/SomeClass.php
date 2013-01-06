<?php

namespace Eventful\Something;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\EventManager\StaticEventManager;
use Zend\EventManager\Event;

class SomeClass implements ServiceLocatorAwareInterface
{
	/**
	 * @var ServiceLocatorInterface
	 */
	protected $serviceLocator;

	/**
	 * @var array
	 */
	protected $eventLog;

	/**
	 * This is *automatically* called by ZF2 because we implement the
	 * ServiceLocatorAwareInterface which allows us to get the eventful_class
	 * object in goGoGo function.
	 *
	 * @param ServiceLocatorInterface $sm
	 */
	public function setServiceLocator(ServiceLocatorInterface $sm)
	{
		$this->serviceLocator = $sm;
		return $this;
	}

	/**
	 * Retrieve the service manager
	 *
	 * @throws \Exception
	 * @return ServiceLocatorInterface
	 */
	public function getServiceLocator()
	{
		// Probably don't need this, but if we wanted to be super cautious...
		if (!$this->serviceLocator)
		{
			throw new \Exception("Service Locator was not injected?");
		}

		return $this->serviceLocator;
	}

	/**
	 * Create our eventful object and attach ourselves to a couple of it's events
	 * @return array
	 */
	public function goGoGo()
	{
		$this->eventLog = array();

		$eventful = $this->getServiceLocator()->get('eventful_class');
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

		return $this->eventLog;
	}

	/**
	 * I listen for events and suchlike
	 * @param Event $e
	 */
	public function somethingFooCallback(Event $e)
	{
		$this->eventLog[] = sprintf("<em>%s</em>: <strong>%s</strong> called in target <strong>%s</strong> with params <strong>%s</strong><br />", get_class($e), $e->getName(), get_class($e->getTarget()), json_encode($e->getParams()));
	}
}