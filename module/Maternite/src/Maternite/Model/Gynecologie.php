<?php


namespace Maternite\Model;

class Gynecologie {
	public $infertilite;
	public $id_cons;
	
	public function exchangeArray($data) {
	
		$this->infertilite= (! empty ( $data ['infertilite'] )) ? $data ['infertilite'] : null;
		$this->id_cons= (! empty ( $data ['$id_cons'] )) ? $data ['$id_cons'] : null;
	}
	
}