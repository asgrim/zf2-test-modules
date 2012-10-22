<?php

return array(
	'view_helpers' => array(
		'invokables' => array(
			'bold' => 'TextStyles\View\Helper\Bold',
			'italic' => 'TextStyles\View\Helper\Italic',
			'underline' => 'TextStyles\View\Helper\Underline',
		),
		'aliases' => array(
			'b' => 'bold',
			'i' => 'italic',
			'u' => 'underline',
		),
	),
);