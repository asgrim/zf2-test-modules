<?php

namespace TextStyles\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class Underline extends AbstractHelper
{
	public function __invoke($string)
	{
		return sprintf('<span style="text-decoration: underline;">%s</span>', $string);
	}
}