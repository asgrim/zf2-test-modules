<?php

namespace Eventful\Something;

use Zend\EventManager\Event;

class MyCustomEvent extends Event
{
	protected $ewok;

	/**
	 * @return string
	 */
	public function getEwok()
	{
		return $this->ewok;
	}

	/**
	 *
	 * @param string $value
	 * @return MyCustomEvent
	 */
	public function setEwok($value)
	{
		// Makes sense to also call setParam I guess?
		$this->setParam('ewok', $value);
		$this->ewok = $value;
		return $this;
	}
}