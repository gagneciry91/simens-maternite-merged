<?php


namespace Maternite\Model;

class Gynecologie {
	public $infertilite;
	public $id_cons;
	public $antepers;
	
	public function exchangeArray($data) {
	
		$this->infertilite= (! empty ( $data ['infertilite'] )) ? $data ['infertilite'] : null;
		$this->id_cons= (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->antepers= (! empty ( $data ['antepers'] )) ? $data ['antepers'] : null;
		
	}
	
}