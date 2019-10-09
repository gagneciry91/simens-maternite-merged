<?php

namespace Maternite\Form\gynecologie;

use Zend\Form\Form;


class ConsultationForm extends Form {
	public $decor = array (
			'ViewHelper' 
	);
	

	public function __construct($name = null) {
		parent::__construct ();
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'dmy-His' );
				
		$heure = $today->format ( "H:i" );
		$dateAujourdhui = $today->format( 'Y-m-d' );
		
		
		$numero_dossier=999;
		
		$this->add ( array (
				'name' => 'id_cons',
				'type' => 'hidden',
				'options' => array (
						'label' => 'Code consultation' 
				),
				'attributes' => array (
						'readonly' => 'readonly',
						'value' =>  $date ,
						'id' => 'id_cons' 
				) 
		) );
		

		$this->add ( array (
				'name' => 'numeroOrdre',
				'type' => 'number',
				
				'attributes' => array (
						'readonly' => 'readonly',
						//'value' => 'pos-' . $date ,
						'id' => 'numeroOrdre'
				)
		) );
	

		$this->add ( array (
				'name' => 'ORDRE',
				'type' => 'number',
		
				'attributes' => array (
						'readonly' => 'readonly',
						//'value' => 'pos-' . $date ,
						'id' => 'ORDRE'
				)
		) );
		
