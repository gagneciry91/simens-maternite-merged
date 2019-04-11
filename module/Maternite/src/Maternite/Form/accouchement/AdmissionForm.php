<?php
namespace Maternite\Form\accouchement;

use Zend\Form\Form;
class AdmissionForm extends Form{

	//protected $serviceTable;
	public function __construct() {
		//$this->serviceTable = $serviceTable;
		parent::__construct ();

		$this->add ( array (
				'name' => 'id_patient',
				'type' => 'Hidden',
				'attributes' => array(
						'id' => 'id_patient'
				)
		) );
		$this->add ( array (
				'name' => 'id_admission',
				'type' => 'Hidden',
				'attributes' => array(
						'id' => 'id_admission'
				)
		) );
		
		
		$this->add ( array (
				'name' => 'id_grossesse',
				'type' => 'Hidden',
				'attributes' => array(
						'id' => 'id_grossesse'
				)
		) );
		
		
		$this->add ( array (
				'name' => 'service',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Service'),
						'value_options' => array (
								'' => 'Maternite',
						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						
						'id' =>'service',
						'required' => false,
				)
		) );
				
		
		$this->add ( array (
				'name' => 'motif_ad',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Type d\'admission'),
						
						'value_options' => array(
								'Normal' => 'Normal',
								'Evacuation'=> 'Evacuation' ,
								'Reference'=> 'Reference' ,
						),
						
						
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'motif_ad',
						'required' => true,
				)
		) );

		
		
		
		/* Note evacuation */
		$this->add ( array (
				'name' => 'motif',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Motif d\'évacuation ' )
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'motif'
				)
		) );
		
		$this->add ( array (
				'name' => 'motif_reference',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Motif  de référence' )
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'motif_reference'
				)
		) );
		
		
		$this->add ( array (
				'name' => 'service_origine',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Service d\'origine' )
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'service_origine'
				)
		) );
		
		
		$this->add ( array (
				'name' => 'date_stat',
				'type' => 'Text',
				'options' => array (
						//'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Service d\'origine' )
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'date_stat'
				)
		) );
		

		$this->add ( array (
				'name' => 'date_debutsat',
				'type' => 'text',
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'date_debutsat'
				)
		) );
		
		$this->add ( array (
				'name' => 'date_finsat',
				'type' => 'text',
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'date_finsat'
				)
		) );
		

		$this->add ( array (
				'name' => 'date_debut',
				'type' => 'Text',
				'options' => array (
						//'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Service d\'origine' )
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'date_debut'
				)
		) );
		
			$this->add ( array (
				'name' => 'date_fin',
				'type' => 'Text',
				'options' => array (
						//'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Service d\'origine' )
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'date_fin'
				)
		) );
		
		$this->add ( array (
				'name' => 'date_cons',
				'type' => 'hidden',
				'options' => array (
						'label' => 'Date'
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'date_cons'
				)
		) );
		
		$this->add ( array (
				'name' => 'service_dorigine',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Service d\'origine' )
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'service_dorigine'
				)
		) );
		
		
		$this->add ( array (
				'name' => 'service_origine_ref',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Service d\'origine' )
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'service_origine_ref'
				)
		) );
	
	
	
		$this->add ( array (
				'name' => 'liste_service',
				'type' => 'Select',
				'options' => array (
						'value_options' => array (
								''=>''
						)
				),
				'attributes' => array (
						'id' => 'liste_service',
				)
		) );
		
		
		$this->add ( array (
				'name' => 'sous_dossier',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Sous dossier'),
							'value_options' => array (
								1 => 'Prenatales',
								2 => 'Accouchement',
								3 => 'Postnatales',
								4 => 'Planification',
								5 => 'Gynecologie',


		
														)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'sous_dossier',
						'required' => true,
				)
		) );		
		
		$this->add ( array (
				'name' => 'motif_admission',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Motif d\'admission'),
						'value_options' => array (
								'Spontannes' => 'Spontannes',
								'Rendez' => 'Rendez-vous',
								'Presentation resultat' => 'Presentation resultat',
								'Reference' => 'Reference',
								'Evacuation' => 'Evacuation',
								'Domicile' => 'Domicile',
		
						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'motif_admission',
						'required' => true,
				)
		) );
		
		
		$this->add ( array (
				'name' => 'type_admission',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Type d\'admission'),
						'value_options' => array (
								'Normal' => 'Normal',
								'Urgence' => 'Urgence',
						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange'=>'getMotif(this.value)',
						'id' =>'type_admission',
						'required' => true,
				)
		) );
		
		$this->add ( array (
				'name' => 'moyen_transport',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Moyen de transport'),
						'value_options' => array (
								1 => 'Moyens Personnel',
								2 => 'Ambulance',
								3 => 'Autres',
								
		
						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'moyen_transport',
						'required' => true,
				)
		) );
		
		
		
		
		$this->add ( array (
				'name' => 'motif_transfert_evacuation',
				'type' => 'Text',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Motif de reference ou d\'evacuation'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'motif_transfert_evacuation',
				)
		) );
		
		
		
	}
}