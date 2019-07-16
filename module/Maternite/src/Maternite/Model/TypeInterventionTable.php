<?php
namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;

class TypeInterventionTable{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	public function listeTypeIntervention(){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('t'=>'type_intervention'));
		$select->columns(array('id_type','type_inter'));
		$select->order('id_type ASC');
		$stat = $sql->prepareStatementForSqlObject($select);
		$result = $stat->execute();
		$options = array(0 => "Choisir");
		foreach ($result as $data) {
			$options[$data['id_type']] = $data['type_inter'];
		}
		//var_dump($data);exit();
		return $options;
	}
	
}