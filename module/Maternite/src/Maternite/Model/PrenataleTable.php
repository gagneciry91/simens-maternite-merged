<?php
namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
class PrenataleTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	
	}

	public function updatePrenatale($values) {
	
		$donnees = array (
				'id_cons' => $values['id_cons'],
				
		); 						//var_dump($donnees);exit();
	
		return $this->tableGateway->getLastInsertValue($this->tableGateway->insert ( $donnees ));
		//var_dump($donnees);exit();
	}
}

