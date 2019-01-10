<?php
namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;

class HereditaireTable{
	
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function updateHereditaire($values) {
	
		//var_dump('test');exit();
	
		$donnees = array (
				'ID_CONS' => $values['ID_CONS'],
				'DiabeteAF' => $values['DiabeteAF'],
				'NoteDiabeteAF' => $values['NoteDiabeteAF'],
				'DrepanocytoseAF' => $values['DrepanocytoseAF'],
				'NoteDrepanocytoseAF' => $values['NoteDrepanocytoseAF'],
				'noteHtaAF' => $values['noteHtaAF'],
				'htaAF' => $values['htaAF'],
				
		);  //var_dump($donnees);exit();
		$this->tableGateway->insert ( $donnees );
	
		//var_dump('test');exit();
	}
}