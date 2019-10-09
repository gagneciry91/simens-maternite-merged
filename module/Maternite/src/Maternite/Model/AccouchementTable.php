<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Sql;

use Maternite\View\Helpers\DateHelper;

class AccouchementTable {
	
	protected $tableGateway;
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
		
	}

	
	public function getDAteAcc(){
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'date_accouchement'
		) );
		$select->from ( array (
				'acc' => 'accouchement'
		) );
		$select->order ( 'acc.id_accouchement ASC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute();
		$variable =array();$i=1;
		foreach ($result as $r){
			$variable[$i] = $r['date_accouchement'];$i++;
		}
		return $variable;
	}
	
	
		public function getLesAccouchement($monthToday,$yearToday) {
			
			$today = new \DateTime ();
			$dateToday = $today->format ( 'Y-m-d' );
			//list($yearToday,$monthToday, $dayToday) = explode('-', $dateToday);
			$dates=array();
			$date=$this->getDAteAcc();
			$month=array();
			for($i=1;$i<=count($date);$i++){
					list($year[$i],$month[$i], $day[$i]) = explode('-', $date[$i]);	
                    if(($month[$i]==$monthToday)&&($year[$i]==$yearToday)){
	               $dates[$i]=$date[$i];
               }
			}
			return $dates;
		}
	
	public function getAccouchement($id_cons) {
		
		$adapter = $this->tableGateway->getAdapter ();	
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				  '*'
		) ); 
		$select->from ( array (
				'acc' => 'accouchement'
		) );
	
		$select->where ( array (
				'acc.id_cons' => $id_cons
		) );
		$select->order ( 'acc.id_accouchement ASC' );
		
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute()->current();
		//var_dump($result);exit();
		return $result;
	}

	
	
	
	
    public function updateAccouchement($donnees,$id_grossesse) {
    	$Control = new DateHelper();
    	
		$this->tableGateway->delete ( array (
				'id_cons' => $donnees ['id_cons'], 
				
		) );    	
		
		$date_accouchement = $donnees['date_accouchement'];
		
		if($date_accouchement)
		{ 
			$date_accouchement = $Control->convertDateInAnglais($date_accouchement); 
		 }
		//else{ $date_accouchement = null;}		
		 //var_dump('test');exit();
	if( $donnees['type_accouchement']!=0){
			$dataac = array (
					'id_cons' => $donnees ['id_cons'],
					'id_admission'=>$donnees['id_admission'],
					'id_grossesse'=>$id_grossesse,
					'id_type' => $donnees['type_accouchement'],					
 					'motif_type' => $donnees['motif_type'],
 					'date_accouchement' => $date_accouchement,
					'heure_accouchement' => $donnees['heure_accouchement'],
 					//'delivrance' => $donnees['delivrance'],
					'ru' => $donnees['ru'],
					//'quantite_hemo' => $donnees['quantite_hemo'],
					//'hemoragie' => $donnees['hemoragie'],
					//'ocytocique_per' => $donnees['ocytocique_per'],
					//'ocytocique_post' => $donnees['ocytocique_post'],
					//'antibiotique' => $donnees['antibiotique'],
					//'anticonvulsant' => $donnees ['anticonvulsant'],
					//'transfusion' => $donnees['transfusion'],
					//'note_delivrance' => $donnees['note_delivrance'],
					//'note_hemorragie' => $donnees['note_hemorragie'],
					//'text_observation' => $donnees['text_observation'],
					//'suite_de_couche' => $donnees['suite_de_couche'],
					//'note_ocytocique' => $donnees['note_ocytocique'],
					//'note_antibiotique' => $donnees['note_antibiotique'],
					//'note_anticonv' => $donnees['note_anticonv'],
					//'note_transfusion' => $donnees['note_transfusion'],
				 	'hrp' => $donnees['hrp'],
					'dystocie' => $donnees['dystocie'],
					'infection' => $donnees['infection'],
					'anemie' => $donnees['anemie'],
					'fistules' => $donnees['fistules'],
					'paludisme' => $donnees['paludisme'],
					'eclapsie'	 => $donnees['eclapsie'],
					'note_dystocie' => $donnees['note_dystocie'],
					'note_infection' => $donnees['note_infection'],
					'note_anemie' => $donnees['note_anemie'],
					'note_fistules' => $donnees['note_fistules'],
					'note_paludisme' => $donnees['note_paludisme'],
						
						
						
			);//var_dump($dataac);exit();
	
			return $this->tableGateway->getLastInsertValue($this->tableGateway->insert ( $dataac ));
			var_dump($dataac);exit();
	}
	}
	
	
	
