<?php

namespace Maternite\Model;

class Contraception {
	public $id_cons;
	public $mama;
	public $autres;
	
	
	public function exchangeArray($data) {
		$this->id_cons = (! empty ( $data ['ID_CONS'] )) ? $data ['ID_CONS'] : null;
	
		$this->mama = (! empty ( $data ['mama'] )) ? $data ['mama'] : null;
		$this->autres = (! empty ( $data ['autres'] )) ? $data ['autres'] : null;
	}
}

?>