<?php

namespace Eventful\Something;

use Zend\EventManager\Event;

use Zend\EventManager\StaticEventManager;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;

class EventfulClass implements EventManagerAwareInterface
{
	protected $events;

	public function setEventManager(EventManagerInterface $events)
	{
		$this->events = $events;
		return $this;
	}

	public function getEventManager()
	{
		if ($this->events == null)
		{
			$this->setEventManager(new EventManager(__CLASS__));
		}
		return $this->events;
	}

	/**
	 * Shortcut to $this->getEventManager()
	 * @return EventManagerInterface
	 */
	public function events()
	{
		return $this->getEventManager();
	}

	/**
	 * Triggers 2 events using EventfulClass' event manager
	 *   first.pre
	 *   first.post
	 *
	 * Apparently the .pre and .post is a convention or something...
	 *
	 * @param mixed $arg1
	 * @param mixed $arg2
	 */
	public function first($arg1, $arg2 = 'blah')
	{
		$params = compact('arg1', 'arg2');
		$this->events()->trigger(__FUNCTION__ . '.pre', $this, $params);

		// Do some code...

		$this->events()->trigger(__FUNCTION__ . '.post', $this, $params);
	}

	/**
	 * Triggers an event. This is pretty much exactly the same
	 * as triggering events above, but we are using a generic name.
	 *
	 * @param mixed $arg
	 */
	public function second($arg1, $arg2 = 'bloo')
	{
		$params = compact('arg1', 'arg2');
		$params['function'] = __FUNCTION__; // Pass through the function name, it might be useful?
		$this->events()->trigger('second', $this, $params);
	}

	/**
	 * Trigger a custom event! The third argument in the above examples are just
	 * arrays that are auto converted into a Zend\EventManager\Event object.
	 * If we pass a custom event (that extends Zend\EventManager\Event) then
	 * we can do whatever funky things we like with that event.
	 */
	public function third($ewok)
	{
		$myEvent = new MyCustomEvent();
		$myEvent->setEwok($ewok);
		$this->events()->trigger(__FUNCTION__, $this, $myEvent);
	}
}