<?php

return array (
		'controllers' => array (
				'invokables' => array (
						'Maternite\Controller\Maternite' => 'Maternite\Controller\MaterniteController',
						'Maternite\Controller\Accouchement' => 'Maternite\Controller\AccouchementController',
						'Maternite\Controller\Postnatale' => 'Maternite\Controller\PostnataleController'
				) 
		),
	
		'router' => array (
				'routes' => array (
						
						'maternite' => array (
						
								'type' => 'segment',
								'options' => array (
										'route' => '/maternite[/][:action][/:id_patient]',
										
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id_patient' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id_patient' => '[0-9]+' 
										// 'val' => '[0-9]+'
																				),
										'defaults' => array (
												'controller' => 'Maternite\Controller\Maternite',
												'action' => 'recherche',
												
										) 
								) 
						), 
						
							 //controlleur Postnatale
						 'postnatale' =>array (
						
						 		'type' => 'segment',
						 		'options' => array (
						 				'route' => '/postnatale[/][:action]',
						
						 				'constraints' => array (
						 						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						 						'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
						 						'id_patient' => '[0-9]+'
						 						// 'val' => '[0-9]+'
						 				),
						 				'defaults' => array (
						 						'controller' => 'Maternite\Controller\Postnatale',
						 						'action' => 'admission',
						
						
						 				)
						 		)
						 ),  
						
						//controlleur Accouchement
						'accouchement' =>array (
						
								'type' => 'segment',
								'options' => array (
										'route' => '/accouchement[/][:action][/:id][/:id_patient]',
						
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id_patient' => '[0-9]+'
												// 'val' => '[0-9]+'
										),
										'defaults' => array (
												'controller' => 'Maternite\Controller\Accouchement',
												'action' => 'admission',
												
						
										),
								),
								),
								),
				
		),

		

		'view_manager' => array (
				'template_map' => array (
						'layout/menugauchecons' => __DIR__ . '/../view/layout/menugauche.phtml',
						//'layout/accouchement' => __DIR__ . '/../view/layout/accouchement.phtml',
						'layout/postnatale' => __DIR__ . '/../view/layout/postnatale.phtml',
						'layout/piedpagecons' => __DIR__ . '/../view/layout/piedpagecons.phtml' 
				),
				'template_path_stack' => array (
						'maternite' => __DIR__ . '/../view',
						'accouchement' => __DIR__ . '/../view',
						'postnatale' => __DIR__ . '/../view'
						
				),
				'strategies' => array (
						'ViewJsonStrategy' 
				) 
		) 
);