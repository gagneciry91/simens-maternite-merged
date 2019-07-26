<?php
namespace Maternite\Controller;

use Zend\Json\Json;
//use Zend\Form\Form;
use Zend\Form\View\Helper\FormRow;
//use Zend\Form\View\Helper\FormInput;
use Maternite\View\Helpers\DateHelper;
use Zend\Mvc\Controller\AbstractActionController;
use Maternite\Form\PatientForm;
use Zend\View\Model\ViewModel;
//use Zend\Db\Sql\Sql;
use Maternite\Form\AjoutDecesForm;
use Maternite\Form\admission\AdmissionForm;
use Maternite\Form\admission\ConsultationForm;
use Maternite;
//use Maternite\Form\admission\PartoForm;
use Zend\Form\View\Helper\FormTextarea;
use Zend\Form\View\Helper\FormHidden;
use Maternite\Form\admission\LibererPatientForm;
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
use Maternite\View\Helpers\SuiteDeCouchePdf;
use Maternite\View\Helpers\ObservationPdf;
use Archivage\Model\Consultation;
use Zend\Console\Adapter\Windows;
use Zend\Code\Generator\DocBlock\Tag\TagInterface;
use Zend\Code\Generator\DocBlock\Tag;
use Doctrine\Common\Annotations\Annotation\Target;
use Archivage\Model\Admission;

class AdmissionController extends AbstractActionController {
	protected $consultationTable;
	protected $admissionTable;
	protected $type_admissionTable;
	protected $type_accouchementTable;
	//protected $type_admissionTable;
	//protected $admissionTable;
	protected $patientTable;
	protected $formPatient;
	protected $formAdmission;
	
	
	
	public function getAdmissionTable() {
		if (! $this->admissionTable) {
			$sm = $this->getServiceLocator ();
			$this->admissionTable = $sm->get ( 'Maternite\Model\AdmissionTable' );
		}
		return $this->admissionTable;
	}
	public function getPatientTable() {
		if (! $this->patientTable) {
			$sm = $this->getServiceLocator ();
			$this->patientTable = $sm->get ( 'Maternite\Model\PatientTable' );
		}
		return $this->patientTable;
	}
	public function getTypeAdmissionTable()
	{
		if (!$this->type_admissionTable) {
			$sm = $this->getServiceLocator();
			$this->type_admissionTable = $sm->get('Maternite\Model\TypeAdmissionTAble');
		}
	
		return $this->type_admissionTable;
	}
	public function getForm() {
		if (! $this->formPatient) {
			$this->formPatient = new PatientForm();
		}
		return $this->formPatient;
	}
	public function admissionAction() {
		$layout = $this->layout ();
	
		$layout->setTemplate ( 'layout/admission' );
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
	
	public function infoPatientAdmisAction() {
		//var_dump('test');exit();
		$this->layout ()->setTemplate ( 'layout/admission' );
		$id_pat = $this->params ()->fromRoute ( 'id_patient', 0 );
	
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getInfoPatient( $id_pat );
	
		return array (
				'lesdetails' => $unPatient,
				'image' => $patient->getPhoto ( $id_pat ),
				'id_patient' => $unPatient['ID_PERSONNE'],
				'date_enregistrement' => $unPatient['DATE_ENREGISTREMENT']
		);
	}
	
	
	public function ajouterAction() {
	
		$this->layout ()->setTemplate ( 'layout/admission' );
	
		//$formAdmission = new AdmissionForm();
		$form = $this->getForm ();
		//var_dump('tests'); exit();
		$patientTable = $this->getPatientTable();
		//var_dump('tests'); exit();
		$form->get('NATIONALITE_ORIGINE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$form->get('NATIONALITE_ACTUELLE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$data = array('NATIONALITE_ORIGINE' => 'SÃ©nÃ©gal', 'NATIONALITE_ACTUELLE' => 'SÃ©nÃ©gal');
	
		$form->populateValues($data);
	
		return new ViewModel ( array (
				'form' => $form
		) );
	
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
			$form = new ConsultationForm ();		//var_dump($form);exit();
			
			$this->getAdmissionTable ()-> addConsultation ( $form,$idService ,12);
			//var_dump($form);exit();
		$id_admission=	$this->getAdmissionTable ()->addAdmissio($donnees);
		
		
		$formData = $this->getRequest ()->getPost ();
		$form->setData ( $formData );
	  
		$this->getAdmissionTable ()-> addConsultation ( $form,$idService ,$id_admission);
	
		$id_cons = $form->get ( "id_cons" )->getValue ();
		
		$this->getAdmissionTable ()->addConsultationMaternite($id_cons);
		
 		return $this->redirect()->toRoute('admission', array(
 				'action' =>'admission'));

	}
		
	public function enregistrementAction() {
	
		$user = $this->layout()->user;
		$id_employe = $user['id_personne']; //L'utilisateur connecté
	
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
					//'NUMERO_DOSSIER' => $this->params ()->fromPost ( 'NUMERO_DOSSIER' ),
			);
				
				
				
			if ($img != false) {
	
				$donnees['PHOTO'] = $nomfile;
				//ENREGISTREMENT DE LA PHOTO
				imagejpeg ( $img, 'C:\wamp64\www\simens-maternite\public\img\photos_patients\\' . $nomfile . '.jpg' );
				//ENREGISTREMENT DES DONNEES
					
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
				if (isset($_POST ['terminer'])){
						
	
					return $this->redirect ()->toRoute ( 'admission', array (
							'action' => 'liste-patient'
					) );}
					if (isset($_POST ['terminer_ad'])){
						return $this->redirect ()->toRoute ( 'admission', array (
								'action' => 'admission'
						));
							
					}
			} else {
					
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
	
				if (isset($_POST ['terminer'])){
					return $this->redirect ()->toRoute ( 'admission', array (
							'action' => 'liste-patient'
					) );}
					if (isset($_POST ['terminer_ad'])){
						return $this->redirect ()->toRoute ( 'admission', array (
								'action' => 'admission'
						) );
							
							
					}
						
						
			}
		}
	
		return $this->redirect ()->toRoute ( 'admission', array (
				'action' => 'liste-patient'
		) );
	}
	
