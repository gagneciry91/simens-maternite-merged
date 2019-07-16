<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class ConclusionTable {
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	
	
	
	
	
	public function getCausesComplication($id){

		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'*'
		) );
		$select->from ( array (
				'c' => 'conclusion'
		) );
		$select->join ( array (
				'cau' => 'cause'
		), 'cau.id_cause = c.id_cause', array (
				'*'
		) );
		$select->where ( array (
				'c.id_cons' => $id,
				'id_type_cause' => 1
		) );
		$select->order ( 'c.id_conclusion ASC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		
		return $result;
		
	}
	
	public function getCausesDeces($id){
	
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'*'
		) );
		$select->from ( array (
				'c' => 'conclusion'
		) );
		$select->join ( array (
				'cau' => 'cause'
		), 'cau.id_cause = c.id_cause', array (
				'*'
		) );
		$select->where ( array (
				'c.id_cons' => $id,
				'id_type_cause' => 2
		) );
		$select->order ( 'c.id_conclusion ASC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
	
		return $result;
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function getConclusion($id) {
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'*' 
		) );
		$select->from ( array (
				'c' => 'conclusion' 
		) );
		$select->where ( array (
				'c.id_cons' => $id 
		) );
		$select->order ( 'c.id_conclusion ASC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		
		return $result;
		
		
	}

	public function getComplicationObstetricale() {
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'*'
		) );
		$select->from ( array (
				'ca' => 'cause'
		) );
		$select->where ( array (
				'id_type_cause' => 1
		) );
		$select->order ( 'id_cause ASC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
	
		return $result;
	}
	


	public function getCauseDecesMaternel() {
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'*'
		) );
		$select->from ( array (
				'ca' => 'cause'
		) );
		$select->where ( array (
				'id_type_cause' => 2
		) );
		$select->order ( 'id_cause ASC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
	
		return $result;
	}
	
	
	public function updateConclusionComp($conclusion,$id_cons,$nbComp,$id_patient) {
		//$Control = new DateHelper();
	/* 	foreach ( $this->getConclusion ( $id_cons ) as $Conc ){
			//if (! in_array ( $Conc ['id_cause'], $Conc )) {
				if ($Conc ['id_cause'] <= 15) {
					$this->tableGateway->delete ( array (
					 	'id_cons' => $conclusion ['id_cons']
					 		) );
				}
			//}
		}
			
		$this->tableGateway->delete ( array (
				'id_cons' => $conclusion ['id_cons']
		) ); */			
		for($i = 1; $i <=  $nbComp ; $i ++){
			$datacomp = array (
					'id_cause' => $conclusion['comp_name_'. $i]?$conclusion['comp_name_'. $i]:null,
					'note_conclusion' => $conclusion['note_comp_' . $i]?$conclusion['note_comp_'. $i]:null,
					'id_cons' => $id_cons,
					'id_patient' => $id_patient,						
			);//var_dump($datacomp);exit();
			$this->tableGateway->insert ( $datacomp );}
			

	
	}
	
	public function updateConclusionDeces($conclusion,$id_cons,$nbCauseDc,$id_patient) {
	
	foreach ( $this->getConclusion ( $id_cons ) as $Conc ){
			//if (! in_array ( $Conc ['id_cause'], $Conc )) {
				if ($Conc ['id_cause'] >= 16) {
					$this->tableGateway->delete ( array (
					 	'id_cons' => $conclusion ['id_cons']
					 		) );
				}
			//}
		}
		for($i = 1; $i <=  $nbCauseDc ; $i ++){
	
			$datadeces = array (
					'id_cause' => $conclusion['deces_name_'. $i]?$conclusion['deces_name_'. $i]:null,
					'note_conclusion' => $conclusion['note_deces_' . $i]?$conclusion['note_deces_'. $i]:null,
					'id_cons' => $id_cons,
					'id_patient' => $id_patient,
			);//var_dump($datadeces);exit();
			$this->tableGateway->insert ( $datadeces );}
				
	
	
	}


















}

