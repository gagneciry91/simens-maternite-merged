<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Sql;

use Maternite\View\Helpers\DateHelper;

class GynecologieTable {
	
	
		protected $tableGateway;
		public function __construct(TableGateway $tableGateway) {
			$this->tableGateway = $tableGateway;
	
		}
		
		public function getGynecologie($id_cons) {
		
			$adapter = $this->tableGateway->getAdapter ();
			$sql = new Sql ( $adapter );
			$select = $sql->select ();
			$select->columns ( array (
					'*'
			) );
			$select->from ( array (
					'gyn' => 'gynecologie'
			) );
		
			$select->where ( array (
					'gyn.id_cons' => $id_cons
			) );
			$select->order ( 'gyn.id_gynecologie ASC' );
		
			$stat = $sql->prepareStatementForSqlObject ( $select );
			$result = $stat->execute()->current();
			//var_dump($result);exit();
			return $result;
		}
		
		public function updateGyneco($values) {
			
			$this->tableGateway->delete ( array (
					'id_cons' => $values ['id_cons'],
			
			) );
			$donnees = array (
					'id_cons' => $values ['id_cons'],
					'infertilite' => $values['infertilite'],
					'antepers' => $values['antepers'],
						
			); 						//var_dump($donnees);exit();
		
			return $this->tableGateway->getLastInsertValue($this->tableGateway->insert( $donnees ));
			var_dump($donnees);exit();
		}
}