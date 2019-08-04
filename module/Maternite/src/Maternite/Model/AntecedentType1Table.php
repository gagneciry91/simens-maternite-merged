<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

use Maternite\View\Helpers\DateHelper;

class AntecedentType1Table {
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
				'pat' => 'patient'
		) );
	}
   
    public function addAntecedentType1($donnees){
    	$result = $this->tableGateway->select(array('id_patient'=> $donnees['id_patient']));
    	if(!$result->current()){
    		$this->tableGateway->insert($donnees);
    	}else{
    		$this->tableGateway->update($donnees, array('id_patient'=> $donnees['id_patient']));
    	}
    }
	
	

    public function updateAntecedentType1($donnees) {
    			$Control = new DateHelper();
    	
    	$this->tableGateway->delete ( array (
     			'id_cons' => $donnees ['id_cons']
     	) );
    	$ddr = $donnees['ddr'];
    	 
    	if($ddr){ $ddr = $Control->convertDateInAnglais($ddr); }else{ $ddr = null;}
    	 
    	$datadonnee = array (
    			'id_cons' => $donnees ['id_cons'],
    			'id_patient' => $donnees ['id_patient'],
    			'enf_viv' => $donnees ['enf_viv'],
    			'parite' => $donnees ['parite'],
    			'geste' => $donnees ['geste'],
    			'note_enf' => $donnees ['note_enf'],
    			'note_parite' => $donnees ['note_parite'],
    			'note_geste' => $donnees ['note_geste'],
    			'mort_ne' => $donnees ['mort_ne'],
    			'note_mort_ne' => $donnees ['note_mort_ne'],
    			'cesar' => $donnees ['cesar'],
    			'nombre_cesar'=>$donnees['nombre_cesar']?$donnees['nombre_cesar']:null,
    			//'avortement' => $donnees ['avortement'],
    			//'note_avortement' => $donnees ['note_avortement'],
    			//'allaitement' => $donnees ['allaitement'],
    			//'note_allaitement' => $donnees ['note_allaitement'],
    			'hta' => $donnees ['hta'],
    			'regularite' => $donnees ['regularite'],
    			'rhesus' => $donnees ['rhesus'],
    			'note_gs' => $donnees ['note_gs'],
    			'menarchie'=> $donnees ['menarchie']?$donnees['menarchie']:null,
    			'test_emmel' => $donnees ['test_emmel'],
    			'profil_emmel' => $donnees ['profil_emmel'],
    			'note_emmel' => $donnees ['note_emmel'],
    			'indication' => $donnees ['indication'],
    			'duree_infertilite'=>$donnees['duree_infertilite']?$donnees['duree_infertilite']:null,
    			'dg'=>$donnees['dg'],
    			'note_dg'=>$donnees['note_dg'],
    			//'ddr'=>$ddr,
    			'inv_uter' => $donnees ['inv_uter']?$donnees['inv_uter']:null,
    			'muqueuse' => $donnees ['muqueuse'],
    			'oeudeme'=> $donnees['oeudeme'],
    			'eg'=> $donnees['eg'],
    			'seins'=>$donnees['seins'],
    			'note_sein'=>$donnees['note_sein'],
    			'tvagin'=>$donnees['tvagin'],
    			'abdomen'=>$donnees['abdomen'],
    			'mollets'=>$donnees['mollets'],
    			'NoteHtaAF'=>$donnees['NoteHtaAF'],
    			'enf_viv_mari'=>$donnees['enf_viv_mari'],
    			'noteenf_viv'=>$donnees['noteenf_viv'],
    			'Vivensemble'=>$donnees['Vivensemble'],
    			'note_Vivensemble'=>$donnees['note_Vivensemble'],
    			'enf_age'=>$donnees['enf_age'],
    			'noteenf_age'=>$donnees['noteenf_age'],
    			'regime'=>$donnees['regime'],
    			'note_regime'=>$donnees['note_regime'],
    			'nouvelleMotifs'=>$donnees['nouvelleMotifs'],
    			'amenere'=>$donnees['amenere'],
    			'kystectomie'=>$donnees['kystectomie'],
    			'myomectomie'=>$donnees['myomectomie'],
    			'kysteovarienne'=>$donnees['kysteovarienne'],
    			'hysterectomie'=>$donnees['hysterectomie'],
    			'autrescons'=>$donnees['autrescons'],
    			 
    			'note_kystectomie'=>$donnees['note_kystectomie'],
    			'note_myomectomie'=>$donnees['note_myomectomie'],
    			'note_hysterectomie'=>$donnees['note_hysterectomie'],
    			'note_kysteovarienne'=>$donnees['note_kysteovarienne'],
    			'note_autrescons'=>$donnees['note_autrescons'],
    			
    			
    			
    			 
    			
    	
    	); 
    	
    	//var_dump($datadonnee);exit();
    
     	
    		return $this->tableGateway->getLastInsertValue($this->tableGateway->insert( $datadonnee ));
    		
    	//var_dump($datadonnee); exit();
    	//$this->tableGateway->insert ( $datadonnee );
    }
    
    public function getPrimipareRisque($date_debut,$date_fin){
    	$db = $this->tableGateway->getAdapter();
    	$sql = new Sql($db);
    	$sQuery = $sql->select()
    	->from(array('ant' => 'antecedent_type_1'))
    	->join ( array (
    			'c' => 'consultation'
    	), 'ant.id_cons = c.ID_CONS', array (
    
    	))
    	->columns( array( '*' ))
    
    	->where ( array (
    			'ant.geste'=>1 ,'c.DATEONLY>= ?' => $date_debut,'c.DATEONLY<= ? '=> $date_fin ) );
    	$stat = $sql->prepareStatementForSqlObject($sQuery);
    	$resultat = $stat->execute();
    	//var_dump(count($resultat));exit();
    	return count($resultat);
    }
	
    public function getMultiparePatho($date_debut,$date_fin){
    	$db = $this->tableGateway->getAdapter();
    	$sql = new Sql($db);
    	$sQuery = $sql->select()
    	->from(array('ant' => 'antecedent_type_1') )
    	->join ( array (
    			'c' => 'consultation'
    	), 'ant.id_cons = c.ID_CONS', array (
    	
    	))
    	->columns( array( '*' ))
    
    	->where ( array (
    			'ant.geste> ?'  => 1 ,'c.DATEONLY>= ?' => $date_debut,'c.DATEONLY<= ? '=> $date_fin ) );
    	$stat = $sql->prepareStatementForSqlObject($sQuery);
    	$resultat = $stat->execute();
    	//var_dump(count($resultat));exit();
    	return count($resultat);
    }
    public function getMultipareRisque($date_debut,$date_fin){
    	$db = $this->tableGateway->getAdapter();
    	$sql = new Sql($db);
    	$sQuery = $sql->select()
    	->from(array('ant' => 'antecedent_type_1'))
    	->join ( array (
    			'c' => 'consultation'
    	), 'ant.id_cons = c.ID_CONS', array (
    	
    	))
    	->columns( array( '*' ))
    
    	->where ( array (
    			'ant.geste> ?'  => 1 ,'c.DATEONLY>= ?' => $date_debut,'c.DATEONLY<= ? '=> $date_fin ) );
    	$stat = $sql->prepareStatementForSqlObject($sQuery);
    	$resultat = $stat->execute();
    	//var_dump(count($resultat));exit();
    	return count($resultat);
    }
    public function getAntecedentType1($id_pat) {
    
    	//$adapter = $this->tableGateway->getAdapter ();
    	$db = $this->tableGateway->getAdapter ();
    	$sql = new Sql ( $db );
    	$sQuery = $sql->select ();
    
    	$sQuery->columns ( array (
    			'*'
    	) );
    
    	$sQuery->from( array (
    			'ant' => 'antecedent_type_1'
    	) )->join ( array (
    			'c' => 'consultation'
    	), 'ant.id_cons = c.ID_CONS', array (
    
    	));
    	$sQuery->where ( array (
    			'ant.id_patient' => $id_pat
    
    	) );
    
    	$sQuery->order ( 'ant.id_ant_t1 ASC' );
    
    	$stat = $sql->prepareStatementForSqlObject ( $sQuery );
    
    	$resultat = $stat->execute ()->current();
    	//var_dump($resultat);exit();
    	return $resultat;
    }
	
	
	
	
}