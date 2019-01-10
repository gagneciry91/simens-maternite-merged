<?php

namespace Maternite\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class AdmissionTable {
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}
	public function getPatientsAdmis() {
		
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		
		$select->from ( array (
				'p' => 'patient'
						
				
		)
		 );
		
		$select->columns ( array ('numero_dossier'=>'NUMERO_DOSSIER') );
		$select->join(array('pers' => 'personne'), 'pers.ID_PERSONNE = p.ID_PERSONNE', array(
	
				'Nom' => 'NOM',
				'Prenom' => 'PRENOM',
				'Age' => 'AGE',
				'Sexe' => 'SEXE',
				'Adresse' => 'ADRESSE',
				'Nationalite' => 'NATIONALITE_ACTUELLE',
				'Id' => 'ID_PERSONNE'
		));
		$select->join ( array (
				'a' => 'admission'
		), 'p.ID_PERSONNE = a.id_patient', array (
				'Id_admission' => 'id_admission'
		) );
		
		
				$select->where ( array (
				'a.date_cons' => $date
		) );
		
		$select->order ( 'id_admission DESC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		return $result;
		//var_dump($result); exit();
	}
	
	public function nbAdmission() {
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ( 'admission' );
		$select->columns ( array (
				'id_admission'
		) );
		$select->where ( array (
				'date_cons' => $date
		) );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$nb = $stat->execute ()->count ();
		return $nb;
	}

	public function addAdmissio($donnees) {
		$datadonnee = array (
				'id_patient' => $donnees ['id_patient'],
				'id_service' => $donnees ['id_service'],
				'date_cons' => $donnees ['date_cons'],
				'id_employe' => $donnees ['id_employe'],
				'date_enregistrement' => $donnees ['date_enregistrement'],
				'sous_dossier'=>$donnees['sous_dossier'],
				'type_admission'=>$donnees['type_admission'],
				'motif_admission'=>$donnees['motif_admission'],
				'motif_transfert_evacuation'=>$donnees['motif_transfert_evacuation'],
				'service_dorigine'=>$donnees['service_dorigine'],
				'moyen_transport'=>$donnees['moyen_transport'],
		);
	
		//var_dump($datadonnee); exit();
		return $this->tableGateway->getLastInsertValue($this->tableGateway->insert($datadonnee));
	}
	

	
	public function addAdmission($donnees , $date_enregistrement , $id_employe){
	
		$date = new \DateTime();
		$mois = $date ->format('m');
		$annee = $date ->format('Y');
	
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('admission')
		->values( $donnees );
	
		$stat = $sql->prepareStatementForSqlObject($sQuery);
	
		//$id_personne = $stat->execute()->getGeneratedValue();
	
		//$dernierPatient = $this->getDernierPatient($mois, $annee);
		 
		
	}
	
	
	public function addAdmissionBloc($donnees){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
			$sQuery = $sql->insert()
			->into('admission_bloc')
			->values($donnees);
			$sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	public function updateAdmissionBloc($donnees){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->update()
		->table('admission_bloc')
		->set( $donnees )
		->where(array('id_admission' => $donnees['id_admission'] ));
		$sql->prepareStatementForSqlObject($sQuery)->execute();
	
	}
	
	/*
	 * Recupérer la liste des patients admis et déjà consultés pour aujourd'hui
	 */
	public function getPatientAdmisCons(){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ( 'consultation' );
		$select->columns ( array (
				'ID_PATIENT'
		) );
		$select->where ( array (
				'DATEONLY' => $date,
		) );
		
		$result = $sql->prepareStatementForSqlObject ( $select )->execute ();
		$tab = array();
		foreach ($result as $res) {
			$tab[] = $res['ID_PATIENT'];
		}
		
		return $tab;
	}
	
	/*
	 * Fonction qui vérifie est ce que le patient n'est pas déja consulté
	 */
	public function verifierPatientConsulter($idPatient, $idService){
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ( 'consultation' );
		$select->columns ( array (
				'ID_PATIENT'
		) );
		$select->where ( array (
				'DATEONLY' => $date,
				'ID_SERVICE' => $idService,
				'ID_PATIENT' => $idPatient,
		) );
		
		return $sql->prepareStatementForSqlObject ( $select )->execute ()->current();
	}
	
	public function deleteAdmissionPatient($id, $idPatient, $idService){
		if($this->verifierPatientConsulter($idPatient, $idService)){
		    return 1;
		} else {
			$this->tableGateway->delete(array('id_admission'=> $id));
			return 0;
		}

	}
	
	public function getPatientAdmis($id){
		$id = ( int ) $id;
		$rowset = $this->tableGateway->select ( array (
				'id_admission' => $id
		) );
		$row =  $rowset->current ();
		if (! $row) {
			throw new \Exception ( "Could not find row $id" );
		}
		return $row;
	}
	
	public function getPatientAdmisBloc($idAdmission){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('admission_bloc')
		->where(array('id_admission' => $idAdmission));
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	
	public function getProtocoleOperatoireBloc($idAdmission){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('protocole_operatoire_bloc')
		->where(array('id_admission_bloc' => $idAdmission));
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	public function getListeProtocoleOperatoireBloc(){
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->select('protocole_operatoire_bloc');
	    $requete = $sql->prepareStatementForSqlObject($sQuery);
	    return $requete->execute();
	}
	
	public function getLastAdmission() {
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select('admission')
		->order('id_admission DESC');
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		return $requete->execute()->current();
	}
	
	//Ajouter la consultation dans la table << consultation >> pour permettre au medecin de pouvoir lui même ajouter les constantes
	//Ajouter la consultation dans la table << consultation >> pour permettre au medecin de pouvoir lui même ajouter les constantes
public function addConsultation($values , $IdDuService,$id_admission){
	
		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d H:i:s' );
		$dateOnly = $today->format ( 'Y-m-d' );
		
		$db = $this->tableGateway->getAdapter();
		$this->tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();
		try {
		
			$dataconsultation = array(
					'ID_CONS'=> $values->get ( "id_cons" )->getValue (),
					'ID_PATIENT'=> $values->get ( "id_patient" )->getValue (),
					'DATE_ENREGISTREMENT'=> $date,
 					'DATEONLY' => $dateOnly,
					'HEURECONS' => $values->get ( "heure_cons" )->getValue (),
					'ID_SERVICE' => $IdDuService,
					'id_admission'=> $id_admission
			);
			
			$sql = new Sql($db);
			$sQuery = $sql->insert()
			->into('consultation')
			->values($dataconsultation);
			//var_dump($dataconsultation);exit();
			$sql->prepareStatementForSqlObject($sQuery)->execute();
	//var_dump($dataconsultation);exit();
			$this->tableGateway->getAdapter()->getDriver()->getConnection()->commit();
		} catch (\Exception $e) {
			$this->tableGateway->getAdapter()->getDriver()->getConnection()->rollback();
	}
	}
	
	public function addConsultationMaternite($id_cons){
		$db = $this->tableGateway->getAdapter();
		
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('consultation_maternite')
		->values(array('id_cons' => $id_cons));//var_dump($id_cons);exit();
		
		
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		$requete->execute();//var_dump($id_cons);exit();
	}
		
	//CONCERVE LA PARTIE POUR LE BLOC OPERATOIRE
	//CONCERVE LA PARTIE POUR LE BLOC OPERATOIRE
	//CONCERVE LA PARTIE POUR LE BLOC OPERATOIRE
	
	public function addProtocoleOperatoire($donnees){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->insert()
		->into('protocole_operatoire_bloc')
		->values($donnees);
		$requete = $sql->prepareStatementForSqlObject($sQuery);
		$requete->execute();
	}

	public function updateProtocoleOperatoire($donnees){
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->update()
		->table('protocole_operatoire_bloc')
		->set( $donnees )
		->where(array('id_protocole' => $donnees['id_protocole'] ));
		$sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	public function addImagesProtocole($nomImage, $id_admission, $id_employe){
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->insert()
	    ->into('protocole_operatoire_image')
	    ->columns(array('nomImage', 'dateEnregistrement', 'idResultat'))
	    ->values(array('nomImage' => $nomImage,  'id_admission' => $id_admission , 'id_employe' => $id_employe));
	    $stat = $sql->prepareStatementForSqlObject($sQuery);
	    $result = $stat->execute();
	    return $result;
	}
	
	public function getImagesProtocoles($id_admission) {
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->select('protocole_operatoire_image')
	    ->order('idImage DESC')
	    ->where(array('id_admission' => $id_admission));
	    
	    return $sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	public function recupererImageProtocole($id, $idAdmission)
	{
	        
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	     $sQuery = $sql->select('protocole_operatoire_image')
	    ->order('idImage DESC')
	    ->where(array('id_admission' => $idAdmission));

	    $Result = $sql->prepareStatementForSqlObject($sQuery)->execute();
	        
	    $i = 1;
	    $tabIdImage = array();
	    $tabNomImage = array();
	    
	    foreach ($Result as $resultat){
	         $tabIdImage[$i] = $resultat['idImage'];
	         $tabNomImage[$i] = $resultat['nomImage'];
	         $i++;
	    }
	        	
	    return  array('idImage' => $tabIdImage[$id], 'nomImage'=> $tabNomImage[$id]);
	
	}
	
	
	public function supprimerImageProtocole($idImage)
	{
	    $idImage = (int) $idImage;
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->delete('protocole_operatoire_image')
	    ->where(array('idImage' => $idImage));
	    return $sql->prepareStatementForSqlObject($sQuery)->execute();
	}
	
	
	public function getProtocoleOperatoire($id_admission) 
	{
	    $db = $this->tableGateway->getAdapter();
	    $sql = new Sql($db);
	    $sQuery = $sql->select('protocole_operatoire_bloc')
	    ->where(array('id_admission_bloc' => $id_admission));
	     
	    return $sql->prepareStatementForSqlObject($sQuery)->execute()->current();
	}
	
	public function cheminBaseUrl(){
	    $baseUrl = $_SERVER['SCRIPT_FILENAME'];
	    $tabURI  = explode('public', $baseUrl);
	    return $tabURI[0];
	}
	
	public function supprimerImagesSansProtocole($id_admission)
	{
	    if(!$this->getProtocoleOperatoire($id_admission)){
	        
	        //On supprime les images sur le disque
	        //On supprime les images sur le disque
	        $db = $this->tableGateway->getAdapter();
	        $sql = new Sql($db);
	        $sQuery = $sql->select('protocole_operatoire_image')
	        ->order('idImage DESC')
	        ->where(array('id_admission' => $id_admission));
	        
	        $Result = $sql->prepareStatementForSqlObject($sQuery)->execute();
	         
	        foreach ($Result as $resultat){
	            unlink ( $this->cheminBaseUrl().'public/images/protocoles/' . $resultat['nomImage'] . '.jpg' );
	        }
	        
	        
	        //On supprime les images dans la base de données
	        //On supprime les images dans la base de données
	        $db = $this->tableGateway->getAdapter();
	        $sql = new Sql($db);
	        $sQuery = $sql->delete('protocole_operatoire_image')
	        ->where(array('id_admission' => $id_admission));
	        return $sql->prepareStatementForSqlObject($sQuery)->execute();
	    }
	}
	
	
	
	
	public function getPatientAccouchee(){


		$today = new \DateTime ( 'now' );
		$date = $today->format ( 'Y-m-d' );
		
		$adapter = $this->tableGateway->getAdapter ();
		$sql = new Sql ( $adapter );
		$select = $sql->select ();
		
		$select->from ( array (
				'p' => 'patient'
		
		
		)
		);
		
		$select->columns ( array ('numero_dossier'=>'NUMERO_DOSSIER') );
		$select->join(array('pers' => 'personne'), 'pers.ID_PERSONNE = p.ID_PERSONNE', array(
		
				'Nom' => 'NOM',
				'Prenom' => 'PRENOM',
				'Age' => 'AGE',
				//'Sexe' => 'SEXE',
				'Adresse' => 'ADRESSE',
				//'Nationalite' => 'NATIONALITE_ACTUELLE',
				'Id' => 'ID_PERSONNE'
		));
		$select->join ( array (
				'a' => 'admission'
		), 'p.ID_PERSONNE = a.id_patient', array (
				'Id_admission' => 'id_admission'
		) );
		
		$select->join ( array (
				'acc' => 'accouchement'
		), 'a.ID_Cons = acc.id_cons', array (
				'id_accouchement' => 'id_accouchement'
		) );
		
		
		$select->order ( 'id_accouchement DESC' );
		$stat = $sql->prepareStatementForSqlObject ( $select );
		$result = $stat->execute ();
		return $result;
		//var_dump($result); exit();
		
	}
	
	
	
	
}