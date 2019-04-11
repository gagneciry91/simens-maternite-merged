<?php

namespace Maternite\Form\maternite;

use Zend\Form\Form;
use Zend\Stdlib\DateTime;

class ConsultationForm extends Form {
	public $decor = array (
			'ViewHelper' 
	);
	public function __construct($name = null) {
		parent::__construct ();
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'dmy-His' );
		$heure = $today->format ( "H:i" );
		
		$this->add ( array (
				'name' => 'id_cons',
				'type' => 'hidden',
				'options' => array (
						'label' => 'Code consultation' 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'value' =>  $date,
						'id' => 'id_cons' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'id_grossesse',
				'type' => 'Hidden',
				'attributes' => array (
						'id' => 'id_grossesse'
				)
		) );
		
		
		$this->add ( array (
				'name' => 'id_admission',
				'type' => 'Hidden',
				'attributes' => array (
						'id' => 'id_admission' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'heure_cons',
				'type' => 'Hidden',
				'attributes' => array (
						'value' => $heure 
				) 
		) );
		$this->add ( array (
				'name' => 'id_medecin',
				'type' => 'Hidden',
				'options' => array (
						'decorators' => $this->decor 
				),
				'attributes' => array (
						'id' => 'id_medecin' 
				) 
		) );
		$this->add ( array (
				'name' => 'id_surveillant',
				'type' => 'Hidden',
				'options' => array (
						'decorators' => $this->decor 
				),
				'attributes' => array (
						'id' => 'id_surveillant' 
				) 
		) );
		$this->add ( array (
				'name' => 'id_patient',
				'type' => 'Hidden',
				'options' => array (
						'decorators' => $this->decor 
				),
				'attributes' => array (
						'id' => 'id_patient' 
				) 
		) );
		$this->add ( array (
				'name' => 'dateonly',
				'type' => 'Hidden',
				'options' => array (
						'decorators' => $this->decor 
				),
				'attributes' => array (
						'id' => 'dateonly' 
				) 
		) );
		/*
		 * $this->add ( array ( 'name' => 'motif_admission', 'type' => 'Text', 'options' => array ( 'label' => 'Motif_admission' ) ) );
		 */
		/**
		 * ********* LES MOTIFS D ADMISSION *************
		 */
		/**
		 * ********* LES MOTIFS D ADMISSION *************
		 */
		
	
		/*
		 * $this->add ( array ( 'name' => 'motif_admission2', 'type' => 'Text', 'options' => array ( 'label' => 'Suivi grossesse' ), 'attributes' => array ( 'id' => 'motif_admission2' ) ) ); $this->add ( array ( 'name' => 'motif_admission3', 'type' => 'Text', 'options' => array ( 'label' => 'Nouvelle grossesse' ), 'attributes' => array ( 'id' => 'motif_admission3' ) ) );
		 */
		
		/**
		 * ********DONNEES DE L EXAMEN PHYSIQUE***********
		 */
		/**
		 * ********DONNEES DE L EXAMEN PHYSIQUE***********
		 */
		$this->add ( array (
				'name' => 'examen_maternite_donnee1',
				'type' => 'number',
				'options' => array (					
				),
				'attributes' => array (
						'max' => 20,
						'min'=>0,
						'id' => 'examen_maternite_donnee1' 
				) 
		) );
		$this->add ( array (
				'name' => 'examen_maternite_donnee2',
				'type' => 'number',
				'options' => array (
				),
				'attributes' => array (
						'max' => 20,
						'min'=>0,
						'id' => 'examen_maternite_donnee2' 
				) 
		) );
		
		
		
	
		$this->add(array(
				'name' => 'examen_maternite_donnee3',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','Non') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','Oui') ,
						),
				),
				'attributes' => array(
						'id' => 'examen_maternite_donnee3',
						'registerInArrayValidator'=>true,
					   'onchange'=>' getExamenMaterniteDonnee3(this.value)',
				),
		));
		
		$this->add(array(
				'name' => 'ajou',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','Non') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','Oui') ,
						),
				),
				'attributes' => array(
						'id' => 'ajou',
						'registerInArrayValidator'=>true,
						'onchange'=>' ajouterElement()(this.value)',
						//'required' => true,
				),
		));
		
		$this->add ( array (
				'name' => 'examen_maternite_donnee10',
				'type' => 'Text',
				'options' => array (
						//'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Nombre de BDC' )
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'examen_maternite_donnee10'
				)
		) );
		$this->add ( array (
				'name' => 'examen_maternite_donnee4',
				'type' => 'Text',
				'options' => array (
						//'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'LA' )
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'examen_maternite_donnee4'
				)
		) );
		
			$this->add(array(
				'name' => 'examen_maternite_donnee5',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','Intact') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','Rompue') ,
						),
				),
				'attributes' => array(
						'id' => 'examen_maternite_donnee5',
						'registerInArrayValidator'=>true,
					   'onchange'=>'getExamenMaterniteDonnee5(this.value)',
						//'required' => true,
				),
		));
			$this->add ( array (
					'name' => 'examen_maternite_donnee11',
					'type' => 'Zend\Form\Element\Select',
					'options' => array (
							
							'value_options' => array (
									'clair' => iconv ( 'ISO-8859-1', 'UTF-8', 'Clair' ),
									'tente' => iconv ( 'ISO-8859-1', 'UTF-8', 'Ténté(méconium)' ),
									'hematique' => iconv ( 'ISO-8859-1', 'UTF-8', 'hématique' )
							)
					),
					'attributes' => array (
							//'readonly' => 'readonly',
							'id' => 'examen_maternite_donnee11'
					)
			) );
		$this->add ( array (
				'name' => 'examen_maternite_donnee6',
				'type' => 'Text',
				'options' => array (
						//'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Date Rupture PDE' ) 
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'examen_maternite_donnee6' 
				) 
		) );
		$this->add ( array (
				'name' => 'examen_maternite_donnee7',
				'type' => 'text',
				'options' => array (
						//'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Heure Rupture PDE' ) 
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'examen_maternite_donnee7' 
				) 
		) );
	
	$this->add ( array (
				'name' => 'examen_maternite_donnee9',
			'type' => 'select',
			'options' => array (
					'value_options' => array(
							0 => 'Praticable',
							1 => 'Non Praticable' ,
					),
			),
				'attributes' => array (
						//'readonly' => 'readonly',
						'registerInArrrayValidator' => false,
						//'onclick' => 'toggletexte(this.value)',
						'id' => 'examen_maternite_donnee9' 
				) 
		) );
		

	$this->add(array(
			'name' => 'paleur',
			'type' => 'select',
			'options' => array (
					'value_options' => array(
							0 => 'Non',
							1 => 'Oui' ,
					),
			),
			'attributes' => array(
					'id' => 'paleur',
					//'required' => true,
			),
	));
	$this->add ( array (
			'name' => 'note_tv',
			'type' => 'Text',
			'options' => array (
	
			),
			'attributes' => array (
					//'readonly' => 'readonly',
					'id' => 'note_tv'
			)
	) );
	
	$this->add ( array (
			'name' => 'note_hu',
			'type' => 'Text',
			'options' => array (
	
			),
			'attributes' => array (
					//'readonly' => 'readonly',
					'id' => 'note_hu'
			)
	) );
	
	
	$this->add ( array (
			'name' => 'note_bdc',
			'type' => 'Text',
			'options' => array (
	
			),
			'attributes' => array (
					//'readonly' => 'readonly',
					'id' => 'note_bdc'
			)
	) );
	
	$this->add ( array (
			'name' => 'note_la',
			'type' => 'Text',
			'options' => array (
	
			),
			'attributes' => array (
					//'readonly' => 'readonly',
					'id' => 'note_la'
			)
	) );
	
	
	$this->add ( array (
			'name' => 'note_pde',
			'type' => 'Text',
			'options' => array (
	
			),
			'attributes' => array (
					//'readonly' => 'readonly',
					'id' => 'note_pde'
			)
	) );
	
	
	
	$this->add ( array (
			'name' => 'note_presentation',
			'type' => 'Text',
			'options' => array (
	
			),
			'attributes' => array (
					//'readonly' => 'readonly',
					'id' => 'note_presentation'
			)
	) );
	$this->add ( array (
			'name' => 'note_bassin',
			'type' => 'Text',
			'options' => array (
	
			),
			'attributes' => array (
					//'readonly' => 'readonly',
					'id' => 'note_bassin'
			)
	) );
	
	
	
	
	
	
	
	
	
	
	
		/**
		 * ********** EXAMENS COMPLEMENTAIRES (EXAMENS ET ANALYSE) *************
		 */
		/**
		 * ********** EXAMENS COMPLEMENTAIRES (EXAMENS ET ANALYSE) *************
		 */
		
		/* C)))*********ACTES******** */
		$this->add ( array (
				'name' => 'doppler_couleur_pulse',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Doppler couleur, pulsï¿½, continu, tissulaire:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'doppler_couleur_pulse' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'echographie_de_stress',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Echographie de stress:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'echographie_de_stress' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'holter_ecg',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Holter ECG:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'holter_ecg' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'holter_tensionnel',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Holter tensionnel:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'holter_tensionnel' 
				) 
		) );
		$this->add ( array (
				'name' => 'fibroscopie_bronchique',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Fibroscopie bronchique:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'fibroscopie_bronchique' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'fibroscopie_gastrique',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Fibroscopie gastrique:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'fibroscopie_gastrique' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'colposcopie',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Colposcopie:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'colposcopie' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'echographie_gynecologique',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Echographie gynï¿½cologique:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'echographie_gynecologique' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'echographie_obstetrique',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Echographie obstï¿½trique:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'echographie_obstetrique' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'cpn',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'CPN:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'cpn' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'consultation_senologie',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Consultation sï¿½nologie:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'consultation_senologie' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'plannification_familiale',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Plannification familiale:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'plannification_familiale' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'ecg',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'ECG:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'ecg' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'eeg',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'EEG:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'eeg' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'efr',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'EFR:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'efr' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'emg',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'EMG:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'emg' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'circoncision',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Circoncision:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'circoncision' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'vaccination',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Vaccination:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'vaccination' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'soins_infirmiers',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Soins infirmiers:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'soins_infirmiers' 
				) 
		) );
		
		/* A)))*********ANALYSE BIOLOGIQUE******** */
		$this->add ( array (
				'name' => 'groupe_sanguin',
				'type' => 'Text',
				'options' => array (
						'label' => 'Groupe Sanguin: ' 
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'groupe_sanguin' 
				) 
		) );
		$this->add ( array (
				'name' => 'hemogramme_sanguin',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Hemogramme sanguin' ) 
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'hemogramme_sanguin' 
				) 
		) );
		$this->add ( array (
				'name' => 'bilan_hemolyse',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Bilan de l\'hémostase:' ) 
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'bilan_hemolyse' 
				) 
		) );
		$this->add ( array (
				'name' => 'bilan_hepatique',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Bilan hépatique:' ) 
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'bilan_hepatique' 
				) 
		) );
		$this->add ( array (
				'name' => 'bilan_renal',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Bilan rénal:' ) 
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'bilan_renal' 
				) 
		) );
		$this->add ( array (
				'name' => 'bilan_inflammatoire',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Bilan inflammatoire:' ) 
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'bilan_inflammatoire' 
				) 
		) );
		/* B)))*********EXAMEN MORPHOLOGIQUE******** */
		/**
		 * * Les balises images dans cette partie ne sont pas utilisï¿½es**
		 */
		$this->add ( array (
				'name' => 'radio',
				'type' => 'Textarea',
				'options' => array (
						'label' => 'Radio:' 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'radio' 
				) 
		) );
		/**
		 * *** image de la radio ****
		 */
		$this->add ( array (
				'name' => 'radio_image',
				'type' => 'Image' 
		) );
		/* --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> */
		$this->add ( array (
				'name' => 'ecographie',
				'type' => 'Textarea',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Echographie: ' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'ecographie' 
				) 
		) );
		/**
		 * *** image de l'ecographie ****
		 */
		$this->add ( array (
				'name' => 'ecographie_image',
				'type' => 'Image' 
		) );
		/* --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> */
		$this->add ( array (
				'name' => 'fibrocospie',
				'type' => 'Textarea',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Fibroscopie: ' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'fibrocospie' 
				) 
		) );
		/**
		 * *** image de la fibroscopie ****
		 */
		$this->add ( array (
				'name' => 'fibroscopie_image',
				'type' => 'Image' 
		) );
		/* --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> */
		$this->add ( array (
				'name' => 'scanner',
				'type' => 'Textarea',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Scanner: ' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'scanner' 
				) 
		) );
		/**
		 * *** image du scanner ****
		 */
		$this->add ( array (
				'name' => 'scanner_image',
				'type' => 'Image' 
		) );
		/* --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> */
		$this->add ( array (
				'name' => 'irm',
				'type' => 'Textarea',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'IRM: ' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'irm' 
				) 
		) );
		/**
		 * *** image de l'irm ****
		 */
		$this->add ( array (
				'name' => '$irm_image',
				'type' => 'Image' 
		) );
		/* --->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> */
		
		/**
		 * ********************************* DIAGNOSTICS *******************************
		 */
		/**
		 * ********************************* DIAGNOSTICS *******************************
		 */
		$this->add ( array (
				'name' => 'diagnostic1',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Diagnostic 1: ' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'diagnostic1' 
				) 
		) );
		$this->add ( array (
				'name' => 'diagnostic2',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Diagnostic 2: ' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'diagnostic2' 
				) 
		) );
		$this->add ( array (
				'name' => 'diagnostic3',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Diagnostic 3: ' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'diagnostic3' 
				) 
		) );
		$this->add ( array (
				'name' => 'diagnostic4',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Diagnostic 4: ' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'diagnostic4' 
				) 
		) );
		$this->add ( array (
				'name' => 'decisions',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Decisions: ' )
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'decisions'
				)
		) );
		/**
		 * ************************* CONSTANTES *****************************************************
		 */
		/**
		 * ************************* CONSTANTES *****************************************************
		 */
		/**
		 * ************************* CONSTANTES *****************************************************
		 */
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
				'name' => 'poids',
				'type' => 'Text',
				'options' => array (
						'label' => 'Poids (kg)' 
				),
				'attributes' => array (
						'class' => 'poids_only_numeric',
						//'readonly' => 'readonly',
						'id' => 'poids' 
				) 
		) );

