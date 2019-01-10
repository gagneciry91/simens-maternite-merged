<?php
namespace Maternite\Model;

class Allaitement {
	public $id_cons;
	public $ame;
	public $autre;
	
	public function exchangeArray($data) {
		$this->id_cons = (! empty ( $data ['ID_CONS'] )) ? $data ['ID_CONS'] : null;
	
		$this->ame = (! empty ( $data ['AME'] )) ? $data ['AME'] : null;
		$this->autre = (! empty ( $data ['AUTRE'] )) ? $data ['AUTRE'] : null;
	}
}