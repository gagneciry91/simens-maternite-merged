<?php

namespace Maternite\Model;

class ConsultationMaternite {
	public $idcons_mater;
	public $id_cons;
	public $id_grossesse;
	public $commentaire;
    public $examen_maternite_donnee1;
	public $date_cons;
	public $toucherVaginale;
	public $hauteurUterine;
	public $positionFoeutus;
	public $vitaliteFoeutus;
	protected $inputFilter;
	public function exchangeArray($data) {
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->examen_maternite_donnee1 = (! empty ( $data ['examen_maternite_donnee1'] )) ? $data ['examen_maternite_donnee1'] : null;
		$this->date_cons = (! empty ( $data ['date_cons'] )) ? $data ['date_cons'] : null;
		
		$this->idcons_mater = (! empty ( $data ['idcons_mater'] )) ? $data ['idcons_mater'] : null;
		$this->id_grossesse = (! empty ( $data ['id_grossesse'] )) ? $data ['id_grossesse'] : null;
		$this->commentaire = (! empty ( $data ['commentaire'] )) ? $data ['commentaire'] : null;
		$this->toucherVaginale = (! empty ( $data ['toucherVaginale'] )) ? $data ['toucherVaginale'] : null;
		$this->hauteurUterine = (! empty ( $data ['hauteurUterine'] )) ? $data ['hauteurUterine'] : null;
		$this->positionFoeutus = (! empty ( $data ['positionFoeutus'] )) ? $data ['positionFoeutus'] : null;
		$this->vitaliteFoeutus = (! empty ( $data ['vitaliteFoeutus'] )) ? $data ['vitaliteFoeutus'] : null;
		
	}
	public function getArrayCopy() {
		return get_object_vars ( $this );
	}
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception ( "Not implemented" );
	}
	public function getInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			$factory = new InputFactory ();
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'id_medecin',
					'filters' => array (
							array (
									'name' => 'Int' 
							) 
					) 
			) ) );
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'id_patient',
					'filters' => array (
							array (
									'name' => 'Int' 
							) 
					) 
			) ) );
			
			/*
			 * $inputFilter->add (array ( 'name' => 'motif_admission', 'filters' => array ( array ( 'name' => 'StripTags' ), array ( 'name' => 'StringTrim' ) ) ) ); $inputFilter->add (array ( 'name' => 'motif_admission1', 'filters' => array ( array ( 'name' => 'StripTags' ), array ( 'name' => 'StringTrim' ) ) ) ); $inputFilter->add (array ( 'name' => 'motif_admission2', 'filters' => array ( array ( 'name' => 'StripTags' ), array ( 'name' => 'StringTrim' ) ) ) ); $inputFilter->add (array ( 'name' => 'motif_admission3', 'filters' => array ( array ( 'name' => 'StripTags' ), array ( 'name' => 'StringTrim' ) ) ) ); $inputFilter->add (array ( 'name' => 'motif_admission4', 'filters' => array ( array ( 'name' => 'StripTags' ), array ( 'name' => 'StringTrim' ) ) ) ); $inputFilter->add (array ( 'name' => 'motif_admission5', 'filters' => array ( array ( 'name' => 'StripTags' ), array ( 'name' => 'StringTrim' ) ) ) );
			 */
			
			$inputFilter->add ( array (
					'name' => 'examen_maternite_donnee1',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'examen_maternite_donnee2',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'examen_maternite_donnee3',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'examen_maternite_donnee4',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'examen_maternite_donnee5',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'examen_maternite_donnee6',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'examen_maternite_donnee7',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'examen_maternite_donnee8',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'examen_maternite_donnee9',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'groupe_sanguin',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'hemogramme_sanguin',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'bilan_hemolyse',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'bilan_hepatique',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'bilan_renal',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'bilan_inflammatoire',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'radio',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'radio_image',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'ecographie',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'ecographie_image',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'fibrocospie',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'fibrocospie_image',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'scanner',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'scanner_image',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'irm',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'irm_image',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'diagnostic1',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'diagnostic2',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'diagnostic3',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'diagnostic4',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'date_cons',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'poids',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'taille',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'temperature',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'tension',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'pouls',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'frequence_respiratoire',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'glycemie_capillaire',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'bu',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'diagnostic_traitement_chirurgical',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'intervention_prevue',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'numero_vpa',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'observation',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'motif_transfert',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'motif_hospitalisation',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			$inputFilter->add ( array (
					'name' => 'motif_rv',
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) );
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
}

?>