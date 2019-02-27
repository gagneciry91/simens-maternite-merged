<?php
namespace Maternite\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Json\Json;
//use Zend\Form\Form;
use Zend\Form\View\Helper\FormRow;
//use Zend\Form\View\Helper\FormInput;
use Maternite\View\Helpers\DateHelper;
use Maternite\Form\PatientForm;
use Zend\View\Model\ViewModel;
//use Zend\Db\Sql\Sql;
use Maternite\Form\AjoutDecesForm;
use Maternite\Form\planification\AdmissionForm;
use Maternite\Form\planification\ConsultationForm;
use Maternite;
//use Maternite\Form\planification\PartoForm;
use Zend\Form\View\Helper\FormTextarea;
use Zend\Form\View\Helper\FormHidden;
use Maternite\Form\planification\LibererPatientForm;
use Zend\Form\View\Helper\FormText;
use Zend\Form\View\Helper\FormSelect;
use Maternite\View\Helpers\DocumentPdf;
use Maternite\View\Helpers\DemandeExamenPdf;
use Maternite\View\Helpers\OrdonnancePdf;
use Maternite\View\Helpers\CertificatPdf;
use Maternite\View\Helpers\ProtocoleOperatoirePdf;
use Maternite\View\Helpers\TraitementChirurgicalPdf;
use Maternite\View\Helpers\TraitementInstrumentalPdf;
use Maternite\View\Helpers\RendezVousPdf;
use Maternite\View\Helpers\TransfertPdf;
use Maternite\View\Helpers\HospitalisationPdf;
use Maternite\View\Helpers\ObservationPdf;


class PlanificationController extends AbstractActionController{
	protected $controlDate;
	protected $patientTable;
	protected $planificationTable;
	
	protected $evacuationTable;
	protected $consultationTable;
	protected $formPatient;
	protected $formAdmission;
	protected $type_admissionTable;
	
	
	public function getPatientTable() {
		if (! $this->patientTable) {
			$sm = $this->getServiceLocator ();
			$this->patientTable = $sm->get ( 'Maternite\Model\PatientTable' );
		}
		return $this->patientTable;
	}
	public function getPlanificationTable() {
		if (! $this->planificationTable) {
			$sm = $this->getServiceLocator ();
			$this->planificationTable = $sm->get ( 'Maternite\Model\PlanificationTable' );
		}
		return $this->planificationTable;
	}
	public function getForm() {
		if (! $this->formPatient) {
			$this->formPatient = new PatientForm();
		}
		return $this->formPatient;
	}
	public function getDateHelper()
	{
		$this->controlDate = new DateHelper ();
	}
	public function getConsultationTable()
	{
		if (!$this->consultationTable) {
			$sm = $this->getServiceLocator();
			$this->consultationTable = $sm->get('Maternite\Model\ConsultationTable');
		}
		return $this->consultationTable;
	}
	
	//ajouter un nouveau patient
	
