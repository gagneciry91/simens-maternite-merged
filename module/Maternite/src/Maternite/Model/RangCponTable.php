<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

use Zend\XmlRpc\Value\String;
use Doctrine\Tests\Common\Annotations\Null;
use Maternite\View\Helpers\DateHelper;

class RangCponTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	
	public function getCpon($id_cons) {
		
		
		$adapter = $this->tableGateway->getAdapter ();	
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				  '*'
		) ); 
		$select->from ( array (
				'cpon' => 'rangcpon'
		) );
	
		$select->where ( array (
				'cpon.ID_CONS' => $id_cons
		) );
		$select->order ( 'cpon.id_datec ASC' );
		
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute()->current();
		//var_dump($result);exit();
		return $result;
	}
	public function updateAllaitement($values) {
	
		//var_dump('test');exit();
	
			
		$donnees = array (
				'ID_CONS' => $values['ID_CONS'],
	
				'AME' => $values['AME'],
				'AUTRES' => $values['AUTRES'],
		); //var_dump($donnees);exit();
		$this->tableGateway->insert ( $donnees );
	
		var_dump('test');exit();
	}


	public function updateRangCpon($values) {
		$Control = new DateHelper();
		$this->tableGateway->delete ( array (
				'ID_CONS' => $values ['ID_CONS'],) );
	 
		$date_intervalle1 = $values['date_intervalle1'];
		$date_intervalle2 = $values['date_intervalle2'];
		$date_intervalle3 = $values['date_intervalle3'];
		
		$date_intervalle1 = $Control->convertDate($date_intervalle1);
		$date_intervalle2 = $Control->convertDateInAnglais($date_intervalle2);
		$date_intervalle3 = $Control->convertDateInAnglais($date_intervalle3);
		
		if( $values['date_intervalle1']){
		
			
	$donnees = array (
				'ID_CONS' => $values['ID_CONS'],
				'intervalle1' => $values['intervalle1'],
				'intervalle2' => $values['intervalle2'],
				'intervalle3' => $values['intervalle3'],
			/* 	'date_intervalle1' => $values['date_intervalle1'],
				'date_intervalle2' => $values['date_intervalle2'],
				'date_intervalle3' => $values['date_intervalle3'], */
				'details' => $values['details'],
				
						); //var_dump($donnees);exit();
		 //$this->tableGateway->insert ( $donnees );
	return $this->tableGateway->getLastInsertValue($this->tableGateway->insert ( $donnees ));
	
			 
	
	var_dump($donnees);exit();
				}
	}		
	}
	