		$this->add ( array (
				'name' => 'id_postnatale',
				'type' => 'Hidden',
				'attributes' => array (
						'id' => 'id_postnatale'
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
				'name' => 'id_accouchement',
				'type' => 'Hidden',
				'attributes' => array (
						'id' => 'id_accouchement'
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
				'name' => 'date_accouchement',
				'type' => 'Hidden',
				'options' => array (
						'decorators' => $this->decor 
				),
				'attributes' => array (
						'id' => 'date_accouchement' 
				) 
		) );
		$this->add ( array (
				'name' => 'deroulement_accouchement',
				'type' => 'Hidden',
				'options' => array (
						'decorators' => $this->decor
				),
				'attributes' => array (
						'id' => 'deroulement_accouchement'
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
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Bilan de l\'hï¿½mostase:' ) 
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
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Bilan hï¿½patique:' ) 
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
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Bilan rï¿½nal:' ) 
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
						//'readonly' => 'readonly',
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
						//'readonly' => 'readonly',
						'id' => 'diagnostic2' 
				) 
		) );
		$this->add ( array (
				'name' => 'diagnostic3',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Decision: ' ) 
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'diagnostic3' 
				) 
		) );
		$this->add ( array (
				'name' => 'diagnostic4',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Decision: ' ) 
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'diagnostic4' 
				) 
		) );		$this->add ( array (
				'name' => 'diagnostic5',
				'type' => 'Text',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Decision: ' ) 
				),
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'diagnostic5' 
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


$this->add(array(
		'name' => 'details',
		'type' => 'select',
		'options' => array (
				'value_options' => array(
						0 => ' ',
						1 => iconv ( 'ISO-8859-1', 'UTF-8','Fait') ,
						2 => iconv ( 'ISO-8859-1', 'UTF-8','Absente') ,
						
						
						
				),
		),
		'attributes' => array(
				'id' => 'details',
		),
));
		
		
		
		
		
		
		$this->add ( array (
				'name' => 'glycemie_capillaire',
				'type' => 'Text',
				'options' => array (),
				// 'label' => iconv('ISO-8859-1', 'UTF-8', 'GlycÃ©mie capillaire (g/l)')
				'attributes' => array (
						'class' => 'glycemie_only_numeric',
						'readonly' => 'readonly',
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
				'name' => 'mariee',
				'type' => 'Select',
				'options' => array (
						'value_options' => array (
								'0' => 'Oui',
								'1' => 'Non'
						)
				),
				'attributes' => array (
						'id' => 'mariee'
				)
		)
		);
		$this->add ( array (
				'name' => 'regime',
				'type' => 'Select',
				'options' => array (
						'value_options' => array (
								'0' => '',
								'1' => 'Monogame',
								'2' => 'Polygame'
								
						)
				),
				'attributes' => array (
						'id' => 'regime'
				)
		)
		);
		$this->add ( array (
				'name' => 'note_regime',
				'type' => 'Text',
			
				'attributes' => array (
						'id' => 'note_regime'
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
				'attributes' => array (
						'class' => 'temperature_only_numeric',
						'min'=>34,
						'id' => 'temperature' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'tension',
				'type' => 'Text',
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
				'type' => 'Text',
				'options' => array (),
				// 'label' => iconv('ISO-8859-1', 'UTF-8', 'Pression artï¿½rielle (mmHg)')
				'attributes' => array (
						'class' => 'tension_only_numeric',
						'id' => 'pressionarterielle' 
				) 
		) );
		
	
		
		$this->add ( array (
				'name' => 'tensionmaximale',
				'type' => 'Text',
				'attributes' => array (
						'class' => 'temperature_only_numeric',
						'id' => 'tensionmaximale' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'tensionminimale',
				'type' => 'Text',
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
						//'readonly' => 'readonly',
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
				'type' => 'Text',
				'options' => array (),
				// 'label' => iconv('ISO-8859-1', 'UTF-8', 'GlycÃ©mie capillaire (g/l)')
				'attributes' => array (
						'class' => 'glycemie_only_numeric',
						//'readonly' => 'readonly',
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
				),
				'attributes' => array (
						'id' => 'date_fin_hospitalisation_prevue' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'date_intervalle2',
				'type' => 'Text',
				'options' => array (
				),
				'attributes' => array (
						'id' => 'date_intervalle2'
				)
		) );
		$this->add ( array (
				'name' => 'date_intervalle1',
				'type' => 'Text',
				'options' => array (
				),
				'attributes' => array (
						'id' => 'date_intervalle1'
				)
		) );
		$this->add ( array (
				'name' => 'date_intervalle3',
				'type' => 'Text',
				'options' => array (
				),
				'attributes' => array (
						'id' => 'date_intervalle3'
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
						//'readonly' => 'readonly',
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
				'name' => 'date_rv_gyn',
				'type' => 'Text',
				'options' => array (
						'label' => 'Date :'
				),
				'attributes' => array (
						'id' => 'date_rv_gyn'
				)
		) );
		$this->add ( array (
				'name' => 'date_debut',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date RV'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'date_debut',
						'min'  => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
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
		$this->add ( array (
				'name' => 'date_debut',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date RV'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeDateDebut(this.value)',
						'id' =>'date_debut',
						
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
		 /* tuberculose*/
		$this->add ( array (
				'name' => 'tuberculose',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'tuberculose'
				)
		) );
		$this->add ( array (
				'name' => 'notetube',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'notetube'
				)
		) );
		
		/* epilepsie  varices*/
		$this->add ( array (
				'name' => 'epilepsie',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'epilepsie'
				)
		) );
		
		$this->add ( array (
				'name' => 'noteepi',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'noteepi'
				)
		) );
		
		/*   varices*/
		$this->add ( array (
				'name' => 'varices',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'varices'
				)
		) );
		
		$this->add ( array (
				'name' => 'notevarice',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'notevarice'
				)
		) );
		
		/*exophtalmi   */
		$this->add ( array (
				'name' => 'exophtalmi',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'exophtalmi'
				)
		) );
		
		$this->add ( array (
				'name' => 'rhesus',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'value_options' => array (
								''=>'',
								' -' => '-',
								'+' => '+',
						)
				),
				'attributes' => array (
						'id' => 'rhesus'
				)
		) );
		$this->add ( array (
				'name' => 'dateces',
				'type' => 'text',
				'options' => array (
						//'label' => iconv('ISO-8859-1', 'UTF-8'),
				),
				'attributes' => array (
						//'registerInArrrayValidator' => true,
						//'onchange' => 'getListeDateDebut(this.value)',
						'id' =>'dateces',
		
						//'required' => t
				)
		) );
		$this->add ( array (
				'name' => 'noteexoph',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'noteexoph'
				)
		) );
		$this->add ( array (
				'name' => 'indication',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'indication'
				)
		) );
		
		$this->add ( array (
				'name' => 'note_ces',
				'type' => 'text',
				'attributes' => array (
						'id' => 'note_ces'
				)
		) );
		/*alergiecuv   */
		$this->add ( array (
				'name' => 'alergiecuv',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'alergiecuv'
				)
		) );
		
		$this->add ( array (
				'name' => 'note_cuve',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'note_cuve'
				)
		) );
		
		/*vulve   */
		$this->add ( array (
				'name' => 'vulve',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'vulve'
				)
		) );
		
		$this->add ( array (
				'name' => 'notevu',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'notevu'
				)
		) );
		/*perine   */
		$this->add ( array (
				'name' => 'perine',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'perine'
				)
		) );
		
		$this->add ( array (
				'name' => 'noteperine',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'noteperine'
				)
		) );
		
		/*col   */
		$this->add ( array (
				'name' => 'col',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'col'
				)
		) );
		
		$this->add ( array (
				'name' => 'note_col',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'note_col'
				)
		) );
		/*  uterus */
		$this->add ( array (
				'name' => 'uterus',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'uterus'
				)
		) );
		
		$this->add ( array (
				'name' => 'note_uterus',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'note_uterus'
				)
		) );
		/*  annexe */
		$this->add ( array (
				'name' => 'annexe',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'annexe'
				)
		) );
		
		$this->add ( array (
				'name' => 'note_annexe',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'note_annexe'
				)
		) );
		/*  pertes */
		$this->add ( array (
				'name' => 'pertes',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'pertes'
				)
		) );
		
		$this->add ( array (
				'name' => 'note_pertes',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'note_pertes'
				)
		) );
		/*  pilule */
		$this->add ( array (
				'name' => 'pilule',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'pilule'
				)
		) );
		
		$this->add ( array (
				'name' => 'notepilule',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'notepilule'
				)
		) );
		/*  tabac */
		$this->add ( array (
				'name' => 'tabac',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'tabac'
				)
		) );
		
		$this->add ( array (
				'name' => 'notetab',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'notetab'
				)
		) );
		
		/* alcool */
		$this->add ( array (
				'name' => 'alcool',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'alcool'
				)
		) );
		
		$this->add ( array (
				'name' => 'noteal',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'noteal'
				)
		) );
		
		/* autresgenre */
		$this->add ( array (
				'name' => 'autresgenre',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'autresgenre'
				)
		) );
		
		$this->add ( array (
				'name' => 'noteautre',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'noteautre'
				)
		) );
		
		
		/*  diaphragme */
		$this->add ( array (
				'name' => 'diaphragme',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'diaphragme'
				)
		) );
		
		$this->add ( array (
				'name' => 'notediaphragme',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'notediaphragme'
				)
		) );
		/*  condoms */
		$this->add ( array (
				'name' => 'condoms',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'condoms'
				)
		) );
		
		$this->add ( array (
				'name' => 'notecondoms',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'notecondoms'
				)
		) );
		/*  spermicides */
		$this->add ( array (
				'name' => 'spermicides',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'spermicides'
				)
		) );
		
		$this->add ( array (
				'name' => 'notespermicides',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'notespermicides'
				)
		) );
		/*  dui */
		$this->add ( array (
				'name' => 'dui',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'dui'
				)
		) );
		
		$this->add ( array (
				'name' => 'notedui',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'notedui'
				)
		) );
		/*  injectable */
		$this->add ( array (
				'name' => 'injectable',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'injectable'
				)
		) );
		
		$this->add ( array (
				'name' => 'note_injectable',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'note_injectable'
				)
		) );
		/*  norplant */
		$this->add ( array (
				'name' => 'norplant',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'norplant'
				)
		) );
		
		$this->add ( array (
				'name' => 'note_norplant',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'note_norplant'
				)
		) );
		/*  autremethode */
		$this->add ( array (
				'name' => 'autremethode',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'autremethode'
				)
		) );
		
		$this->add ( array (
				'name' => 'note_autremethode',
				'type' => 'Text',
				'attributes' => array (
						'id' => 'note_autremethode'
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
		/* cardio */
		$this->add ( array (
				'name' => 'cardio',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'cardio'
				)
		) );
		/* ultere */
		$this->add ( array (
				'name' => 'ultere',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'ultere'
				)
		) );
		
		/*migraine */
		$this->add ( array (
				'name' => 'migraine',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'migraine'
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
				'type' => 'Select',
				'attributes' => array (
						'id' => 'EclampsieGO' 
				) 
		) );
		/*avortement */
		$this->add ( array (
				'name' => 'avortement',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'avortement'
				)
		) );
		$this->add ( array (
				'name' => 'note_avortement',
				'type' => 'text',
				'attributes' => array (
						'id' => 'note_avortement'
				)
		) );
		$this->add ( array (
				'name' => 'un',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'un'
				)
		) );
		$this->add ( array (
				'name' => 'deux',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'deux'
				)
		) );
		$this->add ( array (
				'name' => 'trois',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'trois'
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
		/* Regularite cycle */
		$this->add ( array (
				'name' => 'cycle',
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
						'id' => 'cycle'
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
		$this->add(array(
				'name' => 'ig',
				'type' => 'select',
				'options' => array (
						'value_options' => array(
								0 => 'Non',
								1 => 'Oui' ,
						),
				),
				'attributes' => array(
						'registerInArrrayValidator' => true,
						'id' => 'ig',
						//'required' => true,
				),
		));
		$this->add ( array (
				'name' => 'note_ig',
				'type' => 'Text',
				'options' => array (
		
				),
				'attributes' => array (
						'id' => 'note_ig'
				)
		) );
		$this->add ( array (
				'name' => 'ddr',
				'type' => 'date',
				'options' => array (
						//'label' => iconv('ISO-8859-1', 'UTF-8','DDR:')
				),
				'attributes' => array (
						'id' => 'ddr',
						//'required' => true,
				)
		) );
		
		
		$this->add(array(
				'name' => 'dg',
				'type' => 'select',
				'options' => array (
						'value_options' => array(
								0 => 'Non',
								1 => 'Oui' ,
						),
				),
				'attributes' => array(
						'registerInArrrayValidator' => true,
						'id' => 'dg',
						//'required' => true,
				),
		));
		$this->add ( array (
				'name' => 'note_dg',
				'type' => 'Text',
				'options' => array (
		
				),
				'attributes' => array (
						'id' => 'note_dg'
				)
		) );
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
								''=>'',
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
				'name' => 'j1_j3',
				'type' => 'Text',
				
				'attributes' => array (
						'id' => 'j1_j3' 
				) 
		) );
		$this->add ( array (
				'name' => 'j4_j8',
				'type' => 'Text',
				
				'attributes' => array (
						'id' => 'j4_j8'
				)
		) );
		$this->add ( array (
				'name' => 'j9_j15',
				'type' => 'Text',
				
				'attributes' => array (
						'id' => 'j9_j15'
				)
		) );
		$this->add ( array (
				'name' => 'j16_j41',
				'type' => 'text',
				
				'attributes' => array (
						'id' => 'j16_j41'
				)
		) );
		
		
		$this->add ( array (
				'name' => 'j42',
				'type' => 'text',
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => '42'
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
								0=> '',
								
								1 => 'AS',
							2 => 'SS',
								3=> 'AA',
								
								4=> 'Autre',
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
		
		$this->add ( array (
				'name' => 'cancersein',
				'type' => 'Select',
				'options' => array (
						'value_options' => array (
								'0' => 'Non',
								'1' => 'Oui',
								
						)
				),
				'attributes' => array (
						'id' => 'cancersein' ,
						//'required' => true,
				)
		) );
		

		$this->add ( array (
				'name' => 'cancercol',
				'type' => 'Select',
				'options' => array (
						'value_options' => array (
								'0' => 'Non',
								'1' => 'Oui',
		
						)
				),
				'attributes' => array (
						'id' => 'cancercol' ,
						//'required' => true,
				)
		) );
		$this->add ( array (
				'name' => 'note_cancercol',
				'type' => 'Text',
				'options' => array (
						
				),
				'attributes' => array (
						'id' => 'note_cancercol' ,
						//'required' => true,
				)
		) );
		
		$this->add ( array (
				'name' => 'note_cancersein',
				'type' => 'Text',
				'options' => array (
					
				),
				'attributes' => array (
						'id' => 'note_cancersein' ,
						//'required' => true,
				)
		) );
		
			// clinique
		
		
		$this->add(array(
				'name' => 'eg',
				'type' => 'Text',
			/* 	'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','OMS1') ,
								2 => iconv ( 'ISO-8859-1', 'UTF-8','OMS2') ,
								3 => iconv ( 'ISO-8859-1', 'UTF-8','OMS3') ,
								
						),
				), */
				'attributes' => array(
						'id' => 'eg',
		
				),
		));
		$this->add ( array (
				'name' => 'muqueuse',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','pale') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','moy colorée') ,
								2 => iconv ( 'ISO-8859-1', 'UTF-8',' colorée') ,
								
						),
				),
				'attributes' => array (
						'id' => 'muqueuse',
						//'required' => true,
				)
		) );
		
		
		$this->add(array(
				'name' => 'oeudeme',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','discret') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','important') ,
								2 => iconv ( 'ISO-8859-1', 'UTF-8','absent') ,
		
						),
				),
				'attributes' => array(
						'id' => 'oeudeme',
		
				),
		));
		
		$this->add ( array (
				'name' => 'seins',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','normal') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','anormal') ,
						),
				),
				'attributes' => array (
						'id' => 'seins',
						//'required' => true,
				)
		) );
	
		$this->add ( array (
				'name' => 'tvagin',
				'type' => 'Text',
				'options' => array (),
				'attributes' => array (
						//'class' => 'tension_only_numeric',
						'id' => 'tvagin'
				)
		) );
		$this->add ( array (
				'name' => 'abdomen',
				'type' => 'Text',
				'options' => array (),
				// 'label' => iconv('ISO-8859-1', 'UTF-8', 'Pression artï¿½rielle (mmHg)')
				'attributes' => array (
						'class' => 'tension_only_numeric',
						'id' => 'abdomen'
				)
		) );
		$this->add ( array (
				'name' => 'mollets',
				'type' => 'Text',
				'options' => array (),
				// 'label' => iconv('ISO-8859-1', 'UTF-8', 'Pression artï¿½rielle (mmHg)')
				'attributes' => array (
						'class' => 'tension_only_numeric',
						'id' => 'mollets'
				)
		) );
		// fin cliniaue
		
		$this->add ( array (
				'name' => 'antepers',
				'type' => 'Select',
				'options' => array (
						'value_options' => array (
								'0' => 'Myomectomie',
								'1' => 'Hysterectomie',
								'2' => 'Kystectomie',
								'3' => 'Kysteovarienne',
						)
				),
				'attributes' => array (
						'id' => 'antepers' ,
						//'required' => true,
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
				'type' => 'text',
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
						'onchange'=>' getPostnatale(this.value)',
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
				'name' => 'deroulement_accouchement',
				'type' => 'text',
				'attributes' => array (
						//'readonly' => 'readonly',
						'id' => 'deroulement_accouchement'
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
						
						//'required' => true,
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
		
		$this->add(array(
				'name' => 'etat_enfant',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => 'Normal',
								1=> 'Anormal' ,
						),
				),
				'attributes' => array(
						//'readonly' => 'readonly',
						'id' => 'etat_enfant',
		
				),
		));
		$this->add(array(
				'name' => 'etat_cordon',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => 'Normal',
								1=> 'Anormal' ,
						),
				),
				'attributes' => array(
						//'readonly' => 'readonly',
						'id' => 'etat_cordon',
		
				),
		));
		


	$this->add ( array (
			'name' => 'motif_ad',
			'type' => 'Select',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','Motif d\'admission'),
 					'value_options' => array (
 							'Normal' => 'Normal',
 							'Evacuation' => 'Evacuation',
 							'Reference' => 'Reference',
					)
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
			'name' => 'amenere',
			'type' => 'number',
			'options' => array (
			),
			'attributes' => array (
					'id' => 'amenere',
					'max' => 10,
					'min'=>1,
			)
	) );
	
	
	$this->add(array(
			'name' => 'Vivensemble',
			'type' => 'Select',
			'options' => array (
					'value_options' => array(
							0 => iconv ( 'ISO-8859-1', 'UTF-8','Non') ,
							1 => iconv ( 'ISO-8859-1', 'UTF-8','Oui') ,
					),
			),
			'attributes' => array(
					'id' => 'Vivensemble',
	
			),
	));
	$this->add ( array (
			'name' => 'note_Vivensemble',
			'type' => 'Text',
			'options' => array (
			),
			'attributes' => array (
					'id' => 'Vivensemble',
					
			)
	) );
	
	$this->add ( array (
			'name' => 'enf_viv_mari',
			'type' => 'number',
			'options' => array (
			),
			'attributes' => array (
					'id' => 'enf_viv_mari',
					'max' => 20,
					'min'=>0,
			)
	) );
	
	$this->add ( array (
			'name' => 'enf_age',
			'type' => 'number',
			'options' => array (
			),
			'attributes' => array (
					'id' => 'enf_age',
					'max' => 20,
					'min'=>0,
			)
	) );
	$this->add ( array (
			'name' => 'noteenf_age',
			'type' => 'Text',
			'options' => array (
			),
			'attributes' => array (
					'id' => 'noteenf_age',
					
			)
	) );
	$this->add ( array (
			'name' => 'noteenf_viv',
			'type' => 'Text',
			'options' => array (
			),
			'attributes' => array (
					'id' => 'noteenf_viv',
						
			)
	) );
	

	$this->add ( array (
			'name' => 'duree_infertilite',
			'type' => 'number',
			'options' => array (
			),
			'attributes' => array (
					'id' => 'duree_infertilite',
					'max' => 60,
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
			'name' => 'allaitement',
			'type' => 'Text',
	
			
			'attributes' => array (
					'id' => 'allaitement',
					//'required' => true,
			)
	) );
	$this->add ( array (
			'name' => 'note_allaitement',
			'type' => 'Text',
	
		
			'attributes' => array (
					'id' => 'note_allaitement',
					//'required' => true,
			)
	) );
	$this->add ( array (
			'name' => 'note_enf',
			'type' => 'text',
	
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','GESTE')
			),
			'attributes' => array (
					'id' => 'note_enf',
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
					//'required' => true,numero_d_ordre
			)
	) );
	
	$this->add ( array (
			'name' => 'numero_d_ordre',
			'type' => 'text',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','PARITE')
			),
			'attributes' => array (
					'id' => 'numero_d_ordre',
					
					//'required' => true,numero_d_ordre
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
			'type' => 'text',
			'options' => array (
						
			),
			'attributes' => array(
					'id' => 'note_mort_ne',
					//'required' => true,
			),
	));
	
	
	$this->add(array(
			'name' => 'cesar',
			
			'type' => 'Select',
			'options' => array (
					'value_options' => array(
							0 => 'Non',
							1=> 'Oui' ,
					),
			),
	));
	

	$this->add(array(
			'name' => 'age',
			'type' => 'number',
				
			'options' => array (
						
			),
			'attributes' => array(
					'id' => 'age',
					'max' => 6,
					'min'=>0,
					//'required' => true,
			),
	));
	
	$this->add(array(
			'name' => 'nombre_cesar',
			'type' => 'number',
			'options' => array (
	
			),
			'attributes' => array(
					'id' => 'nombre_cesar',
                    'max' => 5,
					'min'=>0,			),
	));
	

	$this->add ( array (
			'name' => 'nouvelleMotifs',
			'type' => 'radio',
			'options' => array (
					'value_options' => array (
							'0' => 'Kystectomie',
							'1' => 'Myomectomie',
							'2' => 'Kysteovarienne',
							'3' => 'Hysterectomie',
					)
			),
			'attributes' => array (
					'id' => 'nouvelleMotifs',
					//'required' => true,
			)
	) );
	
	
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
	


	$this->add ( array (
			'name' => 'menarchie',
			'type' => 'number',
			'options' => array (
			),
			'attributes' => array (
					'id' => 'menarchie',
					'max' => 18,
					'min'=>7,
			)
	) );
	
	$this->add(array(
			'name' => 'note_menarchie',
			'type' => 'text',
			'options' => array (
	
			),
			'attributes' => array(
					'id' => 'note_menarchie',
					//'required' => true,
			),
	));
		$this->add(array(
			'name' => 'note_sein',
			'type' => 'text',
			'options' => array (
	
			),
			'attributes' => array(
					'id' => 'note_sein',
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
			'type' => 'Select',
			'options' => array (
						'value_options' => array (
								0 => 'Non',
								1 => 'Oui',
								
						) 
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
	$this->add(array(
			'name' => 'infertilite',
			'type' => 'Select',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','Nombre de bébé attendu'),
					'value_options' => array(
							
							1 => '',
							2 => 'Primaire',
							3  => 'secondaire',
						
					),
			),
			'attributes' => array(
					'registerInArrrayValidator' => true,
					//'onchange'=>' getBbAttendu(this.value)',
						
					'id' => 'infertilite',
					//'required' => true,
			),
	));
	
	$this->add(array(
			'name' => 'hta',
			'type' => 'Select',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','Nombre de bébé attendu'),
					'value_options' => array(
							0=> '',
							1 => 'Preecampsie',
							2  => 'gravidique',
							2 => 'surajoute',
							3 => 'chronique',
								
	
					),
			),
			'attributes' => array(
					'registerInArrrayValidator' => true,
					//'onchange'=>' getBbAttendu(this.value)',
	
					'id' => 'hta',
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
			'name' => 'partie',
			'type' => 'Text',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','DDR:')
			),
			'attributes' => array (
					'id' => 'partie',
					//'required' => true,
			)
	) );
$this->add ( array (
				'name' => 'rang_cpon',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'value_options' => array (
								'1' => '1',
								'2' => '2', 
								'3' => '3',
								
						) 
				),
				'attributes' => array (
						'id' => 'rang_cpon' 
				) 
		) );
		
		// fin clinic
		
	/* 	//enfant
		
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
				'name' => 'infection',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => 'Non',
								1=> 'Oui' ,
						),
				),
				'attributes' => array(
						//'readonly' => 'readonly',
						'id' => 'infection',
		
				),
		));
		
		$this->add ( array (
				'name' => 'etat',
				'type' => 'Text',
				'options' => array (
						//'label' => iconv('ISO-8859-1', 'UTF-8','DDR:')
				),
				'attributes' => array (
						'id' => 'etat',
						//'required' => true,
				)
		) );
		$this->add ( array (
				'name' => 'etat_cordon',
				'type' => 'Text',
				'options' => array (
						//'label' => iconv('ISO-8859-1', 'UTF-8','DDR:')
				),
				'attributes' => array (
						'id' => 'etat_cordon',
						//'required' => true,
				)
		) );
 */	// clinique
	
	
	$this->add(array(
			'name' => 'E.G',
			'type' => 'Select',
			'options' => array (
					'value_options' => array(
							0 => iconv ( 'ISO-8859-1', 'UTF-8','bon') ,
							1 => iconv ( 'ISO-8859-1', 'UTF-8','assez bon') ,
							2 => iconv ( 'ISO-8859-1', 'UTF-8','mediocre') ,
							3 => iconv ( 'ISO-8859-1', 'UTF-8','passable') ,
								
					),
			),
			'attributes' => array(
					'id' => 'E.G',
	
			),
	));
	$this->add ( array (
			'name' => 'muq',
			'type' => 'Select',
			'options' => array (
	'value_options' => array(
							0 => iconv ( 'ISO-8859-1', 'UTF-8','légére') ,
							1 => iconv ( 'ISO-8859-1', 'UTF-8','colorée') ,
			                2 => iconv ( 'ISO-8859-1', 'UTF-8','pale') ,
				
					),
								),
			'attributes' => array (
					'id' => 'muq',
					//'required' => true,
			)
	) );
	

	$this->add(array(
			'name' => 'oeud',
			'type' => 'Select',
			'options' => array (
					'value_options' => array(
							0 => iconv ( 'ISO-8859-1', 'UTF-8','discret') ,
							1 => iconv ( 'ISO-8859-1', 'UTF-8','++') ,
							2 => iconv ( 'ISO-8859-1', 'UTF-8','nulle') ,
								
					),
			),
			'attributes' => array(
					'id' => 'oeud',
	
			),
	));
	
	$this->add ( array (
			'name' => 'seins',
			'type' => 'Select',
			'options' => array (
					'value_options' => array(
							0 => iconv ( 'ISO-8859-1', 'UTF-8','normal') ,
							1 => iconv ( 'ISO-8859-1', 'UTF-8','anormal') ,
			),
					),
			'attributes' => array (
					'id' => 'seins',
					//'required' => true,
			)
	) );
	

	
	$this->add ( array (
			'name' => 'inv_uter',
			'type' => 'number',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','PARITE')
			),
			'attributes' => array (
					'id' => 'inv_uter',
					'max' => 1000,
					'min'=>0,
					//'required' => true,numero_d_ordre
			)
	) );
	
	
	$this->add ( array (
			'name' => 'tv',
			'type' => 'Select',
			'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','médian') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','postérieur') ,
						),
				),
			'attributes' => array (
					'id' => 'tv',
			)
	) );
	// fin cliniaue
	
	// ptme
	
	$this->add ( array (
			'name' => 'propos',
			'type' => 'Text',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','DDR:')
			),
			'attributes' => array (
					'id' => 'propos',
					//'required' => true,
			)
	) );
	
	$this->add ( array (
			'name' => 'accept',
			'type' => 'Text',
			'options' => array (
			),
			'attributes' => array (
					'id' => 'accept',
			)
	) );
	
	$this->add ( array (
			'name' => 'retrait',
			'type' => 'Text',
			'options' => array (
			),
			'attributes' => array (
					'id' => 'retrait',
			)
	) );
	// fin ptme
	
	// prevention
	

		$this->add(array(
				'name' => 'vat',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','Non') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','Oui') ,
						),
				),
				'attributes' => array(
						'id' => 'vat',
						
				),
		));
	
	$this->add(array(
				'name' => 'fer',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','Non') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','Oui') ,
						),
				),
				'attributes' => array(
						'id' => 'fer',
						
				),
		));
	$this->add(array(
			'name' => 'vih',
			'type' => 'Select',
			'options' => array (
					'value_options' => array(
							0 => iconv ( 'ISO-8859-1', 'UTF-8','+') ,
							1 => iconv ( 'ISO-8859-1', 'UTF-8','-') ,
					),
			),
			'attributes' => array(
					'id' => 'vih',
	
			),
	));
	//fin  prevention
	
	// ALLAITEMENT

	$this->add ( array (
				'name' => 'ame',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'ame'
				)
		) );
	$this->add(array(
				'name' => 'autres',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','Pilule') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','Diaphragme') ,
								2 => iconv ( 'ISO-8859-1', 'UTF-8','Condoms') ,
								3 => iconv ( 'ISO-8859-1', 'UTF-8','Spermicides') ,
								4 => iconv ( 'ISO-8859-1', 'UTF-8','DUI') ,
								5 => iconv ( 'ISO-8859-1', 'UTF-8','Injectable') ,
								6 => iconv ( 'ISO-8859-1', 'UTF-8','Norplant') ,
								
						),
				),
				'attributes' => array(
						'id' => 'autres',
		
				),
		));
	
	
		$this->add ( array (
				'name' => 'autresa',
				'type' => 'checkbox',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','mixte') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','artificielle') ,
								),
						),
				'attributes' => array (
						'id' => 'autresa'
				)
		) );
	//fin  ALLAITEMENT
	