	public function ajouterAction() {
	
		$this->layout ()->setTemplate ( 'layout/planification' );
		
		$formAdmission = new AdmissionForm();
		
		$form = $this->getForm ();		
		
		$patientTable = $this->getPatientTable();
		//var_dump('tests'); exit();
		$form->get('NATIONALITE_ORIGINE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$form->get('NATIONALITE_ACTUELLE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$data = array('NATIONALITE_ORIGINE' => 'Sénégal', 'NATIONALITE_ACTUELLE' => 'Sénégal');
	
		$form->populateValues($data);
	
		return new ViewModel ( array (
				'form' => $form
		) );
	
	}
	
	public function listePatientAction() {
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/planification' );
		$view = new ViewModel ();
		return $view;
	}
	
	
	
	public function listePatientAjaxAction() {
	
		$output = $this->getPatientTable()->getListePatient();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
public function admissionAction() {
		$layout = $this->layout ();
	
		$layout->setTemplate ( 'layout/planification' );
		$user = $this->layout()->user;	
		$idService = $user ['IdService'];
        //INSTANCIATION DU FORMULAIRE D'ADMISSION
		$formAdmission = new AdmissionForm();	
		$pat = $this->getPatientTable ();
		
		if ($this->getRequest ()->isPost ()) {							
			$today = new \DateTime ();
			$dateAujourdhui = $today->format( 'Y-m-d' );
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
			$donnee_ant = $pat->getInfoPatientAmise( $id );
			
			//MISE A JOUR DE L'AGE DU PATIENT
			$personne = $this->getPatientTable()->miseAJourAgePatient($id);
			//*******************************
	
			//Verifier si le patient a un rendez-vous et si oui dans quel service et a quel heure
			$RendezVOUS = $pat->verifierRV($id, $dateAujourdhui);
			
			$unPatient = $pat->getInfoPatient( $id );
			
	
			$photo = $pat->getPhoto ( $id );
		
			$date = $unPatient['DATE_NAISSANCE'];
			if($date){ $date = $this->convertDate ( $unPatient['DATE_NAISSANCE'] ); }else{ $date = null;}

			$html  = "<div style='width:100%;'>";
			
			$html  = "<div style='width:100%;'>";
				
 			$html .= "<div style='width: 18%; height: 190px; float:left;'>";
 			$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='../img/photos_patients/" . $photo . "' ></div>";
 			$html .= "<div style='margin-left:60px; margin-top: 150px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient['AGE'] . " ans</div></div>";
 			$html .= "</div>";
				
			$html .= "<div id='vuePatientAdmission' style='width: 70%; height: 190px; float:left;'>";
			$html .= "<table style='margin-top:0px; float:left; width: 100%;'>";
				
			$html .= "<tr style='width: 100%;'>";
			
			$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Numero dossier:</a><br><div style='width: 150px; max-width: 160px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NUMERO_DOSSIER'] . "</p></div></td>";
			$html .= "<td style='width: 29%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['DATE_NAISSANCE'] . "</p></div></td>";

			$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></div></td>";
				
			$html .= "<td style='width: 29%; '></td>";
			
				$html .= "</tr><tr style='width: 100%;'>";
				$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></div></td>";
				$html .= "<td style='width: 29%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></div></td>";
				$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><div style='width: 95%; max-width: 135px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE']. "</p></td>";
				$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><div style='width: 100%; max-width: 235px; height:40px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></div></td>";
					
				$html .= "</tr><tr style='width: 100%;'>";
				$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><div style='width: 95%; max-width: 235px; height:40px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['NOM'] . "</p></div></td>";
				$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><div style='width: 97%; max-width: 250px; height:50px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></div></td>";
				$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Sexe:</a><br><div style='width: 100%; max-width: 235px; height:40px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['SEXE'] . "</p></div></td>";
				
			
			$html .= "<td style='width: 30%; height: 50px;'>";
			
			if($RendezVOUS){
				$html .= "<span> <i style='color:green;'>
					        <span id='image-neon' style='color:red; font-weight:bold;'>Rendez-vous! </span> <br>
					        <span style='font-size: 16px;'>Service:</span> <span style='font-size: 16px; font-weight:bold;'> ". $pat->getServiceParId($RendezVOUS[ 'ID_SERVICE' ])[ 'NOM' ]." </span> <br>
					        <span style='font-size: 16px;'>Heure:</span>  <span style='font-size: 16px; font-weight:bold;'>". $RendezVOUS[ 'HEURE' ]." </span> </i>
			              </span>";
			}
				$html .= "</td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";
			
			$html .= "<div style='width: 12%; height: 190px; float:left;'>";
			$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:10px; margin-left:5px; margin-top:5px;'> <img style='width:105px; height:105px;' src='../img/photos_patients/" . $photo . "'></div>";
			$html .= "</div>";
			


			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
 			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
 		}
 		//var_dump($formAdmission);exit();
		return array (
				'form' => $formAdmission
		);
	
	}
	
	
	public function enregistrementAction() {
	
		$user = $this->layout()->user;
		$id_employe = $user['id_personne']; //L'utilisateur connect�
	
		// CHARGEMENT DE LA PHOTO ET ENREGISTREMENT DES DONNEES
		if (isset ( $_POST ['terminer'] )||isset($_POST ['terminer_ad']))  // si formulaire soumis
		{
			$Control = new DateHelper();
			$form = new PatientForm();
			$Patient = $this->getPatientTable ();
			$today = new \DateTime ( 'now' );
			$nomfile = $today->format ( 'dmy_His' );
			$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
			$fileBase64 = $this->params ()->fromPost ( 'fichier_tmp' );
			$fileBase64 = substr ( $fileBase64, 23 );
	
			if($fileBase64){
				$img = imagecreatefromstring(base64_decode($fileBase64));
			}else {
				$img = false;
			}
	
			$date_naissance = $this->params ()->fromPost ( 'DATE_NAISSANCE' );
			if($date_naissance){ $date_naissance = $Control->convertDateInAnglais($this->params ()->fromPost ( 'DATE_NAISSANCE' )); }else{ $date_naissance = null;}
	
			$donnees = array(
					'LIEU_NAISSANCE' => $this->params ()->fromPost ( 'LIEU_NAISSANCE' ),
					'EMAIL' => $this->params ()->fromPost ( 'EMAIL' ),
					'NOM' => $this->params ()->fromPost ( 'NOM' ),
					'TELEPHONE' => $this->params ()->fromPost ( 'TELEPHONE' ),
					'NATIONALITE_ORIGINE' => $this->params ()->fromPost ( 'NATIONALITE_ORIGINE' ),
					'PRENOM' => $this->params ()->fromPost ( 'PRENOM' ),
					'PROFESSION' => $this->params ()->fromPost ( 'PROFESSION' ),
					'NATIONALITE_ACTUELLE' => $this->params ()->fromPost ( 'NATIONALITE_ACTUELLE' ),
					'DATE_NAISSANCE' => $date_naissance,
					'ADRESSE' => $this->params ()->fromPost ( 'ADRESSE' ),
					'SEXE' => $this->params ()->fromPost ( 'SEXE' ),
					'AGE' => $this->params ()->fromPost ( 'AGE' ),
					'DATE_MODIFICATION' => $today->format ( 'Y-m-d' ),
					'NOM_CONJOINT' => $this->params ()->fromPost ( 'NOM_CONJOINT' ),
					'PRENOM_CONJOINT' => $this->params ()->fromPost ( 'PRENOM_CONJOINT' ),
					'PROFESSION_CONJOINT' => $this->params ()->fromPost ( 'PROFESSION_CONJOINT' ),
			);
				
			//var_dump($donnees); exit();
				
			if ($img != false) {
	
				$donnees['PHOTO'] = $nomfile;
				//ENREGISTREMENT DE LA PHOTO
				imagejpeg ( $img, 'C:\wamp64\www\simens-maternite\public\img\photos_patients\\' . $nomfile . '.jpg' );
				//ENREGISTREMENT DES DONNEES
					
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
				if (isset($_POST ['terminer'])){
					return $this->redirect ()->toRoute ( 'planification', array (
							'action' => 'liste-patient'
					) );}
					if (isset($_POST ['terminer_ad'])){
						return $this->redirect ()->toRoute ( 'planification', array (
								'action' => 'admission'
						));
							
					}
			} else {
	
				// On enregistre sans la photo
				//var_dump($donnees); exit();
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
				//var_dump($donnees); exit();
				if (isset($_POST ['terminer'])){
					return $this->redirect ()->toRoute ( 'planification', array (
							'action' => 'liste-patient'
					) );}
					if (isset($_POST ['terminer_ad'])){
						return $this->redirect ()->toRoute ( 'planification', array (
								'action' => 'admission'
						) );
							
							
					}
						
						
			}
		}
	
		return $this->redirect ()->toRoute ( 'planification', array (
				'action' => 'liste-patient'
		) );
	}
	public function planificationAction(){
		$this->layout()->setTemplate('layout/planification');
		$user = $this->layout()->user;
		$idService = $user ['IdService'];
	
		$lespatients = $this->getConsultationTable()->listeDesPlanification($idService);		//var_dump("ggff"); exit();
		
		// RECUPERER TOUS LES PATIENTS AYANT UN RV aujourd'hui
		$tabPatientRV = $this->getConsultationTable()->getPatientsRV($idService);
		//var_dump($lespatients); exit();
		return new ViewModel (array(
				'donnees' => $lespatients,
				'tabPatientRV' => $tabPatientRV
		));
	
	
	
	}
	
	
	public function listeDesPlanificationsAction() {
				$output = $this->getPatientTable()->getPatientPlanification();
//var_dump($output);exit();
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/planification' );
		$view = new ViewModel ();
		
		return $view;
	}
	
	
	