$this->add(array(
				'name' => 'paleur',
				'type' => 'select',
				'options' => array (
						'value_options' => array(
								0 => 'Non',
								1 => 'Oui' ,
						),
				),
				'attributes' => array(
						'id' => 'paleur',
						//'required' => true,
				),
		));
		
		
		
		
		
		
		
		$this->add ( array (
				'name' => 'glycemie_capillaire',
				'type' => 'Number',
				'options' => array (),
				// 'label' => iconv('ISO-8859-1', 'UTF-8', 'GlycÃ©mie capillaire (g/l)')
				'attributes' => array (
						'class' => 'glycemie_only_numeric',
						//'readonly' => 'readonly',
						'id' => 'glycemie_capillaire'
				)
		) );
		$this->add ( array (
				'name' => 'bu',
				'type' => 'Text',
				'options' => array (
						'label' => 'Bandelette urinaire'
				),
				'attributes' => array (
						'class' => 'bu_only_numeric',
						'readonly' => 'readonly',
						'id' => 'bu'
				)
		) );
		
		$this->add ( array (
				'name' => 'albumine',
				'type' => 'radio',
				'options' => array (
						'value_options' => array (
								'0' => 'â€“',
								'1' => '+'
						)
				),
				'attributes' => array (
						'id' => 'albumine'
				)
		)
		);
		$this->add ( array (
				'name' => 'croixalbumine',
				'type' => 'radio',
				'options' => array (
						'value_options' => array (
								'1' => '1',
								'2' => '2',
								'3' => '3',
								'4' => '4'
						)
				),
				'attributes' => array (
						'id' => 'croixalbumine'
				)
		)
		);
		
		$this->add ( array (
				'name' => 'sucre',
				'type' => 'radio',
				'options' => array (
						'value_options' => array (
								'0' => 'â€“',
								'1' => '+'
						)
				),
				'attributes' => array (
						'id' => 'sucre'
				)
		)
		);
		$this->add ( array (
				'name' => 'croixsucre',
				'type' => 'radio',
				'options' => array (
						'value_options' => array (
								'1' => '1',
								'2' => '2',
								'3' => '3',
								'4' => '4'
						)
				),
				'attributes' => array (
						'id' => 'croixsucre'
				)
		)
		);
		
		$this->add ( array (
				'name' => 'corpscetonique',
				'type' => 'radio',
				'options' => array (
						'value_options' => array (
								'0' => 'â€“',
								'1' => '+'
						)
				),
				'attributes' => array (
						'id' => 'corpscetonique'
				)
		)
		);
		$this->add ( array (
				'name' => 'croixcorpscetonique',
				'type' => 'radio',
				'options' => array (
						'value_options' => array (
								'1' => '1',
								'2' => '2',
								'3' => '3',
								'4' => '4'
						)
				),
				'attributes' => array (
						'id' => 'croixcorpscetonique',
						'class' => 'croixcorpscetonique'
				)
		)
		);
		
		
		
		
		
		
		
		
		
		
		$this->add ( array (
				'name' => 'taille',
				'type' => 'Text',
				'options' => array (
						'label' => 'Taille (cm)' 
				),
				'attributes' => array (
						'class' => 'taille_only_numeric',
						'readonly' => 'readonly',
						'id' => 'taille' 
				) 
		) );
		$this->add ( array (
				'name' => 'col',
				'type' => 'Text',
				'options' => array (
						'label' => 'COL (cm)'
				),
				'attributes' => array (
						'class' => 'taille_only_numeric',
						'readonly' => 'readonly',
						'id' => 'col'
				)
		) );
		$this->add ( array (
				'name' => 'hu',
				'type' => 'Text',
				'options' => array (
						'label' => 'HU (cm)'
				),
				'attributes' => array (
						'class' => 'taille_only_numeric',
						'readonly' => 'readonly',
						'id' => 'hu'
				)
		) );
		$this->add ( array (
				'name' => 'temperature',
				'type' => 'Number',
				'options' => array (),
				// 'label' => iconv ( 'UTF-8','ISO-8859-1', 'TempÃ©rature (Â°C)' )
				'attributes' => array (
						'class' => 'temperature_only_numeric',
						//'readonly' => 'readonly',
						'min'=>34,
						'id' => 'temperature' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'tension',
				'type' => 'Number',
				'options' => array (
						'label' => 'Tension' 
				),
				'attributes' => array (
						'class' => 'tension_only_numeric',
						'readonly' => 'readonly',
				
						'id' => 'tension' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'pressionarterielle',
				'type' => 'Number',
				'options' => array (),
				// 'label' => iconv('ISO-8859-1', 'UTF-8', 'Pression artï¿½rielle (mmHg)')
				'attributes' => array (
						'class' => 'tension_only_numeric',
						
						'id' => 'pressionarterielle' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'tensionmaximale',
				'type' => 'Number',
				'attributes' => array (
						'class' => 'tension_only_numeric',
						'id' => 'tensionmaximale' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'tensionminimale',
				'type' => 'Number',
				'attributes' => array (
						'class' => 'tension_only_numeric',
						'id' => 'tensionminimale' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'pouls',
				'type' => 'Text',
				'options' => array (
						'label' => 'Pouls (bat/min)' 
				),
				'attributes' => array (
						'class' => 'pouls_only_numeric',
						'readonly' => 'readonly',
						'id' => 'pouls' 
				) 
		) );
		$this->add ( array (
				'name' => 'frequence_respiratoire',
				'type' => 'Text',
				'options' => array (),
				// 'label' => iconv('ISO-8859-1', 'UTF-8','FrÃ©quence respiratoire')
				'attributes' => array (
						'class' => 'frequence_only_numeric',
						'readonly' => 'readonly',
						'id' => 'frequence_respiratoire' 
				) 
		) );
		
		
		
	
		$this->add ( array (
				'name' => 'glycemie_capillaire',
				'type' => 'Number',
				'options' => array (),
				// 'label' => iconv('ISO-8859-1', 'UTF-8', 'GlycÃ©mie capillaire (g/l)')
				'attributes' => array (
						'class' => 'glycemie_only_numeric',
						'any' => 'any',
						'id' => 'glycemie_capillaire'
				)
		) );
		
		$this->add ( array (
				'name' => 'observation',
				'type' => 'Textarea',
				'options' => array (
						'label' => 'Observations' 
				),
				'attributes' => array (
						'rows' => 1,
						'cols' => 180 
				) 
		) );
		$this->add ( array (
				'name' => 'submit',
				'type' => 'Submit',
				'options' => array (
						'label' => 'Valider' 
				) 
		) );
		// ************** TRAITEMENTS *************
		// ************** TRAITEMENTS *************
		// ************** TRAITEMENTS *************
		/**
		 * ************* traitement chirurgicaux ************
		 */
		/**
		 * ************* traitement chirurgicaux ************
		 */
		$this->add ( array (
				'name' => 'diagnostic_traitement_chirurgical',
				'type' => 'Textarea',
				'options' => array (
						'label' => 'Diagnostic :' 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'diagnostic_traitement_chirurgical' 
				) 
		) );
		$this->add ( array (
				'name' => 'text_chirur',
				'type' => 'Textarea',
				'options' => array (
						//'label' => 'CHirurgie :'
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'text_chirur'
				)
		) );
		$this->add ( array (
				'name' => 'type_anesthesie_demande',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Type d\'anesthï¿½sie :' ),
						'value_options' => array (
								'1' => iconv ( 'ISO-8859-1', 'UTF-8', 'Anesthï¿½sie1' ),
								'2' => iconv ( 'ISO-8859-1', 'UTF-8', 'Anesthï¿½sie2' ),
								'3' => iconv ( 'ISO-8859-1', 'UTF-8', 'Anesthï¿½sie3' ) 
						) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'type_anesthesie_demande' 
				) 
		) );
		$this->add ( array (
				'name' => 'observation',
				'type' => 'Textarea',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Observation :' )
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'observation'
				)
		) );
		$this->add ( array (
				'name' => 'intervention_prevue',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Intervention Prï¿½vue :' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'intervention_prevue' 
				) 
		) );
		$this->add ( array (
				'name' => 'numero_vpa',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'VPA Numï¿½ro:' ) 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'numero_vpa' 
				) 
		) );
		$this->add ( array (
				'name' => 'observations',
				'type' => 'Textarea',
				'options' => array (
						//'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Observation :' ) 
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'observations' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'note_compte_rendu_operatoire',
				'type' => 'Textarea',
				'options' => array (
						//'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Protocole opératoire' ) 
				),
				'attributes' => array (
						'id' => 'note_compte_rendu_operatoire' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'note_compte_rendu_operatoire_instrumental',
				'type' => 'Textarea',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Note :' ) 
				),
				'attributes' => array (
						'id' => 'note_compte_rendu_operatoire_instrumental' 
				) 
		) );
		/**
		 * ************* Autres (Transfert / hospitalisation / Rendez-vous! ************
		 */
		/**
		 * ************* Autres (Transfert / hospitalisation / Rendez-vous! ************
		 */
		/**
		 * ************* Autres (Transfert / hospitalisation / Rendez-vous! ************
		 */
		
		/* A))************** Transfert ************ */
		/*A))************** Transfert *************/
		$this->add ( array (
				'name' => 'hopital_accueil',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Hopital d\'accueil :' ) 
				// 'value_options' => array (
				// 'zzz' => 'zzz'
				// )
								),
				'attributes' => array (
						'registerInArrrayValidator' => false,
						'onchange' => 'getservices(this.value)',
						'id' => 'hopital_accueil' 
				) 
		) );
		$this->add ( array (
				'name' => 'service_accueil',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Service d\'accueil :' ) 
				// 'value_options' => array (
				// '' => ''
				// )
								),
				'attributes' => array (
						'registerInArrrayValidator' => false,
						'id' => 'service_accueil' 
				) 
		) );
		$this->add ( array (
				'name' => 'motif_transfert',
				'type' => 'Textarea',
				'options' => array (
						'label' => 'Motif du transfert :' 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'motif_transfert' 
				) 
		) );
		/* B))************** Hospitalisation ************ */
		/*B))************** Hospitalisation *************/
		$this->add ( array (
				'name' => 'motif_hospitalisation',
				'type' => 'Textarea',
				'options' => array (
						'label' => 'Motif hospitalisation :' 
				),
				'attributes' => array (
						'id' => 'motif_hospitalisation' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'date_fin_hospitalisation_prevue',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Date fin prï¿½vue :' ) 
				),
				'attributes' => array (
						'id' => 'date_fin_hospitalisation_prevue' 
				) 
		) );
		
		/* C))************** Rendez-vous ************ */
		/*C))************** Rendez-vous *************/
		$this->add ( array (
				'name' => 'motif_rv',
				'type' => 'Textarea',
				'options' => array (
						'label' => 'Motif du rendez-vous :' 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'motif_rv' 
				) 
		) );
		$this->add ( array (
				'name' => 'habitude_vie1',
				'type' => 'Text',
				'options' => array (
						'label' => 'Habitude de vie 1' 
				),
				'attributes' => array (
						'id' => 'habitude_vie1' 
				) 
		) );
		$this->add ( array (
				'name' => 'habitude_vie2',
				'type' => 'Text',
				'options' => array (
						'label' => 'Habitude de vie 2' 
				),
				'attributes' => array (
						'id' => 'habitude_vie2' 
				) 
		) );
		$this->add ( array (
				'name' => 'habitude_vie3',
				'type' => 'Text',
				'options' => array (
						'label' => 'Habitude de vie 3' 
				),
				'attributes' => array (
						'id' => 'habitude_vie3' 
				) 
		) );
		$this->add ( array (
				'name' => 'habitude_vie4',
				'type' => 'Text',
				'options' => array (
						'label' => 'Habitude de vie 4' 
				),
				'attributes' => array (
						'id' => 'habitude_vie4' 
				) 
		) );
		$this->add ( array (
				'name' => 'antecedent_familial1',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Antï¿½cï¿½dent 1' ) 
				),
				'attributes' => array (
						'id' => 'antecedent_familial1' 
				) 
		) );
		$this->add ( array (
				'name' => 'antecedent_familial2',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Antï¿½cï¿½dent 2' ) 
				),
				'attributes' => array (
						'id' => 'antecedent_familial2' 
				) 
		) );
		$this->add ( array (
				'name' => 'antecedent_familial3',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Antï¿½cï¿½dent 3' ) 
				),
				'attributes' => array (
						'id' => 'antecedent_familial3' 
				) 
		) );
		$this->add ( array (
				'name' => 'antecedent_familial4',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Antï¿½cï¿½dent 4' ) 
				),
				'attributes' => array (
						'id' => 'antecedent_familial4' 
				) 
		) );
		$this->add ( array (
				'name' => 'date_rv',
				'type' => 'Text',
				'options' => array (
						'label' => 'Date :' 
				),
				'attributes' => array (
						'id' => 'date_rv' 
				) 
		) );
		$this->add ( array (
				'name' => 'heure_rv',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => 'Heure :',
						'empty_option' => 'Choisir',
						'value_options' => array (
								'08:00' => '08:00',
								'09:00' => '09:00',
								'10:00' => '10:00',
								'15:00' => '15:00',
								'16:00' => '16:00' 
						) 
				),
				'attributes' => array (
						'id' => 'heure_rv' 
				) 
		) );
		
		/**
		 * LES HISTORIQUES OU TERRAINS PARTICULIERS
		 * LES HISTORIQUES OU TERRAINS PARTICULIERS
		 * LES HISTORIQUES OU TERRAINS PARTICULIERS
		 */
		/**
		 * ** ANTECEDENTS PERSONNELS ***
		 */
		/**
		 * ** ANTECEDENTS PERSONNELS ***
		 */
		
		/* LES HABITUDES DE VIE DU PATIENTS */
		/*Alcoolique*/
		$this->add ( array (
				'name' => 'AlcooliqueHV',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'AlcooliqueHV' 
				) 
		) );
		$this->add ( array (
				'name' => 'DateDebutAlcooliqueHV',
				'type' => 'text',
				'attributes' => array (
						'id' => 'DateDebutAlcooliqueHV' 
				) 
		) );
		$this->add ( array (
				'name' => 'DateFinAlcooliqueHV',
				'type' => 'text',
				'attributes' => array (
						'id' => 'DateFinAlcooliqueHV' 
				) 
		) );
		$this->add ( array (
				'name' => 'AutresHV',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'AutresHV' 
				) 
		) );
		$this->add ( array (
				'name' => 'NoteAutresHV',
				'type' => 'text',
				'attributes' => array (
						'id' => 'NoteAutresHV' 
				) 
		) );
		/* Fumeur */
		$this->add ( array (
				'name' => 'FumeurHV',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'FumeurHV' 
				) 
		) );
		$this->add ( array (
				'name' => 'DateDebutFumeurHV',
				'type' => 'text',
				'attributes' => array (
						'id' => 'DateDebutFumeurHV' 
				) 
		) );
		$this->add ( array (
				'name' => 'DateFinFumeurHV',
				'type' => 'text',
				'attributes' => array (
						'id' => 'DateFinFumeurHV' 
				) 
		) );
		$this->add ( array (
				'name' => 'nbPaquetFumeurHV',
				'type' => 'text',
				'attributes' => array (
						'id' => 'nbPaquetFumeurHV' 
				) 
		) );
		$this->add ( array (
				'name' => 'nbPaquetAnneeFumeurHV',
				'type' => 'text',
				'attributes' => array (
						'id' => 'nbPaquetAnneeFumeurHV' 
				) 
		) );
		/* Droguï¿½ */
		$this->add ( array (
				'name' => 'DroguerHV',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'DroguerHV' 
				) 
		) );
		$this->add ( array (
				'name' => 'DateDebutDroguerHV',
				'type' => 'text',
				'attributes' => array (
						'id' => 'DateDebutDroguerHV' 
				) 
		) );
		$this->add ( array (
				'name' => 'DateFinDroguerHV',
				'type' => 'text',
				'attributes' => array (
						'id' => 'DateFinDroguerHV' 
				) 
		) );
		/* LES ANTECEDENTS MEDICAUX */
		/*Diabete*/
		$this->add ( array (
				'name' => 'DiabeteAM',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'DiabeteAM' 
				) 
		) );
		/* HTA */
		$this->add ( array (
				'name' => 'htaAM',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'htaAM' 
				) 
		) );
		/* Drepanocytose */
		$this->add ( array (
				'name' => 'drepanocytoseAM',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'drepanocytoseAM' 
				) 
		) );
		/* Dislipidemie */
		$this->add ( array (
				'name' => 'dislipidemieAM',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'dislipidemieAM' 
				) 
		) );
		/* Asthme */
		$this->add ( array (
				'name' => 'asthmeAM',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'asthmeAM' 
				) 
		) );
		/* Autre */
		$this->add ( array (
				'name' => 'autresAM',
				'type' => 'text',
				'attributes' => array (
						'id' => 'autresAM',
						'maxlength' => 13 
				) 
		) );
		/* nbCheckbox */
		$this->add ( array (
				'name' => 'nbCheckboxAM',
				'type' => 'hidden',
				'attributes' => array (
						'id' => 'nbCheckboxAM' 
				) 
		) );
		/* GYNECO-OBSTETRIQUE */
		/*Menarche*/
		$this->add ( array (
				'name' => 'MenarcheGO',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'MenarcheGO' 
				) 
		) );
		/* Note Menarche */
		$this->add ( array (
				'name' => 'NoteMenarcheGO',
				'type' => 'text',
				'attributes' => array (
						'id' => 'NoteMenarcheGO' 
				) 
		) );
		
		/* Enf Viv */
		$this->add ( array (
				'name' => 'EnfVivGO',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'EnfVivGO' 
				) 
		) );
		/* Note Enf Viv */
		$this->add ( array (
				'name' => 'NoteEnfVivGO',
				'type' => 'text',
				'attributes' => array (
						'id' => 'NoteEnfVivGO' 
				) 
		) );
		
		/* Eclampsie */
		$this->add ( array (
				'name' => 'EclampsieGO',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'EclampsieGO' 
				) 
		) );
		/* Note Eclampsie */
		$this->add ( array (
				'name' => 'NoteEclampsieGO',
				'type' => 'text',
				'attributes' => array (
						'id' => 'NoteEclampsieGO' 
				) 
		)
		 );
		
		/* Cesarienne */
		$this->add ( array (
				'name' => 'CesarienneGO',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'CesarienneGO' 
				) 
		) );
		/* Note Cesarienne */
		$this->add ( array (
				'name' => 'NoteCesarienneGO',
				'type' => 'text',
				'attributes' => array (
						'id' => 'NoteCesarienneGO' 
				) 
		)
		 );
		
		/* Mort-Ne */
		$this->add ( array (
				'name' => 'MortNeGO',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'MortNeGO' 
				) 
		) );
		/* Note Mort-NÃ© */
		$this->add ( array (
				'name' => 'NoteMortNeGO',
				'type' => 'text',
				'attributes' => array (
						'id' => 'NoteMortNeGO' 
				) 
		)
		 );
		
		/* Dystocie */
		$this->add ( array (
				'name' => 'DystocieGO',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'DystocieGO' 
				) 
		) );
		/* Note Dystocie */
		$this->add ( array (
				'name' => 'NoteDystocieGO',
				'type' => 'text',
				'attributes' => array (
						'id' => 'NoteDystocieGO' 
				) 
		)
		 );
		
		/* Gestite */
		$this->add ( array (
				'name' => 'GestiteGO',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'GestiteGO' 
				) 
		) );
		/* Note Gestite */
		$this->add ( array (
				'name' => 'NoteGestiteGO',
				'type' => 'text',
				'attributes' => array (
						'id' => 'NoteGestiteGO' 
				) 
		) );
		
		/* Parite */
		$this->add ( array (
				'name' => 'PariteGO',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'PariteGO' 
				) 
		) );
		/* Note Parite */
		$this->add ( array (
				'name' => 'NotePariteGO',
				'type' => 'text',
				'attributes' => array (
						'id' => 'NotePariteGO' 
				) 
		) );
		
		/* Cycle */
