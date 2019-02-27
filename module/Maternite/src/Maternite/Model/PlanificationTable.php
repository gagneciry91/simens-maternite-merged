<?php
namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Crypt\PublicKey\Rsa\PublicKey;
use Zend\Validator\File\Count;

class PlanificationTable {

	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;

	}
	public function updatePlanification($values) {
	
	//var_dump('test');exit();
		$donnees = array (
				'ID_CONS' => $values['ID_CONS'],
				//'etat_de_la_mere' => $values['etat_de_la_mere'],
				'pilule' => $values['pilule'],
	
				//'type_accouchement' => $values['type_accouchement'],
				//'lieu_accouchement' => $values['lieu_accouchement'],
				//'numero_d_ordre' => $values['numero_d_ordre'],
		);
		return $this->tableGateway->getLastInsertValue($this->tableGateway->insert ( $donnees ));
		var_dump($donnees);exit();
	}
	
}