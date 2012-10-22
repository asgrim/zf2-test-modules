<?php

namespace EveryPage\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class EveryPage extends AbstractPlugin
{
	public function __invoke()
	{
		echo "If you see this, the EveryPage controller plugin ran...";
		// @todo How can I put stuff in the view from here?
		// @todo If I access the controller (using $this->getController()) it's not the right instance
	}
}