// 		$this->add ( array (
// 				'name' => 'cycle',
// 				'type' => 'checkbox',
// 				'attributes' => array (
// 						'id' => 'cycle' 
// 				) 
// 		) );
		
		$this->add(array(
				'name' => 'note_cycle',
				'type' => 'Text',
				'options' => array (
		
				),
				'attributes' => array(
						'id' => 'note_cycle',
						//'required' => true,
				),
		));
		/* Duree Cycle */
		$this->add ( array (
				'name' => 'duree_cycle',
				'type' => 'Number',
				'attributes' => array (
						'id' => 'duree_cycle' 
				) 
		) );
		
		
		
	
		
		
		/* Regularite cycle */
		$this->add ( array (
				'name' => 'regularite',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'value_options' => array (
								0 => 'Regulier',
								1 => 'Irregulier',
								
						) 
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange'=>' getCycle(this.value)',
						'id' => 'regularite' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'quantite_regle',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'value_options' => array (
								0 => 'non abnte',
								1 => ' abondate',
								
						) 
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange'=>' getQuantite(this.value)',
						'id' => 'quantite_regle' 
				) 
		) );
		$this->add ( array (
				'name' => 'nb_garniture_jr',
				'type' => 'Text',
				'options' => array (
		
				),
				'attributes' => array (
						'id' => 'nb_garniture_jr'
				)
		) );
		
		
		$this->add(array(
				'name' => 'contraception',
				'type' => 'select',
				'options' => array (
						'value_options' => array(
								0 => 'Non',
								1 => 'Oui' ,
						),
				),
				'attributes' => array(
						'registerInArrrayValidator' => true,
						'onchange'=>' getContraception(this.value)',
						'id' => 'contraception',
						//'required' => true,
				),
		));
		$this->add ( array (
				'name' => 'type_contraception',
				'type' => 'Text',
				'options' => array (
		
				),
				'attributes' => array (
						'id' => 'type_contraception'
				)
		) );
		$this->add ( array (
				'name' => 'duree_contraception',
				'type' => 'Text',
				'options' => array (
		
				),
				'attributes' => array (
						'id' => 'duree_contraception'
				)
		) );
		$this->add ( array (
				'name' => 'note_contraception',
				'type' => 'Text',
				'options' => array (
		
				),
				'attributes' => array (
						'id' => 'note_contraception'
				)
		) );
		/* Dysmenorrhee cycle */
		$this->add ( array (
				'name' => 'DysmenorrheeCycleGO',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'value_options' => array (
								' ' => '',
								'1' => 'Oui',
								'0' => 'Non' 
						) 
				),
				'attributes' => array (
						'id' => 'DysmenorrheeCycleGO' 
				) 
		) );
		
		/* Autres */
		$this->add ( array (
				'name' => 'autre_go',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'autre_go' 
				) 
		) );
		/* Note Autres */
		$this->add ( array (
				'name' => 'note_autre_go',
				'type' => 'text',
				'attributes' => array (
						'id' => 'note_autre_go' 
				) 
		) );
		
		
	$this->add ( array (
				'name' => 'groupe_sanguins',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'value_options' => array (
								'A' => 'A',
								'B' => 'B', 
								'AB' => 'AB',
								'O' => 'O',
						) 
				),
				'attributes' => array (
						'id' => 'groupe_sanguins' 
				) 
		) );
		$this->add ( array (
				'name' => 'rhesus',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'value_options' => array (
								' -' => '-',
								'+' => '+',
						)
				),
				'attributes' => array (
						'id' => 'rhesus'
				)
		) );
		$this->add ( array (
				'name' => 'note_gs',
				'type' => 'text',
				'attributes' => array (
						'id' => 'note_gs'
				)
		) );
		
		
		$this->add ( array (
				'name' => 'test_emmel',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'value_options' => array (
								0 => '-',
								1 => '+',
						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange'=>' getTest(this.value)',
						'id' => 'test_emmel'
				)
		) );
		
		$this->add ( array (
				'name' => 'profil_emmel',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'value_options' => array (
								1 => 'AS',
							2 => 'SS',
								3=> 'Autre',
						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange'=>' getProfil(this.value)',
						'id' => 'profil_emmel'
				)
		) );
		
		$this->add ( array (
				'name' => 'note_emmel',
				'type' => 'text',
				'attributes' => array (
						'id' => 'note_emmel'
				)
		) );
		
		
		
		/**
		 * ** ANTECEDENTS FAMILIAUX ***
		 */
		/**
		 * ** ANTECEDENTS FAMILIAUX ***
		 */
		
		/* Diabete */
		$this->add ( array (
				'name' => 'DiabeteAF',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'DiabeteAF' 
				) 
		) );
		/* Note Diabete */
		$this->add ( array (
				'name' => 'NoteDiabeteAF',
				'type' => 'text',
				'attributes' => array (
						'id' => 'NoteDiabeteAF' 
				) 
		) );
		
		/* Drepanocytose */
		$this->add ( array (
				'name' => 'DrepanocytoseAF',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'DrepanocytoseAF' 
				) 
		) );
		/* Note Drepanocytose */
		$this->add ( array (
				'name' => 'NoteDrepanocytoseAF',
				'type' => 'text',
				'attributes' => array (
						'id' => 'NoteDrepanocytoseAF' 
				) 
		) );
		
		/* HTA */
		$this->add ( array (
				'name' => 'htaAF',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'htaAF' 
				) 
		) );
		/* Note HTA */
		$this->add ( array (
				'name' => 'NoteHtaAF',
				'type' => 'text',
				'attributes' => array (
						'id' => 'NoteHtaAF' 
				) 
		) );
		
		/* Autres */
		$this->add ( array (
				'name' => 'autresAF',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'autresAF' 
				) 
		) );
		$this->add ( array (
				'name' => 'nbCheckboxAF',
				'type' => 'hidden',
				'attributes' => array (
						'id' => 'nbCheckboxAF'
				)
		) );
		/* Note Autres */
		$this->add ( array (
				'name' => 'NoteAutresAF',
				'type' => 'textarea',
				'attributes' => array (
						'id' => 'NoteAutresAF' 
				) 
		) );
		
		/**
		 * ** TRAITEMENTS CHIRURGICAUX ***
		 */
		/**
		 * ** TRAITEMENTS CHIRURCICAUX ***
		 */
		$this->add ( array (
				'name' => 'traitement_chirur',
				'type' => 'Textarea',
				'options' => array (
						//'label' => 'CHirurgie :'
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'traitement_chirur'
				)
		) );
		$this->add ( array (
				'name' => 'endoscopieInterventionnelle',
				'type' => 'Text',
				'options' => array (
						'label' => 'Endoscopie Interventionnelle :' 
				),
				'attributes' => array (
						'id' => 'endoscopieInterventionnelle' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'radiologieInterventionnelle',
				'type' => 'Text',
				'options' => array (
						'label' => 'Radiologie Interventionnelle :' 
				),
				'attributes' => array (
						'id' => 'radiologieInterventionnelle' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'cardiologieInterventionnelle',
				'type' => 'Text',
				'options' => array (
						'label' => 'Cardiologie Interventionnelle :' 
				),
				'attributes' => array (
						'id' => 'cardiologieInterventionnelle' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'autresIntervention',
				'type' => 'Text',
				'options' => array (
						'label' => 'Autres interventions:' 
				),
				'attributes' => array (
						'id' => 'autresIntervention' 
				) 
		) );
		
		
		
	
		$this->add ( array (
				'name' => 'examen_maternite_donnee8',
				'type' => 'Select',
				'options' => array (
						//'label' => iconv('ISO-8859-1', 'UTF-8','Type D\'Accouchemet:'),
						'value_options' => array (
								''=>''
						)
				),
				'attributes' => array (
						'readonly' => 'readonly',
						
						'id' => 'examen_maternite_donnee8'
				)
		) );

		$this->add ( array (
				'name' => 'type_accouchement',
				'type' => 'Select',
				'options' => array (
						//'label' => iconv('ISO-8859-1', 'UTF-8','Type D\'Accouchemet:'),
						'value_options' => array (
								''=>''
						)
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'registerInArrrayValidator' => true,
						'onchange'=>' getAccouchement(this.value)',
						'id' => 'type_accouchement',
						//'required' => true,
				)
		) );
		
		$this->add ( array (
				'name' => 'motif_type',
				'type' => 'text',
				'attributes' => array (
						'id' => 'motif_type'
				)
		) );
		
		
		
		
		
		
		
		
		$this->add ( array (
				'name' => 'date_accouchement',
				'type' => 'text',
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'date_accouchement'
				)
		) );
		
		
		
		$this->add ( array (
				'name' => 'heure_accouchement',
				'type' => 'text',
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'heure_accouchement'
				)
		) );
		
		
		
		
			$this->add ( array (
				'name' => 'delivrance',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						//'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Mode de delivrance :' ),
						'value_options' => array (
								'Spontanee' => iconv ( 'ISO-8859-1', 'UTF-8', 'Spontannee' ),
								'DA' => iconv ( 'ISO-8859-1', 'UTF-8', 'DA ' ),
								'GATPA' => iconv ( 'ISO-8859-1', 'UTF-8', 'GATPA' ),
								
						)
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'id' => 'delivrance'
				)
		) );
	
		
	$this->add(array(
				'name' => 'ru',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => 'Non',
								 1=> 'Oui' ,
						),
				),
				'attributes' => array(
						'id' => 'ru',
						
				),
		));
		$this->add(array(
				'name' => 'hemoragie',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => 'Non',
								 1=> 'Oui' ,
						),
				),
				'attributes' => array(
						'id' => 'hemoragie',
						
						//'required' => true,
				),
		));
		$this->add(array(
				'name' => 'quantite_hemo',
				'type' => 'Number',
				'attributes' => array(
							
						'id' => 'quantite_hemo',
						//'readonly' => 'readonly',
						//'required' => true,
				),
		));
		$this->add(array(
				'name' => 'note_accouchement',
				'type' => 'Text',
				'attributes' => array(
					
						'id' => 'note_accouchement',
						//'readonly' => 'readonly',
						//'required' => true,
				),
		));
		
		$this->add(array(
				'name' => 'note_delivrance',
				'type' => 'Text',
				'attributes' => array(
						
						'id' => 'note_delivrance',
						//'readonly' => 'readonly',
						//'required' => true,
				),
		));
		$this->add(array(
				'name' => 'note_hemorragie',
				'type' => 'Text',
				'attributes' => array(
						//'readonly' => 'readonly',
						'id' => 'note_hemorragie',
					
						//'required' => true,
				),
		));
		
		$this->add(array(
				'name' => 'note_ocytocique',
				'type' => 'Text',
				'attributes' => array(
					
						'id' => 'note_ocytocique',
						//'readonly' => 'readonly',
						//'required' => true,
				),
		));
		
		
		$this->add(array(
				'name' => 'note_antibiotique',
				'type' => 'Text',
				'attributes' => array(
						
						'id' => 'note_antibiotique',
						//'readonly' => 'readonly',
						//'required' => true,
				),
		));
		
		
		$this->add(array(
				'name' => 'note_anticonv',
				'type' => 'Text',
				'attributes' => array(
						
						'id' => 'note_anticonv',
						//'readonly' => 'readonly',
						//'required' => true,
				),
		));
		

		$this->add(array(
				'name' => 'note_transfusion',
				'type' => 'Text',
				'attributes' => array(
						
						'id' => 'note_transfusion',
						//'readonly' => 'readonly',
						//'required' => true,
				),
		));
	$this->add(array(
				'name' => 'ocytocique_per',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => 'Non',
								 1=> 'Oui' ,
						),
				),
				'attributes' => array(
						'id' => 'ocytocique_per',
						
						//'required' => true,
				),
		));
		
		
		
		$this->add(array(
				'name' => 'ocytocique_post',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => 'Non',
								 1=> 'Oui' ,
						),
				),
				'attributes' => array(
						'id' => 'ocytocique_post',
						
						
				),
		));
		
		

		$this->add(array(
				'name' => 'antibiotique',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
							0 => 'Non',
							1=> 'Oui' ,
						),
				),
				'attributes' => array(
						//'readonly' => 'readonly',
						'id' => 'antibiotique',
					
				),
		));
		
		$this->add(array(
				'name' => 'anticonvulsant',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
							0 => 'Non',
						     1=> 'Oui' ,
						),
				),
				'attributes' => array(
						//'readonly' => 'readonly',
						'id' => 'anticonvulsant',
						
				),
		));
		
		
		$this->add(array(
				'name' => 'transfusion',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
							0 => 'Non',
							1=> 'Oui' ,
						),
				),
				'attributes' => array(
						//'readonly' => 'readonly',
						'id' => 'transfusion',
						
				),
		));
		


	$this->add ( array (
			'name' => 'motif_ad',
			'type' => 'Text',
			'options' => array (
			),
			'attributes' => array (
					'registerInArrrayValidator' => true,
					'onchange'=>'getMotif(this.value)',
					'id' =>'motif_ad',
						'readonly' => 'readonly',
			)
	) );
	
	$this->add ( array (
			'name' => 'type_ad',
			'type' => 'Text',
			'options' => array (
			
			),
			'attributes' => array (
					'registerInArrrayValidator' => true,
					'onchange'=>'getMotif(this.value)',
					'id' =>'type_ad',
					//'required' => false,
			)
	) );

	
	/* Note evacuation */
	$this->add ( array (
			'name' => 'motif',
			'type' => 'Text',
			'options' => array (
					
			),
			'attributes' => array (
					'readonly' => 'readonly',
					'id' => 'motif'
			)
	) );
	
	
	
	/* Note evacuation */
	$this->add ( array (
			'name' => 'motif_reference',
			'type' => 'Text',
			'options' => array (
					//'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Motif d\'evacuation ou de reference' )
			),
			'attributes' => array (
					'readonly' => 'readonly',
					'id' => 'motif_reference'
			)
	) );
	
	
	$this->add ( array (
			'name' => 'service_origine',
			'type' => 'Text',
			'options' => array (
					
			),
			'attributes' => array (
					'readonly' => 'readonly',
					'id' => 'service_origine'
			)
	) );
	

	$this->add ( array (
			'name' => 'enf_viv',
			'type' => 'number',			
			'options' => array (
			),
			'attributes' => array (
					'id' => 'enf_viv',
					'max' => 20,
					'min'=>0,
			)
	) );
	
	
	
	$this->add ( array (
			'name' => 'geste',
			'type' => 'number',
			
			'options' => array (
			),
			'attributes' => array (
					'id' => 'geste',
					'max' => 20,
					'min'=>0,
				//	'required' => true,
			)
	) );
	
	
	$this->add ( array (
			'name' => 'note_geste',
			'type' => 'Text',
				
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','GESTE')
			),
			'attributes' => array (
					'id' => 'note_geste',
					//'required' => true,
			)
	) );
	
	
	
	$this->add ( array (
			'name' => 'note_parite',
			'type' => 'Text',
	
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','GESTE')
			),
			'attributes' => array (
					'id' => 'note_parite',
					//'required' => true,
			)
	) );
	
	
	$this->add ( array (
			'name' => 'note_enf',
			'type' => 'Text',
	
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','GESTE')
			),
			'attributes' => array (
					'id' => 'note_enf',
					//'required' => true,
			)
	) );
	$this->add ( array (
			'name' => 'parite',
			'type' => 'number',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','PARITE')
			),
			'attributes' => array (
					'id' => 'parite',
					'max' => 20,
					'min'=>0,
					//'required' => true,
			)
	) );
	
	
	
	
	
	
	

	$this->add(array(
			'name' => 'mort_ne',
			'type' => 'number',
			
			'options' => array (
					
			),
			'attributes' => array(
					'id' => 'mort_ne',
					'max' => 20,
					'min'=>0,
					//'required' => true,
			),
	));
	
	$this->add(array(
			'name' => 'note_mort_ne',
			'type' => 'Text',
			'options' => array (
						
			),
			'attributes' => array(
					'id' => 'note_mort_ne',
					//'required' => true,
			),
	));
	
	
	$this->add(array(
			'name' => 'cesar',
			'type' => 'number',
			
			'options' => array (
					
			),
			'attributes' => array(
					'id' => 'cesar',
					'max' => 20,
					'min'=>0,
					//'required' => true,
			),
	));
	
	$this->add(array(
			'name' => 'note_cesar',
			'type' => 'Text',
			'options' => array (
	
			),
			'attributes' => array(
					'id' => 'note_cesar',
					//'required' => true,
			),
	));
	

	$this->add(array(
			'name' => 'dystocie',
			'type' => 'checkbox',
			'options' => array (
				
			),
			'attributes' => array(
					'registerInArrrayValidator' => true,
					'onchange'=>' getDystocie(this.value)',
					'id' => 'dystocie',
					//'required' => true,
			),
	));
	
	

	$this->add(array(
			'name' => 'note',
			'type' => 'Text',
			'options' => array (
	
			),
			'attributes' => array(
					'id' => 'note',
					//'required' => true,
			),
	));
	
	$this->add(array(
			'name' => 'note_dystocie',
			'type' => 'Text',
			'options' => array (
	
			),
			'attributes' => array(
					'id' => 'note_dystocie',
					//'required' => true,
			),
	));
	$this->add(array(
			'name' => 'eclampsie',
			'type' => 'checkbox',
			'options' => array (
					
			),
			'attributes' => array(
					'id' => 'eclampsie',
					//'required' => true,
			),
	));
	
	
	$this->add(array(
			'name' => 'note_eclampsie',
			'type' => 'Text',
			'options' => array (
	
			),
			'attributes' => array(
					'id' => 'note_eclampsie',
					//'required' => true,
			),
	));
	$this->add(array(
			'name' => 'bb_attendu',
			'type' => 'Select',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','Nombre de bébé attendu'),
					'value_options' => array(
							1 => 'Simple',
							2  => 'Gemellaire',
							3 => 'Triple',
							0 => 'Multiple',
	
					),
			),
			'attributes' => array(
					'registerInArrrayValidator' => true,
					'onchange'=>' getBbAttendu(this.value)',
					
					'id' => 'bb_attendu',
					//'required' => true,
			),
	));

	$this->add ( array (
			'name' => 'ddr',
			'type' => 'Text',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','DDR:')
			),
			'attributes' => array (
					'id' => 'ddr',
					//'required' => true,
			)
	) );
	
	
	
	$this->add ( array (
			'name' => 'note_ddr',
			'type' => 'Text',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','Duree Grossesse en semaine:')
			),
			'attributes' => array (
					'id' => 'note_ddr',
	
					//'required' => true,
			)
	) );
	
	$this->add ( array (
			'name' => 'duree_grossesse',
			'type' => 'Text',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','Duree Grossesse en semaine:')
			),
			'attributes' => array (
					'id' => 'duree_grossesse',
	
					//'required' => true,
			)
	) );
	
	
	$this->add ( array (
			'name' => 'nb_cpn',
			'type' => 'Text',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','Nombre CPN:')
			),
			'attributes' => array (
					'id' => 'nb_cpn',
					'max' => 5,
					'min'=>0,
					//'required' => true,
			)
	) );
	
	$this->add ( array (
			'name' => 'note_cpn',
			'type' => 'Text',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','Duree Grossesse en semaine:')
			),
			'attributes' => array (
					'id' => 'note_cpn',
	
					//'required' => true,
			)
	) );
	
	$this->add ( array (
			'name' => 'vat_1',
			'type' => 'checkbox',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','VAT 1:')
			),
			'attributes' => array (
					'id' => 'vat_1',
					//'required' => false,
			)
	) );
		
		
	$this->add ( array (
			'name' => 'vat_2',
			'type' => 'checkbox',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','VAT 2:')
			),
			'attributes' => array (
					'id' => 'vat_2',
					//'required' => false,
			)
	) );
	$this->add ( array (
			'name' => 'vat_3',
			'type' => 'checkbox',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','VAT 3:')
			),
			'attributes' => array (
					'id' => 'vat_3',
					//'required' => false,
						
			)
	) );
	$this->add ( array (
			'name' => 'note_vat',
			'type' => 'Text',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','Duree Grossesse en semaine:')
			),
			'attributes' => array (
					'id' => 'note_vat',
	
					//'required' => true,
			)
	) );
	
	$this->add ( array (
			'name' => 'nombre_bb',
			'type' => 'number',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','Nombre de bb:')
			),
			'attributes' => array (
					'id' => 'nombre_bb',
					'max' => 20,
					'min'=>0,
					//'required' => true,
			)
	) );
	
	$this->add ( array (
			'name' => 'note_observation',
			'type' => 'Text',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','Duree Grossesse en semaine:')
			),
			'attributes' => array (
					'id' => 'note_observation',
	
					//'required' => true,
			)
	) );
	
	$this->add ( array (
			'name' => 'note_bb',
			'type' => 'Text',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','Duree Grossesse en semaine:')
			),
			'attributes' => array (
					'id' => 'note_bb',
	
					//'required' => true,
			)
	) );
	
	

	
	
	$this->add(array(
			'name' => 'vpo',
			'type' => 'Select',
			'options' => array (
					'value_options' => array(
							0 => 'Non',
							1=> 'Oui' ,
					),
			),
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'vpo',
	
			),
	));
	$this->add(array(
			'name' => 'anti_hepatique',
			'type' => 'Select',
			'options' => array (
					'value_options' => array(
							0 => 'Non',
							1=> 'Oui' ,
					),
			),
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'anti_heppatique',
	
			),
	));
	
	$this->add(array(
			'name' => 'anti_tuberculeux',
			'type' => 'Select',
			'options' => array (
					'value_options' => array(
							0 => 'Non',
							1=> 'Oui' ,
					),
			),
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'anti_tuberculeux',
	
			),
	));
	$this->add(array(
			'name' => 'note_vacc',
			'type' => 'text',
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'note_vacc',
	
			),
	));
	
	$this->add(array(
			'name' => 'hepa_vacc',
			'type' => 'Select',
			'options' => array (
					'value_options' => array(
							0 => 'Non',
							1=> 'Oui' ,
					),
			),
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'hepa_vacc',
	
			),
	));
	
	
	
	
	
	
	$this->add(array(
			'name' => 'note_hepa',
			'type' => 'Text',
			
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'note_hepa',
	
			),
	));
	
	
	$this->add(array(
			'name' => 'bcg',
			'type' => 'Select',
			'options' => array (
					'value_options' => array(
							0 => 'Non',
							1=> 'Oui' ,
					),
			),
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'bcg',
	
			),
	));
	
	
	$this->add(array(
			'name' => 'note_bcg',
			'type' => 'Text',
			
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'note_bcg',
	
			),
	));
	
	$this->add(array(
			'name' => 'autre_vacc',
			'type' => 'Select',
			'options' => array (
					'value_options' => array(
							0 => 'Non',
							1=> 'Oui' ,
					),
			),
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'autre_vacc',
	
			),
	));
	$this->add(array(
			'name' => 'note_autre_vacc',
			'type' => 'Text',
			
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'note_autre_vacc',
	
			),
	));
	
	$this->add(array(
			'name' => 'type_autre_vacc',
			'type' => 'Text',
				
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'type_autre_vacc',
	
			),
	));
	
	
	$this->add ( array (
			'name' => 'perim_cranien',
			'type' => 'number',
				
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','GESTE')
			),
			'attributes' => array (
					'id' => 'perim_cranien',
					'max' => 100,
					'min'=>0,
					//'required' => true,
			)
	) );
	
	
	
	$this->add ( array (
			'name' => 'perim_brachial',
			'type' => 'number',
	
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','GESTE')
			),
			'attributes' => array (
					'id' => 'perim_brachial',
					'max' => 20,
					'min'=>0,
					//'required' => true,
			)
	) );
	
	$this->add ( array (
			'name' => 'perim_cephalique',
			'type' => 'number',
	
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','GESTE')
			),
			'attributes' => array (
					'id' => 'perim_cephalique',
					'max' => 20,
					'min'=>0,
					//'required' => true,
			)
	) );
	
	
	
	
	
	$this->add ( array (
			'name' => 'taille_enf',
			'type' => 'number',
	
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','GESTE')
			),
			'attributes' => array (
					'id' => 'taille_enf',
					//'max' => 20,
					'min'=>0,
					//'required' => true,
			)
	) );
	
	
	
	$this->add(array(
			'name' => 'note_perim',
			'type' => 'Text',
	
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'note_perim',
	
			),
	));	
	
	$this->add(array(
			'name' => 'note_taille_enf',
			'type' => 'Text',
	
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'note_taille_enf',
	
			),
	));
	
	$this->add ( array (
			'name' => 'text_observation',
			'type' => 'Textarea',
			'options' => array (
					
			),
			'attributes' => array (
				
					'id' => 'text_observation'
			)
	) );
	$this->add ( array (
			'name' => 'suite_de_couches',
			'type' => 'Textarea',
			'options' => array (
						
			),
			'attributes' => array (
	
					'id' => 'suite_de_couches'
			)
	) );

	
	$this->add(array(
			'name' => 'prenome',
			'type' => 'Text',
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'prenome',
					//'readonly' => 'readonly',
					//'required' => true,
			),
	));
	
	$this->add(array(
			'name' => 'viv_viable',
			'type' => 'Text',
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'viv_viable',
					//'readonly' => 'readonly',
					//'required' => true,
			),
	));
	$this->add(array(
			'name' => 'mor_ne',
			'type' => 'Text',
			'attributes' => array(
					//'readonly' => 'readonly',
					'id' => 'mor_ne',
					//'readonly' => 'readonly',
					//'required' => true,
			),
	));
	
	
	//Avortement
	
	$this->add ( array (
			'name' => 'periode_av',
			'type' => 'Select',
			'options' => array (
					'value_options' => array (
							0=>'Choisir',
							1=>'premier trimestre',
							2=>'Deuxieme trimestre'
					)
			),
			'attributes' => array (
					'id' => 'periode_av',
			)
	) );
	
	
		$this->add ( array (
				'name' => 'type_avortement',
				'type' => 'Select',
				'options' => array (
						'value_options' => array (
								''=>''
						)
				),
				'attributes' => array (
						'id' => 'type_avortement',
				)
		) );
	
		$this->add ( array (
				'name' => 'traitement_recu',
				'type' => 'Select',
				'options' => array (
						'value_options' => array (
								''=>''
						)
				),
				'attributes' => array (
						'id' => 'traitement_recu',
				)
		) );
	
	}
	
	
	
	
	
	
	
}









