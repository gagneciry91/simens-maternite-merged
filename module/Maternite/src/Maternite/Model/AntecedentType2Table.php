<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;


class AntecedentType2Table {
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	
	
	public function getAdmission() {
	
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
	
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->from ( array (
				'ad' => 'admission'
		) );}

        public function addAntecedentType2($donnees){
        	return $this->tableGateway->getLastInsertValue($this->tableGateway->insert($donnees));
        }
	
        public function updateAntecedentType2($donnees) {
        	
        	$this->tableGateway->delete ( array (
        			'id_cons' => $donnees ['id_cons']
        	) );
        
        	$datadonnee = array (
        			'id_cons' => $donnees ['id_cons'],
        			'id_patient' => $donnees ['id_patient'],
        			'dystocie' => $donnees ['dystocie'],
        			'eclampsie' => $donnees ['eclampsie'],
        			'cycle' => $donnees ['regularite'],
        			'duree_cycle' => $donnees ['duree_cycle'],
        			'quantite_regle' => $donnees ['quantite_regle'],
        			'nb_garniture_jr' => $donnees ['nb_garniture_jr'],
        			'note_dystocie' => $donnees ['note_dystocie'],
        			'note_eclampsie' => $donnees ['note_eclampsie'], 			
        			//'note_cycle' => $donnees ['note_cycle'],
        			'autre_go' => $donnees ['autre_go'],
        			'note_autre' => $donnees ['note_autre'],
        			'contraception' => $donnees ['contraception'],
        			'type_contraception' => $donnees ['type_contraception'],
        			'duree_contraception' => $donnees ['duree_contraception'],
        			'note_contraception' => $donnees ['note_contraception'],
        			
        	);
        
        return	$this->tableGateway->update($datadonnee, array('id_cons'=> $donnees['id_cons']));
        	 
        		//return $this->tableGateway->getLastInsertValue($this->tableGateway->insert($datadonnee));
        	
        	//var_dump($datadonnee); exit();
        	//$this->tableGateway->insert ( $datadonnee );
        }
        

        public function getAntecedentType2($id_cons) {
        
        	//$adapter = $this->tableGateway->getAdapter ();
        	$db = $this->tableGateway->getAdapter ();
        	$sql = new Sql ( $db );
        	$sQuery = $sql->select ();
        
        	$sQuery->columns ( array (
        			'*'
        	) );
        
        	$sQuery->from( array (
        			'ant' => 'antecedent_type_2'
        	) )->join ( array (
        			'c' => 'consultation'
        	), 'ant.id_cons = c.ID_CONS', array (
        
        	));
        	$sQuery->where ( array (
        			'ant.id_cons' => $id_cons
        
        	) );
        
        	$sQuery->order ( 'ant.id_ant_t2 ASC' );
        
        	$stat = $sql->prepareStatementForSqlObject ( $sQuery );
        
        	$resultat = $stat->execute ()->current();
        	//var_dump($resultat);exit();
        	return $resultat;
        }
	
	
	
	
	
	
	
}