<?php
namespace Maternite\Form\accouchement;

use Zend\Form\Form;

class StatistiqueForm extends Form{

	public function __construct() {
		parent::__construct ();

		$today = new \DateTime ();
		$dateAujourdhui = $today->format( 'Y-m-d' );
		
		$this->add ( array (
				'name' => 'id_sous_dossier',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Choix du sous dossier'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getInformationsSousDossierRapport(this.value)',
						'id' => 'id_sous_dossier',
						'class' => 'select-element',
				)
		) );
		
		
		$this->add ( array (
				'name' => 'id_sous_dossier_genre',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Choix du sous dossier'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getInformationsSousDossierGenre(this.value)',
						'id' => 'id_sous_dossier_genre',
						'class' => 'select-element',
				)
		) );
		
		
		
		
		
		$this->add ( array (
				'name' => 'id_personne',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Choix du sexe'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getInformationsGenre(this.value)',
						'id' => 'id_personne',
						'class' => 'select-element',
				)
		) );
		
		
		
		
		
		$this->add ( array (
				'name' => 'sous_dossier',
				'type' => 'select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Type Sous-Dossier'),
				),
				'attributes' => array (
						'id' =>'sous_dossier',
						'required' => true
		
				)
		) );
		
		$this->add ( array (
				'name' => 'id_medecin',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Choix du médecin'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getInformationsMedecin(this.value)',
						'id' =>'id_medecin',
				)
		) );
		
		$this->add ( array (
				'name' => 'age_min',
				'type' => 'number',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Age min(1)'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeAgeMin(this.value)',
						'id' =>'age_min',
						'min' => 1,
						'max' => 150,
						
				)
		) );
		
		$this->add ( array (
				'name' => 'age_max',
				'type' => 'number',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Age max(150)'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeAgeMax(this.value)',
						'id' =>'age_max',
						'min' => 1,
						'max' => 150,
				)
		) );
		
		$this->add ( array (
				'name' => 'date_debut',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date début'),
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
				'name' => 'date_fin',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date fin'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'date_fin',
						'min' => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
				)
		) );
		
		$this->add ( array (
				'name' => 'diagnostic',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Choix du diagnostic'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeDiagnostic(this.value)',
						'id' =>'diagnostic',
						'class' => 'diagnostic',
				)
		) );
		
		
		
		
		
		
		
		
		//POUR LA TROISIEME PARTIE ----- STAT 3
		//POUR LA TROISIEME PARTIE ----- STAT 3
		//POUR LA TROISIEME PARTIE ----- STAT 3
		//POUR LA TROISIEME PARTIE ----- STAT 3
		$this->add ( array (
				'name' => 'id_service_rapport',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Choix du service'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getInformationsServiceRapport(this.value)',
						'id' => 'id_service_rapport',
						'class' => 'select-element',
				)
		) );
		
		$this->add ( array (
				'name' => 'date_debut_rapport',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date début'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'date_debut_rapport',
						'min'  => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
				)
		) );
		
		$this->add ( array (
				'name' => 'date_fin_rapport',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date fin'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'date_fin_rapport',
						'min' => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
				)
		) );
		
		
		
		$this->add ( array (
				'name' => 'date_debut_genre',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date début'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeDateDebutRapport(this.value)',
						'id' =>'date_debut_genre',
						'min'  => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
				)
		) );
		$this->add ( array (
				'name' => 'cibles',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Cibles'),
						'value_options' => array (
								1 => 'Accouchements Eutociques',
								2 => 'Accouchements dystociques',
								3 => 'Type dintervention',
								
						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'cibles',
						'required' => true,
				)
		) );
		$this->add ( array (
				'name' => 'sexe',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Sexe'),
						'value_options' => array (
								1 => 'Masculin',
								2 => 'Feminin',
						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'sexe',
						'required' => true,
				)
		) );
		$this->add ( array (
				'name' => 'naissance',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Naissance'),
						'value_options' => array (
								1 => 'Vivants',
								2 => 'Deces',
						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'naissance',
						'required' => true,
				)
		) );
		$this->add ( array (
				'name' => 'cibler',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Cibles'),
						'value_options' => array (
								1 => 'Accouchements Eutociques',
								2 => 'Accouchements dystociques',
								3 => 'Type dintervention',
								
		
						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'cibler',
						'required' => true,
				)
		) );
		$this->add ( array (
				'name' => 'nature_naissance',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Type'),
						'value_options' => array (
								1 => 'Accouchements Eutociques',
								2 => 'Accouchements dystociques',
								3 => 'Type dintervention',
								
						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'nature_naissance',
						'required' => true,
				)
		) );
		

		$this->add ( array (
				'name' => 'surveillance',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Surveillance'),
						'value_options' => array (
								1 => 'Vaccin',
								2 => 'Grossesse',
								3 => 'Femme',
								4 => 'CPN',
		                        5=> 'Accouchement a domicile'
		
		
						)
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'surveillance',
						'required' => true,
				)
		) );
		
		
		$this->add ( array (
				'name' => 'date_fin_genre',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date fin'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeDateFinRapport(this.value)',
						'id' =>'date_fin_genre',
						'min' => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
				)
		) );
		
		
		$this->add ( array (
				'name' => 'date_debut_maternel',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date fin'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeDateFinRapport(this.value)',
						'id' =>'date_debut_maternel',
						'min' => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
				)
		) );
		
		$this->add ( array (
				'name' => 'date_fin_maternel',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date fin'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeDateFinRapport(this.value)',
						'id' =>'date_fin_maternel',
						'min' => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
				)
		) );
		
		
		$this->add ( array (
				'name' => 'date_debut_patho',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date fin'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'date_debut_patho',
						'min' => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
				)
		) );
		

		$this->add ( array (
				'name' => 'date_fin_patho',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date fin'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'date_fin_patho',
						'min' => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
				)
		) );
		

		$this->add ( array (
				'name' => 'date_fin_accouchement',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date fin'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'date_fin_accouchement',
						'min' => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
				)
		) );
		$this->add ( array (
				'name' => 'date_debut_accouchement',
				'type' => 'date',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Date Debut'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'id' =>'date_debut_accouchement',
						'min' => '2016-08-24',
						'max' => "$dateAujourdhui",
						'required' => true,
				)
		) );
		
		$this->add ( array (
				'name' => 'diagnostic_rapport',
				'type' => 'Select',
				'options' => array (
						'label' => iconv('ISO-8859-1', 'UTF-8','Choix du diagnostic'),
				),
				'attributes' => array (
						'registerInArrrayValidator' => true,
						'onchange' => 'getListeDiagnosticRapport(this.value)',
						'id' =>'diagnostic_rapport',
						'class' => 'diagnostic_rapport',
				)
		) );
		
		
		
// 		$this->add ( array (
// 				'name' => 'SEXE',
// 				'type' => 'Zend\Form\Element\Select',
// 				'options' => array (
// 						'label' => 'Sexe',
// 						'value_options' => array (
// 								'' => '',
// 								'Masculin' => 'Masculin',
// 								iconv ( 'ISO-8859-1', 'UTF-8','Féminin') => iconv ( 'ISO-8859-1', 'UTF-8','Féminin')
// 						)
// 				),
// 				'attributes' => array (
// 						'id' => 'SEXE',
// 						//'required' => true,
// 						//'tabindex' => 1,
// 				)
// 		) );		
		
	}
}