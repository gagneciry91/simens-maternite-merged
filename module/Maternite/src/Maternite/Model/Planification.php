<?php
namespace Maternite\Model;


class Planification  {
	public $id_admission;
	public $id_cons;
	public $pilule;
	public $id_planification;
	
	public function exchangeArray($data) {
		$this->id_admission = (! empty ( $data ['id_admission'] )) ? $data ['id_admission'] : null;
		$this->id_cons= (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->pilule = (! empty ( $data ['pilule'] )) ? $data ['pilule'] : null;
		$this->id_planification = (! empty ( $data ['id_planification'] )) ? $data ['id_planification'] : null;
		
	}
}
