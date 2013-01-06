<?php

return array(
	'controllers' => array(
		'invokables' => array(
			'GearmanWorker\Controller\Worker' => 'GearmanWorker\Controller\WorkerController',
		),
	),
	'console' => array(
		'router' => array(
			'routes' => array(
				'gearman-worker' => array(
					'options' => array(
						'route'    => 'work',
						'defaults' => array(
							'controller' => 'GearmanWorker\Controller\Worker',
							'action'     => 'work'
						)
					)
				)
			)
		)
	)
);