public function addPrenomme($donne,$id_acc) {
		
	$db = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $db );
		$sQuery = $sql->insert ()->into ( 'prenomme_des_bb' )->values ( array (
				'id_accouchement' => $id_acc,
				'prenomme'  => $donne
		) );
		$requete = $sql->prepareStatementForSqlObject ( $sQuery );
		$requete->execute ();
	}
	
	public function getPrenomme($id_acc) {
		
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		$select->columns ( array (
				'*'
		) );
		$select->from( array (
				'pre' => 'prenomme_des_bb'
		) )->join ( array (
				'acc' => 'accouchement'
		), 'pre.id_accouchement = acc.id_accouchement', array (
		
		));
		$select->where ( array (
				'pre.id_accouchement' => $id_acc
		) );
		$select->order ( 'pre.id_prenome ASC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ()->current();
	
		return $result;
	}
	

	
	public function getNbPatientsAcc($date_debut,$date_fin){
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('ad' => 'admission'));
		$select->from(array('a' => 'accouchement') );
		$select->where( array('a.date_accouchement  >= ?' => $date_debut, 'a.date_accouchement <= ?' => $date_fin));
		
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute();//var_dump(count($result));exit();
		return count($result);
	}
	public function getNbDecesMaternelPortPartum($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('con' => 'conclusion'))
		->columns( array( '*' ))
		->where ( array (
        'con.id_cause' => 3));
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		return count($resultat);
		}
	
	
		public function getNbDecesMaternelAntePartum($date_debut,$date_fin){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->select()
			->from(array('con' => 'conclusion'))
			->columns( array( '*' ))
			->where ( array (
					'con.id_cause' => 5));
			$stat = $sql->prepareStatementForSqlObject($sQuery);
			$resultat = $stat->execute();
			return count($resultat);
		}
		
		
		public function getNbDecesMaternelDystocie($date_debut,$date_fin){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->select()
			->from(array('con' => 'conclusion'))
			->columns( array( '*' ))
			->where ( array (
					'con.id_cause' => 18));
			$stat = $sql->prepareStatementForSqlObject($sQuery);
			$resultat = $stat->execute();
			return count($resultat);
		}
		public function getNbDecesMaternelHypertension($date_debut,$date_fin){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->select()
			->from(array('con' => 'conclusion'))
			->columns( array( '*' ))
			->where ( array (
					'con.id_cause' => 19));
			$stat = $sql->prepareStatementForSqlObject($sQuery);
			$resultat = $stat->execute();
			return count($resultat);
		}	
		public function getNbDecesMaternelInfection($date_debut,$date_fin){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->select()
			->from(array('con' => 'conclusion'))
			->columns( array( '*' ))
			->where ( array (
					'con.id_cause' => 20));
			$stat = $sql->prepareStatementForSqlObject($sQuery);
			$resultat = $stat->execute();
			return count($resultat);
		}
		public function getNbDecesMaternelDirect($date_debut,$date_fin){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->select()
			->from(array('con' => 'conclusion'))
			->columns( array( '*' ))
			->where ( array (
					'con.id_cause' => 21));
			$stat = $sql->prepareStatementForSqlObject($sQuery);
			$resultat = $stat->execute();
			return count($resultat);
		}
		public function getNbDecesMaternelIndirect($date_debut,$date_fin){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->select()
			->from(array('con' => 'conclusion'))
			->columns( array( '*' ))
			->where ( array (
					'con.id_cause' => 22));
			$stat = $sql->prepareStatementForSqlObject($sQuery);
			$resultat = $stat->execute();
			return count($resultat);
		}
		public function getNbDecesMaternelIndtermine($date_debut,$date_fin){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->select()
			->from(array('con' => 'conclusion'))
			->columns( array( '*' ))
			->where ( array (
					'con.id_cause' => 23));
			$stat = $sql->prepareStatementForSqlObject($sQuery);
			$resultat = $stat->execute();
			return count($resultat);
		}
		
	public  function getNbPatientsAccN($date_debut,$date_fin){
		
		
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('p' => 'patient'));
		$select->join(array('gro' => 'grossesse') ,'gro.id_patient = p.id_personne');
		$select->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'));
		$select->where(array('id_type' => 1,'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute();
		return count($result);
	}
	
	public function getNbPatientsAccNSimple($date_debut,$date_fin){
	
	
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('p' => 'patient'));
		$select->join(array('gro' => 'grossesse') ,'gro.id_patient = p.id_personne');
		$select->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'));
		$select->where(array('id_type' => 1,'gro.bb_attendu'=>1 ,'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute();
		return count($result);
	}
	
	public function getNbPatientsAccNDouble($date_debut,$date_fin){
	
	
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('p' => 'patient'));
		$select->join(array('gro' => 'grossesse') ,'gro.id_patient = p.id_personne');
		$select->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'));
		$select->where(array('id_type' => 1,'gro.bb_attendu'=>2, 'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute();
		return count($result);
	}
	
	public function getNbPatientsAccNTriplePlus($date_debut,$date_fin){
	
	
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('p' => 'patient'));
		$select->join(array('gro' => 'grossesse') ,'gro.id_patient = p.id_personne');
		$select->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'));
		$select->where(array('id_type' => 1,'gro.bb_attendu'=>3 ,'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute();
		return count($result);
	}
	
	
	
	public function getNbPatientsAccGatPa($date_debut,$date_fin){
	
	
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('p' => 'patient'));
		$select->join(array('gro' => 'grossesse') ,'gro.id_patient = p.id_personne');
		$select->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type','date_accouchement'));
		$select->where(array('delivrance' => 'GATPA', 'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
	    $stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute();
		return count($result);
	}
	
	
	
	public function getNbPatientsAccF($date_debut,$date_fin){
		
		
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('p' => 'patient'));
		$select->join(array('gro' => 'grossesse') ,'gro.id_patient = p.id_personne');
		$select->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'));
		$select->where(array('id_type' => 2,'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute();
		return count($result);
	}
	
	public function getNbPatientsAccV($date_debut,$date_fin){
		
		
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('p' => 'patient'));
		$select->join(array('gro' => 'grossesse') ,'gro.id_patient = p.id_personne');
		$select->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'));
		$select->where(array('id_type' => 3,'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute();
		return count($result);
	}
	public function getNbPatientsAccM($date_debut,$date_fin){
		
		
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('p' => 'patient'));
		$select->join(array('gro' => 'grossesse') ,'gro.id_patient = p.id_personne');
		$select->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'));
		$select->where(array('id_type' => 4,'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute();
		return count($result);
	}
	
	
	
	
	public function getNbPatientsAccCes($date_debut, $date_fin){
	
		$adapter = $this->tableGateway->getAdapter();
		$sql = new Sql($adapter);
		$select = $sql->select();
		$select->from(array('p' => 'patient'));
		$select->join(array('gro' => 'grossesse') ,'gro.id_patient = p.id_personne');
		$select->join(array('acc' => 'accouchement') ,'acc.id_grossesse = gro.id_grossesse',array('id_type'));
		$select->where(array('id_type' => 5,'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
		
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute();
		return count($result);
	}
	
	
	
	
	public function getNbAvortement($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('av' => 'avortement'))
		->columns( array( '*' ))
		
		->join(array('c'=>'consultation'),'c.id_cons=av.id_cons')
		->where ( array (
				'c.DATEONLY>= ?' => $date_debut,'c.DATEONLY<= ? '=> $date_fin ) );
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultat = $stat->execute();
		//var_dump(count($resultat));exit();
		return count($resultat);
	}
	
	public function getNbRU($date_debut,$date_fin){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('acc' => 'accouchement'))
		->columns( array( '*' ))
		->where(array('acc.ru'=> 'Oui','acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin)); 
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		
		$resultat = $stat->execute();
		return count($resultat);
		}
		

		public function getNbhrp($date_debut,$date_fin){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->select()
			->from(array('acc' => 'accouchement'))
			->columns( array( '*' ))
			->where(array('acc.hrp'=> 1,'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
			$stat = $sql->prepareStatementForSqlObject($sQuery);
			$resultat = $stat->execute();
			return count($resultat);
		}
		public function getNbhpp($date_debut,$date_fin){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->select()
			->from(array('acc' => 'accouchement'))
			->columns( array( '*' ))
			->where(array('acc.hemoragie'=> 1,'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
			$stat = $sql->prepareStatementForSqlObject($sQuery);
		
			$resultat = $stat->execute();
			return count($resultat);
		}
		public function getNbanemie($date_debut,$date_fin){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->select()
			->from(array('acc' => 'accouchement'))
			->columns( array( '*' ))
			->where(array('acc.anemie'=> 1,'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
			$stat = $sql->prepareStatementForSqlObject($sQuery);
		
			$resultat = $stat->execute();
			return count($resultat);
		}
		public function getNbPaludisme($date_debut,$date_fin){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->select()
			->from(array('acc' => 'accouchement'))
			->columns( array( '*' ))
			->where(array('acc.paludisme'=> 1,'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
			$stat = $sql->prepareStatementForSqlObject($sQuery);
		
			$resultat = $stat->execute();
			return count($resultat);
		}
		public function getNbFistules($date_debut,$date_fin){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->select()
			->from(array('acc' => 'accouchement'))
			->columns( array( '*' ))
			->where(array('acc.fistules'=> 1,'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
			$stat = $sql->prepareStatementForSqlObject($sQuery);
		
			$resultat = $stat->execute();
			return count($resultat);
		}
		public function getNbDystocie($date_debut,$date_fin){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->select()
			->from(array('acc' => 'accouchement'))
				
			->columns( array( '*' ))
			->where(array('acc.dystocie'=> 1,'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
			$stat = $sql->prepareStatementForSqlObject($sQuery);
		
			$resultat = $stat->execute();
			return count($resultat);
		}
		
		public function getNbEclapsie($date_debut,$date_fin){
			$db = $this->tableGateway->getAdapter();
			$sql = new Sql($db);
			$sQuery = $sql->select()
			->from(array('acc' => 'accouchement'))
		
			->columns( array( '*' ))
			->where(array('acc.eclapsie'=> 1,'acc.date_accouchement  >= ?' => $date_debut, 'acc.date_accouchement <= ?' => $date_fin));
			$stat = $sql->prepareStatementForSqlObject($sQuery);
		
			$resultat = $stat->execute();
			return count($resultat);
		}
	}
	
	
	
	

