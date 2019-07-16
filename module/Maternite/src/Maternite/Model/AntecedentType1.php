<?php
namespace Maternite\Model;

class AntecedentType1 {
	public $id_patient;
	public $id_cons;
	public $id_service;
	public $date_cons;
	public $enf_viv;
	public $geste;
	public $parite;
	public $mort_ne;
	public $cesar;
	public $avortement;
	public $age;
	public $regularite;
	public $allaitement;
	public $note_allaitement;
	public $note_avortement;
	public $note_enf;
	public $note_geste;
	public $note_parite;
	public $note_mort_ne;
	public $note_cesar;
	public $groupe_sanguin;
	public $rhesus;
	public $test_emmel;
	public $profil_emmel;
	public $note_gs;
	public $note_emmel;
	public $menarchie;
	public $hta;
	public $nombre_cesar;
	public $inv_uter;
	

	
	public function exchangeArray($data) {
		$this->id_patient = (! empty ( $data ['id_patient'] )) ? $data ['id_patient'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->geste = (! empty ( $data ['geste'] )) ? $data ['geste'] : null;
		$this->parite = (! empty ( $data ['parite'] )) ? $data ['parite'] : null;
		$this->enf_viv = (! empty ( $data ['enf_viv'] )) ? $data ['enf_viv'] : null;
		$this->note_allaitement = (! empty ( $data ['note_allaitement'] )) ? $data ['note_allaitement'] : null;
		$this->nallaitement = (! empty ( $data ['allaitement'] )) ? $data ['allaitement'] : null;
		$this->regularite = (! empty ( $data ['regularite'] )) ? $data ['regularite'] : null;
		$this->nombre_cesar = (! empty ( $data ['nombre_cesar'] )) ? $data ['nombre_cesar'] : null;
		$this->inv_uter = (! empty ( $data ['inv_uter'] )) ? $data ['inv_uter'] : null;
		
		$this->age = (! empty ( $data ['age'] )) ? $data ['age'] : null;
		$this->avortement = (! empty ( $data ['avortement'] )) ? $data ['avortement'] : null;
		$this->note_avortement = (! empty ( $data ['note_avortement'] )) ? $data ['note_avortement'] : null;
		$this->menarchie = (! empty ( $data ['menarchie'] )) ? $data ['menarchie'] : null;
		$this->hta = (! empty ( $data ['hta'] )) ? $data ['hta'] : null;
		
		$this->mort_ne = (! empty ( $data ['mort_ne'] )) ? $data ['mort_ne'] : null;
		$this->cesar = (! empty ( $data ['cesar'] )) ? $data ['cesar'] : null;
		$this->note_enf = (! empty ( $data ['note_enf'] )) ? $data ['note_enf'] : null;
		$this->note_geste = (! empty ( $data ['note_geste'] )) ? $data ['note_geste'] : null;	
		$this->note_parite = (! empty ( $data ['note_parite'] )) ? $data ['note_parite'] : null;
		$this->note_cesar = (! empty ( $data ['note_cesar'] )) ? $data ['note_cesar'] : null;
		$this->note_mort_ne = (! empty ( $data ['note_mort_ne'] )) ? $data ['note_mort_ne'] : null;
		$this->groupe_sanguin = (! empty ( $data ['groupe_sanguin'] )) ? $data ['groupe_sanguin'] : null;
		$this->note_gs = (! empty ( $data ['note_gs'] )) ? $data ['note_gs'] : null;
		$this->rhesus= (! empty ( $data ['rhesus'] )) ? $data ['rhesus'] : null;
		$this->test_emmel = (! empty ( $data ['test_emmel'] )) ? $data ['test_emmel'] : null;
		$this->profil_emmel = (! empty ( $data ['profil_emmel'] )) ? $data ['profil_emmel'] : null;
	    $this->note_emmel = (! empty ( $data ['note_emmel'] )) ? $data ['note_emmel'] : null;

		
	}

}