	public function listeDesPlanificationsAjaxAction() {
		$id_pat = $this->params()->fromQuery('id_patient', 0);
		
		$output = $this->getPatientTable()->getPatientPlanification();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	
	
	public function complementPlanificationAction()
	{
		$this->layout()->setTemplate('layout/planification');
		$user = $this->layout()->user;
		$IdDuService = $user ['IdService'];
		$id_medecin = $user ['id_personne'];		
	
		$id_pat = $this->params()->fromQuery('id_patient', 0);
		$id = $this->params()->fromQuery('id_cons');
		$inf=$this->getConsultationTable()->infpat($id_pat, $id);
		//var_dump($id);exit();
		$id_admi = $this->params()->fromQuery('id_admission', 0);
		
		$liste = $this->getConsultationTable()->getInfoPatient($id_pat);
		$id_admission=$liste['id_admission'];
		$consult = $this->getConsultationTable()->getConsult($id);
		
		$image = $this->getConsultationTable()->getPhoto($id_pat);
		//$this->getDateHelper();
		/* $donne_ante=$this->getAntecedentType1Table()->getAntecedentType1($id_pat);
		$donne_ante2=$this->getAntecedentType2Table()->getAntecedentType2($id);
		$donneesAntecedentsPersonnels = $this->getAntecedantPersonnelTable()->getTableauAntecedentsPersonnels($id_pat);
		$donneesAntecedentsFamiliaux = $this->getAntecedantsFamiliauxTable()->getTableauAntecedentsFamiliaux($id_pat);
		 */
		// Recuperer les antecedents medicaux ajouter pour le patient
		$antMedPat = $this->getConsultationTable()->getAntecedentMedicauxPersonneParIdPatient($id_pat);
		
		// Recuperer les antecedents medicaux
		// Recuperer les antecedents medicaux
		$listeAntMed = $this->getConsultationTable()->getAntecedentsMedicaux();
		$form = new ConsultationForm ();
		$listedates= $this->getConsultationTable()->datesvisites();
		// instancier la consultation et r�cup�rer l'enregistrement
		$consult = $this->getConsultationTable()->getConsult($id);
		$pos = strpos($consult->pression_arterielle, '/');
		$tensionmaximale = substr($consult->pression_arterielle, 0, $pos);
		$tensionminimale = substr($consult->pression_arterielle, $pos + 1);
		
		// POUR LES HISTORIQUES OU TERRAIN PARTICULIER
		
		// *** Liste des consultations
		$listeConsultation = $this->getConsultationTable()->getConsultationPatient($id_pat, $id);
		
		
		$data = array(
					
				'id_cons' => $consult->id_cons,
				'id_medecin' => $id_medecin,
				'id_patient' => $consult->id_patient,
				'date_cons' => $consult->date,
				'tensionmaximale' => $tensionmaximale,
				'tensionminimale' => $tensionminimale,
				'glycemie_capillaire' => $consult->glycemie_capillaire,
				'temperature' => $consult->temperature,
				'paleur' => $consult->paleur,
				'pouls' => $consult->pouls,
				'poids' => $consult->poids,
		
				'pressionarterielle' => $consult->pression_arterielle,
				//'hopital_accueil' => $idHopital,
				'id_admission' => $id_admission,
		
		);
		
		//var_dump($listedates);exit();
		
		
	//	$this->getDateHelper();		
		//var_dump('test'); exit();
		
		
		return array(
				'lesdetails' => $liste,
				'id_cons' => $id,
		
				'image' => $image,
				'form' => $form,
				'listeForme' => $listedates,
				'heure_cons' => $consult->heurecons,
				'dateonly' => $consult->dateonly,
				//'donneesAntecedentsPersonnels' => $donneesAntecedentsPersonnels,
				//'donneesAntecedentsFamiliaux' => $donneesAntecedentsFamiliaux,
				//'liste_med' => $listeMedicament,
					
		
				/* 'temoin' => $bandelettes ['temoin'],
				listeForme' => $listedates,
				/*'listetypeQuantiteMedicament' => $listetypeQuantiteMedicament,
				
				//'liste' => $listeConsultation,
				'nbDiagnostics'=> $infoDiagnostics->count(),
				//'resultRV' => $resultRV,
						//'listesDecesMaternel'=>$listesDecesMaternel,
				//'listeDesExamensMorphologiques' => $listeDesExamensMorphologiques,
				'listeAntMed' => $listeAntMed,
				'antMedPat' => $antMedPat,
				'nbAntMedPat' => $antMedPat->count(), */
		
		);
	}
	
	public function infoPlanificationAction() {
		//var_dump('test');exit();
		$this->layout ()->setTemplate ( 'layout/planification' );
		$id_pat = $this->params ()->fromRoute ( 'id_patient', 0 );
	
		$user = $this->layout()->user;
		$idService = $user ['IdService'];
		$form = new ConsultationForm ();
	
		//var_dump($form);exit();
		$formData = $this->getRequest ()->getPost ();
		$form->setData ( $formData );
	
		$id_cons = $form->get ( "id_cons" )->getValue ();//var_dump($inf);exit();
		$accouchement = $this->getConsultationTable()->listePlanification($id_pat);
		$nb= $this->getConsultationTable()->nbenf($id_pat);
	
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getInformationPatient( $id_pat);
	
		return array (
				//'nb_enf'=>$nb,
				'donnees_acc'=>$accouchement,
				'lesdetails' => $unPatient,
				'image' => $patient->getPhoto ( $id_pat ),
				'date_enregistrement' => $unPatient['DATE_ENREGISTREMENT']
		);
	}
	
	public function visiteAction()
	{
		$id_cons = $this->params()->fromPost('id_cons');
		$complication = $this->params()->fromPost('comp');
		$notesComp = $this->params()->fromPost('notesComp');
	
		$this->conclusionTable()->saveComplication($id_cons, $complication, $notesComp);
	
		$this->getResponse()->getHeaders()->addHeaderLine('Content-Type', 'application/html');
		return $this->getResponse()->setContent(Json::encode());
	}
	public function declarerDecesAction() {
		$this->layout ()->setTemplate ( 'layout/planification' );
	
		//INSTANCIATION DU FORMULAIRE DE DECES
		$ajoutDecesForm = new AjoutDecesForm ();
	
		if ($this->getRequest ()->isPost ()) {
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
	
			$personne = $this->getPatientTable()->miseAJourAgePatient($id);
			//*******************************
			//*******************************
			//*******************************
			$pat = $this->getPatientTable ();
			$unPatient = $pat->getInfoPatient ( $id );
			$photo = $pat->getPhoto ( $id );
	
			$date = $unPatient['DATE_NAISSANCE'];
			if($date){ $date = $this->convertDate ($date); }else{ $date = null;}
	
			$html = "<div style='float:left;' ><div id='photo' style='float:left; margin-right:20px; margin-bottom: 10px;'> <img  src='../img/photos_patients/" . $photo . "'  style='width:105px; height:105px;'></div>";
			$html .= "<div style='margin-left:6px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient['AGE'] . " ans</div></div></div>";
	
	
			$html .= "<table>";
	
			$html .= "<tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $date . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></td>";
			$html .= "</tr><tr>";
			$html .= "<td><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><p style='width:280px; font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></td>";
			$html .= "</tr>";
	
			$html .= "</table>";
			$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
			return $this->getResponse ()->setContent ( Json::encode ( $html ) );
		}
		return array (
				'form' => $ajoutDecesForm
		);
	}
	public function enregistrerAdmissionAction() {
	
		$user = $this->layout()->user;
		$id_employe = $user['id_personne'];
		$Control = new DateHelper();
		$idService = $user ['IdService'];
		$service= $user ['NomService'];
		//var_dump($user); exit();
		$today = new \DateTime ( "now" );
		$date_cons = $today->format ( 'Y-m-d' );
		$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
	
		$id_patient = ( int ) $this->params ()->fromPost ( 'id_patient', 0 );
	
	
	
		//pour  evacuation reference
	
		//donnee pour admission
		$donnees = array (
	
				'id_patient' => $id_patient,
				'sous_dossier'=>$this->params ()->fromPost('sous_dossier'),
				'type_admission'=>$this->params ()->fromPost('type_admission'),
				'motif_admission'=>$this->params ()->fromPost('motif_admission'),
				'motif_transfert_evacuation'=>$this->params ()->fromPost('motif_transfert_evacuation'),
				'service_dorigine'=>$this->params ()->fromPost('service_dorigine'),
				'moyen_transport'=>$this->params ()->fromPost('moyen_transport'),
				'id_service' => $idService,
				'date_cons' => $date_cons,
				'date_enregistrement' => $date_enregistrement,
				'id_employe' => $id_employe,
		);
		$form = new ConsultationForm ();
		$this->getAdmissionTable ()-> addConsultation ( $form,$idService ,12);
		//var_dump($form);exit();
		$id_admission=	$this->getAdmissionTable ()->addAdmissio($donnees);
	
	
	
		$formData = $this->getRequest ()->getPost ();
		$form->setData ( $formData );
		 
		$this->getAdmissionTable ()-> addConsultation ( $form,$idService ,$id_admission);
	
		$id_cons = $form->get ( "id_cons" )->getValue ();
	
		$this->getAdmissionTable ()->addConsultationMaternite($id_cons);
	
		return $this->redirect()->toRoute('planification', array(
				'action' =>'admission'));
	
	}
	public function updateComplementPlanificationAction()
		{
	$this->layout()->setTemplate('layout/planification');
        $this->getDateHelper();
        $Control = new DateHelper();
        $id_cons = $this->params()->fromPost('id_cons');
        $id_patient = $this->params()->fromPost('id_patient');
        $form = new ConsultationForm ();
        $formData = $this->getRequest()->getPost();
        
       // var_dump($id_cons);exit();
        
        $form->setData($formData);
        $id_admission = $this->params()->fromPost('id_admission');
        $user = $this->layout()->user;
        $IdDuService = $user ['IdService'];
        $id_medecin = $user ['id_personne'];
	
		// **********-- MODIFICATION DES CONSTANTES --********
		// **********-- MODIFICATION DES CONSTANTES --********
		// **********-- MODIFICATION DES CONSTANTES --********
	
		// les antecedents medicaux du patient a ajouter addAntecedentMedicauxPersonne
		$this->getConsultationTable()->addAntecedentMedicaux($formData);
		$this->getConsultationTable()->addAntecedentMedicauxPersonne($formData);
		// $this->getMotifAdmissionTable()->deleteMotifAdmission($id_cons);
	
	
		$this->getConsultationTable()->updateConsultation($form);//var_dump('test');exit();

		$info_planification = array(
				'pilule' => $this->params()->fromPost('pilule'),
				//'numero_d_ordre' => $this->params()->fromPost('numero_d_ordre'),
				//'etat_de_la_mere' => $this->params()->fromPost('etat_de_la_mere'),
				//'type_accouchement' => $this->params()->fromPost('type_accouchement'),
				//'lieu_accouchement' => $this->params()->fromPost('lieu_accouchement'),
				//'id_accouchement' => $id_accouchement,
				'ID_CONS' => $id_cons
		); //
		//var_dump($info_planification);exit();
		$this->getPlanificationTable()->updatePlanification($info_planification);
		// Recuperer les donnees sur les bandelettes urinaires
		// Recuperer les donnees sur les bandelettes urinaires
		return $this->redirect()->toRoute('planification', array(
				'action' => 'planification',
		));
	
	}
	public function modifierAction() {
	
		$control = new DateHelper();
		$this->layout ()->setTemplate ( 'layout/planification' );
		$id_patient = $this->params ()->fromRoute ( 'id_patient', 0 );
	
		$infoPatient = $this->getPatientTable ();
		try {
			$info = $infoPatient->getInfoPatient( $id_patient );
		} catch ( \Exception $ex ) {
			return $this->redirect ()->toRoute ( 'planification', array (
					'action' => 'liste-patient'
			) );
		}
		$form = new PatientForm();
		$form->get('NATIONALITE_ORIGINE')->setvalueOptions($infoPatient->listeDeTousLesPays());
		$form->get('NATIONALITE_ACTUELLE')->setvalueOptions($infoPatient->listeDeTousLesPays());
	
		$date_naissance = $info['DATE_NAISSANCE'];
		if($date_naissance){ $info['DATE_NAISSANCE'] =  $control->convertDate($info['DATE_NAISSANCE']); }else{ $info['DATE_NAISSANCE'] = null;}
	
		$form->populateValues ( $info );
	
		if (! $info['PHOTO']) {
			$info['PHOTO'] = "identite";
		}
		return array (
				'form' => $form,
				'photo' => $info['PHOTO']
		);
	}
	
	
	public function impressionPdfAction()
	{
		$user =$this->layout()->setTemplate('layout/planification');
		$user = $this->layout()->user;
		$serviceMedecin = $user ['NomService'];
		$nomMedecin = $user ['Nom'];
		$prenomMedecin = $user ['Prenom'];
		$donneesMedecin = array(
				'nomMedecin' => $nomMedecin,
				'prenomMedecin' => $prenomMedecin
		);
		$form = new ConsultationForm ();
	
		$formData = $this->getRequest()->getPost();
		$object=$this->params('pdf');
			
		// *************************************
		// *************************************
		// ***DONNEES COMMUNES A TOUS LES PDF***
		// *************************************
		// *************************************
		$id_patient = $this->params()->fromPost('id_patient', 0);
		$id_cons = $this->params()->fromPost('id_cons', 0);
	
		// *************************************
		$donneesPatientOR = $this->getConsultationTable()->getInfoPatient($id_patient);
	
	
	
		// var_dump($donneesPatientOR); exit();
		// **********ORDONNANCE*****************
		// **********ORDONNANCE*****************
		// **********ORDONNANCE*****************
		if (isset ($_POST ['suitedecouche'])) {
			// R�cup�ration des donn�es
			$donneesDemande ['suite_de_couches'] = $this->params()->fromPost('suite_de_couches');
			// CREATION DU DOCUMENT PDF
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			//$page = new SuiteDeCouchePdf();
	
			// var_dump($donneesDemande); exit();
	
			// Envoi Id de la consultation
			/* $page->setIdConsTC($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientTC($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinTC($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeTC($donneesDemande);
	
			// Ajouter les donnees a la page
			$page->addNoteTC();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage()); */
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		}
			
		else
		if (isset ($_POST ['observation_go'])) {
			// R�cup�ration des donn�es
			$donneesDemande ['text_observation'] = $this->params()->fromPost('text_observation');
			// CREATION DU DOCUMENT PDF
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new ObservationPdf();
	
			// var_dump($donneesDemande); exit();
	
			// Envoi Id de la consultation
			$page->setIdConsTC($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientTC($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinTC($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeTC($donneesDemande);
	
			// Ajouter les donnees a la page
			$page->addNoteTC();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		}
	
		else
		if (isset ($_POST ['ordonnance'])) {
			// r�cup�ration de la liste des m�dicaments
			$medicaments = $this->getConsultationTable()->fetchConsommable();
	
			$tab = array();
			$j = 1;
	
			// NOUVEAU CODE AVEC AUTOCOMPLETION
			for ($i = 1; $i < 10; $i++) {
				$nomMedicament = $this->params()->fromPost("medicament_0" . $i);
				if ($nomMedicament == true) {
					$tab [$j++] = $this->params()->fromPost("medicament_0" . $i);
					$tab [$j++] = $this->params()->fromPost("forme_" . $i);
					$tab [$j++] = $this->params()->fromPost("nb_medicament_" . $i);
					$tab [$j++] = $this->params()->fromPost("quantite_" . $i);
				}
			}
	
			// -***************************************************************
			// Cr�ation du fichier pdf
			// *************************
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new OrdonnancePdf ();
	
			// Envoyer l'id_cons
			$page->setIdCons($id_cons);
			$page->setService($serviceMedecin);
			// Envoyer les donn�es sur le partient
			$page->setDonneesPatient($donneesPatientOR);
			// Envoyer les m�dicaments
			$page->setMedicaments($tab);
	
			// Ajouter une note � la page
			$page->addNote();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		} else
		//**********TRAITEMENT CHIRURGICAL*****************
		//**********TRAITEMENT CHIRURGICAL*****************
		//**********TRAITEMENT CHIRURGICAL*****************
		if (isset ($_POST['traitement_chirurgical'])) {
			// R�cup�ration des donn�es
			$donneesDemande ['diagnostic'] = $this->params()->fromPost('diagnostic_traitement_chirurgical');
			$donneesDemande ['intervention_prevue'] = $this->params()->fromPost('intervention_prevue');
			$donneesDemande ['observation'] = $this->params()->fromPost('observation');
	
			// CREATION DU DOCUMENT PDF
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new TraitementChirurgicalPdf ();
	
			// Envoi Id de la consultation
			$page->setIdConsTC($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientTC($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinTC($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeTC($donneesDemande);
	
			// Ajouter les donnees a la page
			$page->addNoteTC();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		} else
		//********** PROTOCOLE OPERATOIRE *****************
		//********** PROTOCOLE OPERATOIRE *****************
		//********** PROTOCOLE OPERATOIRE *****************
		if (isset ($_POST ['protocole_operatoire'])) {
			// R�cup�ration des donn�es
			$donneesDemande ['diagnostic'] = $this->params()->fromPost('diagnostic_traitement_chirurgical');
			$donneesDemande ['intervention_prevue'] = $this->params()->fromPost('intervention_prevue');
			$donneesDemande ['observation'] = $this->params()->fromPost('observation');
			$donneesDemande ['note_compte_rendu_operatoire'] = $this->params()->fromPost('note_compte_rendu_operatoire');
			$donneesDemande ['resultatNumeroVPA'] = $this->params()->fromPost('resultatNumeroVPA');
			$donneesDemande ['resultatTypeIntervention'] = $this->params()->fromPost('resultatTypeIntervention');
	
			// CREATION DU DOCUMENT PDF
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new ProtocoleOperatoirePdf ();
	
			// var_dump($donneesDemande); exit();
	
			// Envoi Id de la consultation
			$page->setIdConsTC($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientTC($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinTC($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeTC($donneesDemande);
	
			// Ajouter les donnees a la page
			$page->addNoteTC();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		} else
		//**********TRANSFERT DU PATIENT*****************
		//**********TRANSFERT DU PATIENT*****************
		//**********TRANSFERT DU PATIENT*****************
		if (isset ($_POST ['transfert'])) {
			$id_hopital = $this->params()->fromPost('hopital_accueil');
			$id_service = $this->params()->fromPost('service_accueil');
			$motif_transfert = $this->params()->fromPost('motif_transfert');
	
			// R�cup�rer le nom du service d'accueil
			$service = $this->getServiceTable();
			//var_dump($id_service);exit();
			$infoService =$service->getServiceParNom($serviceMedecin);
			// var_dump($infoService);exit();
			// R�cup�rer le nom de l'hopital d'accueil
			$hopital = $this->getHopitalTable();
	
			$infoHopital = $hopital->getHopitalParId($id_hopital);
	
			$donneesDemandeT ['NomService'] = $infoService ['NOM'];
	
			$donneesDemandeT ['NomHopital'] = $infoHopital ['NOM_HOPITAL'];
			$donneesDemandeT ['MotifTransfert'] = $motif_transfert;
	
			// -***************************************************************
			// Cr�ation du fichier pdf
			// -***************************************************************
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new TransfertPdf ();
	
			// Envoi Id de la consultation
			$page->setIdConsT($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientT($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinT($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeT($donneesDemandeT);
	
			//var_dump($serviceMedecin,$page);exit();
			// Ajouter les donnees a la page
			$page->addNoteT();
	
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
	
			$DocPdf->getDocument();
		} else
		//**********RENDEZ VOUS ****************
		//**********RENDEZ VOUS ****************
		//**********RENDEZ VOUS ****************
		if (isset ($_POST ['rendezvous'])) {
	
			$donneesDemandeRv ['dateRv'] = $this->params()->fromPost('date_rv_tampon');
			$donneesDemandeRv ['heureRV'] = $this->params()->fromPost('heure_rv_tampon');
			$donneesDemandeRv ['MotifRV'] = $this->params()->fromPost('motif_rv');
	
			// Cr�ation du fichier pdf
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new RendezVousPdf ();
	
			// Envoi Id de la consultation
			$page->setIdConsR($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientR($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinR($donneesMedecin);
			// Envoi les donn�es du redez vous
			$page->setDonneesDemandeR($donneesDemandeRv);
	
			// Ajouter les donnees a la page
			$page->addNoteR();
			//var_dump($page);exit();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		} else
		//**********TRAITEMENT INSTRUMENTAL ****************
		//**********TRAITEMENT INSTRUMENTAL ****************
		//**********TRAITEMENT INSTRUMENTAL ****************
		if (isset ($_POST ['traitement_instrumental'])) {
			// R�cup�ration des donn�es
			$donneesTraitementChirurgical ['endoscopieInterventionnelle'] = $this->params()->fromPost('endoscopieInterventionnelle');
			$donneesTraitementChirurgical ['radiologieInterventionnelle'] = $this->params()->fromPost('radiologieInterventionnelle');
			$donneesTraitementChirurgical ['cardiologieInterventionnelle'] = $this->params()->fromPost('cardiologieInterventionnelle');
			$donneesTraitementChirurgical ['autresIntervention'] = $this->params()->fromPost('autresIntervention');
	
			// CREATION DU DOCUMENT PDF
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new TraitementInstrumentalPdf ();
	
			// Envoi Id de la consultation
			$page->setIdConsTC($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientTC($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinTC($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeTC($donneesTraitementChirurgical);
	
			// Ajouter les donnees a la page
			$page->addNoteTC();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		} else
		//**********HOSPITALISATION ****************
		//**********HOSPITALISATION ****************
		//**********HOSPITALISATION ****************
		if (isset ($_POST ['hospitalisation'])) {
			// R�cup�ration des donn�es
			$donneesHospitalisation ['motif_hospitalisation'] = $this->params()->fromPost('motif_hospitalisation');
			$donneesHospitalisation ['date_fin_hospitalisation_prevue'] = $this->params()->fromPost('date_fin_hospitalisation_prevue');
	
			// CREATION DU DOCUMENT PDF
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new HospitalisationPdf ();
			// Envoi Id de la consultation
			$page->setIdConsH($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientH($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinH($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeH($donneesHospitalisation);
	
			// Ajouter les donnees a la page
			$page->addNoteH();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
		} else
		//**********DEMANDES D'EXAMENS****************
		//**********DEMANDES D'EXAMENS****************
		//**********DEMANDES D'EXAMENS****************
		if (isset ($_POST ['demandeExamenBioMorpho'])) {
			$i = 1;
			$j = 1;
			$donneesExamensBio = array();
			$notesExamensBio = array();
			// R�cup�ration des donn�es examens biologiques
			for (; $i <= 6; $i++) {
				if ($this->params()->fromPost('examenBio_name_' . $i)) {
					$donneesExamensBio [$j] = $this->params()->fromPost('examenBio_name_' . $i);
					$notesExamensBio [$j++] = $this->params()->fromPost('noteExamenBio_' . $i);
				}
			}
	
			$k = 1;
			$l = $j;
			$donneesExamensMorph = array();
			$notesExamensMorph = array();
			// R�cup�ration des donn�es examens morphologiques
			for (; $k <= 11; $k++) {
				if ($this->params()->fromPost('element_name_' . $k)) {
					$donneesExamensMorph [$l] = $this->params()->fromPost('element_name_' . $k);
					$notesExamensMorph [$l++] = $this->params()->fromPost('note_' . $k);
				}
			}
	
			// CREATION DU DOCUMENT PDF
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new DemandeExamenPdf ();
			// Envoi Id de la consultation
			$page->setIdConsBio($id_cons);
			$page->setService($serviceMedecin);
			// Envoi des donn�es du patient
			$page->setDonneesPatientBio($donneesPatientOR);
			// Envoi des donn�es du medecin
			$page->setDonneesMedecinBio($donneesMedecin);
			// Envoi les donn�es de la demande
			$page->setDonneesDemandeBio($donneesExamensBio);
			$page->setNotesDemandeBio($notesExamensBio);
			$page->setDonneesDemandeMorph($donneesExamensMorph);
			$page->setNotesDemandeMorph($notesExamensMorph);
	
			// Ajouter les donnees a la page
			$page->addNoteBio();
			// Ajouter la page au document
			$DocPdf->addPage($page->getPage());
	
			// Afficher le document contenant la page
			$DocPdf->getDocument();
				
		}
	
	
}
}