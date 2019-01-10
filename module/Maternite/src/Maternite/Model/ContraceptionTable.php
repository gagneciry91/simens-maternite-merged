<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
class ContraceptionTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	public function updateContraception($values) {
	
		//var_dump('test');exit();
	
			
		$donnees = array (
				'ID_CONS' => $values['ID_CONS'],
				'mama' => $values['mama'],
				'autres' => $values['autres'],
		);  //var_dump($donnees);exit();
		$this->tableGateway->insert ( $donnees );
	
		//var_dump('test');exit();
	}
	
}

?>