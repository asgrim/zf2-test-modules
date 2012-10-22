<?php

namespace TextStyles\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class Bold extends AbstractHelper
{
	public function __invoke($string)
	{
		return sprintf('<span style="font-weight: bold;">%s</span>', $string);
	}
}