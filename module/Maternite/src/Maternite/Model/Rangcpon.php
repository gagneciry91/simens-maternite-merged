<?php
namespace Maternite\Model;

class RangCpon {
public $id_cons;
	public $intervalle1;
	public $intervalle2;
	public $intervalle3;
	public $date_intervalle1;
	public $date_intervalle2;
	public $date_intervalle3;
	public $details;	
	
	public function exchangeArray($data) {
		$this->id_cons = (! empty ( $data ['ID_CONS'] )) ? $data ['ID_CONS'] : null;
		
		$this->intervalle1 = (! empty ( $data ['intervalle1'] )) ? $data ['intervalle1'] : null;
		$this->intervalle2 = (! empty ( $data ['intervalle2'] )) ? $data ['intervalle2'] : null;
		$this->intervalle3 = (! empty ( $data ['intervalle3'] )) ? $data ['intervalle3'] : null;
		$this->date_intervalle1 = (! empty ( $data ['date_intervalle1'] )) ? $data ['date_intervalle1'] : null;
		$this->date_intervalle2 = (! empty ( $data ['date_intervalle2'] )) ? $data ['date_intervalle2'] : null;
		$this->date_intervalle3 = (! empty ( $data ['date_intervalle3'] )) ? $data ['date_intervalle3'] : null;
		$this->details = (! empty ( $data ['details'] )) ? $data ['details'] : null;
		
		
	}
}