	public function modifierAction() {
		//var_dump('test');exit();
	
		$control = new DateHelper();
		$this->layout ()->setTemplate ( 'layout/admission' );
		$id_patient = $this->params ()->fromRoute ( 'id_patient', 0 );
	
		$infoPatient = $this->getPatientTable ();
		try {
			$info = $infoPatient->getInfoPatient( $id_patient );
		} catch ( \Exception $ex ) {
			return $this->redirect ()->toRoute ( 'admission', array (
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
	
	//ENREGISTREMNT MODIFICATION
	public function enregistrementModificationAction() {
	
		$user = $this->layout()->user;
		//var_dump($user); exit();
		$id_employe = $user['id_personne']; //L'utilisateur connecté
	
		if (isset ( $_POST ['terminer'] ))
		{
			$Control = new DateHelper();
			$Patient = $this->getPatientTable ();
			$today = new \DateTime ( 'now' );
			$nomfile = $today->format ( 'dmy_His' );
			$date_modification = $today->format ( 'Y-m-d H:i:s' );
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
					'NOM_CONJOINT' => $this->params ()->fromPost ( 'NOM_CONJOINT' ),
					'PRENOM_CONJOINT' => $this->params ()->fromPost ( 'PRENOM_CONJOINT' ),
					'PROFESSION_CONJOINT' => $this->params ()->fromPost ( 'PROFESSION_CONJOINT' ),
			);
	
			$id_patient =  $this->params ()->fromPost ( 'ID_PERSONNE' );
			if ($img != false) {
	
				$lePatient = $Patient->getInfoPatient ( $id_patient );
				$ancienneImage = $lePatient['PHOTO'];
	
				if($ancienneImage) {
					unlink ( 'C:\wamp64\www\simens\public\img\photos_patients\\' . $ancienneImage . '.jpg' );
				}
				imagejpeg ( $img, 'C:\wamp64\www\simens\public\img\photos_patients\\' . $nomfile . '.jpg' );
	
				$donnees['PHOTO'] = $nomfile;
				$Patient->updatePatient ( $donnees , $id_patient, $date_modification, $id_employe);
	
				return $this->redirect ()->toRoute ( 'admission', array (
						'action' => 'liste-patient'
				) );
			} else {
				$Patient->updatePatient($donnees, $id_patient, $date_modification, $id_employe);
				return $this->redirect ()->toRoute ( 'admission', array (
						'action' => 'liste-patient'
				) );
			}
		}
		return $this->redirect ()->toRoute ( 'admission', array (
				'action' => 'liste-patient'
		) );
	}
	
/* 	public function infoPatientAction() {
		//var_dump('test');exit();
		$this->layout ()->setTemplate ( 'layout/accouchement' );
		$id_pat = $this->params ()->fromRoute ( 'id_patient', 0 );
	
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getInfoPatient( $id_pat );
	
		return array (
				'lesdetails' => $unPatient,
				'image' => $patient->getPhoto ( $id_pat ),
				'date_enregistrement' => $unPatient['DATE_ENREGISTREMENT']
		);
	} */
	public function infoPatientAction() {
		//var_dump('test');exit();
		$this->layout ()->setTemplate ( 'layout/admission' );
		$id_pat = $this->params ()->fromRoute ( 'id_patient', 0 );
		//var_dump('test');exit();
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getInfoPatient( $id_pat );
	
		return array (
				'lesdetails' => $unPatient,
				'image' => $patient->getPhoto ( $id_pat ),
				//'id_patient' => $unPatient['ID_PERSONNE'],
				'date_enregistrement' => $unPatient['DATE_ENREGISTREMENT']
		);
	}
	
	

	public function listeAdmissionAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->laListePatientsAjax();
		//$output = $patient->getListePatientsAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	

	public function listePatientsAdmisAction() {
	
		$this->layout ()->setTemplate ( 'layout/admission' );
			
		//INSTANCIATION DU FORMULAIRE
	
		$formAdmission = new AdmissionForm ();
	
		//var_dump('$layout'); exit();
		$patientsAdmis = $this->getAdmissionTable ();
		return new ViewModel ( array (
				'listePatientsAdmis' => $patientsAdmis->getPatientsAdmis (),
	
				'form' => $formAdmission,
				'listePatientsCons' => $patientsAdmis->getPatientAdmisCons(),
		) );
	
	
	}
	public function listePatientAction() {
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/admission' );
		//var_dump('test');exit();
		$view = new ViewModel ();
		return $view;
	}

	public function listePatientAjaxAction() {
	
		$output = $this->getPatientTable()->getListePatientsecretaire();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	
	public function declarerDecesAction() {
		$this->layout ()->setTemplate ( 'layout/admission' );
	
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
	

	public function statistiqueAction(){
		$this->getDateHelper();
		$this->layout ()->setTemplate ( 'layout/admission' );
		$formAdmission = new AdmissionForm();
	
		return array (
	
				'form' => $formAdmission,
		);
	}
	
	
	
	public function infoStatistiqueAction() {
		$this->getDateHelper();
		$user = $this->layout()->user;
	
		//$this->layout ()->setTemplate ( 'layout/accouchement' );
		$formAdmission = new AdmissionForm();
		$idService = $user ['IdService'];
	
		$val = $this->params ()->fromPost ( 'date_stat' );
		list($month, $year) = explode(' ', $val);
		//$id_cons = $form->get ( "id_cons" )->getValue ();
	
		//$nbrpost=count($post);
		//var_dump($post);exit();
		$acc=count( $this->getAccouchementTable()->getLesAccouchement($month,$year));
		$nbPatientAcc   =$acc;
		//$nbPatientAccCes  =  $this->getAccouchementTable()->getNbPatientsAccCes();
		$nbPatientAccCes=$this->getConsultationTable()->getNbPatientsPost();
	
		$nbPatientAccN  = $this->getConsultationTable()->getNbPatientsAcc();
		//$nbPatientAccN  = $this->getAccouchementTable()->getNbPatientsAccN();
		//$nbPatientAccF = $this->getAccouchementTable()->getNbPatientsAccF();
		$nbPatientAccF = $this->getConsultationTable()->getNbPatientsPre();
		//$nbPatientAccV = $this->getAccouchementTable()->getNbPatientsAccV();
		$nbPatientAccV= $this->getConsultationTable()->getNbPatientsPla();
	
		$nbPatientAccM = $this->getAccouchementTable()->getNbPatientsAccM();
		$nbGatPa = $this->getAccouchementTable()->getNbPatientsAccGatPa();
		$nbGrossesseGemellaire=$this->getGrossesseTable()->getNbGrossesseGemellaire();
		//$nbr=$nbPatientAccCes+$nbPatientAccN+$nbPatientAccF+$nbPatientAccV+$nbPatientAccM;
		//var_dump($nbPatientAccN);exit();
		//Pour les Accouchements
		return array (
				//'nbr'=>$nbr,
				//'nbrpost'=>$nbrpost,
				'nbPatientAcc'   => $nbPatientAcc,
				'nbPatientAccCes'  => $nbPatientAccCes,
				'nbPatientAccN'  => $nbPatientAccN,
				'nbPatientAccF' => $nbPatientAccF,
				'nbPatientAccV' => $nbPatientAccV,
				'nbPatientAccM' => $nbPatientAccM,
				'nbPatientAccGatPa' => $nbGatPa,
				'nbGrossesseGemellaire' => $nbGrossesseGemellaire,
				'form' => $formAdmission,
				'date' => $val,
		);
		 
		//Pour les Nouveau Nés
		return array (
		//     			'nbPatientAcc'   => $nbPatientAcc,
		//     			'nbPatientAccCes'  => $nbPatientAccCes,
		//     			'nbPatientAccN'  => $nbPatientAccN,
		//     			'nbPatientAccF' => $nbPatientAccF,
		//     			'nbPatientAccV' => $nbPatientAccV,
		//     			'nbPatientAccM' => $nbPatientAccM,
		);
		 
	
	}
	
}

?>