//	
$this->add ( array (
				'name' => 'myomectomie',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'myomectomie'
				)
		) );
$this->add ( array (
		'name' => 'kystectomie',
		'type' => 'checkbox',
		'attributes' => array (
				'id' => 'kystectomie'
		)
) );
$this->add ( array (
		'name' => 'autrescons',
		'type' => 'checkbox',
		'attributes' => array (
				'id' => 'autrescons'
		)
) );
$this->add ( array (
		'name' => 'kysteovarienne',
		'type' => 'checkbox',
		'attributes' => array (
				'id' => 'kysteovarienne'
		)
) );
$this->add ( array (
		'name' => 'hysterectomie',
		'type' => 'checkbox',
		'attributes' => array (
				'id' => 'hysterectomie'
		)
) );
	
	// CONTRACEPTION
	
		$this->add ( array (
				'name' => 'mama',
				'type' => 'checkbox',
				'attributes' => array (
						'id' => 'mama'
				)
		) );
	
	
	//fin  CONTRACEPTION
	
		/* ethnie*/
		$this->add(array(
				'name' => 'ethnie',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','Wolof') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','Serere') ,
								2 => iconv ( 'ISO-8859-1', 'UTF-8','Toucouleur') ,
								3 => iconv ( 'ISO-8859-1', 'UTF-8','Mandingue') ,
								4 => iconv ( 'ISO-8859-1', 'UTF-8','Diola') ,
								5 => iconv ( 'ISO-8859-1', 'UTF-8','Autres') ,
										
						),
				),
				'attributes' => array(
						'id' => 'ethnie',
		
				),
		));
		
		// intervalle
		$this->add(array(
				'name' => 'intervalle1',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','J1 à J3') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','J4 à J8') ,
								
								
								
		
						),
				),
				'attributes' => array(
						'id' => 'intervalle1',
		
				),
		));
		$this->add(array(
				'name' => 'intervalle2',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','J9 à J15') ,
					
						),
				),
				'attributes' => array(
						'id' => 'intervalle2',
		
				),
		));
		$this->add(array(
				'name' => 'intervalle3',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','J16 à J41') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','J42') ,
					
						),
				),
				'attributes' => array(
						'id' => 'intervalle3',
		
				),
		));
		/* source info */
		$this->add(array(
				'name' => 'source',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','Parent') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','Mari') ,
								2 => iconv ( 'ISO-8859-1', 'UTF-8','Agent de santé') ,
								3 => iconv ( 'ISO-8859-1', 'UTF-8','Groupement') ,
								4 => iconv ( 'ISO-8859-1', 'UTF-8','Radio') ,
								5 => iconv ( 'ISO-8859-1', 'UTF-8','Télévision') ,
								6 => iconv ( 'ISO-8859-1', 'UTF-8','Affiche') ,
								7 => iconv ( 'ISO-8859-1', 'UTF-8','Autres') ,
		
						),
				),
				'attributes' => array(
						'id' => 'source',
		
				),
		));
		/* situation matrimonial*/
		$this->add(array(
				'name' => 'situation',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','Mariée') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','Célibataire') ,
								2 => iconv ( 'ISO-8859-1', 'UTF-8','Veuve') ,
								3 => iconv ( 'ISO-8859-1', 'UTF-8','Divorcée') ,
								4 => iconv ( 'ISO-8859-1', 'UTF-8','Separée') ,		
						),
				),
				'attributes' => array(
						'id' => 'situation',
		
				),
		));
		/* niveau d'instruction*/
		$this->add(array(
				'name' => 'niveau',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','Non Scolarisée') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','Alphabétisée') ,
								2 => iconv ( 'ISO-8859-1', 'UTF-8','Primaire') ,
								3 => iconv ( 'ISO-8859-1', 'UTF-8','Secondaire') ,
								4 => iconv ( 'ISO-8859-1', 'UTF-8','Supérieur') ,
						),
				),
				'attributes' => array(
						'id' => 'niveau',
		
				),
		));
		/* profession du mari */
		$this->add(array(
				'name' => 'profession',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','Sans') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','Cultivateur') ,
								2 => iconv ( 'ISO-8859-1', 'UTF-8','Salarié') ,
								3 => iconv ( 'ISO-8859-1', 'UTF-8','A son compte') ,
						),
				),
				'attributes' => array(
						'id' => 'profession',
		
				),
		));
		/* */
		$this->add(array(
				'name' => 'prefere',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','Oui') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','Non') ,
						),
				),
				'attributes' => array(
						'id' => 'prefere',
		
				),
		));
		/* religion*/
		$this->add(array(
				'name' => 'religion',
				'type' => 'Select',
				'options' => array (
						'value_options' => array(
								0 => iconv ( 'ISO-8859-1', 'UTF-8','Musulmane') ,
								1 => iconv ( 'ISO-8859-1', 'UTF-8','Chretienne') ,
								2 => iconv ( 'ISO-8859-1', 'UTF-8','Autres') ,
								
						),
				),
				'attributes' => array(
						'id' => 'religion',
		
				),
		));
	
	$this->add ( array (
			'name' => 'etat_de_la_mere',
			'type' => 'Text',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','DDR:')
			),
			'attributes' => array (
					'id' => 'etat_de_la_mere',
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
			'name' => 'note_kystectomie',
			'type' => 'Text',
			'options' => array (
			),
			'attributes' => array (
					'id' => 'note_kystectomie',
	
					//'required' => true,
			)
	) );
	$this->add ( array (
			'name' => 'note_autrescons',
			'type' => 'Text',
			'options' => array (
			),
			'attributes' => array (
					'id' => 'note_autrescons',
	
					//'required' => true,
			)
	) );
	$this->add ( array (
			'name' => 'note_myomectomie',
			'type' => 'Text',
			'options' => array (
			),
			'attributes' => array (
					'id' => 'note_myomectomie',
	
					//'required' => true,
			)
	) );
		$this->add ( array (
			'name' => 'note_hysterectomie',
			'type' => 'Text',
			'options' => array (
			),
			'attributes' => array (
					'id' => 'note_hysterectomie',
	
					//'required' => true,
			)
	) );
	$this->add ( array (
			'name' => 'note_kysteovarienne',
			'type' => 'Text',
			'options' => array (
			),
			'attributes' => array (
					'id' => 'note_kysteovarienne',
	
					//'required' => true,
			)
	) );
	
	$this->add ( array (
			'name' => 'note_hta',
			'type' => 'Text',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','Duree Grossesse en semaine:')
			),
			'attributes' => array (
					'id' => 'note_hta',
	
					//'required' => true,
			)
	) );
	
		$this->add ( array (
				'name' => 'poids',
				'type' => 'Number',
				'options' => array (),
				// 'label' => iconv ( 'UTF-8','ISO-8859-1', 'TempÃ©rature (Â°C)' )
				'attributes' => array (
						'class' => 'temperature_only_numeric',
						//'readonly' => 'readonly',
						'min'=>34,
						'id' => 'poids' 
				) 
		) );

	$this->add ( array (
			'name' => 'lieu_accouchement',
			'type' => 'Text',
			'options' => array (
					//'label' => iconv('ISO-8859-1', 'UTF-8','Duree Grossesse en semaine:')
			),
			'attributes' => array (
					'id' => 'lieu_accouchement',
	
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
			'name' => 'text_examen',
			'type' => 'Textarea',
			'options' => array (
						
			),
			'attributes' => array (
	
					'id' => 'text_examen'
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









