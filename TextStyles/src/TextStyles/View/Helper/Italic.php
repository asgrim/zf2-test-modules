<?php

namespace TextStyles\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class Italic extends AbstractHelper
{
	public function __invoke($string)
	{
		return sprintf('<span style="font-style: italic;">%s</span>', $string);
	}
}