<?php

namespace Maternite\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Patient implements InputFilterAwareInterface {
	public $id_personne;
	public $ordre;
	public $numero_dossier;
	public $mois;
	public $numeroOrdre;
	public $annee;
	public $date_enregistrement;
	protected $inputFilter;
	
	public function exchangeArray($data) {
		$this->id_personne = (! empty ( $data ['ID_PERSONNE'] )) ? $data ['ID_PERSONNE'] : null;
		$this->ordre = (! empty ( $data ['ORDRE'] )) ? $data ['ORDRE'] : null;
		$this->numeroOrdre = (! empty ( $data ['numeroOrdre'] )) ? $data ['numeroOrdre'] : null;
		
		$this->numero_dossier = (! empty ( $data ['NUMERO_DOSSIER'] )) ? $data ['NUMERO_DOSSIER'] : null;
		$this->mois = (! empty ( $data ['MOIS'] )) ? $data ['MOIS'] : null;
		$this->annee = (! empty ( $data ['ANNEE'] )) ? $data ['ANNEE'] : null;
		$this->date_enregistrement = (! empty ( $data ['DATE_ENREGISTREMENT'] )) ? $data ['DATE_ENREGISTREMENT'] : null;
		
	}
	public function getArrayCopy() {
		return get_object_vars ( $this );
	}
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception ( "Not used" );
	}
	public function getInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			$factory = new InputFactory ();
			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}