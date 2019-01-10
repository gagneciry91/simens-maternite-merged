<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\XmlRpc\Value\String;
use Doctrine\Tests\Common\Annotations\Null;
use Maternite\View\Helpers\DateHelper;

class DateCponTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	

	public function getDateCpon1($id_cons) {
	
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'*'
		) );
		$select->from ( array (
				'cpon' => 'dateCpon'
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
	public function getDateCpon($id) {
		var_dump('test');exit();
		$rowset = $this->tableGateway->select ( array (
				'ID_CONS' => $id 
		) );		var_dump('test');exit();
				
		$row = $rowset->current ();		
		
		if (! $row) {
			// throw new \Exception ( "Could not find row $id" );
			return $row;
		}
		return $row;
	}

	public function updateDateCpon1($infos_cpon) {
		
		$this->tableGateway->delete ( array (
				'ID_CONS' => $infos_cpon ['ID_CONS'] 
		) );	var_dump('test');exit();
				
		
		if ($infos_cpon ['J1_J3'] && $infos_cpon ['J4_J8']) {
			$this->tableGateway->insert ( $infos_cpon );
			
		}
	}
	

	public function updateDateCpon($values) {
		
		//var_dump('test');exit();
		
		$Control = new DateHelper();
	
		
		
		
		$donnees = array (
				'ID_CONS' => $values['ID_CONS'],
				'intervalle1' => $values['intervalle1'],
				'intervalle2' => $values['intervalle2'],
				'intervalle3' => $values['intervalle3'],
				'date_intervalle1' => $values['date_intervalle1'],
				'date_intervalle2' => $values['date_intervalle1'],
				'date_intervalle3' => $values['date_intervalle3'],
				'details' => $values['details'],
				
						);  var_dump($donnees);exit();
		 $this->tableGateway->insert ( $donnees );
		
				//var_dump('test');exit();
		}		
	}
	

