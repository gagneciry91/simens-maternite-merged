<?php

return array (
		'controllers' => array (
				'invokables' => array (
						'Maternite\Controller\Admission' => 'Maternite\Controller\AdmissionController',
						'Maternite\Controller\Maternite' => 'Maternite\Controller\MaterniteController',
						'Maternite\Controller\Accouchement' => 'Maternite\Controller\AccouchementController',
						'Maternite\Controller\Postnatale' => 'Maternite\Controller\PostnataleController',
						'Maternite\Controller\Planification' => 'Maternite\Controller\PlanificationController',
<<<<<<< HEAD
						'Maternite\Controller\Gynecologie' => 'Maternite\Controller\GynecologieController'
=======
						'Maternite\Controller\Gynechologie' => 'Maternite\Controller\GynechologieController'
>>>>>>> 7589768401636726eb4be927b165bbe87ef8d6aa
						
						
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
						
						//controlleur Admission
						'admission' =>array (
						
								'type' => 'segment',
								'options' => array (
										'route' => '/admission[/][:action]',
						
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id_patient' => '[0-9]+'
												// 'val' => '[0-9]+'
										),
										'defaults' => array (
												'controller' => 'Maternite\Controller\Admission',
												'action' => 'admission',
						
						
										)
								)
						),
						

<<<<<<< HEAD
						//controlleur Gynecologie
						'gynecologie' =>array (
						
								'type' => 'segment',
								'options' => array (
										'route' => '/gynecologie[/][:action]',
=======
						//controlleur Gynechologie
						'gynechologie' =>array (
						
								'type' => 'segment',
								'options' => array (
										'route' => '/gynechologie[/][:action]',
>>>>>>> 7589768401636726eb4be927b165bbe87ef8d6aa
						
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id_patient' => '[0-9]+'
												// 'val' => '[0-9]+'
										),
										'defaults' => array (
<<<<<<< HEAD
												'controller' => 'Maternite\Controller\Gynecologie',
=======
												'controller' => 'Maternite\Controller\Gynechologie',
>>>>>>> 7589768401636726eb4be927b165bbe87ef8d6aa
												'action' => 'admission',
						
						
										)
								)
						),
						
						
						//controlleur Planification
						'planification' =>array (
						
								'type' => 'segment',
								'options' => array (
										'route' => '/planification[/][:action]',
						
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id_patient' => '[0-9]+'
												// 'val' => '[0-9]+'
										),
										'defaults' => array (
												'controller' => 'Maternite\Controller\Planification',
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
						'layout/planification' => __DIR__ . '/../view/layout/planification.phtml',
						'layout/admission' => __DIR__ . '/../view/layout/admission.phtml',
<<<<<<< HEAD
						'layout/gynecologie' => __DIR__ . '/../view/layout/gynecologie.phtml',
=======
						'layout/gynechologie' => __DIR__ . '/../view/layout/gynechologie.phtml',
>>>>>>> 7589768401636726eb4be927b165bbe87ef8d6aa
						
						
						'layout/piedpagecons' => __DIR__ . '/../view/layout/piedpagecons.phtml' 
				),
				'template_path_stack' => array (
						'maternite' => __DIR__ . '/../view',
						'accouchement' => __DIR__ . '/../view',
						'postnatale' => __DIR__ . '/../view',
						'planification' => __DIR__ . '/../view',
<<<<<<< HEAD
						'gynecologie' => __DIR__ . '/../view',
=======
						'gynechologie' => __DIR__ . '/../view',
>>>>>>> 7589768401636726eb4be927b165bbe87ef8d6aa
						'admission' => __DIR__ . '/../view'
						
				),
				'strategies' => array (
						'ViewJsonStrategy' 
				) 
		) 
);