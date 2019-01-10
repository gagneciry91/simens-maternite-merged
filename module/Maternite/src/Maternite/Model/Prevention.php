<?php
namespace Maternite\Model;

class Prevention {
	public $fer;
	public $vat;
	public $vih;
	public $id_cons;
	
	
	public function exchangeArray($data) {
		$this->id_cons = (! empty ( $data ['ID_CONS'] )) ? $data ['ID_CONS'] : null;
		
		$this->fer = (! empty ( $data ['FER'] )) ? $data ['FER'] : null;
		$this->vat = (! empty ( $data ['VAT'] )) ? $data ['VAT'] : null;
		$this->vih = (! empty ( $data ['VIH'] )) ? $data ['VIH'] : null;
		
	}
}
