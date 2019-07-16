<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class DiagnosticsTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getDiagnostics($id) {
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->from ( 'diagnostic' );
		$select->columns ( array (
				'*' 
		) );
		$select->where ( array (
				'id_cons' => $id 
		) );
		$select->order ( 'code_diagnostics ASC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		return $result;
	}
	public function updateDiagnostics($donnees) {
		$this->tableGateway->delete ( array (
				'id_cons' => $donnees ['id_cons'] 
		) );
		
		for($i = 1; $i < 5; $i ++) {
			if ($donnees ['diagnostic' . $i]) {
				$donneeDiagnostic = array (
						'libelle_diagnostics' => $donnees ['diagnostic' . $i],
						'id_cons' => $donnees ['id_cons'],
						//'decision' => $donnees ['decision']
				);//var_dump($donneeDiagnostic);exit();
				$this->tableGateway->insert ( $donneeDiagnostic );
			}
		}
	}
	
	
	
	

	public function addDecision($donne,$id_cons) {
		$db = $this->tableGateway->getAdapter ();
		$this->tableGateway->delete ( array (
				//'id_cons' => $donne ['id_cons']
		) ); //var_dump('test');exit(); 
		$sql = new Sql ( $db );
		$sQuery = $sql->insert ()->into ( 'decision' )->values ( array (
				'id_cons' => $id_cons,
				'decision'  => $donne
		) );
		$requete = $sql->prepareStatementForSqlObject ( $sQuery );
		$requete->execute ();
	}
	
	public function getDecision($id_cons) {
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'*'
		) );
		$select->from( array (
				'dec' => 'decision'
		) )->join ( array (
				'cons' => 'consultation'
		), 'dec.id_cons = cons.ID_CONS', array (
	
		));
		$select->where ( array (
				'dec.id_cons' => $id_cons
		) );
		$select->order ( 'dec.id_decision ASC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ()->current();
	
		return $result;
	}
	
}
