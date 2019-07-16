<?php
namespace Maternite\Model;

class TypeIntervention {
	public  $id_type;
	Public  $type_inter;
	

	public function exchangeArray($data) {
		$this->id_type = (! empty ( $data ['id_type'] )) ? $data ['id_type'] : null;
		$this->type_inter = (! empty ( $data ['type_inter'] )) ? $data ['type_intert'] : null;
	
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}