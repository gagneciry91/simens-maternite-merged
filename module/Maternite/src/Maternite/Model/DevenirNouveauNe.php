<?php

namespace Maternite\Model;

class DevenirNouveauNe {
	public $id_bebe;
	public $id_cons;
	public $viv_bien_portant;
	public $viv_mal_formation;
	public $malade;
	public $decede;
	public $date_deces;
	public $heure_deces;
	public $cause_deces;
	public $note_viv_bien_portant;
	public $note_viv_mal_formation;
	public $note_malade;
	//
	public $poid;
	public $temperature;
	public $etat_de_l_enfant;
	public $etat_cordon;
	public $infection;
	public $BCG_polio;
	

	
	
	public function exchangeArray($data) {
		$this->id_bebe = (! empty ( $data ['id_bebe'] )) ? $data ['id_bebe'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->viv_bien_portant= (! empty ( $data ['viv_bien_portant'] )) ? $data ['viv_bien_portant'] : null;
		$this->viv_mal_formation= (! empty ( $data ['viv_mal_formation'] )) ? $data ['viv_mal_formation'] : null;
	    $this->malade= (! empty ( $data ['malade'] )) ? $data ['malade'] : null;
	   $this->decede= (! empty ( $data ['decede'] )) ? $data ['decede'] : null;
		$this->date_deces = (! empty ( $data ['date_deces'] )) ? $data ['date_deces'] : null;
		$this->heure_deces = (! empty ( $data ['heure_deces'] )) ? $data ['heure_deces'] : null;
		$this->cause_deces= (! empty ( $data ['cause_deces'] )) ? $data ['cause_deces'] : null;
		$this->note_viv_bien_portant = (! empty ( $data ['note_viv_bien_portant'] )) ? $data ['note_viv_bien_portant'] : null;
		$this->note_viv_mal_formation = (! empty ( $data ['note_viv_mal_formation'] )) ? $data ['note_viv_mal_formation'] : null;
		$this->note_malade = (! empty ( $data ['note_malade'] )) ? $data ['note_malade'] : null;
		$this->infection = (! empty ( $data ['infection'] )) ? $data ['infection'] : null;
		$this->poid = (! empty ( $data ['poid'] )) ? $data ['poid'] : null;
		$this->temperature = (! empty ( $data ['temperature'] )) ? $data ['temperature'] : null;
		$this->etat_de_l_enfant = (! empty ( $data ['etat_de_l_enfant'] )) ? $data ['etat_de_l_enfant'] : null;
		$this->etat_cordon = (! empty ( $data ['etat_cordon'] )) ? $data ['etat_cordon'] : null;
		$this->BCG_polio = (! empty ( $data ['BCG_polio'] )) ? $data ['BCG_polio'] : null;
		
		
		
		
		
		
		
		
	}
}