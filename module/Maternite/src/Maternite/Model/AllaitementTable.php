<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

use Maternite\View\Helpers\DateHelper;


class AllaitementTable {
	
protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	

	public function updateAllaitement($values) {
	
		//var_dump('test');exit();
	
		$Control = new DateHelper();
			
		$donnees = array (
				'ID_CONS' => $values['ID_CONS'],
				'AME' => $values['AME'],
				'AUTRE' => $values['AUTRE'],
		);  //var_dump($donnees);exit();
		$this->tableGateway->insert ( $donnees );
	
		//var_dump('test');exit();
	}
}

?>