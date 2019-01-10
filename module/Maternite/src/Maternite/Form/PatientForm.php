<?php

namespace Maternite\Form;

use Zend\Form\Form;
use Doctrine\Common\Collections\Expr\Value;

class PatientForm extends Form {
	public function __construct($name = null) {
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
				'name' => 'ID_PERSONNE',
				'type' => 'Hidden',
				'attributes' => array (
				)
		) );
		$this->add ( array (
				'name' => 'CIVILITE',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Civilite',
						'value_options' => array (
								'Mme' => 'Mme',
								'Mlle' => 'Mlle',
								'M' => 'M'
						)
				),
				'attributes' => array (
						'id' => 'CIVILITE',
						'value' => 'M',
				)
		) );
		$this->add ( array (
				'name' => 'SEXE',
				'type' => 'Text',
				'options' => array (
						'label' => 'Sexe',
						
				),
				'attributes' => array (
						'id' => 'SEXE',
						'required' => true,
						'tabindex' => 1,
						'Value'=>"Feminin",
						'readonly' => 'readonly',
				)
		) );
		
		
		$this->add ( array (
				'name' => 'NOM',
				'type' => 'Text',
				'options' => array (
						'label' => 'Nom'
				),
				'attributes' => array (
// 						'class' => 'only_Char',
						'id' => 'NOM',
						'required' => true,
						'tabindex' => 2,
				)
		) );
		

		$this->add ( array (
				'name' => 'NOMPERE',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Nom du pére' )
				),
				'attributes' => array (
				// 						'class' => 'only_Char',
						'id' => 'NOMPERE',
						'required' => true,
						'tabindex' => 2,
				)
		) );
		
		$this->add ( array (
				'name' => 'PRENOM',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Prénom' )
				),
				'attributes' => array (
						'id' => 'PRENOM',
						//'class' => 'only_Char',
						'required' => true,
						'tabindex' => 3,
				)
		) );
		
		$this->add ( array (
				'name' => 'PRENOMPERE',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Prénom du Pére' )
				),
				'attributes' => array (
						'id' => 'PRENOMPERE',
						//'class' => 'only_Char',
						'required' => true,
						'tabindex' => 3,
				)
		) );

		
		$this->add ( array (
				'name' => 'AGE',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Âge' )
				),
				'attributes' => array (
						'id' => 'AGE',
						'tabindex' => 4,
						'required' => true,
				)
		) );
		

		$this->add ( array (
				'name' => 'DATE_NAISSANCE',
				'type' => 'Text',
				'options' => array (
						'label' => 'Date de naissance'
				),
				'attributes' => array (
						'id' => 'DATE_NAISSANCE',
						'tabindex' => 5,
				)
				) );


		$this->add ( array (
				'name' => 'LIEU_NAISSANCE',
				'type' => 'Text',
				'options' => array (
						'label' => 'Lieu de naissance'
				),
				'attributes' => array (
						'id' => 'LIEU_NAISSANCE',
						'tabindex' => 6,
				)
				) );

		$this->add ( array (
				'name' => 'TELEPHONE',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Téléphone' )
				),
				'attributes' => array (
						'id' => 'TELEPHONE',
						'tabindex' => 7,
				)
		) );
		$this->add ( array (
				'name' => 'PROFESSION',
				'type' => 'Text',
				'options' => array (
						'label' => 'Profession'
				),
				'attributes' => array (
						'id' => 'PROFESSION',
						'tabindex' => 8,
				)
		) );
		
		$this->add ( array (
				'name' => 'PROFESSIONPERE',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Profession du Pére' )
				),
				'attributes' => array (
						'id' => 'PROFESSIONPERE',
						'tabindex' => 8,
				)
		) );
		
		$this->add ( array (
				'name' => 'ADRESSE',
				'type' => 'Text',
				'options' => array (
						'label' => 'Adresse'
				),
				'attributes' => array (
						'id' => 'ADRESSE',
						'tabindex' => 9,
				)
		) );
		
		$this->add ( array (
				'type' => 'Zend\Form\Element\Email',
				'name' => 'EMAIL',
				'options' => array (
						'label' => 'Email'
				),
				'attributes' => array (
						'placeholder' => 'votre@domain.com',
						'id' => 'EMAIL',
						'tabindex' => 10,
				)
		) );
		
		$this->add ( array (
				'name' => 'NATIONALITE_ORIGINE',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8','Nationalité origine'),
				),
				'attributes' => array (
						'id' => 'NATIONALITE_ORIGINE',
						'tabindex' => 11,
				)
		) );
		
		$this->add ( array (
				'name' => 'NATIONALITE_ACTUELLE',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8','Nationalité actuelle'),
						'value_options' => array (
								'' => ''
						)
				),
				'attributes' => array (
						'id' => 'NATIONALITE_ACTUELLE',
						'tabindex' => 12,
				)
		
		) );
		
		
		
		

		$this->add ( array (
				'name' => 'NOM_CONJOINT',
				'type' => 'Text',
				'options' => array (
						'label' => 'Nom du conjoint'
				),
				'attributes' => array (
						'id' => 'NOM_CONJOINT',
						'tabindex' => 13,
				)
		) );
		$this->add ( array (
				'name' => 'PRENOM_CONJOINT',
				'type' => 'Text',
				'options' => array (
						'label' => 'Prenom  du conjoint'
				),
				'attributes' => array (
						'id' => 'PRENOM_CONJOINT',
						'tabindex' => 14,
				)
		) );
		$this->add ( array (
				'name' => 'PROFESSION_CONJOINT',
				'type' => 'Text',
				'options' => array (
						'label' => 'Profession du conjoint'
				),
				'attributes' => array (
						'id' => 'PROFESSION_CONJOINT',
						'tabindex' => 15,
				)
		) );
		
		$this->add ( array (
				'name' => 'motif_ad',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Type d\'admission'),
						// 						'value_options' => array (
								// 								'Normal' => 'Normal',
								// 								'Evacuation' => 'Evacuation',
								// 								'Reference' => 'Reference',
		
								// 						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange'=>'getMotif(this.value)',
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
				'name' => 'submit',
				'type' => 'Submit',
				'options' => array (
						'label' => 'Sauvegarder'
				)
		) );
	}
}