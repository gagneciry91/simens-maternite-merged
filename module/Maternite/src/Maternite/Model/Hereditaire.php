<?php
namespace Maternite\Model;

class Hereditaire{
	public $DiabeteAF;
	public $NoteDiabeteAF;
	public $DrepanocytoseAF;
	public $NoteDrepanocytoseAF;
	public $noteHtaAF;
	public $htaAF;
	public $id_cons;
	
	public function exchangeArray($data) {
		$this->id_cons = (! empty ( $data ['ID_CONS'] )) ? $data ['ID_CONS'] : null;
		$this->DiabeteAF = (! empty ( $data ['DiabeteAF'] )) ? $data ['DiabeteAF'] : null;
		
		$this->NoteDiabeteAF = (! empty ( $data ['NoteDiabeteAF'] )) ? $data ['NoteDiabeteAF'] : null;
		$this->DrepanocytoseAF = (! empty ( $data ['DrepanocytoseAF'] )) ? $data ['DrepanocytoseAF'] : null;
		$this->NoteDrepanocytoseAF = (! empty ( $data ['NoteDrepanocytoseAF'] )) ? $data ['NoteDrepanocytoseAF'] : null;
		$this->noteHtaAF = (! empty ( $data ['noteHtaAF'] )) ? $data ['noteHtaAF'] : null;
		$this->htaAF = (! empty ( $data ['htaAF'] )) ? $data ['htaAF'] : null;
		
	}
	
	
	
	

}