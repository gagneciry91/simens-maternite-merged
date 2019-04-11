<?php
namespace Maternite\Model;
Class Prenatale{
	public $id_grossesse;
	public $id_admission;
	public $id_cons;
	public $id_prenatale;
	public $hauteurUterine;
	public $toucherVaginal;
	public $positionFoeutus;
	public $vitaliteFoeutus;
	
	public function exchangeArray($data) {
		$this->id_grossesse = (! empty ( $data ['id_grossesse'] )) ? $data ['id_grossesse'] : null;
		$this->id_admission = (! empty ( $data ['id_admission'] )) ? $data ['id_admission'] : null;
		$this->id_cons = (! empty ( $data ['id_cons'] )) ? $data ['id_cons'] : null;
		$this->id_prenatale= (! empty ( $data ['id_prenatale'] )) ? $data ['id_prenatale'] : null;
		$this->hauteurUterine= (! empty ( $data ['hauteurUterine'] )) ? $data ['hauteurUterine'] : null;
		$this->toucherVaginal= (! empty ( $data ['toucherVaginal'] )) ? $data ['toucherVaginal'] : null;
		$this->positionFoeutus= (! empty ( $data ['positionFoeutus'] )) ? $data ['positionFoeutus'] : null;
		$this->vitaliteFoeutus= (! empty ( $data ['vitaliteFoeutus'] )) ? $data ['vitaliteFoeutus'] : null;
		
	}
}
