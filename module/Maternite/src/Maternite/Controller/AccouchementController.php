<?php

namespace Maternite\Controller;
use Zend\Json\Json;
use Zend\Form\View\Helper\FormRow;
use Maternite\View\Helpers\DateHelper;
use Zend\Mvc\Controller\AbstractActionController;
use Maternite\Form\PatientForm;
use Zend\View\Model\ViewModel;
use Maternite\Form\AjoutDecesForm;
use Maternite\Form\accouchement\AdmissionForm;
use Maternite\Form\accouchement\ConsultationForm;
use Maternite\Form\accouchement\StatistiqueForm;

use Maternite;
use Zend\Form\View\Helper\FormTextarea;
use Zend\Form\View\Helper\FormHidden;
use Maternite\Form\accouchement\LibererPatientForm;
use Maternite\View\Helpers\DocumentPdf;
use Maternite\View\Helpers\DemandeExamenPdf;
use Maternite\View\Helpers\OrdonnancePdf;
use Maternite\View\Helpers\CertificatPdf;
use Maternite\View\Helpers\GeneralPdf;
use Maternite\View\Helpers\ProtocoleOperatoirePdf;
use Maternite\View\Helpers\TraitementChirurgicalPdf;
use Maternite\View\Helpers\TraitementInstrumentalPdf;
use Maternite\View\Helpers\infosStatistiquePdf;
use Maternite\View\Helpers\infosStatistiquePathologiePdf;
use Maternite\View\Helpers\infosStatistiqueDecesPdf;
use Maternite\View\Helpers\RendezVousPdf;
use Maternite\View\Helpers\statistiqueGrossesse;
use Maternite\View\Helpers\TransfertPdf;
use Maternite\View\Helpers\HospitalisationPdf;
use Maternite\View\Helpers\SuiteDeCouchePdf;
use Maternite\View\Helpers\ObservationPdf;
use Maternite\View\Helpers\infosStatistiqueGrossessePdf;

class AccouchementController extends AbstractActionController

{
	protected $controlDate;
    protected $patientTable;
     protected $formPatient;
     protected $formAdmission;
    protected $batimentTable;
    protected $consultationTable;
   protected $accouchementTable;
   protected $type_accouchementTable;
   protected $type_admissionTable;
    protected $grossesse;
    protected $antecedent_grossesse;
    protected $naissanceTable;
    protected $dateHelper;
    protected $devenir_nouveau_neTable;
    protected $consultationMaterniteTable;
    protected $motifAdmissionTable;
    protected $rvPatientConsTable;
    protected $serviceTable;
    protected $hopitalTable;
    protected $transfererPatientServiceTable;
    protected $consommableTable;
    protected $donneesExamensPhysiquesTable;
    protected $diagnosticsTable;
    protected $ordonnanceTable;
    protected $demandeVisitePreanesthesiqueTable;
    protected $notesExamensBiologiqueTable;
    protected $notesExamensMorphologiquesTable;
    protected $demandeExamensTable;
    protected $conclusionTable;
    protected $ordonConsommableTable;
    protected $antecedantPersonnelTable;
    protected $antecedantsFamiliauxTable;
    protected $demandeHospitalisationTable;
    protected $soinhospitalisationTable;
    protected $soinsTable;
    protected $hospitalisationTable;
    protected $hospitalisationlitTable;
    protected $litTable;
    protected $salleTable;
    protected $postnataleTable;
    protected $tarifConsultationTable;
    protected $resultatVpaTable;
    protected $demandeActeTable;
    protected $admissionTable;
    protected $antecedenttype1Table;
    protected $antecedenttype2Table;
   protected  $tableGateway;
  //recuperer la table patient  
	public function getPatientTable() {
		if (! $this->patientTable) {
			$sm = $this->getServiceLocator ();
			$this->patientTable = $sm->get ( 'Maternite\Model\PatientTable' );
		}
		return $this->patientTable;
	}
	
	public function getConclusionTable()
	{
		if (!$this->conclusionTable) {
			$sm = $this->getServiceLocator();
			$this->conclusionTable = $sm->get('Maternite\Model\ConclusionTable');
		}
		return $this->conclusionTable;
	}
	
	public function getAdmissionTable() {
		if (! $this->admissionTable) {
			$sm = $this->getServiceLocator ();
			$this->admissionTable = $sm->get ( 'Maternite\Model\AdmissionTable' );
		}
		return $this->admissionTable;
	}
	public function getPostnataleTable() {
		if (! $this->postnataleTable) {
			$sm = $this->getServiceLocator ();
			$this->postnataleTable = $sm->get ( 'Maternite\Model\PostnataleTable' );
		}
		return $this->postnataleTable;
	}
	
	public function getAntecedentType1Table() {
		if (! $this->antecedenttype1Table) {
			$sm = $this->getServiceLocator ();
			$this->antecedenttype1Table = $sm->get ( 'Maternite\Model\AntecedentType1Table' );
		}
		return $this->antecedenttype1Table;
	}
	public function getAntecedentType2Table() {
		if (! $this->antecedenttype2Table) {
			$sm = $this->getServiceLocator ();
			$this->antecedenttype2Table = $sm->get ( 'Maternite\Model\AntecedentType2Table' );
		}
		return $this->antecedenttype2Table;
	}
	
	public function getGrossesseTable() {
		if (! $this->grossesse) {
			$sm = $this->getServiceLocator ();
			$this->grossesse = $sm->get ( 'Maternite\Model\GrossesseTable' );
		}
		return $this->grossesse;
	}
	

	public function getDateHelper()
	{
		$this->controlDate = new DateHelper ();
	}
	public function convertDate($date) {
		$nouv_date = substr ( $date, 8, 2 ) . '/' . substr ( $date, 5, 2 ) . '/' . substr ( $date, 0, 4 );
		//var_dump($nouv_date);exit();
		return $nouv_date;
	}
	
	public function getHopitalTable()
	{
		if (!$this->hopitalTable) {
			$sm = $this->getServiceLocator();
			$this->hopitalTable = $sm->get('Personnel\Model\HopitalTable');
		}
		return $this->hopitalTable;
	}
	
	public function getTransfererPatientServiceTable()
	{
		if (!$this->transfererPatientServiceTable) {
			$sm = $this->getServiceLocator();
			$this->transfererPatientServiceTable = $sm->get('Maternite\Model\TransfererPatientServiceTable');
		}
		return $this->transfererPatientServiceTable;
	}
	
	public function getConsommableTable()
	{
		if (!$this->consommableTable) {
			$sm = $this->getServiceLocator();
			$this->consommableTable = $sm->get('Pharmacie\Model\ConsommableTable');
		}
		return $this->consommableTable;
	}
	
	public function getDonneesExamensPhysiquesTable()
	{
		if (!$this->donneesExamensPhysiquesTable) {
			$sm = $this->getServiceLocator();
			$this->donneesExamensPhysiquesTable = $sm->get('Maternite\Model\DonneesExamensPhysiquesTable');
		}
		return $this->donneesExamensPhysiquesTable;
	}
	
	public function getDiagnosticsTable()
	{
		if (!$this->diagnosticsTable) {
			$sm = $this->getServiceLocator();
			$this->diagnosticsTable = $sm->get('Maternite\Model\DiagnosticsTable');
		}
		return $this->diagnosticsTable;
	}
	
	public function getOrdonnanceTable()
	{
		if (!$this->ordonnanceTable) {
			$sm = $this->getServiceLocator();
			$this->ordonnanceTable = $sm->get('Maternite\Model\OrdonnanceTable');
		}
		return $this->ordonnanceTable;
	}


		public function getConsultationMaterniteTable()
	{
		if (!$this->consultationMaterniteTable) {
			$sm = $this->getServiceLocator();
			$this->consultationMaterniteTable = $sm->get('Maternite\Model\ConsultationMaterniteTable');
		}
		return $this->consultationMaterniteTable;
	}
	

	
	public function getRvPatientConsTable()
	{
		if (!$this->rvPatientConsTable) {
			$sm = $this->getServiceLocator();
			$this->rvPatientConsTable = $sm->get('Maternite\Model\RvPatientConsTable');
		}
		return $this->rvPatientConsTable;
	}
	public function getDemandeVisitePreanesthesiqueTable()
	{
		if (!$this->demandeVisitePreanesthesiqueTable) {
			$sm = $this->getServiceLocator();
			$this->demandeVisitePreanesthesiqueTable = $sm->get('Maternite\Model\DemandeVisitePreanesthesiqueTable');
		}
		return $this->demandeVisitePreanesthesiqueTable;
	}
	
	public function getNotesExamensMorphologiquesTable()
	{
		if (!$this->notesExamensMorphologiquesTable) {
			$sm = $this->getServiceLocator();
			$this->notesExamensMorphologiquesTable = $sm->get('Maternite\Model\NotesExamensMorphologiquesTable');
		}
		return $this->notesExamensMorphologiquesTable;
	}
	
	
	public function getNotesExamensBiologiqueTable()
	{
		if (!$this->notesExamensBiologiqueTable) {
			$sm = $this->getServiceLocator();
			$this->notesExamensBiologiqueTable = $sm->get('Maternite\Model\NotesExamensBiologiqueTable');
		}
		return $this->notesExamensBiologiqueTable;
	}
	
	public function demandeExamensTable()
	{
		if (!$this->demandeExamensTable) {
			$sm = $this->getServiceLocator();
			$this->demandeExamensTable = $sm->get('Maternite\Model\DemandeTable');
		}
		return $this->demandeExamensTable;
	}
	public function conclusionTable()
	{
		if (!$this->conclusionTable) {
			$sm = $this->getServiceLocator();
			$this->conclusionTable = $sm->get('Maternite\Model\ConclusionTable');
		}
		return $this->conclusionTable;
	}
	public function getOrdonConsommableTable()
	{
		if (!$this->ordonConsommableTable) {
			$sm = $this->getServiceLocator();
			$this->ordonConsommableTable = $sm->get('Maternite\Model\OrdonConsommableTable');
		}
		return $this->ordonConsommableTable;
	}
	
	public function getAntecedantPersonnelTable()
	{
		if (!$this->antecedantPersonnelTable) {
			$sm = $this->getServiceLocator();
			$this->antecedantPersonnelTable = $sm->get('Maternite\Model\AntecedentPersonnelTable');
		}
		return $this->antecedantPersonnelTable;
	}
	
	public function getAntecedantsFamiliauxTable()
	{
		if (!$this->antecedantsFamiliauxTable) {
			$sm = $this->getServiceLocator();
			$this->antecedantsFamiliauxTable = $sm->get('Maternite\Model\AntecedentsFamiliauxTable');
		}
		return $this->antecedantsFamiliauxTable;
	}
	
	public function getDemandeHospitalisationTable()
	{
		if (!$this->demandeHospitalisationTable) {
			$sm = $this->getServiceLocator();
			$this->demandeHospitalisationTable = $sm->get('Maternite\Model\DemandehospitalisationTable');
		}
		return $this->demandeHospitalisationTable;
	}
	

	public function getHospitalisationTable()
	{
		if (!$this->hospitalisationTable) {
			$sm = $this->getServiceLocator();
			$this->hospitalisationTable = $sm->get('Maternite\Model\HospitalisationTable');
		}
		return $this->hospitalisationTable;
	}
	
	public function getHospitalisationlitTable()
	{
		if (!$this->hospitalisationlitTable) {
			$sm = $this->getServiceLocator();
			$this->hospitalisationlitTable = $sm->get('Maternite\Model\HospitalisationlitTable');
		}
		return $this->hospitalisationlitTable;
	}
	
	public function getLitTable()
	{
		if (!$this->litTable) {
			$sm = $this->getServiceLocator();
			$this->litTable = $sm->get('Maternite\Model\LitTable');
		}
		return $this->litTable;
	}
	
	public function getSalleTable()
	{
		if (!$this->salleTable) {
			$sm = $this->getServiceLocator();
			$this->salleTable = $sm->get('Maternite\Model\SalleTable');
		}
		return $this->salleTable;
	}
	
	public function getBatimentTable()
	{
		if (!$this->batimentTable) {
			$sm = $this->getServiceLocator();
			$this->batimentTable = $sm->get('Maternite\Model\BatimentTable');
		}
		return $this->batimentTable;
	}
	
	public function getResultatVpa()
	{
		if (!$this->resultatVpaTable) {
			$sm = $this->getServiceLocator();
			$this->resultatVpaTable = $sm->get('Maternite\Model\ResultatVisitePreanesthesiqueTable');
		}
		return $this->resultatVpaTable;
	}
	
	public function getDemandeActe()
	{
		if (!$this->demandeActeTable) {
			$sm = $this->getServiceLocator();
			$this->demandeActeTable = $sm->get('Maternite\Model\DemandeActeTable');
		}
		return $this->demandeActeTable;
	}
	
	
	public function getForm() {
		if (! $this->formPatient) {
			$this->formPatient = new PatientForm();
		}
		return $this->formPatient;
	}
	
	public function getConsultationTable()
	{
		if (!$this->consultationTable) {
			$sm = $this->getServiceLocator();
			$this->consultationTable = $sm->get('Maternite\Model\ConsultationTable');
		}
		return $this->consultationTable;
	}
	
	
public function getAccouchementTable() {
		if (! $this->accouchementTable) {
			$sm = $this->getServiceLocator ();
			$this->accouchementTable = $sm->get ( 'Maternite\Model\AccouchementTable' );
		}//var_dump(accouchementTable);exit();
		return $this->accouchementTable;
	}
	
	public function getTypeAccouchementTable()
	{
		if (!$this->type_accouchementTable) {
			$sm = $this->getServiceLocator();
			$this->type_accouchementTable = $sm->get('Maternite\Model\TypeAccouchementTable');
		}
		//var_dump($$this->accouchementTable);exit();
		return $this->type_accouchementTable;
	}
	
	public function getNaissanceTable()
	{
		if (!$this->naissanceTable) {
			$sm = $this->getServiceLocator();
			$this->naissanceTable = $sm->get('Maternite\Model\NaissanceTable');
		}
		//var_dump($$this->accouchementTable);exit();
		return $this->naissanceTable;
	}
	
	public function getDevenirNouveauNeTable()
	{
		if (!$this->devenir_nouveau_neTable) {
			$sm = $this->getServiceLocator();
			$this->devenir_nouveau_neTable = $sm->get('Maternite\Model\DevenirNouveauNeTable');
		}
		//var_dump($$this->accouchementTable);exit();
		return $this->devenir_nouveau_neTable;
	}
	public function admissionGrossesseNormalAction()
	{
		
		$this->layout()->setTemplate('layout/accouchement');
		$user = $this->layout()->user;
		$idService = $user ['IdService'];
		$form = new AdmissionForm();
		
		$lespatients = $this->getConsultationTable()->listePatientsConsParMedecin($idService);
		
		// RECUPERER TOUS LES PATIENTS AYANT UN RV aujourd'hui
		$tabPatientRV = $this->getConsultationTable()->getPatientsRV($idService);
		
		return new ViewModel (array(
				'donnees' => $lespatients,
				'tabPatientRV' => $tabPatientRV,
				'form' => $form
		));
	}
	
	

	public function creerDossierPatienteAction(){
		$this->layout()->setTemplate('layout/accouchement');
            
	}

	public function ajouterAction() {
		
		$this->layout ()->setTemplate ( 'layout/accouchement' );
		//$formAdmission = new AdmissionForm();
		$form = $this->getForm ();
		//var_dump($form); exit();
		$patientTable = $this->getPatientTable();
		$form->get('NATIONALITE_ORIGINE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$form->get('NATIONALITE_ACTUELLE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$data = array('NATIONALITE_ORIGINE' => 'SÃ©nÃ©gal', 'NATIONALITE_ACTUELLE' => 'SÃ©nÃ©gal');
	
		$form->populateValues($data);
	
		return new ViewModel ( array (
				'form' => $form
		) );
		
	}
	
	//enregistrement de la PPatiente
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
					'NOM_CONJOINT' => $this->params ()->fromPost ( 'NOM_CONJOINT' ),
					'PRENOM_CONJOINT' => $this->params ()->fromPost ( 'PRENOM_CONJOINT' ),
					'PROFESSION_CONJOINT' => $this->params ()->fromPost ( 'PROFESSION_CONJOINT' ),
			);
			
			//var_dump($donnees); exit();
			
			if ($img != false) {
	
				$donnees['PHOTO'] = $nomfile;
				//ENREGISTREMENT DE LA PHOTO
				imagejpeg ( $img, '.\img\photos_patients\\' . $nomfile . '.jpg' );
				//ENREGISTREMENT DES DONNEES
			
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
				if (isset($_POST ['terminer'])){
				return $this->redirect ()->toRoute ( 'accouchement', array (
						'action' => 'liste-patient'
				) );}
				if (isset($_POST ['terminer_ad'])){
					return $this->redirect ()->toRoute ( 'accouchement', array (
							'action' => 'admission'	
					));
					
				}
			} else {
				
				// On enregistre sans la photo
				//var_dump($donnees); exit();
				$Patient->addPatient ( $donnees , $date_enregistrement , $id_employe );
			//var_dump($donnees); exit();
			if (isset($_POST ['terminer'])){
				return $this->redirect ()->toRoute ( 'accouchement', array (
						'action' => 'liste-patient'
				) );}
				if (isset($_POST ['terminer_ad'])){
					return $this->redirect ()->toRoute ( 'accouchement', array (
							'action' => 'admission'
					) );
					
					
				}
			
			
			}
		}

		return $this->redirect ()->toRoute ( 'accouchement', array (
				'action' => 'liste-patient'
		) );
	}
	
	public function listePatientAction() {
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/accouchement' );
		$view = new ViewModel ();
		return $view;
	}

public function listePatientAjaxAction() {
		
		$output = $this->getPatientTable()->getListePatient();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	//visualiser le patient
	public function infoPatientAction() {
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
	}
	
	
	public function infoAccouchementAction() {
		//var_dump('test');exit();
		$this->layout ()->setTemplate ( 'layout/accouchement' );
		$id_pat = $this->params ()->fromRoute ( 'id_patient', 0 );
		
		$user = $this->layout()->user;
		$idService = $user ['IdService'];
		$form = new ConsultationForm ();
		
		//var_dump($form);exit();
		$formData = $this->getRequest ()->getPost ();
		$form->setData ( $formData );

		$id_cons = $form->get ( "id_cons" )->getValue ();//var_dump($inf);exit();
		$accouchement = $this->getConsultationTable()->listeAccouchement($id_pat);
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
	
	
	public function infosPatientAction() {
		$this->getDateHelper();
		$id_personne = $this->params()->fromPost('id_personne',0);
		$id_cons = $this->params()->fromPost('id_cons',0);
		$encours = $this->params()->fromPost('encours',0);
		$terminer = $this->params()->fromPost('terminer',0);
		$id_demande_hospi = $this->params()->fromPost('id_demande_hospi',0);
	
		$unPatient = $this->getPatientTable()->getInfoPatient($id_personne);
		$photo = $this->getPatientTable()->getPhoto($id_personne);
	
		$demande = $this->getDemandeHospitalisationTable()->getDemandeHospitalisationWithIdcons($id_cons);
	
		$date = $this->controlDate->convertDate( $unPatient['DATE_NAISSANCE'] );
	
		$html  = "<div style='width:100%;'>";
			
		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "' ></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 70%; height: 200px; float:left;'>";
		$html .= "<table style='margin-top:10px; float:left; width: 100%;'>";
	
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><div style='width: 95%; max-width: 135px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NOM'] . "</p></div></td>";
		$html .= "<td style='width: 29%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><div style='width: 95%; max-width: 135px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></div></td>";
		$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute;  d'origine:</a><br><div style='width: 95%; max-width: 135px;  overflow:auto;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE'] . "</p></div></td>";
		$html .= "<td style='width: 29%; '></td>";
			
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><div style='width: 95%; max-width: 135px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><div style='width: 95%; max-width: 250px; overflow:auto;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE']. " </p></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><div style='width: 100%; max-width: 250px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></div></td>";
			
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><div style='width: 95%; max-width: 135px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><div style='width: 95%; max-width: 250px; height:50px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['ADRESSE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><div style='width: 95%; max-width: 250px; overflow:auto;'><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></div></td>";
		$html .= "<td></td>";
		$html .= "</tr>";
	
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 12%; height: 200px; float:left;'>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:5px; margin-left:5px; margin-top:5px;'> <img style='width:105px; height:105px;' src='".$this->getPath()."/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
			
		$html .= "</div>";
	
		$html .= "<div id='titre_info_deces'>
				     <span id='titre_info_demande41' style='margin-left:-5px; cursor:pointer;'>
				        <img src='../img/light/plus.png' /> D&eacute;tails des infos sur la demande
				     </span>
				  </div>
		          <div id='barre'></div>";
	
		$html .= "<div id='info_demande41'>";
		$html .= "<table style='margin-top:10px; margin-left: 18%; width: 80%;'>";
		$html .= "<tr style='width: 95%;'>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Consultation:</a><br><p style='font-weight:bold; font-size:17px;'>" . $id_cons . "</p></td>";
		$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de la demande:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($demande['date_demande_hospi']) . "</p></td>";
		$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date fin pr&eacute;vue:</a><br><p style=' font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDate($demande['date_fin_prevue_hospi']) . "</p></td>";
		$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>M&eacute;decin demandeur:</a><br><p style=' font-weight:bold; font-size:17px;'>" .$demande['PrenomMedecin'].' '.$demande['NomMedecin']. "</p></td>";
		$html .= "</tr>";
		$html .= "</table>";
	
		$html .="<table style='margin-top:0px; margin-left: 18%; width: 70%;'>";
		$html .="<tr style='width: 70%'>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Motif de la demande:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'>". $demande['motif_demande_hospi'] ."</p></td>";
		$html .="<td style='padding-top: 10px; padding-bottom: 0px; padding-right: 30px; width: 20%; '><a style='text-decoration:underline; font-size:13px;'>Note:</a><br><p id='circonstance_deces' style='background:#f8faf8; font-weight:bold; font-size:17px;'> </p></td>";
		$html .="</tr>";
		$html .="</table>";
		$html .= "</div>";
	
		/***
		 * UTILISER UNIQUEMENT DANS LA VUE DE LA LISTE DES PATIENTS EN COURS D'HOSPITALISATION
		*/
		if($encours == 111) {
			$this->getDateHelper();
			$hospitalisation = $this->getHospitalisationTable()->getHospitalisationWithCodedh($id_demande_hospi);
			$lit_hospitalisation = $this->getHospitalisationlitTable()->getHospitalisationlit($hospitalisation->id_hosp);
			$lit = $this->getLitTable()->getLit($lit_hospitalisation->id_materiel);
			$salle = $this->getSalleTable()->getSalle($lit->id_salle);
			$batiment = $this->getBatimentTable()->getBatiment($salle->id_batiment);
	
			$html .= "<div id='titre_info_deces'>
					   <span id='titre_info_hospitalisation21' style='margin-left:-5px; cursor:pointer;'>
				          <img src='../img/light/plus.png' /> Infos sur l'hospitalisation
				       </span>
					  </div>
	
					  <div id='barre'></div>";
				
			$html .= "<div id='info_hospitalisation21'>";
			$html .= "<table style='margin-top:10px; margin-left: 18%; width: 80%;'>";
			$html .= "<tr style='width: 80%;'>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date d&eacute;but:</a><br><p style='font-weight:bold; font-size:17px;'>" . $this->controlDate->convertDateTime($hospitalisation->date_debut) . "</p></td>";
			$html .= "<td style='width: 25%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Batiment:</a><br><p style=' font-weight:bold; font-size:17px;'>".$batiment->intitule."</p></td>";
			$html .= "<td style='width: 20%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Salle:</a><br><p style=' font-weight:bold; font-size:17px;'>".$salle->numero_salle."</p></td>";
			$html .= "<td style='width: 30%; height: 50px; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lit:</a><br><p style=' font-weight:bold; font-size:17px;'>".$lit->intitule."</p></td>";
			$html .= "</tr>";
			$html .= "</table>";
			$html .= "</div>";
		}
	
		if($terminer == 0) {
			$html .="<div style='width: 100%; height: 100px;'>
	    		     <div style='margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
			$html .="<div class='block' id='thoughtbot' style='vertical-align: bottom; padding-left:60%; margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='terminerVisualisationHosp'>Terminer</button></div>
                     </div>";
		}
		/***
		 * UTILISER UNIQUEMENT DANS LA PAGE POUR LA LIBERATION DU PATIENT EN COURS D'HOSPITALISATION
		*/
		else if($terminer == 111) {
			$html .="<div style='width: 100%; height: 270px;'>";
	
			$html .= "<div id='titre_info_deces' >Infos sur la lib&eacute;ration du patient </div>
		              <div id='barre'></div>";
	
			$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
			$formLiberation = new LibererPatientForm();
			$data = array('id_demande_hospi' => $id_demande_hospi);
			$formLiberation->populateValues($data);
	
			$formRow = new FormRow();
			$formTextArea = new FormTextarea();
			$formHidden = new FormHidden();
	
			$html .="<form id='Formulaire_Liberer_Patient'  method='post' action='".$chemin."/accouchement/liberer-patient'>";
			$html .=$formHidden($formLiberation->get('id_demande_hospi'));
			$html .=$formHidden($formLiberation->get('temoin_transfert'));
			$html .=$formHidden($formLiberation->get('id_cons'));
			$html .="<div style='width: 80%; margin-left: 18%;'>";
			$html .="<table id='form_patient' style='width: 100%; '>
					 <tr class='comment-form-patient' style='width: 100%'>
					   <td id='note_soin'  style='width: 45%; '>". $formRow($formLiberation->get('resumer_medical')).$formTextArea($formLiberation->get('resumer_medical'))."</td>
					   <td id='note_soin'  style='width: 45%; '>". $formRow($formLiberation->get('motif_sorti')).$formTextArea($formLiberation->get('motif_sorti'))."</td>
					   <td  style='width: 10%;'><a href='javascript:vider_liberation()'><img id='test' style=' margin-left: 25%;' src='../images_icons/118.png' title='vider tout'></a></td>
					 </tr>
					 </table>";
			$html .="</div>";
	
			$html .="<div style=' margin-left:40px; color: white; opacity: 1; width:95px; height:40px; padding-right:15px; float:left;'>
                        <img  src='".$this->path."/images_icons/fleur1.jpg' />
                     </div>";
	
			$html .="<div style='width: 10%; padding-left: 30%; float:left;'>";
			$html .="<div class='block' id='thoughtbot' style=' float:left; width: 30%; vertical-align: bottom;  margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button id='terminerLiberer'>Annuler</button></div>";
			$html .="</div>";
				
			$html .="<div class='block' id='thoughtbot' style=' float:left; width: 30%; vertical-align: bottom;  margin-bottom: 40px; padding-top: 35px; font-size: 18px; font-weight: bold;'><button type='submit' id='liberer'>Lib&eacute;rer</button></div>";
			$html .="</form>";
	
			$html .="<script>
					  function vider_liberation(){
	                   $('#resumer_medical').val('');
	                   $('#motif_sorti').val('');
		              }
					  //$('#resumer_medical, #motif_sorti').css({'font-weight':'bold','color':'#065d10','font-family': 'Times  New Roman','font-size':'16px'});
					  $('#resumer_medical, #motif_sorti').css({'font-size':'17px'});
					</script>
					";
		}
		$html .="</div>";
	
		$html .="<script>
				  listepatient();
				  initAnimationVue();
				  animationPliantDepliant21();
		          animationPliantDepliant41();
	
				  var clickUneSeuleFois = 0;
				  $('#prescriptionOrdonnance').click(function(){
			        $( '#confirmationDeLaLiberation' ).dialog( 'close' );
			        PrescriptionOrdonnancePopup();
			        $('#PrescriptionOrdonnancePopupInterface').dialog('open');
			        if(clickUneSeuleFois == 0){
				       $('#ajouter_medicament').trigger('click');
				       $('#impressionPdf').toggle(false);
				       $('#id_personneForOrdonnance').val(".$id_personne.");
				       $('#id_consForOrdonnance').val('".$id_cons."');
				   
				       clickUneSeuleFois = 1;
	                }
			        return false;
		          });
	
				 </script>";
	
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ( $html ) );
	}
	
	public function infoPatientAdmisAction() {
		//var_dump('test');exit();
		$this->layout ()->setTemplate ( 'layout/accouchement' );
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


	public function modifierAction() {
		
		$control = new DateHelper();
		$this->layout ()->setTemplate ( 'layout/accouchement' );
		$id_patient = $this->params ()->fromRoute ( 'id_patient', 0 );
	
		$infoPatient = $this->getPatientTable ();
		try {
			$info = $infoPatient->getInfoPatient( $id_patient );
		} catch ( \Exception $ex ) {
			return $this->redirect ()->toRoute ( 'accouchement', array (
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
					unlink ( '.\img\photos_patients\\' . $ancienneImage . '.jpg' );
				}
				imagejpeg ( $img, '.\img\photos_patients\\' . $nomfile . '.jpg' );
	
				$donnees['PHOTO'] = $nomfile;
				$Patient->updatePatient ( $donnees , $id_patient, $date_modification, $id_employe);
	
				return $this->redirect ()->toRoute ( 'accouchement', array (
						'action' => 'liste-patient'
				) );
			} else {
				$Patient->updatePatient($donnees, $id_patient, $date_modification, $id_employe);
				return $this->redirect ()->toRoute ( 'accouchement', array (
						'action' => 'liste-patient'
				) );
			}
		}
		return $this->redirect ()->toRoute ( 'accouchement', array (
				'action' => 'liste-patient'
		) );
	}

	public function listeAdmissionAjaxAction() {
		$patient = $this->getPatientTable ();
		$output = $patient->laListePatientsAjax();
		//$output = $patient->getListePatientsAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	public function getServiceTable() {
		if (! $this->serviceTable) {
			$sm = $this->getServiceLocator ();
			$this->serviceTable = $sm->get ( 'Maternite\Model\ServiceTable' );
		}
		return $this->serviceTable;
	}
	
	

      public function admissionAction() {
		$layout = $this->layout ();
		//var_dump('$layout'); exit();
	
		$layout->setTemplate ( 'layout/accouchement' );
		$user = $this->layout()->user;
		$idService = $user ['IdService'];
        //INSTANCIATION DU FORMULAIRE D'ADMISSION
		$formAdmission = new AdmissionForm();	
		$pat = $this->getPatientTable ();
		
		if ($this->getRequest ()->isPost ()) {							
			$today = new \DateTime ();
			$dateAujourdhui = $today->format( 'Y-m-d' );
			$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
			//var_dump($id);exit();
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
		
		//var_dump($id_admission);exit();
		
		$formData = $this->getRequest ()->getPost ();
		$form->setData ( $formData );
	  
		$this->getAdmissionTable ()-> addConsultation ( $form,$idService ,$id_admission);
	
		$id_cons = $form->get ( "id_cons" )->getValue ();
		
		$this->getAdmissionTable ()->addConsultationMaternite($id_cons);
		
 		return $this->redirect()->toRoute('accouchement', array(
 				'action' =>'admission'));

	}

public function listePatientsAdmisAction() {
		
		 $this->layout ()->setTemplate ( 'layout/accouchement' );
		$patientsAdmis = $this->getAdmissionTable ();
		//INSTANCIATION DU FORMULAIRE
		
		$formAdmission = new AdmissionForm ();
	
	
		
		return new ViewModel ( array (
				'listePatientsAdmis' => $patientsAdmis->getPatientsAdmis (),
				
				'form' => $formAdmission,
				'listePatientsCons' => $patientsAdmis->getPatientAdmisCons(),
		) );
		

	}

	
public function declarerDecesAction() {
		$this->layout ()->setTemplate ( 'layout/accouchement' );
		
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
	
	
	public function listeAccouchementAjaxAction() {
		$output = $this->getPatientTable ()->getListePatientsAdmisAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	public function listeAccouchementAction() {
	
		$this->layout ()->setTemplate ( 'layout/accouchement' );
		$user = $this->layout()->user;
		$idService = $user['IdService'];

		return new ViewModel ( array (
		) );
	}
	public function accoucherAction(){
		$this->layout()->setTemplate('layout/accouchement');
		$user = $this->layout()->user;
		$idService = $user ['IdService'];
		
		$lespatients = $this->getConsultationTable()->listeDesAccouchement($idService);
		//var_dump(count($lespatients))
		// RECUPERER TOUS LES PATIENTS AYANT UN RV aujourd'hui
		$tabPatientRV = $this->getConsultationTable()->getPatientsRV($idService);
		//var_dump($user); exit();
		return new ViewModel (array(
				'donnees' => $lespatients,
				'tabPatientRV' => $tabPatientRV
		));

	
		
	}
	public function partogrammeAction(){
		$this->layout()->setTemplate('layout/accouchement');
       $form = new ConsultationForm ();
       $forms = new AdmissionForm ();
       return array (
       		'form' => $form,
       		'forms' => $forms,
       	
       );
	}
	
	public function listeDesAccouchementsAction() {
		
		
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/accouchement' );
		$view = new ViewModel ();
		
		return $view;
	}
	
	
	
	public function listeDesAccouchementsAjaxAction() {
		$id_pat = $this->params()->fromQuery('id_patient', 0);
		
		$output = $this->getPatientTable()->getPatientAccouchee();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}

	
	public function complementAccouchementAction()
	{
		$this->layout()->setTemplate('layout/accouchement');
		$user = $this->layout()->user;
		$IdDuService = $user ['IdService'];
		$id_medecin = $user ['id_personne'];
		$this->getDateHelper();
		$id_pat = $this->params()->fromQuery('id_patient', 0);
		$id = $this->params()->fromQuery('id_cons');
		$inf=$this->getConsultationTable()->infpat($id_pat, $id);
		// le nobre de patientes par rendez-vous est limié à 20
		//var_dump($id);exit();	
		$id_admi = $this->params()->fromQuery('id_admission', 0);
		$listeMedicament = $this->getConsultationTable()->listeDeTousLesMedicaments();
		
		$listeForme = $this->getConsultationTable()->formesMedicaments();
		$listetypeQuantiteMedicament = $this->getConsultationTable()->typeQuantiteMedicaments();
		
		// INSTANTIATION DE L'ORDONNANCE
		$infoOrdonnance = $this->getOrdonnanceTable()->getOrdonnanceNonHospi($id);
		
		if ($infoOrdonnance) {
			$idOrdonnance = $infoOrdonnance->id_document;
			$duree_traitement = $infoOrdonnance->duree_traitement;
			// LISTE DES MEDICAMENTS PRESCRITS
			$listeMedicamentsPrescrits = $this->getOrdonnanceTable()->getMedicamentsParIdOrdonnance($idOrdonnance);
			$nbMedPrescrit = $listeMedicamentsPrescrits->count();
		} else {
			$nbMedPrescrit = null;
			$listeMedicamentsPrescrits = null;
			$duree_traitement = null;
		}
		//demande examen biologique et morphologique
		$listeDemandesMorphologiques = $this->demandeExamensTable()->getDemandeExamensMorphologiques($id);
		$listeDemandesBiologiques = $this->demandeExamensTable()->getDemandeExamensBiologiques($id);		
		$listeDesExamensBiologiques = $this->demandeExamensTable()->getDemandeDesExamensBiologiques();
		$listeDesExamensMorphologiques = $this->demandeExamensTable()->getDemandeDesExamensMorphologiques();
		$listeCausesComplicationObstetricale = $this->ConclusionTable()->getCausesComplication($id);
		$Naissances = $this->getNaissanceTable()->getNaissance($id);//getEnf($id);
		$nombre=count($Naissances);
		$Nouveau = $this->getDevenirNouveauNeTable()->getDevenu($id);
		$listesDecesMaternel = $this->conclusionTable()->getCausesDeces($id);
		//var_dump(count($listesDecesMaternel));exit();
		$tabNv=array();$j=1;
		$tabEnf=array();$k=1;
		//var_dump(count($Nouveau));exit();
foreach ($Naissances as $enfant){
	$tabEnf['sexe_'.$k]=$enfant['sexe'];
	$tabEnf['n_sexe_'.$k]=$enfant['note_sexe'];
	$tabEnf['poids_'.$k]=$enfant['poids'];
	$tabEnf['n_poids_'.$k]=$enfant['note_poids'];
	$tabEnf['taille_'.$k]=$enfant['taille'];
	$tabEnf['n_taille_'.$k]=$enfant['note_taille'];
	$tabEnf['cri_'.$k]=$enfant['cri'];
	$tabEnf['n_cri_'.$k]=$enfant['note_cri'];
	$tabEnf['malf_'.$k]=$enfant['malf'];
	$tabEnf['n_malf_'.$k]=$enfant['note_malf'];
	$tabEnf['sat_'.$k]=$enfant['sat'];
	$tabEnf['n_sat_'.$k]=$enfant['note_sat'];
	$tabEnf['vitk_'.$k]=$enfant['vit_k'];
	$tabEnf['n_vitk_'.$k]=$enfant['note_vitk'];
	$tabEnf['mt_'.$k]=$enfant['maintien_temp'];
	$tabEnf['n_mt_'.$k]=$enfant['note_temp'];
	$tabEnf['msp_'.$k]=$enfant['mise_soin_precoce'];
	$tabEnf['n_msp_'.$k]=$enfant['note_soin_precoce'];
	$tabEnf['sc_'.$k]=$enfant['soin_cordon'];
	$tabEnf['n_sc_'.$k]=$enfant['note_cordon'];
	$tabEnf['reanim_'.$k]=$enfant['reanimation'];
	$tabEnf['n_reanim_'.$k]=$enfant['note_reanim'];
	$tabEnf['collyre_'.$k]=$enfant['collyre'];
	$tabEnf['n_collyre_'.$k]=$enfant['note_collyre'];
	$tabEnf['vpo_'.$k]=$enfant['vpo'];
	$tabEnf['n_vpo_'.$k]=$enfant['note_vpo'];
	$tabEnf['antiT_'.$k]=$enfant['anti_tuberculeux'];
	$tabEnf['n_antiT_'.$k]=$enfant['note_tuberculeux'];
	$tabEnf['bcg_'.$k]=$enfant['bcg'];
	$tabEnf['n_bcg_'.$k]=$enfant['note_bcg'];
	$tabEnf['anti_hepa_'.$k]=$enfant['anti_hepatique'];
	$tabEnf['n_anti_hepa_'.$k]=$enfant['note_hepa'];
	$tabEnf['autre_vacc_'.$k]=$enfant['autre_vacc'];
	$tabEnf['type_autre_vacc_'.$k]=$enfant['type_autre_vacc'];
	$tabEnf['n_autre_vacc_'.$k]=$enfant['note_autre_vacc'];
	$tabEnf['cranien_'.$k]=$enfant['perim_cranien'];
	$tabEnf['cephalique_'.$k]=$enfant['perim_cephalique'];
	$tabEnf['brachial_'.$k]=$enfant['perim_brachial'];
	$tabEnf['n_perim_'.$k]=$enfant['note_perim'];
	$tabEnf['apgar1_'.$k]=$enfant['apgar_1'];
	$tabEnf['apgar5_'.$k]=$enfant['apgar_5'];
	$tabEnf['n_apgar_'.$k]=$enfant['note_apgar'];
	$tabEnf['consj1j2_'.$k]=$enfant['consult_j1_j2'];
	$k++;		
	
}

foreach ($Nouveau as $Nv){
	$tabNv['viv_bien_portant_'.$j]=$Nv['viv_bien_portant'];
	$tabNv['n_viv_bien_portant_'.$j]=$Nv['note_viv_bien_portant'];
	$tabNv['viv_mal_form_'.$j]=$Nv['viv_mal_formation'];
	$tabNv['n_viv_mal_form_'.$j]=$Nv['note_viv_mal_formation'];
	$tabNv['malade_'.$j]=$Nv['malade'];
	$tabNv['n_malade_'.$j]=$Nv['note_malade'];
	$tabNv['decede_'.$j]=$Nv['decede'];
	$tabNv['date_deces_'.$j]=$Nv['date_deces'];
	$tabNv['heure_deces_'.$j]=$Nv['heure_deces'];
	$tabNv['cause_deces_'.$j]=$Nv['cause_deces'];
	$j++;
}

//var_dump($tabNv);exit();
		$liste = $this->getConsultationTable()->getInfoPatient($id_pat);
		$id_admission=$liste['id_admission'];
		$image = $this->getConsultationTable()->getPhoto($id_pat);
		$this->getDateHelper();
		$donne_ante=$this->getAntecedentType1Table()->getAntecedentType1($id_pat);
		$donne_ante2=$this->getAntecedentType2Table()->getAntecedentType2($id);
		$donne_grossesses=$this->getGrossesseTable()->getGrossesse($id_pat,$id);
		
		$avortement=$this->getGrossesseTable()->getAvortement($id);		
		
		$donne_examen=$this->getDonneesExamensPhysiquesTable()->getExamensPhysiques($id);
		
		 $date_rupt_pde = $this->controlDate->convertDate( $donne_examen['date_rupt_pde']);
		
		$donne_accouchement=$this->getAccouchementTable()->getAccouchement($id);
		
			// recuperer le mois dans la date
		 	
		$date = $donne_accouchement['date_accouchement'];
		
	
		 $donne_prenome=$this->getAccouchementTable()->getPrenomme($donne_accouchement['id_accouchement']);
		// var_dump($donne_prenome);exit();
		 $date_accouchement = $this->controlDate->convertDate( $donne_accouchement['date_accouchement']);
		$form = new ConsultationForm ();		
		
		//var_dump($form);exit();
		$donne_ant1=array(
					
				'enf_viv'=>$donne_ante['enf_viv'],
				'geste'=>$donne_ante['geste'],
				'parite'=>$donne_ante['parite'],
				'note_enf'=>$donne_ante['note_enf'],
				'note_geste'=>$donne_ante['note_geste'],
				'note_parite'=>$donne_ante['note_parite'],
				'mort_ne'=>$donne_ante['mort_ne'],
				'note_mort_ne'=>$donne_ante['note_mort_ne'],
				'cesar'=>$donne_ante['cesar'],
				//'note_cesar'=>$donne_ante['note_cesar'],
				'groupe_sanguins'=>$donne_ante['groupe_sanguin'],
				'rhesus'=>$donne_ante['rhesus'],
				'note_gs'=>$donne_ante['note_gs'],
				'test_emmel'=>$donne_ante['test_emmel'],
				'profil_emmel'=>$donne_ante['profil_emmel'],
				'note_emmel'=>$donne_ante['note_emmel'],
				
			
					
		);	
		
		$form->populateValues($donne_ant1);
		
		$donne_antecedent2=array(
				'dystocie'=>$donne_ante2['dystocie'],
				'eclampsie'=>$donne_ante2['eclampsie'],
				'regularite'=>$donne_ante2['cycle'],
				'quantite_regle'=>$donne_ante2['quantite_regle'],
				'duree_cycle'=>$donne_ante2['duree_cycle'],
				'note_dystocie'=>$donne_ante2['note_dystocie'],
				'note_eclampsie'=>$donne_ante2['note_eclampsie'],
				'autre_go'=>$donne_ante2['autre_go'],
				'note_autre_go'=>$donne_ante2['note_autre'],
				'nb_garniture_jr'=>$donne_ante2['nb_garniture_jr'],
				'contraception'=>$donne_ante2['contraception'],
				'type_contraception'=>$donne_ante2['type_contraception'],
				'duree_contraception'=>$donne_ante2['duree_contraception'],
				'note_contraception'=>$donne_ante2['note_contraception'],
		);//var_dump($donne_antecedent2);exit();
		
		$form->populateValues($donne_antecedent2);
		
		
		$donne_grossesse=array(
				'ddr'=>$donne_grossesses['ddr'],
				'duree_grossesse'=>$donne_grossesses['duree_grossesse'],
				'note_ddr'=>$donne_grossesses['note_ddr'],
				'nb_cpn'=>$donne_grossesses['nb_cpn'] ,
				'note_cpn'=>$donne_grossesses['note_cpn'],
				'bb_attendu'=>$donne_grossesses['bb_attendu'],
				'nombre_bb'=>$donne_grossesses['nombre_bb'],
				'note_bb'=>$donne_grossesses['note_bb'],
				'vat_1'=>$donne_grossesses['vat_1'],
				'vat_2'=>$donne_grossesses['vat_2'],
				'vat_3'=>$donne_grossesses['vat_3'],
				'vat_4'=>$donne_grossesses['vat_4'],
				'vat_5'=>$donne_grossesses['vat_5'],
				'tpi_1'=>$donne_grossesses['tpi_1'],
				'tpi_2'=>$donne_grossesses['tpi_2'],
				'tpi_4'=>$donne_grossesses['tpi_4'],
				'tpi_3'=>$donne_grossesses['tpi_3'],
				'note_vat'=>$donne_grossesses['note_vat'],
		);
	
	
		// recuperer le mois dans la date
		//$date = "04/30/1973";
		//list($month, $day, $year) = explode('/', $date);
		//echo "Mois : $month; Jour : $day; Année : $year<br />\n";
	//var_dump($month);exit();
		
		
		
		
		
		$form->populateValues($donne_grossesse);
		
		$donne_av=array(
				'type_avortement'=>$avortement['id_type_av'],
				'traitement_recu'=>$avortement['id_traitement'],
				'periode_av'=>$avortement['periode_av'],
			
		);//var_dump($donne_av);exit();
		$form->populateValues($donne_av);
		
		$donne_examenp=array(
				
					'examen_maternite_donnee1' => $donne_examen ['toucher_vaginale'],
						'examen_maternite_donnee2' => $donne_examen ['hauteur_uterine'],
						'examen_maternite_donnee3' => $donne_examen ['bdc'],			
						'examen_maternite_donnee5' => $donne_examen ['pde'],
						'examen_maternite_donnee6' => $date_rupt_pde,
						'examen_maternite_donnee7' => $donne_examen ['heure_rupt_pde'],
						'examen_maternite_donnee8' => $donne_examen['id_pres'],
						'examen_maternite_donnee9' => $donne_examen ['bassin'],
						'examen_maternite_donnee10' => $donne_examen ['nb_bdc'],
						'note_tv' => $donne_examen ['note_tv'],
						'note_hu' => $donne_examen ['note_hu'],
						'note_bdc' => $donne_examen ['note_bdc'],
						'note_bassin' => $donne_examen ['note_bassin'],
						'examen_maternite_donnee11' => $donne_examen ['aspect'],
		);//var_dump($donne_examenp);exit();
		$form->populateValues($donne_examenp);
		
		
		
		

		$donnees_accouchement=array(
		
					'type_accouchement' => $donne_accouchement['id_type'],					
 					'motif_type' => $donne_accouchement['motif_type'],
 					'date_accouchement' => $date_accouchement,
					'heure_accouchement' => $donne_accouchement['heure_accouchement'],
 					'delivrance' => $donne_accouchement['delivrance'],
					'ru' => $donne_accouchement['ru'],
					'quantite_hemo' => $donne_accouchement['quantite_hemo'],
					'hemoragie' => $donne_accouchement['hemoragie'],
					'ocytocique_per' => $donne_accouchement['ocytocique_per'],
					'ocytocique_post' => $donne_accouchement['ocytocique_post'],
					'antibiotique' => $donne_accouchement['antibiotique'],
					'anticonvulsant' => $donne_accouchement ['anticonvulsant'],
					'transfusion' => $donne_accouchement['transfusion'],
				    'hrp' => $donne_accouchement['hrp'],
				    'dystocie' => $donne_accouchement['dystocie'],
				    'infection' => $donne_accouchement['infection'],
				    'anemie' => $donne_accouchement['anemie'],
				    'fistules' => $donne_accouchement['fistules'],
				    'paludisme' => $donne_accouchement['paludisme'],
				    'eclapsie' => $donne_accouchement['paludisme'],
					'note_delivrance' => $donne_accouchement['note_delivrance'],
					'note_hemorragie' => $donne_accouchement['note_hemorragie'],
					'text_observation' => $donne_accouchement['text_observation'],
					'suite_de_couches' => $donne_accouchement['suite_de_couche'],
					'note_ocytocique' => $donne_accouchement['note_ocytocique'],
					'note_antibiotique' => $donne_accouchement['note_antibiotique'],
					'note_anticonv' => $donne_accouchement['note_anticonv'],
					'note_transfusion' => $donne_accouchement['note_transfusion'],
				    'note_hrp' => $donne_accouchement['note_hrp'],
				    'note_dystocie' => $donne_accouchement['note_dystocie'],
				    'note_infection' => $donne_accouchement['note_infection'],
				    'note_anemie' => $donne_accouchement['note_anemie'],
				     'note_fistules' => $donne_accouchement['note_fistules'],
				     'note_paludisme' => $donne_accouchement['note_paludisme'],
				
				
				
				
				
		);
		$form->populateValues($donnees_accouchement);
		
		$donne_pre=array(
				'prenome'=>$donne_prenome['prenomme']
				
		);
		
		$form->populateValues($donne_pre);
		$type_admission = $this->getConsultationTable()->RecuperTousLesIdAdmis($inf['id_admission']);
		//var_dump($type_admission['motif_admission']);exit();
  		if($type_admission['type_admission']=='Normal'){
 			$form->get('motif_ad')->setValue($type_admission['type_admission']);
 			
  		}
	   
		else{
				$form->get('motif_ad')->setValue($type_admission['motif_admission']);
			$form->get('motif')->setValue($type_admission['motif_transfert_evacuation']);
			$form->get('service_origine')->setValue($type_admission['service_dorigine']);
			
		}


	$liste_pres = $this->getDonneesExamensPhysiquesTable ()->listePresentation ();
	
		$tab_pres = $liste_pres ;
		$form->get('examen_maternite_donnee8')->setValueOptions($tab_pres);
		
		
		//pour la presentation du foetus
		$liste_type = $this->getTypeAccouchementTable ()->listeTypeAccouchement ();
		
		$afficheTous = array ("" => 'Selectionnez un Type');
		//	var_dump($liste_type);exit();
		$tab_type = $liste_type ;
		$form->get('type_accouchement')->setValueOptions($tab_type);
		
		//AVORTEMENT
		$liste_type_av = $this->getTypeAccouchementTable ()->TypeAvortement ();
		$tab_type_av = $liste_type_av ;
		$form->get('type_avortement')->setValueOptions($tab_type_av);
		
		$liste_type_t = $this->getTypeAccouchementTable ()->Traitement();
		$tab_type_t = $liste_type_t ;
		$form->get('traitement_recu')->setValueOptions($tab_type_t);
		
		
		// instancier la consultation et rï¿½cupï¿½rer l'enregistrement
		$consult = $this->getConsultationTable()->getConsult($id);
		$pos = strpos($consult->pression_arterielle, '/');
		$tensionmaximale = substr($consult->pression_arterielle, 0, $pos);
		$tensionminimale = substr($consult->pression_arterielle, $pos + 1);		
		
		// POUR LES HISTORIQUES OU TERRAIN PARTICULIER

		// *** Liste des consultations
		$listeConsultation = $this->getConsultationTable()->getConsultationPatient($id_pat, $id);
	
		// Liste des examens biologiques
		$listeDesExamensBiologiques = $this->demandeExamensTable()->getDemandeDesExamensBiologiques();
		$listeDesComplication = $this->conclusionTable()->getComplicationObstetricale();
		$listeDesCauseDeces = $this->conclusionTable()->getCauseDecesMaternel();
		// Liste des examens Morphologiques
		$listeDesExamensMorphologiques = $this->demandeExamensTable()->getDemandeDesExamensMorphologiques();
		
		// *** Liste des Hospitalisations
		$listeHospitalisation = $this->getDemandeHospitalisationTable()->getDemandeHospitalisationWithIdPatient($id_pat);
		$infoDiagnostics = $this->getDiagnosticsTable()->getDiagnostics($id);
		// POUR LES DIAGNOSTICS
		$k = 1;$tabdiagons=array();
		foreach ($infoDiagnostics as $diagnos) {
			$tabdiagons ['diagnostic' . $k] = $diagnos ['libelle_diagnostics'];
			//$data ['decisions']=$diagnos['decision'];
			$k++;
		}
		$Decision = $this->getDiagnosticsTable()->getDecision($id);
		$donne_dec=array(
				'decisions'=>$Decision['decision']
		
		);
		
		$form->populateValues($donne_dec);

		// POUR LE TRANSFERT
		// INSTANCIATION DU TRANSFERT
		// RECUPERATION DE LA LISTE DES HOPITAUX
		$hopital = $this->getTransfererPatientServiceTable()->fetchHopital();
		
		// LISTE DES HOPITAUX
		$form->get('hopital_accueil')->setValueOptions($hopital);
		// RECUPERATION DU SERVICE OU EST TRANSFERE LE PATIENT
		$transfertPatientService = $this->getTransfererPatientServiceTable()->getServicePatientTransfert($id);
		
		if ($transfertPatientService) {
			$idService = $transfertPatientService ['ID_SERVICE'];
			// RECUPERATION DE L'HOPITAL DU SERVICE
			$transfertPatientHopital = $this->getTransfererPatientServiceTable()->getHopitalPatientTransfert($idService);
			$idHopital = $transfertPatientHopital ['ID_HOPITAL'];
			// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU IL EST TRANSFERE
			$serviceHopital = $this->getTransfererPatientServiceTable()->fetchServiceWithHopital($idHopital);
		
			// LISTE DES SERVICES DE L'HOPITAL
			$form->get('service_accueil')->setValueOptions($serviceHopital);
		
			// SELECTION DE L'HOPITAL ET DU SERVICE SUR LES LISTES
			$data ['hopital_accueil'] = $idHopital;
			$data ['service_accueil'] = $idService;
			$data ['motif_transfert'] = $transfertPatientService ['MOTIF_TRANSFERT'];
			$hopitalSelect = 1;
		} else {
				
			$hopitalSelect = 0;
			// RECUPERATION DE L'HOPITAL DU SERVICE
			$transfertPatientHopital = $this->getTransfererPatientServiceTable()->getHopitalPatientTransfert($IdDuService);
			$idHopital = $transfertPatientHopital ['ID_HOPITAL'];
			$data ['hopital_accueil'] = $idHopital;
			// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
			$serviceHopital = $this->getTransfererPatientServiceTable()->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
			// LISTE DES SERVICES DE L'HOPITAL
			$form->get('service_accueil')->setValueOptions($serviceHopital);
		}
		
		$infoOrdonnance = $this->getOrdonnanceTable()->getOrdonnanceNonHospi($id);
		
		if ($infoOrdonnance) {
			$idOrdonnance = $infoOrdonnance->id_document;
			$duree_traitement = $infoOrdonnance->duree_traitement;
			// LISTE DES MEDICAMENTS PRESCRITS
			$listeMedicamentsPrescrits = $this->getOrdonnanceTable()->getMedicamentsParIdOrdonnance($idOrdonnance);
			$nbMedPrescrit = $listeMedicamentsPrescrits->count();
		} else {
				
			$nbMedPrescrit = null;
			$listeMedicamentsPrescrits = null;
			$duree_traitement = null;
		}
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
				'pressionarterielle' => $consult->pression_arterielle,
				'hopital_accueil' => $idHopital,		
				'id_admission' => $id_admission,
				
		);		//var_dump($data);exit();	
				
		$donneesHospi = $this->getDemandeHospitalisationTable()->getDemandehospitalisationParIdcons($id);
		if ($donneesHospi) {
			$data ['motif_hospitalisation'] = $donneesHospi->motif_demande_hospi;
			$data ['date_fin_hospitalisation_prevue'] = $this->controlDate->convertDate($donneesHospi->date_fin_prevue_hospi);
		}
	
	   // var_dump($data);exit();
		$leRendezVous = $this->getRvPatientConsTable()->getRendezVous($id);
		//$heure= array(	$leRendezVous->heure);
	 
		if ($leRendezVous) {
			$data ['heure_rv'] = $leRendezVous->heure;
			$data ['date_rv'] = $this->controlDate->convertDate($leRendezVous->date);
			$data ['motif_rv'] = $leRendezVous->note;
		}
		
		
		
		$Tranfer = $this->getTransfererPatientServiceTable()->getServicePatientTransfert($id);
			if ($Tranfer) {
			$data ['motif_transfert'] = $Tranfer['MOTIF_TRANSFERT'];
			$data ['service_accueil'] = $Tranfer['ID_SERVICE'];
		}
		//var_dump($data);exit();
		
		if ($leRendezVous) {
			$data ['heure_rv'] = $leRendezVous->heure;
			$data ['date_rv'] = $this->controlDate->convertDate($leRendezVous->date);
			$data ['motif_rv'] = $leRendezVous->note;
		}
		
		
		// Pour recuper les bandelettes
		$bandelettes = $this->getConsultationTable()->getBandelette($id);
		
		// RECUPERATION DES ANTECEDENTS
		$donneesAntecedentsPersonnels = $this->getAntecedantPersonnelTable()->getTableauAntecedentsPersonnels($id_pat);
		$donneesAntecedentsFamiliaux = $this->getAntecedantsFamiliauxTable()->getTableauAntecedentsFamiliaux($id_pat);

			// Recuperer les antecedents medicaux ajouter pour le patient
		$antMedPat = $this->getConsultationTable()->getAntecedentMedicauxPersonneParIdPatient($id_pat);
	
		// Recuperer les antecedents medicaux
		// Recuperer les antecedents medicaux
		$listeAntMed = $this->getConsultationTable()->getAntecedentsMedicaux();
		// //RESULTATS DES EXAMENS MORPHOLOGIQUE
		$examen_morphologique = $this->getNotesExamensMorphologiquesTable()->getNotesExamensMorphologiques($id);
		
		$data ['radio'] = $examen_morphologique ['radio'];
		$data ['ecographie'] = $examen_morphologique ['ecographie'];
		$data ['fibrocospie'] = $examen_morphologique ['fibroscopie'];
		$data ['scanner'] = $examen_morphologique ['scanner'];
		$data ['irm'] = $examen_morphologique ['irm'];
		
		// //RESULTATS DES EXAMENS BIOLOGIQUE DEJA EFFECTUES ET ENVOYER PAR LE BIOLOGISTE
		/* $examen_biologique = $this->getNotesExamensBiologiqueTable()->getNotesExamensBiologiques($id);
		//var_dump('test');exit();
		
		$data ['groupe_sanguin'] = $examen_biologique ['groupe_sanguin'];
		$data ['hemogramme_sanguin'] = $examen_biologique ['hemogramme_sanguin'];
		$data ['bilan_hemolyse'] = $examen_biologique ['bilan_hemolyse'];
		$data ['bilan_hepatique'] = $examen_biologique ['bilan_hepatique'];
		$data ['bilan_renal'] = $examen_biologique ['bilan_renal'];
		$data ['bilan_inflammatoire'] = $examen_biologique ['bilan_inflammatoire']; */
		//var_dump($examen_biologique);exit();
		//$form->setValue($data['heure_rv']);
		
		$form->populateValues(array_merge($data,$tabdiagons, $bandelettes, $donneesAntecedentsPersonnels, $donneesAntecedentsFamiliaux));
		return array(
				'lesdetails' => $liste,
				'id_cons' => $id,
				
				'image' => $image,
				'form' => $form,
				'heure_cons' => $consult->heurecons,
				'dateonly' => $consult->dateonly,
				'liste_med' => $listeMedicament,
			
				'nb_med_prescrit' => $nbMedPrescrit,
				'liste_med_prescrit' => $listeMedicamentsPrescrits,
				'duree_traitement' => $duree_traitement,
				'temoin' => $bandelettes ['temoin'],
				'listeForme' => $listeForme,
				'listetypeQuantiteMedicament' => $listetypeQuantiteMedicament,
				'donneesAntecedentsPersonnels' => $donneesAntecedentsPersonnels,
				'donneesAntecedentsFamiliaux' => $donneesAntecedentsFamiliaux,
				'liste' => $listeConsultation,
				'nbDiagnostics'=> $infoDiagnostics->count(),
				//'resultRV' => $resultRV,
				'listeHospitalisation' => $listeHospitalisation,
				'listeDesExamensBiologiques' => $listeDesExamensBiologiques,
				'listeDesComplication' => $listeDesComplication,
				'listeCauseDeces'=>$listeDesCauseDeces,
				'listeComplicationObstetricales'=>$listeCausesComplicationObstetricale,
				  'Naissances'   =>$tabEnf,
				'Nouveau'   =>$tabNv,
				 'nombre_enf' => $nombre,
				'listesDecesMaternel'=>$listesDecesMaternel,
				'listeDesExamensMorphologiques' => $listeDesExamensMorphologiques,
				'listeAntMed' => $listeAntMed,
				'antMedPat' => $antMedPat,
				'nbAntMedPat' => $antMedPat->count(),
				'listeDemandesMorphologiques' => $listeDemandesMorphologiques,
				'listeDemandesBiologiques' => $listeDemandesBiologiques,
				'listeDesExamensBiologiques' => $listeDesExamensBiologiques,
				'listeDesExamensMorphologiques' => $listeDesExamensMorphologiques,
		);		
				

	}

	public function vuePatientAdmisAction(){
		$this->getDateHelper();
		$idPatient = (int)$this->params()->fromPost ('idPatient');
		$idAdmission = (int)$this->params()->fromPost ('idAdmission');
	
		$unPatient = $this->getPatientTable()->getInfoPatient($idPatient);
		$photo = $this->getPatientTable()->getPhoto($idPatient);
		
		$today = new \DateTime ();
		$dateAujourdhui = $today->format( 'Y-m-d' );
		$RendezVOUS = $this->getPatientTable ()->verifierRV($idPatient, $dateAujourdhui);
		$date = $unPatient['DATE_NAISSANCE'];
		//if($date){ $date = (new DateHelper())->convertDate ( $unPatient['DATE_NAISSANCE'] ); }else{ $date = null;}
	
		$html  = "<div style='width:100%;'>";
			
 		$html .= "<div style='width: 18%; height: 180px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='../img/photos_patients/". $photo ."' ></div>";
		$html .= "<div style='margin-left:60px; margin-top: 150px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient['AGE'] . " ans</div></div>";
		$html .= "</div>";
			
		$html .= "<div style='width: 70%; height: 180px; float:left;'>";
		$html .= "<table id='vuePatientAdmission' style='margin-top:10px; float:left'>";
	
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nmero dossier:</a><br><div style='width: 150px; max-width: 160px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['NUMERO_DOSSIER'] . "</p></div></td>";
		$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><div style='width: 150px; max-width: 160px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['DATE_NAISSANCE'] . "</p></div></td>";
		$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute;  d'origine:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ORIGINE'] . "</p></div></td>";
		$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['TELEPHONE'] . "</p></div></td>";
		$html .= "<td style='width: 29%; '></td>";
		
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['PRENOM'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['LIEU_NAISSANCE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><div style='width: 95%; max-width: 135px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['NATIONALITE_ACTUELLE']. "</p></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><div style='width: 100%; max-width: 235px; height:40px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient['EMAIL'] . "</p></div></td>";
			
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nom  :</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" .$unPatient['NOM']  . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Sexe:</a><br><div style='width: 97%; max-width: 250px; height:50px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient['SEXE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><div style='width: 95%; max-width: 235px; height:40px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['ADRESSE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><div style='width: 95%; max-width: 235px; height:40px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" .  $unPatient['PROFESSION'] . "</p></div></td>";
		if($RendezVOUS){
			$html .= "<span> <i style='color:green;'>
					        <span id='image-neon' style='color:red; font-weight:bold;'>Rendez-vous! </span> <br>
					        <span style='font-size: 16px;'>Service:</span> <span style='font-size: 16px; font-weight:bold;'> ". $RendezVOUS[ 'NOM' ]." </span> <br>
					        <span style='font-size: 16px;'>Heure:</span>  <span style='font-size: 16px; font-weight:bold;'>". $RendezVOUS[ 'HEURE' ]." </span> </i>
			              </span>";
		}
	
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .="</div>";
			
		$html .= "<div style='width: 12%; height: 180px; float:left; '>";

		
		$html .= "</div>";
			
		$html .= "</div>";
	
		
		$html .="<div id='barre_separateur'></div>";
	
		$html .="<table style='margin-top:10px; margin-left:18%; width: 80%; margin-bottom: 60px;'>";
	
 		$html .="<tr style='width: 80%; '>";
       // $html .="<td style='width: 50%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Date d'admission </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px;'> ". $this->controlDate->convertDateTime($InfoAdmis->date_enregistrement) ." </p></td>";

 		//$html .="<td style='width: 50%; vertical-align:top; margin-right:10px;'><span id='labelHeureLABEL' style='padding-left: 5px;'>Service </span><br><p id='zoneChampInfo1' style='background:#f8faf8; padding-left: 5px; padding-top: 5px; font-size:15px;'> ". $InfoService->nom ." </p></td>";

		//$html .="</tr>";
	

	    $html .="</table>";
    	$html .="<table style='margin-top:10px; margin-left:18%; width: 80%;'>";
        $html .="<tr style='width: 80%;'>";
	
 		$html .="<td class='block' id='thoughtbot' style='width: 35%; display: inline-block;  vertical-align: bottom; padding-left:350px; padding-bottom: 15px; padding-right: 150px;'><button type='submit' id='terminer'>Terminer</button></td>";
	
		$html .="</tr>";
 		$html .="</table>";
	

 		
		$html .="<script>listepatient();
				  function FaireClignoterImage (){
                    $('#image-neon').fadeOut(900).delay(300).fadeIn(800);
                  }
                  setInterval('FaireClignoterImage()',2200);
	
				  $('#button_pdf').click(function(){
				     vart='./facturation/impression-facture';
				     var formulaire = document.createElement('form');
			         formulaire.setAttribute('action', vart);
			         formulaire.setAttribute('method', 'POST');
			         formulaire.setAttribute('target', '_blank');
	
				     var champ = document.createElement('input');
				     champ.setAttribute('type', 'hidden');
				     champ.setAttribute('name', 'idAdmission');
				     champ.setAttribute('value', ".$idAdmission.");
				     formulaire.appendChild(champ);
				  
				     formulaire.submit();
	              });
	
				  $('a,img,hass').tooltip({
                  animation: true,
                  html: true,
                  placement: 'bottom',
                  show: {
                    effect: 'slideDown',
                      delay: 250
                    }
                  });
	
				 </script>";
		//var_dump($photo);exit();
 		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse()->setContent(Json::encode($html));
	
	} 
	
	public function ajouterMamanAction() {
		$this->layout ()->setTemplate ( 'layout/accouchement' );
		$form = $this->getForm ();
		$patientTable = $this->getPatientTable();
		$form->get('NATIONALITE_ORIGINE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$form->get('NATIONALITE_ACTUELLE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$data = array('NATIONALITE_ORIGINE' => 'SÃ©nÃ©gal', 'NATIONALITE_ACTUELLE' => 'SÃ©nÃ©gal');
	
		$form->populateValues($data);
	
		return new ViewModel ( array (
				'form' => $form
		) );
	}

	 public function majComplementAccouchementAction()
	{$this->layout()->setTemplate('layout/accouchement');}

	
	public function updateComplementAccouchementAction()
	{
		$this->layout()->setTemplate('layout/accouchement');
        $this->getDateHelper();
        $Control = new DateHelper();
        $id_cons = $this->params()->fromPost('id_cons');
        $id_patient = $this->params()->fromPost('id_patient');
        $form = new ConsultationForm ();
        $formData = $this->getRequest()->getPost();
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
      
      
        $this->getConsultationTable()->updateConsultation($form);
        
        // Recuperer les donnees sur les bandelettes urinaires
        $bandelettes = array(
            'id_cons' => $id_cons,
            'albumine' => $this->params()->fromPost('albumine'),
            'sucre' => $this->params()->fromPost('sucre'),
            'corpscetonique' => $this->params()->fromPost('corpscetonique'),
            'croixalbumine' => $this->params()->fromPost('croixalbumine'),
            'croixsucre' => $this->params()->fromPost('croixsucre'),
            'croixcorpscetonique' => $this->params()->fromPost('croixcorpscetonique')
        );
        // mettre a jour les bandelettes urinaires
        $this->getConsultationTable()->deleteBandelette($id_cons);
        $this->getConsultationTable()->addBandelette($bandelettes);
       //var_dump('tset');exit();
        
        //$id_grossesse= $this->getGrossesseTable()->updateGrossesse($formData);
        
       // $this->getGrossesseTable()->updateAvortement($formData,$id_cons,$id_grossesse);
        //$this->getConsultationMaterniteTable()->addConsultationMaternite($id_cons,$id_grossesse);
       
        //$id_antecedent1 = $this->getAntecedentType1Table ()-> updateAntecedentType1($formData);         
        
   // $id_antecegetAntecedentType2Table ()-> updateAntecedentType2($formData);
    $this->getDonneesExamensPhysiquesTable()->updateExamenPhysique($formData);
    
   $id_acc= $this->getAccouchementTable()->updateAccouchement($formData,$id_cons); //var_dump('test');exit(); 
   //var_dump('test');exit();
   $this->getAccouchementTable()->addPrenomme($formData['prenome'],$id_acc);    
 
    // var_dump($formData['prenome']); exit();
        $enfant=$formData['nombre_enfant'];
       	$tab_bebes = $this->getNaissanceTable()->saveNaissance($formData,$id_cons,$id_patient);
       	//var_dump(count($tab_bebes));exit();
       	$this->getDevenirNouveauNeTable()->saveNouveauNe($formData, $id_cons, $tab_bebes);      	
       
        //Nouveau ne
    //var_dump('tse');exit();
      //pour les conclusion: complication et deces maternel
      $nombre_cause = $this->params()->fromPost('nb_comp');
      $nombre_causeDC = $this->params()->fromPost('nbcauseDC');
      $this->conclusionTable()->updateConclusionComp($formData, $id_cons,$nombre_cause,$id_patient);
      $this->conclusionTable()->updateConclusionDeces($formData, $id_cons,$nombre_causeDC,$id_patient);
        
        // POUR LES ANTECEDENTS ANTECEDENTS ANTECEDENTS
        // POUR LES ANTECEDENTS ANTECEDENTS ANTECEDENTS
        // POUR LES ANTECEDENTS ANTECEDENTS ANTECEDENTS
        $donneesDesAntecedents = array(
            // **=== ANTECEDENTS PERSONNELS
            // **=== ANTECEDENTS PERSONNELS
            // LES HABITUDES DE VIE DU PATIENTS
            /* Alcoolique */
            'AlcooliqueHV' => $this->params()->fromPost('AlcooliqueHV'),
            'DateDebutAlcooliqueHV' => $this->params()->fromPost('DateDebutAlcooliqueHV'),
            'DateFinAlcooliqueHV' => $this->params()->fromPost('DateFinAlcooliqueHV'),
            /*Fumeur*/
            'FumeurHV' => $this->params()->fromPost('FumeurHV'),
            'DateDebutFumeurHV' => $this->params()->fromPost('DateDebutFumeurHV'),
            'DateFinFumeurHV' => $this->params()->fromPost('DateFinFumeurHV'),
            'nbPaquetFumeurHV' => $this->params()->fromPost('nbPaquetFumeurHV'),
        		'AutresHV' => $this->params()->fromPost('AutresHV'),
        		'NoteAutresHV' => $this->params()->fromPost('NoteAutresHV'),
            /*Droguer*/
            'DroguerHV' => $this->params()->fromPost('DroguerHV'),
            'DateDebutDroguerHV' => $this->params()->fromPost('DateDebutDroguerHV'),
            'DateFinDroguerHV' => $this->params()->fromPost('DateFinDroguerHV'),

            // LES ANTECEDENTS MEDICAUX
            'DiabeteAM' => $this->params()->fromPost('DiabeteAM'),
            'htaAM' => $this->params()->fromPost('htaAM'),
            'drepanocytoseAM' => $this->params()->fromPost('drepanocytoseAM'),
            'dislipidemieAM' => $this->params()->fromPost('dislipidemieAM'),
            'asthmeAM' => $this->params()->fromPost('asthmeAM'),

            // **=== ANTECEDENTS FAMILIAUX
            'DiabeteAF' => $this->params()->fromPost('DiabeteAF'),
            'NoteDiabeteAF' => $this->params()->fromPost('NoteDiabeteAF'),
            'DrepanocytoseAF' => $this->params()->fromPost('DrepanocytoseAF'),
            'NoteDrepanocytoseAF' => $this->params()->fromPost('NoteDrepanocytoseAF'),
            'htaAF' => $this->params()->fromPost('htaAF'),
            'NoteHtaAF' => $this->params()->fromPost('NoteHtaAF'),
            'NoteAutresAF' => $this->params()->fromPost('NoteAutresAF'),
            'text_chirur' => $this->params()->fromPost('text_chirur')
            
        );
//var_dump($donneesDesAntecedents);exit();
        
        $id_personne = $this->getAntecedantPersonnelTable()->getIdPersonneParIdCons($id_cons);
        $this->getAntecedantPersonnelTable()->addAntecedentsPersonnels($donneesDesAntecedents, $id_personne, $id_medecin);
        $this->getAntecedantsFamiliauxTable()->addAntecedentsFamiliaux($donneesDesAntecedents, $id_personne, $id_medecin);

        // POUR LES RESULTATS DES EXAMENS MORPHOLOGIQUES
        // POUR LES RESULTATS DES EXAMENS MORPHOLOGIQUES
        // POUR LES RESULTATS DES EXAMENS MORPHOLOGIQUES

        $info_examen_morphologique = array(
            'id_cons' => $id_cons,
            '8' => $this->params()->fromPost('radio_'),
            '9' => $this->params()->fromPost('ecographie_'),
            '12' => $this->params()->fromPost('irm_'),
            '11' => $this->params()->fromPost('scanner_'),
            '10' => $this->params()->fromPost('fibroscopie_')
        );

        $this->getNotesExamensMorphologiquesTable()->updateNotesExamensMorphologiques($info_examen_morphologique);

        
        
        
        $info_examen_biologique = array(
        		'id_cons' => $id_cons,
        		'1' => $this->params()->fromPost('groupe_sanguin'),
        		'2' => $this->params()->fromPost('hemogramme_sanguin'),
        		'3' => $this->params()->fromPost('bilan_hemolyse'),
        		'4' => $this->params()->fromPost('bilan_hepatique'),
        		'5' => $this->params()->fromPost('bilan_renal'),
        		'6' => $this->params()->fromPost('bilan_inflammatoire')
        );
        //var_dump($info_examen_biologique);exit();
        //$this->getNotesExamensBiologiqueTable()->updateNotesExamensBiologiques($formData);
        
        // POUR LES DIAGNOSTICS
        // POUR LES DIAGNOSTICS
        // POUR LES DIAGNOSTICS
        $info_diagnostics = array(
            'id_cons' => $id_cons,
            'diagnostic1' => $this->params()->fromPost('diagnostic1'),
            'diagnostic2' => $this->params()->fromPost('diagnostic2'),
            'diagnostic3' => $this->params()->fromPost('diagnostic3'),
            'diagnostic4' => $this->params()->fromPost('diagnostic4'),
        );

        $id_diagn= $this->getDiagnosticsTable()->updateDiagnostics($info_diagnostics);
        $decision=$this->params()->fromPost('decisions');
        $this->getDiagnosticsTable()->addDecision($decision,$id_cons);
     
        // POUR LES TRAITEMENTS
        // POUR LES TRAITEMENTS
        // POUR LES TRAITEMENTS
        /**
         * ** MEDICAUX ***
         */
        /**
         * ** MEDICAUX ***
         */
        $dureeTraitement = $this->params()->fromPost('duree_traitement_ord');
        $donnees = array(
            'id_cons' => $id_cons,
            'duree_traitement' => $dureeTraitement
        );

        $Consommable = $this->getOrdonConsommableTable();
        $tab = array();
        $j = 1;

        $nomMedicament = "";
        $formeMedicament = "";
        $quantiteMedicament = "";
        for ($i = 1; $i < 10; $i++) {
            if ($this->params()->fromPost("medicament_0" . $i)) {

                $nomMedicament = $this->params()->fromPost("medicament_0" . $i);
                $formeMedicament = $this->params()->fromPost("forme_" . $i);
                $quantiteMedicament = $this->params()->fromPost("quantite_" . $i);

                if ($this->params()->fromPost("medicament_0" . $i)) {

                    $result = $Consommable->getMedicamentByName($this->params()->fromPost("medicament_0" . $i))['ID_MATERIEL'];

                    if ($result) {
                        $tab [$j++] = $result;
                        $tab [$j++] = $formeMedicament;
                        $Consommable->addFormes($formeMedicament);
                        $tab [$j++] = $this->params()->fromPost("nb_medicament_" . $i);
                        $tab [$j++] = $quantiteMedicament;
                        $Consommable->addQuantites($quantiteMedicament);
                    } else {
                        $idMedicaments = $Consommable->addMedicaments($nomMedicament);
                        $tab [$j++] = $idMedicaments;
                        $tab [$j++] = $formeMedicament;
                        $Consommable->addFormes($formeMedicament);
                        $tab [$j++] = $this->params()->fromPost("nb_medicament_" . $i);
                        $tab [$j++] = $quantiteMedicament;
                        $Consommable->addQuantites($quantiteMedicament);
                    }
                }
            }
        }

        /* Mettre a jour la duree du traitement de l'ordonnance */
        $idOrdonnance = $this->getOrdonnanceTable()->updateOrdonnance($tab, $donnees);

        /* Mettre a jour les medicaments */
        $resultat = $Consommable->updateOrdonConsommable($tab, $idOrdonnance, $nomMedicament);

        /* si aucun mï¿½dicament n'est ajoutï¿½ ($resultat = false) on supprime l'ordonnance */
        if ($resultat == false) {
            $this->getOrdonnanceTable()->deleteOrdonnance($idOrdonnance);
        }

        $infoDemande = array(
            'diagnostic' => $this->params()->fromPost("diagnostic_traitement_chirurgical"),
            'intervention_prevue' => $this->params()->fromPost("intervention_prevue"),
            'observation' => $this->params()->fromPost("observation"),
            'ID_CONS' => $id_cons
        );

        $this->getDemandeVisitePreanesthesiqueTable()->updateDemandeVisitePreanesthesique($formData);

        // POUR LES COMPTES RENDU DES TRAITEMENTS
        // POUR LES COMPTES RENDU DES TRAITEMENTS
        $note_compte_rendu1 = $this->params()->fromPost('note_compte_rendu_operatoire');
        $note_compte_rendu2 = $this->params()->fromPost('note_compte_rendu_operatoire_instrumental');

        $this->getConsultationTable()->addCompteRenduOperatoire($note_compte_rendu1, 1, $id_cons);
        $this->getConsultationTable()->addCompteRenduOperatoire($note_compte_rendu2, 2, $id_cons);
        // POUR LES RENDEZ VOUS
        // POUR LES RENDEZ VOUS
        // POUR LES RENDEZ VOUS
        $id_patient = $this->params()->fromPost('id_patient');
        $date_RV_Recu = $this->params()->fromPost('date_rv');
        if ($date_RV_Recu) {
            $date_RV = $this->controlDate->convertDateInAnglais($date_RV_Recu);
        } else {
            $date_RV = $date_RV_Recu;
        }
        $infos_rv = array(
            'ID_CONS' => $id_cons,
            'NOTE' => $this->params()->fromPost('motif_rv'),
            'HEURE' => $this->params()->fromPost('heure_rv'),
            'DATE' => $date_RV
        );
     //var_dump($infos_rv);exit();
        $this->getRvPatientConsTable()->updateRendezVous($infos_rv);

        // POUR LES TRANSFERT
        // POUR LES TRANSFERT
        // POUR LES TRANSFERT
        $info_transfert = array(
            'ID_SERVICE' => $this->params()->fromPost('id_service'),
            'ID_MEDECIN' => $this->params()->fromPost('med_id_personne'),
            'MOTIF_TRANSFERT' => $this->params()->fromPost('motif_transfert'),
            'ID_CONS' => $id_cons
        );

        $this->getTransfererPatientServiceTable()->updateTransfertPatientService($info_transfert);

        // POUR LES HOSPITALISATION
        // POUR LES HOSPITALISATION
        // POUR LES HOSPITALISATION
        $today = new \DateTime ();
        $dateAujourdhui = $today->format('Y-m-d H:i:s');
        $infoDemandeHospitalisation = array(
            'motif_demande_hospi' => $this->params()->fromPost('motif_hospitalisation'),
            'date_demande_hospi' => $dateAujourdhui,
           'date_fin_prevue_hospi' => $this->controlDate->convertDateInAnglais($this->params()->fromPost('date_fin_hospitalisation_prevue')),
            'id_cons' => $id_cons
        );

        $this->getDemandeHospitalisationTable()->saveDemandehospitalisation($infoDemandeHospitalisation);

        // POUR LA PAGE complement-accouchement
        if ($this->params()->fromPost('terminer') == 'save') {

            // VALIDER EN METTANT '1' DANS CONSPRISE Signifiant que le medecin a consulter le patient
            // Ajouter l'id du medecin ayant consulter le patient
            $valide = array(
                'VALIDER' => 1,
                'ID_CONS' => $id_cons,
                'ID_MEDECIN' => $this->params()->fromPost('med_id_personne')
            );//var_dump($valide);exit();
            $this->getConsultationTable()->validerConsultation($valide);
           
        }
        
        return $this->redirect()->toRoute('accouchement', array(
        		'action' => 'accoucher',
        ));

	}
	
	
	function imprimerCertifatAccouchementAction(){

	
		$id_patient = $this->params()->fromPost('id_patient');
		$form = new ConsultationForm ();
		$formData = $this->getRequest()->getPost();
		$form->setData($formData);
		$id_cons = $this->params()->fromPost('id_cons');
		$user = $this->layout()->user;
		$IdDuService = $user ['IdService'];
		$id_medecin = $user ['id_personne'];
		
		$user = $this->layout()->user;
		$serviceMedecin = $user ['NomService'];
		$nomMedecin = $user ['Nom'];
		$prenomMedecin = $user ['Prenom'];
		$sexeMedecin = $user ['Sexe'];
		$donneesMedecin = array(
				'nomMedecin' => $nomMedecin,
				'prenomMedecin' => $prenomMedecin,
				'sexeMedecin' => $sexeMedecin,
		);
		
//var_dump('test');exit();
		$donneesPatientOR = $this->getConsultationTable()->getInfoPatient($id_patient);
		// Rï¿½cupï¿½ration des donnï¿½es
		$donneesDemande ['prenome'] = $formData['prenome'];
		
		$donneesDemande ['heure_accouchement'] = $this->params()->fromPost('heure_accouchement');
		$donneesDemande ['date_accouchement'] = $this->params()->fromPost('date_accouchement');
		$donneesDemande ['user'] =$this->layout()->user;
		
		$donneesDemande ['viv'] = $this->params()->fromPost('sexe_1');
		$formData = $this->getRequest()->getPost();
		 
		$nb_bb=$formData['bb_attendu'];
		if($nb_bb==0){
			$nb_bb=$formData['nombre_bb'];
		}else
		{
			$nb_bb=$formData['bb_attendu'];
		}
		//var_dump($nb_bb);exit();
		$donneesDemande ['nb_bb']= $nb_bb;//var_dump($donneesDemande ['nb_bb']);exit();
		for($i=1;$i<=$nb_bb;$i++){
			$donneesDemande ['sexe_'.$i] = $this->params()->fromPost('sexe_'.$i);
			$donneesDemande ['viv_bien_portant_'.$i] = $this->params()->fromPost('viv_bien_portant_'.$i);
			$donneesDemande ['decede_'.$i] = $this->params()->fromPost('decede_'.$i);
		
		}
		
		$DocPdf = new DocumentPdf ();
		// Crï¿½er la page
		$page = new CertificatPdf();
		
		//var_dump($donneesDemande); exit();
		
		// Envoi Id de la consultation
		$page->setIdConsTC($id_cons);
		$page->setService($serviceMedecin);
		//Envoi des donnï¿½es du patient
		$page->setDonneesPatientTC($donneesPatientOR);
		//Envoi des donnï¿½es du medecin
		$page->setDonneesMedecinTC($donneesMedecin);
		//Envoi les donnï¿½es de la demande
		$page->setDonneesDemandeTC($donneesDemande);
		
		// Ajouter les donnees a la page
		$page->addNoteTC();
		// Ajouter la page au document
		$doc=$DocPdf->addPage($page->getPage());
		
		// Afficher le document contenant la page
		 
		
		$DocPdf->getDocument();
		//header('Location: public/accouchement/accoucher.phtml');
		
		
	}
    
  
    
    public function getPath(){
    	$this->path = $this->getServiceLocator()->get('Request')->getBasePath();
    	return $this->path;
    }


    public function conclusionComplicationAction()
    {
    	$id_cons = $this->params()->fromPost('id_cons');
    	$complication = $this->params()->fromPost('comp');
    	$notesComp = $this->params()->fromPost('notesComp');
    
    	$this->conclusionTable()->saveComplication($id_cons, $complication, $notesComp);
    
    	$this->getResponse()->getHeaders()->addHeaderLine('Content-Type', 'application/html');
    	return $this->getResponse()->setContent(Json::encode());
    }
   
 public function impressionPdfAction()
    {
    	 //$user =$this->layout()->setTemplate('layout/accouchement');
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
        	// Rï¿½cupï¿½ration des donnï¿½es
        	$donneesDemande ['suite_de_couches'] = $this->params()->fromPost('suite_de_couches');
         	// CREATION DU DOCUMENT PDF
        	// Crï¿½er le document
        	$DocPdf = new DocumentPdf ();//var_dump('test');exit();
        	// Crï¿½er la page
        	$page = new SuiteDeCouchePdf();
        
        	// var_dump($donneesDemande); exit();
        
        	// Envoi Id de la consultation
        	$page->setIdConsTC($id_cons);
        	$page->setService($serviceMedecin);
        	// Envoi des donnï¿½es du patient
        	$page->setDonneesPatientTC($donneesPatientOR);
        	// Envoi des donnï¿½es du medecin
        	$page->setDonneesMedecinTC($donneesMedecin);
        	// Envoi les donnï¿½es de la demande
        	$page->setDonneesDemandeTC($donneesDemande);
        
        	// Ajouter les donnees a la page
        	$page->addNoteTC();
        	// Ajouter la page au document
        	$DocPdf->addPage($page->getPage());
        
        	// Afficher le document contenant la page
        	$DocPdf->getDocument();
        } 
     
        else
        if (isset ($_POST ['observation_go'])) {
        	// Rï¿½cupï¿½ration des donnï¿½es
        	$donneesDemande ['text_observation'] = $this->params()->fromPost('text_observation');
        	// CREATION DU DOCUMENT PDF
        	// Crï¿½er le document
        	$DocPdf = new DocumentPdf ();
        	// Crï¿½er la page
        	$page = new ObservationPdf();
        
        	// var_dump($donneesDemande); exit();
        
        	// Envoi Id de la consultation
        	$page->setIdConsTC($id_cons);
        	$page->setService($serviceMedecin);
        	// Envoi des donnï¿½es du patient
        	$page->setDonneesPatientTC($donneesPatientOR);
        	// Envoi des donnï¿½es du medecin
        	$page->setDonneesMedecinTC($donneesMedecin);
        	// Envoi les donnï¿½es de la demande
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
            // rï¿½cupï¿½ration de la liste des mï¿½dicaments
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
            // Crï¿½ation du fichier pdf
            // *************************
            // Crï¿½er le document
            $DocPdf = new DocumentPdf ();
            // Crï¿½er la page
            $page = new OrdonnancePdf ();

            // Envoyer l'id_cons
            $page->setIdCons($id_cons);
            $page->setService($serviceMedecin);
            // Envoyer les donnï¿½es sur le partient
            $page->setDonneesPatient($donneesPatientOR);
            // Envoyer les mï¿½dicaments
            $page->setMedicaments($tab);

            // Ajouter une note ï¿½ la page
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
                // Rï¿½cupï¿½ration des donnï¿½es
                $donneesDemande ['diagnostic'] = $this->params()->fromPost('diagnostic_traitement_chirurgical');
                $donneesDemande ['intervention_prevue'] = $this->params()->fromPost('intervention_prevue');
                $donneesDemande ['observation'] = $this->params()->fromPost('observation');

                // CREATION DU DOCUMENT PDF
                // Crï¿½er le document
                $DocPdf = new DocumentPdf ();
                // Crï¿½er la page
                $page = new TraitementChirurgicalPdf ();

                // Envoi Id de la consultation
                $page->setIdConsTC($id_cons);
                $page->setService($serviceMedecin);
                // Envoi des donnï¿½es du patient
                $page->setDonneesPatientTC($donneesPatientOR);
                // Envoi des donnï¿½es du medecin
                $page->setDonneesMedecinTC($donneesMedecin);
                // Envoi les donnï¿½es de la demande
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
                    // Rï¿½cupï¿½ration des donnï¿½es
                    $donneesDemande ['diagnostic'] = $this->params()->fromPost('diagnostic_traitement_chirurgical');
                    $donneesDemande ['intervention_prevue'] = $this->params()->fromPost('intervention_prevue');
                    $donneesDemande ['observation'] = $this->params()->fromPost('observation');
                    $donneesDemande ['note_compte_rendu_operatoire'] = $this->params()->fromPost('note_compte_rendu_operatoire');
                    $donneesDemande ['resultatNumeroVPA'] = $this->params()->fromPost('resultatNumeroVPA');
                    $donneesDemande ['resultatTypeIntervention'] = $this->params()->fromPost('resultatTypeIntervention');

                    // CREATION DU DOCUMENT PDF
                    // Crï¿½er le document
                    $DocPdf = new DocumentPdf ();
                    // Crï¿½er la page
                    $page = new ProtocoleOperatoirePdf ();

                    // var_dump($donneesDemande); exit();

                    // Envoi Id de la consultation
                    $page->setIdConsTC($id_cons);
                    $page->setService($serviceMedecin);
                    // Envoi des donnï¿½es du patient
                    $page->setDonneesPatientTC($donneesPatientOR);
                    // Envoi des donnï¿½es du medecin
                    $page->setDonneesMedecinTC($donneesMedecin);
                    // Envoi les donnï¿½es de la demande
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

                        // Rï¿½cupï¿½rer le nom du service d'accueil
                       $service = $this->getServiceTable();
                       //var_dump($id_service);exit();
                       $infoService =$service->getServiceParNom($serviceMedecin);
                      // var_dump($infoService);exit();
                        // Rï¿½cupï¿½rer le nom de l'hopital d'accueil
                        $hopital = $this->getHopitalTable();
                       
                        $infoHopital = $hopital->getHopitalParId($id_hopital);

                        $donneesDemandeT ['NomService'] = $infoService ['NOM'];
                      
                        $donneesDemandeT ['NomHopital'] = $infoHopital ['NOM_HOPITAL'];
                        $donneesDemandeT ['MotifTransfert'] = $motif_transfert;

                        // -***************************************************************
                        // Crï¿½ation du fichier pdf
                        // -***************************************************************
                        // Crï¿½er le document
                        $DocPdf = new DocumentPdf ();
                        // Crï¿½er la page
                        $page = new TransfertPdf ();
                       
                        // Envoi Id de la consultation
                        $page->setIdConsT($id_cons);
                        $page->setService($serviceMedecin);
                        // Envoi des donnï¿½es du patient
                        $page->setDonneesPatientT($donneesPatientOR);
                        // Envoi des donnï¿½es du medecin
                        $page->setDonneesMedecinT($donneesMedecin);
                        // Envoi les donnï¿½es de la demande
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

                            // Crï¿½ation du fichier pdf
                            // Crï¿½er le document
                            $DocPdf = new DocumentPdf ();
                            // Crï¿½er la page
                            $page = new RendezVousPdf ();

                            // Envoi Id de la consultation
                            $page->setIdConsR($id_cons);
                            $page->setService($serviceMedecin);
                            // Envoi des donnï¿½es du patient
                            $page->setDonneesPatientR($donneesPatientOR);
                            // Envoi des donnï¿½es du medecin
                            $page->setDonneesMedecinR($donneesMedecin);
                            // Envoi les donnï¿½es du redez vous
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
                                // Rï¿½cupï¿½ration des donnï¿½es
                                $donneesTraitementChirurgical ['endoscopieInterventionnelle'] = $this->params()->fromPost('endoscopieInterventionnelle');
                                $donneesTraitementChirurgical ['radiologieInterventionnelle'] = $this->params()->fromPost('radiologieInterventionnelle');
                                $donneesTraitementChirurgical ['cardiologieInterventionnelle'] = $this->params()->fromPost('cardiologieInterventionnelle');
                                $donneesTraitementChirurgical ['autresIntervention'] = $this->params()->fromPost('autresIntervention');

                                // CREATION DU DOCUMENT PDF
                                // Crï¿½er le document
                                $DocPdf = new DocumentPdf ();
                                // Crï¿½er la page
                                $page = new TraitementInstrumentalPdf ();

                                // Envoi Id de la consultation
                                $page->setIdConsTC($id_cons);
                                $page->setService($serviceMedecin);
                                // Envoi des donnï¿½es du patient
                                $page->setDonneesPatientTC($donneesPatientOR);
                                // Envoi des donnï¿½es du medecin
                                $page->setDonneesMedecinTC($donneesMedecin);
                                // Envoi les donnï¿½es de la demande
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
                                    // Rï¿½cupï¿½ration des donnï¿½es
                                    $donneesHospitalisation ['motif_hospitalisation'] = $this->params()->fromPost('motif_hospitalisation');
                                    $donneesHospitalisation ['date_fin_hospitalisation_prevue'] = $this->params()->fromPost('date_fin_hospitalisation_prevue');

                                    // CREATION DU DOCUMENT PDF
                                    // Crï¿½er le document
                                    $DocPdf = new DocumentPdf ();
                                    // Crï¿½er la page
                                    $page = new HospitalisationPdf ();
                                    // Envoi Id de la consultation
                                    $page->setIdConsH($id_cons);
                                    $page->setService($serviceMedecin);
                                    // Envoi des donnï¿½es du patient
                                    $page->setDonneesPatientH($donneesPatientOR);
                                    // Envoi des donnï¿½es du medecin
                                    $page->setDonneesMedecinH($donneesMedecin);
                                    // Envoi les donnï¿½es de la demande
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
                                        // Rï¿½cupï¿½ration des donnï¿½es examens biologiques
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
                                        // Rï¿½cupï¿½ration des donnï¿½es examens morphologiques
                                        for (; $k <= 11; $k++) {
                                            if ($this->params()->fromPost('element_name_' . $k)) {
                                                $donneesExamensMorph [$l] = $this->params()->fromPost('element_name_' . $k);
                                                $notesExamensMorph [$l++] = $this->params()->fromPost('note_' . $k);
                                            }
                                        }

                                        // CREATION DU DOCUMENT PDF
                                        // Crï¿½er le document
                                        $DocPdf = new DocumentPdf ();
                                        // Crï¿½er la page
                                        $page = new DemandeExamenPdf ();
                                        // Envoi Id de la consultation
                                        $page->setIdConsBio($id_cons);
                                        $page->setService($serviceMedecin);
                                        // Envoi des donnï¿½es du patient
                                        $page->setDonneesPatientBio($donneesPatientOR);
                                        // Envoi des donnï¿½es du medecin
                                        $page->setDonneesMedecinBio($donneesMedecin);
                                        // Envoi les donnï¿½es de la demande
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
    
  
public function getStatistiqueSurveillanceAccouchementAction (){
	$date_debut = $this->params()->fromPost ('date_debut');
	$date_fin   = $this->params()->fromPost ('date_fin');
	$cibler=$this->params()->fromPost ('cibler');
	$sexe=$this->params()->fromPost ('sexe');
	$naissance=$this->params()->fromPost ('naissance');
		$control = new DateHelper();
	$infoPeriodeRapport ="Rapport du ".$control->convertDate($date_debut)." au ".$control->convertDate($date_fin);
	if ($cibler==1 ){
		if(($sexe==1)&& ($naissance==1) ){
			$simplepre=$this->getGrossesseTable()->getNbNaissanePrematureMascSimpleEutocique($date_debut,$date_fin);
			$simpleter=$this->getGrossesseTable()->getNbNaissanePrematureMascSimpleEutocique($date_debut, $date_fin);
			$doublepre=$this->getGrossesseTable()->getNbNaissanePrematureMascDoubleEutocique($date_debut, $date_fin);
			$doubleter=$this->getGrossesseTable()->getNbNaissaneTermMascDoubleEutocique($date_debut, $date_fin);
			$triplepre=$this->getGrossesseTable()->getNbNaissanePrematureMascTriplePlusEutocique($date_debut, $date_fin);
			$tripleter=$this->getGrossesseTable()->getNbNaissaneTermMascTriplePlusEutocique($date_debut, $date_fin);
			 
			 $html ='<table class="table table-bordered tab_list_mini" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
			
				<tr style="width: 60%; height: 40px; font-family: police2;">
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">Nature Naissance</th>
				
		  <th  style="width: 5%;  font-weight: bold; font-size: 15px; ">Nbre</th>
			
		<th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Terme</th>
		 <th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Premature</th>
						</tr>
			
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Simple </th>
								<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >10
		                </td>
										<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$simpleter.'
		                </td>
							
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$simplepre.'
		                </td>
							
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Double </th>
													<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >10
		                </td>
										<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$doubleter.'
		                </td>
							
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$doublepre.'
		                </td>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Triple et plus </th>
																	<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >10
		                </td>
										<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$tripleter.'
		                </td>
							
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$triplepre.'
		                </td>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Total </th>
						</tr>
			
			
						<table>';
		} else if(($sexe==1)&& ($naissance==2) ){
			$html ='<table class="table table-bordered tab_list_mini" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
		
				<tr style="width: 60%; height: 40px; font-family: police2;">
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">Nature Naissance</th>
			
		  <th  style="width: 5%;  font-weight: bold; font-size: 15px; ">Nbre</th>
		
		
		<th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Terme</th>
		 <th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Premature</th>
						</tr>
		
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Simple </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Double </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Triple et plus </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Total </th>
						</tr>
		
		
						<table>';
			
		}else if(($sexe==2) && ($naissance==1) ){
			$simpleterF=$this->getGrossesseTable()->getNbNaissaneTermFemSimpleEutocique($date_debut, $date_fin);
			$simplepreF=$this->getGrossesseTable()->getNbNaissanePrematureFemSimpleEutocique($date_debut, $date_fin);
			$doupleterF=$this->getGrossesseTable()->getNbNaissaneTermFemDoubleEutocique($date_debut, $date_fin);
			$doublepreF=$this->getGrossesseTable()->getNbNaissanePrematureFemDoubleEutocique($date_debut, $date_fin);
			$tripleterF=$this->getGrossesseTable()->getNbNaissaneTermFemTriplePlusEutocique($date_debut, $date_fin);
			$triplepreF=$this->getGrossesseTable()->getNbNaissanePrematureFemTriplePlusEutocique($date_debut, $date_fin);
			$html ='<table class="table table-bordered tab_list_mini" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
			
				<tr style="width: 60%; height: 40px; font-family: police2;">
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">Nature Naissance</th>
		
		  <th  style="width: 5%;  font-weight: bold; font-size: 15px; ">Nbre</th>
			
			
		<th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Terme</th>
		 <th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Premature</th>
						</tr>
			
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Simple </th>
										<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >10
		                </td>
										<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$simpleterF.'
		                </td>
							
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$simplepreF.'
		                </td>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Double </th>
											<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >10
		                </td>
										<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$doupleterF.'
		                </td>
							
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$doublepreF.'
		                </td>
					
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Triple et plus </th>
																<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >10
		                </td>
										<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$tripleterF.'
		                </td>
							
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$triplepreF.'
		                </td>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Total </th>
						</tr>
			
			
						<table>';
		

		}else if(($sexe==2) && ($naissance==2) ){
			$html ='<table class="table table-bordered tab_list_mini" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
		
				<tr style="width: 60%; height: 40px; font-family: police2;">
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">Nature Naissance</th>
		
		  <th  style="width: 5%;  font-weight: bold; font-size: 15px; ">Nbre</th>
		
		
		<th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Terme</th>
		 <th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Premature</th>
						</tr>
		
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Simple </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Double </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Triple et plus </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Total </th>
						</tr>
		
		
						<table>';
		}
	
	
				
	}
	else if($cibler==2){
		if(($sexe==1)&& ($naissance==1) ){
			$html ='<table class="table table-bordered tab_list_mini" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
			
				<tr style="width: 60%; height: 40px; font-family: police2;">
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">Nature Naissance</th>
				
		  <th  style="width: 5%;  font-weight: bold; font-size: 15px; ">Nbre</th>
			
			
		<th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Terme</th>
		 <th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Premature</th>
						</tr>
			
			
			
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Simple </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Double </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Triple et plus </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Total </th>
						</tr>
			
			
						<table>';
		} else if(($sexe==1)&& ($naissance==2) ){
			$html ='<table class="table table-bordered tab_list_mini" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
		
				<tr style="width: 60%; height: 40px; font-family: police2;">
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">Nature Naissance</th>
			
		  <th  style="width: 5%;  font-weight: bold; font-size: 15px; ">Nbre</th>
		
		
		<th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Terme</th>
		 <th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Premature</th>
						</tr>
		
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Simple </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Double </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Triple et plus </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Total </th>
						</tr>
		
		
						<table>';
			
		}else if(($sexe==2) && ($naissance==1) ){
			$html ='<table class="table table-bordered tab_list_mini" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
			
				<tr style="width: 60%; height: 40px; font-family: police2;">
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">Nature Naissance</th>
		
		  <th  style="width: 5%;  font-weight: bold; font-size: 15px; ">Nbre</th>
			
			
		<th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Terme</th>
		 <th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Premature</th>
						</tr>
			
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Simple </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Double </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Triple et plus </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Total </th>
						</tr>
			
			
						<table>';
		

		}else if(($sexe==2) && ($naissance==2) ){
			$html ='<table class="table table-bordered tab_list_mini" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
		
				<tr style="width: 60%; height: 40px; font-family: police2;">
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">Nature Naissance</th>
		
		  <th  style="width: 5%;  font-weight: bold; font-size: 15px; ">Nbre</th>
		
		
		<th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Terme</th>
		 <th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Premature</th>
						</tr>
		
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Simple </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Double </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Triple et plus </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Total </th>
						</tr>
		
		
						<table>';
			
	}
	}else if($cibler==3){
		if(($sexe==1)&& ($naissance==1) ){
			$html ='<table class="table table-bordered tab_list_mini" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
			
				<tr style="width: 60%; height: 40px; font-family: police2;">
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">Nature Naissance</th>
				
		  <th  style="width: 5%;  font-weight: bold; font-size: 15px; ">Nbre</th>
			
			
		<th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Terme</th>
		 <th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Premature</th>
						</tr>
			
			
			
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Simple </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Double </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Triple et plus </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Total </th>
						</tr>
			
			
						<table>';
		} else if(($sexe==1)&& ($naissance==2) ){
			$html ='<table class="table table-bordered tab_list_mini" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
		
				<tr style="width: 60%; height: 40px; font-family: police2;">
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">Nature Naissance</th>
			
		  <th  style="width: 5%;  font-weight: bold; font-size: 15px; ">Nbre</th>
		
		
		<th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Terme</th>
		 <th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Premature</th>
						</tr>
		
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Simple </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Double </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Triple et plus </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Total </th>
						</tr>
		
		
						<table>';
			
		}else if(($sexe==2) && ($naissance==1) ){
			$html ='<table class="table table-bordered tab_list_mini" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
			
				<tr style="width: 60%; height: 40px; font-family: police2;">
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">Nature Naissance</th>
		
		  <th  style="width: 5%;  font-weight: bold; font-size: 15px; ">Nbre</th>
			
			
		<th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Terme</th>
		 <th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Premature</th>
						</tr>
			
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Simple </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Double </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Triple et plus </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Total </th>
						</tr>
			
			
						<table>';
		

		}else if(($sexe==2) && ($naissance==2) ){
			$html ='<table class="table table-bordered tab_list_mini" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
		
				<tr style="width: 60%; height: 40px; font-family: police2;">
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">Nature Naissance</th>
		
		  <th  style="width: 5%;  font-weight: bold; font-size: 15px; ">Nbre</th>
		
		
		<th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Terme</th>
		 <th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Premature</th>
						</tr>
		
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Simple </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Double </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Triple et plus </th>
						</tr>
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Total </th>
						</tr>
		
		
						<table>';
		}
	
	
				
	}
	
	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
	return $this->getResponse ()->setContent ( Json::encode (array($html,$infoPeriodeRapport) ));
	
} 
public function getStatistiqueMaternelAction(){
	$date_debut = $this->params()->fromPost ('date_debut');
	$date_fin   = $this->params()->fromPost ('date_fin');
	$control = new DateHelper();
	$infoPeriodeRapport ="Rapport du ".$control->convertDate($date_debut)." au ".$control->convertDate($date_fin);
    /* $post=$this->getAccouchementTable()->getNbhrp($date_debut,$date_fin);
    $ant=$this->getAccouchementTable()->getNbDecesMaternelAntePartum($date_debut, $date_fin);
    $dystocie=$this->getAccouchementTable()->getNbDystocie($date_debut, $date_fin);
    $hyper=$this->getAccouchementTable()->getNbDecesMaternelHypertension($date_debut, $date_fin);
    $inf=$this->getAccouchementTable()->getNbDecesMaternelInfection($date_debut, $date_fin);
    $direct=$this->getAccouchementTable()->getNbDecesMaternelDirect($date_debut, $date_fin);
    $indirect=$this->getAccouchementTable()->getNbDecesMaternelIndirect($date_debut, $date_fin);
    $indeterminer=$this->getAccouchementTable()->getNbDecesMaternelIndtermine($date_debut, $date_fin);
     */
    $html1="<script> $('#nbHemoregiejax').html(5);</script>";
    $html2="<script> $('#nbHemoregie1jax').html(6);</script>";
    $html3="<script> $('#DystocieAjax').html(2);</script>";
    $html4="<script> $('#HypertensionAjax').html(5);</script>";
    $html5="<script> $('#InfectionAjax').html(2);</script>";
    $html6="<script> $('#DirectAjax').html(0);</script>";
    $html7="<script> $('#indirectAjax').html(1);</script>";
    $html8="<script> $('#indetermine').html(3);</script>";
    $html9  ="<script>";
			
		$html9 .= "
		
				    	$(document).ready(function($) {
				    		var chart = new CanvasJS.Chart('patientConsulteMaternel', {
				  
				    			data: [{
				    				type: 'pie',
				    				dataPoints: [
		
				    				{ y: 5, label: 'Hemorragie Post-Partum' },
				    				{ y: 6, label: 'Hemorragie ante-Partum' },
				    				{ y: 2, label: 'Dystocie' },
				    				{ y: 5, label: 'Hypertension' },
				    				{ y: 2, label: 'Infection' },
				    				{ y: 0, label: 'Cause Directe' },
				    				{ y: 1, label: 'Cause Indirecte' },
				    				{ y: 3, label: 'Indetermine' },
				    				]
				    			}]
				    		});
		
				    		chart.render();
				    });";
		$html9 .="</script> ";

	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
	return $this->getResponse ()->setContent ( Json::encode (array($infoPeriodeRapport,$html1,$html2,$html3,$html4,$html5,$html6,$html7,$html8,$html9)) );

}
public function getStatistiquePathologieAction(){
	$date_debut = $this->params()->fromPost ('date_debut');
	$date_fin   = $this->params()->fromPost ('date_fin');
	$control = new DateHelper();
	$infoPeriodeRapport ="Rapport du ".$control->convertDate($date_debut)." au ".$control->convertDate($date_fin);
		
/* 	    $hrp=$this->getAccouchementTable()->getNbhrp($date_debut,$date_fin);
		$hpp=$this->getAccouchementTable()->getNbhpp($date_debut, $date_fin);
		$anemie=$this->getAccouchementTable()->getNbanemie($date_debut, $date_fin);
		$fistules=$this->getAccouchementTable()->getNbFistules($date_debut, $date_fin);
		$paludisme=$this->getAccouchementTable()->getNbPaludisme($date_debut, $date_fin);
		$ru=$this->getAccouchementTable()->getNbRU($date_debut,$date_fin);
		$eclapsie=$this->getAccouchementTable()->getNbEclapsie($date_debut, $date_fin);
		$dystocie=$this->getAccouchementTable()->getNbDystocie($date_debut, $date_fin);
		 */
		$html1="<script> $('#nbHRPAjax').html(10);</script>";
		$html2="<script> $('#nbHPPAjax').html(20);</script>";
		$html3="<script> $('#nbAnemieAjax').html(40);</script>";
		$html4="<script> $('#nbFistulesAjax').html(5);</script>";
		$html5="<script> $('#nbPaludismeAjax').html(15);</script>";
		$html6="<script> $('#nbARuAjax').html(10);</script>";
		$html7="<script> $('#nbEclapsieAjax').html(5);</script>";
		$html8="<script> $('#nbDystocieAjax').html(9);</script>";
		
		$html9  ="<script>";
			
		$html9 .= "
		
				    	$(document).ready(function($) {
				    		var chart = new CanvasJS.Chart('patientConsulte', {
				  
				    			data: [{
				    				type: 'pie',
				    				dataPoints: [
		
				    				{ y: 10, label: 'HRP' },
				    				{ y: 20, label: 'HPP' },
				    				{ y: 40, label: 'Anemie' },
				    				{ y: 5, label: 'Fistules' },
				    				{ y: 15, label: 'Paludisme' },
				    				{ y: 10, label: 'Revision Uterine' },
				    				{ y: 5, label: 'Eclapsie' },
				    				{ y: 9, label: 'Dystocie' },
				    				]
				    			}]
				    		});
		
				    		chart.render();
				    });";
		$html9 .="</script> ";
		
		
	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
	return $this->getResponse ()->setContent ( Json::encode (array($infoPeriodeRapport,$html1,$html2,$html3,$html4,$html5,$html6,$html7,$html8,$html9)) );

}
public function getStatistiqueSurveillanceGrossesseAction(){
	$date_debut = $this->params()->fromPost ('date_debut');
	$date_fin   = $this->params()->fromPost ('date_fin');
	$surveillance=$this->params()->fromPost ('surveillance');
	
	$control = new DateHelper();
	$infoPeriodeRapport ="Rapport du ".$control->convertDate($date_debut)." au ".$control->convertDate($date_fin);
	
	if($surveillance == 3){
		$cpn1=$this->getGrossesseTable()->getCPN3($date_debut,$date_fin);
		$html ='<table class="table table-bordered" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
			         <tr style="width: 80%; height: 40px; font-family: police2;">
                                    <th style="width: 60%;  font-weight: bold; font-size: 15px; ">INTITULEES</th>
                                    <th style="width: 20%; font-weight: bold; font-size: 15px; text-align: left;">NOMBRE</th>
                                  </tr>
			     
	
	     
		               		<tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de femme presentant une MAS </td>
                                 						             
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;">'.$cpn1.'</td>
		                        </tr>
		               		<tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de femme enceinte presentant une MAM </td>
                                 						             
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" >'.$cpn1.' 
		                </td>
		                        </tr>
		                            <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de femme enceinte presentant une anemie </td>
                                 						             
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" >'.$cpn1.' 
		                </td>
		                        </tr>
		                            <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de femme enceinte ayant recu une prescription de fer </td>
                                 						             
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" > 
		                </td>
		                        </tr>
		                            <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de femme enceinte ayant recu une prescription de MILDA </td>
                                 						             
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" > 
		                </td>
		                        </tr>
		                          <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de femme enceinte ayant recu un conceling SIDA</td>
                                 						             
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" > 
		                </td>
		                        </tr>
		                             <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de femme enceinte ayant accepe le depistage VIH </td>
                                 						             
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" > 
			            
		                </td>
		                        </tr>
		                                <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de femme enceinte depistee </td>
                                 						             
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;"> 
		                </td>
		                        </tr>
		                       
		                        <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de femme supplementees en fer </td>
                                 						             
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" > 
		                </td>
		                        </tr>
		               		</table>';
		
	
	}else if($surveillance == 1){
		$vat1=$this->getGrossesseTable()->getnbVAT1($date_debut, $date_fin);
		$vat2=$this->getGrossesseTable()->getnbVAT2($date_debut, $date_fin);
		$vat3=$this->getGrossesseTable()->getnbVAT3($date_debut, $date_fin);
		$vat4=$this->getGrossesseTable()->getnbVAT4($date_debut, $date_fin);
		$vat5=$this->getGrossesseTable()->getnbVAT5($date_debut, $date_fin);
		$tpi1=$this->getGrossesseTable()->getnbTPI1($date_debut, $date_fin);
		$tpi2=$this->getGrossesseTable()->getnbTPI2($date_debut, $date_fin);
		$tpi3=$this->getGrossesseTable()->getnbTPI3($date_debut, $date_fin);
		$tpi4=$this->getGrossesseTable()->getnbTPI4($date_debut, $date_fin);
		$vatTotal=$vat1+$vat2+$vat3+$vat4+$vat5;
		$totalTPI=$tpi1+$tpi2+$tpi3+$tpi4;
		
		$html ='<table class="table table-bordered" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
                 <caption>VACCIN</caption>
				<tr style="width: 80%; height: 40px; font-family: police2;">
                                    <th style="width: 60%;  font-weight: bold; font-size: 15px; ">NATURE VACCIN</th>
                                    <th style="width: 20%; font-weight: bold; font-size: 15px; text-align: left;">NOMBRE</th>
				
				</tr>
		
		
		
		               		<tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de VAT1 </td>
		
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;">'.$vat1.'</td>
		                        </tr>
		               		<tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de VAT2 </td>
		
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" >'.$vat2.'
		                </td>
		                        </tr>
		                            <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de VAT3 </td>
		
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" >'.$vat3.'
		                </td>
		                        </tr>
		                            <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de VAT4 </td>
		
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" >'.$vat4.'
		                </td>
		                        </tr>
		                            <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de VAT5 </td>
		
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" >'.$vat5.'
		                </td>
		                        </tr>
		                          <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre Totalde VAT</td>
		
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" >'.$vatTotal.'</td>
		               		</tr>
		               		  <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de TPI1 </td>
		
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" >'.$tpi1.'
		                </td>
		                        </tr>
		               		  <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de TPI2 </td>
		
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" >'.$tpi2.'
		                </td>
		                        </tr>
		               				  <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de TPI3 </td>
		
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" >'.$tpi3.'
		                </td>
		                        </tr>
		               				  <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre de TPI24</td>
		
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" >'.$tpi4.'
		                </td>
		                        </tr>
		               				  <tr style="width: 80%; height: 40px; font-family: police2;">
	                          <td style="width: 3%; border: 2px solid #cccccc; padding-left: 10px;">Nombre Total de TPI </td>
		
		               <td style="width: 33%; border: 2px solid #cccccc; padding-left: 10px;" >'.$totalTPI.'
		                </td>
		                        </tr>
		                
		                      		               		</table>';
		
/* 		 $html1  ="<script>";
			
		$html1 .= "
		
				    	$(document).ready(function($) {
				    		var chart = new CanvasJS.Chart('vaccin', {
						
				    			data: [{
				    				type: 'pie',
				    				dataPoints: [
		
				    				{ y: ".$vat1.", label: 'VAT1' },
				    				{ y: ".$vat2.", label: 'VAT2' },
				    				{ y: ".$vat3.", label: 'VAT3' },
				    				{ y: ".$vat4.", label: 'VAT4' },
				    				{ y: ".$vat5.", label: 'VAT5' },
				    						
				    						
				  
				    				]
				    			}]
				    		});
		
				    		chart.render();
				    });";
		$html1 .="</script> "; */
				 
				}else if($surveillance == 4){
					$vat1=$this->getGrossesseTable()->getnbVAT1($date_debut, $date_fin);
					$cpn1Pri=$this->getGrossesseTable()->getCPN1Primipare($date_debut, $date_fin);	
					$cpn2Pri=$this->getGrossesseTable()->getCPN2Primipare($date_debut, $date_fin);
					$cpn3Pri=$this->getGrossesseTable()->getCPN3Primipare($date_debut, $date_fin);
					$cpn4Pri=$this->getGrossesseTable()->getCPN4Primipare($date_debut, $date_fin);
					$cpn5Pri=$this->getGrossesseTable()->getCPNSup4Primipare($date_debut, $date_fin);
					$cpn1Multi=$this->getGrossesseTable()->getCPN1Multipare($date_debut, $date_fin);
					$cpn2Multi=$this->getGrossesseTable()->getCPN2Multipare($date_debut, $date_fin);
					$cpn3Multi=$this->getGrossesseTable()->getCPN3Multipare($date_debut, $date_fin);
					$cpn4Multi=$this->getGrossesseTable()->getCPN4Multipare($date_debut, $date_fin);
					$cpn5Multi=$this->getGrossesseTable()->getCPNSup4Multipare($date_debut, $date_fin);
					$total1= $cpn1Pri+ $cpn1Multi;
					$total2= $cpn2Pri+ $cpn2Multi;
					$total3= $cpn3Pri+ $cpn3Multi;
					$total4= $cpn4Pri+ $cpn4Multi;
					$total5= $cpn5Pri+ $cpn5Multi;
						
					$html ='<table class="table table-bordered tab_list_mini" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
					
				<tr style="width: 80%; height: 40px; font-family: police2;">
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">Cibles</th>
							
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">CPN1</th>
		<th  style="width: 20%;  font-weight: bold; font-size: 15px; ">CPN2</th>
		 <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">CPN3</th>
		 <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">CPN4</th>
		 <th style="width: 20%;  font-weight: bold; font-size: 15px; ">Plus4</th>
	
	</tr>
		
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Primipares </th>
							<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$cpn1Pri.'
		                </td>
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$cpn2Pri.'
		                </td>
								<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$cpn3Pri.'
		                </td>
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$cpn4Pri.'
		                </td>
							<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$cpn5Pri.'
		                </td>
				                        </tr>
							<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Multipares </th>
							<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$cpn1Multi.'
		                </td>
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$cpn2Multi.'
		                </td>
								<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$cpn3Multi.'
		                </td>
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$cpn4Multi.'
		                </td>
							<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$cpn5Multi.'
		                </td>
						      </tr>
							<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Total </th>
										<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$total1.'
		                </td>
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$total2.'
		                </td>
								<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$total3.'
		                </td>
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$total4.'
		                </td>
							<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$total5.'
		                </td>
						      </tr>
					</table>';
				}	else if($surveillance == 5){
						$vat1=$this->getGrossesseTable()->getnbVAT1($date_debut, $date_fin);
						$total1=$vat1+$vat1;
						$total2=$vat1+$vat1;
						$total3=$vat1+$vat1;
						
				
					$html ='<table class="table table-bordered tab_list_mini" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
					
				<tr style="width: 80%; height: 40px; font-family: police2;">
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">Cibles</th>
							
		  <th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Simple</th>
		<th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Double</th>
		 <th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Total</th>
	
	</tr>
		
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Primipares </th>
							<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$vat1.'
		                </td>
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$vat1.'
		                </td>
								<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$vat1.'
		                </td>
						
				                        </tr>
							<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Multipares </th>
							<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$vat1.'
		                </td>
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$vat1.'
		                </td>
								<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$vat1.'
		                </td>
						
						      </tr>
							<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Total </th>
											<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$total1.'
		                </td>
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$total2.'
		                </td>
								<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$total3.'
		                </td>
						      </tr>
					</table>';
					
					
				}
				else if($surveillance == 2){
					$vat1=$this->getGrossesseTable()->getnbVAT1($date_debut, $date_fin);
					$PrimPatho=$this->getGrossesseTable()->getPrimiparePatho($date_debut, $date_fin);
					$PrimRisque=$this->getAntecedentType1Table()->getPrimipareRisque($date_debut, $date_fin);
				    $MultiPatho=$this->getGrossesseTable()->getMultiparePatho($date_debut, $date_fin);
				    $MultiRisque=$this->getGrossesseTable()->getMultipareRisque($date_debut, $date_fin);
				    $total1= $PrimPatho + $MultiPatho;
				    $total2= $PrimRisque + $MultiRisque;
				   
					$html ='<table class="table table-bordered tab_list_mini" style="width: 80%; height: 36px; border: 1px solid #cccccc;">  <thead style="width: 80%;">
			
				<tr style="width: 80%; height: 40px; font-family: police2;">
		  <th  style="width: 20%;  font-weight: bold; font-size: 15px; ">Cibles</th>
				
		  <th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Patho</th>
		<th  style="width: 30%;  font-weight: bold; font-size: 15px; ">Risque</th>
				
	</tr>
				
						<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Primipares </th>
							<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$PrimPatho.'
		                </td>
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$PrimRisque.'
		                </td>
							
				
				                        </tr>
							<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Multipares </th>
							
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$MultiPatho.'
		                </td>
								<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$MultiRisque.'
		                </td>
				
						      </tr>
							<tr style="width: 80%; height: 40px; font-family: police2;">
							 <th  style="width: 20%;  font-weight: bold; font-size: 15px;">Total </th>
										
									<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$total1.'
		                </td>
								<td style="width: 20%; border: 2px solid #cccccc; padding-left: 10px;" >'.$total2.'
		                </td>
						      </tr>
					</table>';
						
						
				}
				
				
							
	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
	return $this->getResponse ()->setContent ( Json::encode (array($html,$infoPeriodeRapport)) );
	
	
	
}
  public function getStatistiquesParPeriodeAction(){

  	$date_debut = $this->params()->fromPost ('date_debut');
  	$date_fin   = $this->params()->fromPost ('date_fin');
  	$control = new DateHelper();
  	$infoPeriodeRapport ="Rapport du ".$control->convertDate($date_debut)." au ".$control->convertDate($date_fin);
  	 $nbPatientAccou  = $this->getAccouchementTable()->getNbPatientsAcc($date_debut,$date_fin);
  	$nbPatientAccCes  =  $this->getAccouchementTable()->getNbPatientsAccCes($date_debut,$date_fin);
  	$nbPatientAccN  = $this->getAccouchementTable()->getNbPatientsAccN($date_debut,$date_fin);
  	$nbPatientAccF = $this->getAccouchementTable()->getNbPatientsAccF($date_debut,$date_fin);
  	$nbcri=$this->getNaissanceTable()->getNbEnfantNonCrier($date_debut,$date_fin);
  	$nbinf=$this->getNaissanceTable()->getNbEnfantPoidsInferieur($date_debut,$date_fin);
  	//$enfviant=count($this->getNaissanceTable()->getEnf($date_debut,$date_fin));
  	$nbPatientAccV = $this->getAccouchementTable()->getNbPatientsAccV($date_debut,$date_fin);
  	$nbPatientAccM = $this->getAccouchementTable()->getNbPatientsAccM($date_debut,$date_fin);
  	$nbGatPa = $this->getAccouchementTable()->getNbPatientsAccGatPa($date_debut,$date_fin);
  	 
  	$decede=$this->getDevenirNouveauNeTable()->getNbMortNe($date_debut,$date_fin);
  	$reanimer=$this->getNaissanceTable()->getNbEnfantReanime($date_debut,$date_fin); 
  	
  	$html1="<script> $('#nbAccouchementTotalAjax').html(".$nbPatientAccou.");</script>";
  	$html2="<script> $('#nbAccouchementCesarienneAjax').html(".$nbPatientAccCes.");</script>";
  	$html3="<script> $('#nbAccouchementNormalAjax').html(".$nbPatientAccN.");</script>";
  	$html4="<script> $('#nbAccouchementForcepsAjax').html(".$nbPatientAccF.");</script>";
  	$html5="<script> $('#nbAccouchementVentouseAjax').html(".$nbPatientAccV.");</script>";
  	$html6="<script> $('#nbAccouchementManoeuvreAjax').html(".$nbPatientAccM.");</script>";
  	$html7="<script> $('#nbBebeNotCriAjax').html(".$nbcri.");</script>";
  	$html8="<script> $('#nbBebePoidInfAjax').html(".$nbinf.");</script>";
  	//$html9="<script> $('#nbBebeVivantsAjax').html(".$enfviant.");</script>";
  	//$html10="<script> $('#nbBebeVivantsAjax').html(".$enfviant.");</script>";
  	$html11="<script> $('#nbBebeReanimesAjax').html(".$reanimer.");</script>";
  	$html12="<script> $('#nbMortNesAjax').html(".$decede.");</script>";
  
  	
  	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
  	return $this->getResponse ()->setContent ( Json::encode (array($infoPeriodeRapport,$html1,$html2,$html3,$html4,$html5,$html6,$html7,$html8,$html11,$html12)) );
  	}
  	
 
   
  public function statistiqueAction(){
  	$this->getDateHelper();
  	//var_dump($this);exit();
  	$this->layout ()->setTemplate ( 'layout/accouchement' );
  	$id_cons = $this->params()->fromPost('id_cons');
  	//$listeSousDossier = $this->getConsultationTable()->getInfosSousDossier();
  	 //var_dump($listeSousDossier);exit();
  	$formStatistique = new StatistiqueForm();
  	$date_debut = $this->params()->fromPost ('date_debut');
  	$date_fin   = $this->params()->fromPost ('date_fin');
  	$control = new DateHelper();
  	 
  	//$hrp=$this->getAccouchementTable()->getNbhrp($date_debut,$date_fin);
  	//$hpp=$this->getAccouchementTable()->getNbhpp($date_debut, $date_fin);
  	 
  	//$anemie=$this->getAccouchementTable()->getNbanemie($date_debut, $date_fin);
  	//$fistules=$this->getAccouchementTable()->getNbFistules($date_debut, $date_fin);
  	//$paludisme=$this->getAccouchementTable()->getNbPaludisme($date_debut, $date_fin);
  	//$ru=$this->getAccouchementTable()->getNbRU($date_debut,$date_fin);
  	//$eclapsie=$this->getAccouchementTable()->getNbEclapsie($date_debut, $date_fin);
  	//$dystocie=$this->getAccouchementTable()->getNbDystocie($date_debut, $date_fin);
  	 
  	$nbPatientPost=$this->getConsultationTable()->getNbPatientsPost();
  	$nbPatientPre = $this->getConsultationTable()->getNbPatientsPre();
  	$nbPatientPla= $this->getConsultationTable()->getNbPatientsPla();  	
  	
  	
  	$nbPatientGyneco=$this->getConsultationTable()->getNbPatientsGyneco();
  	//var_dump($nbPatientGyneco);exit();
  	$nbPatientAccou  = $this->getConsultationTable()->getNbPatientsAcc();
  
  	$nbPatientPost=$this->getConsultationTable()->getNbPatientsPost();
  	//$ant=$this->getAccouchementTable()->getNbDecesMaternelAntePartum('2017-01-01','2019-07-15');
  	//$PrimRisque=$this->getAntecedentType1Table()->getPrimipareRisque('2017-01-01','2019-08-01');
  	//var_dump($PrimRisque);exit();
  	//$vat3=$this->getGrossesseTable()->getnbTPI1('2017-01-01','2019-08-03');
  	//var_dump($vat3);exit();
  	//$nbpat=$this->getAccouchementTable()->getNbDecesMaternelPortPartum('2017-01-01','2019-07-15');
  	$nbPatientAccou  = $this->getConsultationTable()->getNbPatientsAcc();    //var_dump($nbPatientAccou);exit();
  	$nbPatientPre = $this->getConsultationTable()->getNbPatientsPre();
  	$nbPatientPla= $this->getConsultationTable()->getNbPatientsPla();
  	
  	$listeSousDossier=$this->getConsultationTable()->getInfosSousDossier();
  	//var_dump('test');exit();
  	 
  	$nbGrossesseGemellaire=$this->getGrossesseTable()->getNbGrossesseGemellaire();
  	
  
  	return array (
  			 'listeSousDossier'=>$listeSousDossier,
  			'formStatistique' => $formStatistique,
  			//'hrp'=>$hrp,
  			//'hpp'=>$hpp,
  			//'anemie'=>$anemie,
  			//'fistules'=>$fistules,
  			//'paludisme'=>$paludisme,
  			//'ru'=>$ru,
  			//'eclapsie'=>$eclapsie,
  			//'dystocie'=>$dystocie,
  			'nbPatientPost'  => $nbPatientPost,
  			'nbPatientPre' => $nbPatientPre,
  			'nbPatientPla' => $nbPatientPla,
  			'nbPatientAcc'   => $nbPatientAccou,
  			'$nbPatientAccou'=>$nbPatientAccou,
  			'nbPatientGyneco'=>$nbPatientGyneco,
  			'nbGrossesseGemellaire' => $nbGrossesseGemellaire,
  	);
  }
  
  public function getInfoStatistiqueSousDossier()
  {
  	$nbPatientPost=$this->getConsultationTable()->getNbPatientsPost();
  	$nbPatientPre = $this->getConsultationTable()->getNbPatientsPre();
  	$nbPatientPla= $this->getConsultationTable()->getNbPatientsPla();
  	$nbPatientAccou  = $this->getConsultationTable()->getNbPatientsAcc();    //var_dump($nbPatientAccou);exit();
  	  
  	 
  	 
  	
  }
  public function statistiquesGrossessesImprimeesAction(){
  	
  	$date_debut = $this->params()->fromPost ('date_debut');
  	$date_fin   = $this->params()->fromPost ('date_fin');
  	$surveillance=$this->params()->fromPost ('surveillance');
  	 
  	$periodeStat = array();
  	if($date_debut && $date_fin){ /*Une période est selectionnée*/
  			
  		/**=======================*/
  		$periodeStat[0] = $date_debut;
  		$periodeStat[1] = $date_fin;
  		
  		
  			$vat1=$this->getGrossesseTable()->getnbVAT1($date_debut, $date_fin);
  			$vat2=$this->getGrossesseTable()->getnbVAT2($date_debut, $date_fin);
  			$vat3=$this->getGrossesseTable()->getnbVAT3($date_debut, $date_fin);
  			$vat4=$this->getGrossesseTable()->getnbVAT4($date_debut, $date_fin);
  			$vat5=$this->getGrossesseTable()->getnbVAT5($date_debut, $date_fin);
  			$tpi1=$this->getGrossesseTable()->getnbTPI1($date_debut, $date_fin);
  			$tpi2=$this->getGrossesseTable()->getnbTPI2($date_debut, $date_fin);
  			$tpi3=$this->getGrossesseTable()->getnbTPI3($date_debut, $date_fin);
  			$tpi4=$this->getGrossesseTable()->getnbTPI4($date_debut, $date_fin);
  			$PrimPatho=$this->getGrossesseTable()->getPrimiparePatho($date_debut, $date_fin);
  			$PrimRisque=$this->getAntecedentType1Table()->getPrimipareRisque($date_debut, $date_fin);
  			$MultiPatho=$this->getGrossesseTable()->getMultiparePatho($date_debut, $date_fin);
  			$MultiRisque=$this->getGrossesseTable()->getMultipareRisque($date_debut, $date_fin);
  			$total1= $PrimPatho + $MultiPatho;
  			$total2= $PrimRisque + $MultiRisque;
  		
  		
  	}
  	
  	$user = $this->layout()->user;
  	$nomService = $user['NomService'];
  	 
  	$infosComp['dateImpression'] = (new \DateTime ())->format( 'd/m/Y' );//var_dump($date_fin);exit();
  	$pdf = new statistiqueGrossesse();
  	$pdf->SetMargins(13.5,13.5,13.5);
  	//$pdf->setTabInformations($liste);
   $pdf->setVat1($vat1);
   $pdf->setVat2($vat2);
   $pdf->setVat3($vat3);
   $pdf->setVat4($vat3);
   $pdf->setVat5($vat5);
   $pdf->setTpi1($tpi1);
   $pdf->setTpi2($tpi2);
   $pdf->setTpi3($tpi3);
   $pdf->setTpi4($tpi4);
    
   $pdf->setPrimPatho($PrimPatho);
   $pdf->setPrimRisque($PrimRisque);
   $pdf->setMultiPatho($MultiPatho);
   $pdf->setMultiRisque($MultiRisque);
  	$pdf->setInfosComp($infosComp);
  	$pdf->setPeriode($periodeStat);
  	$pdf-> setsurveillance($surveillance);
  	 
  	$pdf->ImpressionInfosStatistiques();
  	$pdf->Output('I');
  	
  }
  public function statistiquesImprimeesAction() {
  
  	$control = new DateHelper();
  
  	$id_service = (int) $this->params()->fromPost ('id_service');
  	//$id_diagnostic = (int) $this->params()->fromPost ('id_diagnostic');
  	$date_debut = $this->params()->fromPost ('date_debut');
  	$date_fin   = $this->params()->fromPost ('date_fin');
  
  	$periodeIntervention = array();
  
  $listeSousDossier=$this->getConsultationTable()->getInfosSousDossier();
  //var_dump($listeSousDossier);exit();
  	$user = $this->layout()->user;
  	$nomService = $user['NomService'];
  	$infosComp['dateImpression'] = (new \DateTime ())->format( 'd/m/Y' );
  
  	$pdf = new infosStatistiquePdf();
  	$pdf->SetMargins(13.5,13.5,13.5);
  	$pdf->setTabInformations($listeSousDossier);
  	
		$pdf->setNomService($nomService);
  	  	$pdf->setInfosComp($infosComp);
  
  	$pdf->ImpressionInfosStatistiques();
  	$pdf->Output('I');
  
  }
  public function statistiquesDecesImprimeesAction(){
  	 
  	$date_debut = $this->params()->fromPost ('date_debut');
  	$date_fin   = $this->params()->fromPost ('date_fin');
  	$periodeStat = array();
  	if($date_debut && $date_fin){ /*Une période est selectionnée*/
  		 
  		/**=======================*/
  		$periodeStat[0] = $date_debut;
  		$periodeStat[1] = $date_fin;
  		
  		$post=$this->getAccouchementTable()->getNbDecesMaternelPortPartum($date_debut, $date_fin);
  		$ant=$this->getAccouchementTable()->getNbDecesMaternelAntePartum($date_debut, $date_fin);
  		$dystocie=$this->getAccouchementTable()->getNbDecesMaternelDystocie($date_debut, $date_fin);
  		$hyper=$this->getAccouchementTable()->getNbDecesMaternelHypertension($date_debut, $date_fin);
  		$inf=$this->getAccouchementTable()->getNbDecesMaternelInfection($date_debut, $date_fin);
  		$direct=$this->getAccouchementTable()->getNbDecesMaternelDirect($date_debut, $date_fin);
  		$indirect=$this->getAccouchementTable()->getNbDecesMaternelIndirect($date_debut, $date_fin);
  		$indeterminer=$this->getAccouchementTable()->getNbDecesMaternelIndtermine($date_debut, $date_fin);
  	}else{
  		$post=$this->getAccouchementTable()->getNbDecesMaternelPortPartum($date_debut, $date_fin);
  		$ant=$this->getAccouchementTable()->getNbDecesMaternelAntePartum($date_debut, $date_fin);
  		$dystocie=$this->getAccouchementTable()->getNbDecesMaternelDystocie($date_debut, $date_fin);
  		$hyper=$this->getAccouchementTable()->getNbDecesMaternelHypertension($date_debut, $date_fin);
  		$inf=$this->getAccouchementTable()->getNbDecesMaternelInfection($date_debut, $date_fin);
  		$direct=$this->getAccouchementTable()->getNbDecesMaternelDirect($date_debut, $date_fin);
  		$indirect=$this->getAccouchementTable()->getNbDecesMaternelIndirect($date_debut, $date_fin);
  		$indeterminer=$this->getAccouchementTable()->getNbDecesMaternelIndtermine($date_debut, $date_fin);}
  		
  	$user = $this->layout()->user;
  	$nomService = $user['NomService'];
  	 
  	$infosComp['dateImpression'] = (new \DateTime ())->format( 'd/m/Y' );//var_dump($date_fin);exit();
  	$pdf = new infosStatistiqueDecesPdf();  	
  	
  	$pdf->SetMargins(13.5,13.5,13.5);
  	//$pdf->setTabInformations($liste);
  	$pdf->setNombrepost($post);
  	$pdf->setNombreant($ant);
  	$pdf->setNombredystociee($dystocie);
  	$pdf->setNombrehyper($hyper);
  	$pdf->setNombreinf($inf);
  	$pdf->setNombredirect($direct);
  	$pdf->setNombreindirect($indirect);
  	$pdf->setNombreindeterminer($indeterminer);
  	$pdf->setNomService($nomService);
  	$pdf->setInfosComp($infosComp);
  	$pdf->setPeriode($periodeStat);//var_dump($date_fin);exit();
  	
  	$pdf->ImpressionInfosStatistiques();
  	$pdf->Output('I');
  }
  public function statistiquesPathologiesImprimeesAction()
  {
  	$date_debut = $this->params()->fromPost ('date_debut');
	$date_fin   = $this->params()->fromPost ('date_fin');
	
  	$periodeStat = array();
  	if($date_debut && $date_fin){ /*Une période est selectionnée*/
  	
  		/**=======================*/
  		$periodeStat[0] = $date_debut;
  		$periodeStat[1] = $date_fin;
  		
  		$hrp=$this->getAccouchementTable()->getNbhrp($date_debut,$date_fin);
  		$hpp=$this->getAccouchementTable()->getNbhpp($date_debut, $date_fin);
  		$anemie=$this->getAccouchementTable()->getNbanemie($date_debut, $date_fin);
  		$fistules=$this->getAccouchementTable()->getNbFistules($date_debut, $date_fin);
  		$paludisme=$this->getAccouchementTable()->getNbPaludisme($date_debut, $date_fin);
  		$ru=$this->getAccouchementTable()->getNbRU($date_debut,$date_fin);
  		$eclapsie=$this->getAccouchementTable()->getNbEclapsie($date_debut, $date_fin);
  		$dystocie=$this->getAccouchementTable()->getNbDystocie($date_debut, $date_fin);
  		$liste = array($hrp,$hpp,$anemie,$fistules,$paludisme,$ru,$eclapsie,$dystocie);//var_dump($liste);exit();
  	}else {
  		$hrp=$this->getAccouchementTable()->getNbhrp($date_debut,$date_fin);
  		$hpp=$this->getAccouchementTable()->getNbhpp($date_debut, $date_fin);
  		$anemie=$this->getAccouchementTable()->getNbanemie($date_debut, $date_fin);
  		$fistules=$this->getAccouchementTable()->getNbFistules($date_debut, $date_fin);
  		$paludisme=$this->getAccouchementTable()->getNbPaludisme($date_debut, $date_fin);
  		$ru=$this->getAccouchementTable()->getNbRU($date_debut,$date_fin);
  		$eclapsie=$this->getAccouchementTable()->getNbEclapsie($date_debut, $date_fin);
  		$dystocie=$this->getAccouchementTable()->getNbDystocie($date_debut, $date_fin);
  		//var_dump($dystocie);exit();
  		$liste = array($hrp,$hpp,$anemie,$fistules,$paludisme,$ru,$eclapsie,$dystocie);
  	}
  	
  	$user = $this->layout()->user;
  	$nomService = $user['NomService'];  	
  	
  	$infosComp['dateImpression'] = (new \DateTime ())->format( 'd/m/Y' );
  		
  	$pdf = new infosStatistiquePathologiePdf();
  	$pdf->SetMargins(13.5,13.5,13.5);
  	//$pdf->setTabInformations($liste);
  	$pdf->setNombrehrp($hrp);
  	$pdf->setNombrehpp($hpp);
  	$pdf->setNombreanemie($anemie);
  	$pdf->setNombrefistule($fistules);
  	$pdf->setNombrepaludisme($paludisme);
  	$pdf->setNombreru($ru);
  	$pdf->setNombreeclapsie($eclapsie);
  	$pdf->setNombredystocie($dystocie);
  	
  	$pdf->setNomService($nomService);
  	$pdf->setInfosComp($infosComp);
  	$pdf->setPeriode($periodeStat);//var_dump($date_fin);exit();
  		
  	$pdf->ImpressionInfosStatistiques();
  	$pdf->Output('I');
  }
    
 public function infoStatistiqueAction() {
    	$this->getDateHelper();
    	$user = $this->layout()->user;
    	//$this->layout ()->setTemplate ( 'layout/accouchement' );
    	$formAdmission = new AdmissionForm();
    	$idService = $user ['IdService'];
    	$id_cons = $this->params()->fromPost('id_cons');
    	$id_patient = $this->params()->fromPost('id_patient');
    	$form = new ConsultationForm ();
    	$formData = $this->getRequest()->getPost();
    	$val1 = $this->params ()->fromPost ( 'date_stat' );
    	$val2 = $this->params ()->fromPost ( 'date_debut' );
    	 
    	list($month, $year) = explode(' ', $val1);
    	
    	$nbcri=$this->getNaissanceTable()->getNbEnfantNonCrier();
    	$nbrcier=count($nbcri);
    	$ru=count($this->getAccouchementTable()->getNbRU());
    	$nbinf=count($this->getNaissanceTable()->getNbEnfantPoidsInferieur());
    	$enfviant=count($this->getNaissanceTable()->getEnf($id_cons));
    	//var_dump($nbinf) ;exit();
    		$decede=$this->getDevenirNouveauNeTable()->getNbMortNe();
    		$reanimer=count($this->getNaissanceTable()->getNbEnfantReanime());
    		//var_dump($reanimer);exit();
    		$avo=count($this->getAccouchementTable()->getNbAvortement());
    		//var_dump($avo);exit();
    	$acc=count( $this->getAccouchementTable()->getLesAccouchement($month,$year));
    	$nbPatientAcc   =$acc;
    	$nbPatientAccCes  =  $this->getAccouchementTable()->getNbPatientsAccCes();
    	$nbPatientPost=$this->getConsultationTable()->getNbPatientsPost();
    	 
    	$nbPatientAccou  = $this->getConsultationTable()->getNbPatientsAcc();    //var_dump($nbPatientAccou);exit();
    	
    	$nbPatientAccN  = $this->getAccouchementTable()->getNbPatientsAccN();
    	$nbPatientAccF = $this->getAccouchementTable()->getNbPatientsAccF();
    	$nbPatientPre = $this->getConsultationTable()->getNbPatientsPre();
    	$nbPatientAccV = $this->getAccouchementTable()->getNbPatientsAccV();
    	$nbPatientPla= $this->getConsultationTable()->getNbPatientsPla();
    	 
    	$nbPatientAccM = $this->getAccouchementTable()->getNbPatientsAccM();
    	$nbGatPa = $this->getAccouchementTable()->getNbPatientsAccGatPa();
    	$nbGrossesseGemellaire=$this->getGrossesseTable()->getNbGrossesseGemellaire();
    	//$nbr=$nbPatientAccCes+$nbPatientAccN+$nbPatientAccF+$nbPatientAccV+$nbPatientAccM;
    	 //var_dump($nbPatientPla);exit();
    
     	
   
    	//Pour les Accouchements
    	return array (
    			//'nbr'=>$nbr,
    			'$nbPatientAccou'=>'$nbPatientAccou',
    			'$decede'=>$decede,
    			'$ru'=>$ru,
    			'$reanimer'=>$reanimer,
    			'enfviant'=>$enfviant,
    			'nbinf'=>$nbinf,
    			'nbrcier'=>$nbrcier,
    			'nbPatientAcc'   => $nbPatientAcc,
    			'nbPatientAccCes'  => $nbPatientAccCes,
    			'nbPatientAccN'  => $nbPatientAccN,
    			'nbPatientAccF' => $nbPatientAccF,
    			'nbPatientAccV' => $nbPatientAccV,
    			'nbPatientAccM' => $nbPatientAccM,
    			'nbPatientAccGatPa' => $nbGatPa,
    			'nbGrossesseGemellaire' => $nbGrossesseGemellaire,
    			'form' => $formAdmission,
    			'date' => $val1,
    			'date_debut' => $val2,
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
    
    public function statistiquesGeneralImprimeesAction() {
         $control = new DateHelper();
		//var_dump('test');exit();
			$date_debut = $this->params()->fromPost ('date_debut');
			$date_fin   = $this->params()->fromPost ('date_fin');
			
			$periodeDiagnostic = array();
			if($date_debut && $date_fin){ /*Une période est selectionnée*/
		
				$periodeDiagnostic[0] = $date_debut;
				$periodeDiagnostic[1] = $date_fin;
				
				$nbPatientAccou  = $this->getAccouchementTable()->getNbPatientsAcc($date_debut,$date_fin);
				$nbPatientAccCes  =  $this->getAccouchementTable()->getNbPatientsAccCes($date_debut,$date_fin);
				$nbPatientAccN  = $this->getAccouchementTable()->getNbPatientsAccN($date_debut,$date_fin);
				$nbPatientAccF = $this->getAccouchementTable()->getNbPatientsAccF($date_debut,$date_fin);
				$nbcri=$this->getNaissanceTable()->getNbEnfantNonCrier($date_debut,$date_fin);
				$nbinf=$this->getNaissanceTable()->getNbEnfantPoidsInferieur($date_debut,$date_fin);
				//$enfviant=count($this->getNaissanceTable()->getEnf($date_debut,$date_fin));
				$nbPatientAccV = $this->getAccouchementTable()->getNbPatientsAccV($date_debut,$date_fin);
				$nbPatientAccM = $this->getAccouchementTable()->getNbPatientsAccM($date_debut,$date_fin);
				$nbGatPa = $this->getAccouchementTable()->getNbPatientsAccGatPa($date_debut,$date_fin);
				$decede=$this->getDevenirNouveauNeTable()->getNbMortNe($date_debut,$date_fin);
				$reanimer=$this->getNaissanceTable()->getNbEnfantReanime($date_debut,$date_fin);
				
			}else {
				$nbPatientAccou  = $this->getAccouchementTable()->getNbPatientsAcc($date_debut,$date_fin);
				$nbPatientAccCes  =  $this->getAccouchementTable()->getNbPatientsAccCes($date_debut,$date_fin);
				$nbPatientAccN  = $this->getAccouchementTable()->getNbPatientsAccN($date_debut,$date_fin);
				$nbPatientAccF = $this->getAccouchementTable()->getNbPatientsAccF($date_debut,$date_fin);
				$nbcri=$this->getNaissanceTable()->getNbEnfantNonCrier($date_debut,$date_fin);
				$nbinf=$this->getNaissanceTable()->getNbEnfantPoidsInferieur($date_debut,$date_fin);
				$enfviant=count($this->getNaissanceTable()->getEnf($date_debut,$date_fin));
				$nbPatientAccV = $this->getAccouchementTable()->getNbPatientsAccV($date_debut,$date_fin);
				$nbPatientAccM = $this->getAccouchementTable()->getNbPatientsAccM($date_debut,$date_fin);
				$nbGatPa = $this->getAccouchementTable()->getNbPatientsAccGatPa($date_debut,$date_fin);
				$decede=$this->getDevenirNouveauNeTable()->getNbMortNe($date_debut,$date_fin);
				$reanimer=$this->getNaissanceTable()->getNbEnfantReanime($date_debut,$date_fin);
				
			}
			$user = $this->layout()->user;
			$nomService = $user['NomService'];
			$infosComp['dateImpression'] = (new \DateTime ())->format( 'd/m/Y' );
			$pdf = new GeneralPdf();
			$pdf->SetMargins(13.5,13.5,13.5);
			$pdf->setNbPatientAccou($nbPatientAccou)	;
			$pdf->setNbPatientAccCes($nbPatientAccCes);
			$pdf->setNbPatientAccN($nbPatientAccN);
			$pdf->setNbPatientAccM($nbPatientAccM);
			$pdf->setNbPatientAccF($nbPatientAccF);
			$pdf->setNbPatientAccV($nbPatientAccV);
			$pdf->setNbcri($nbcri);
			$pdf->setNbinf($nbinf);
			//$pdf->setEnfviant($enfviant);
			$pdf->setNbGatPa($nbGatPa);
			$pdf->setDecede($decede);
			$pdf->setReanimer($reanimer);
			$pdf->setNomService($nomService);
			$pdf->setInfosComp($infosComp);
			$pdf->setPeriodeDiagnostic($periodeDiagnostic);
			$pdf->ImpressionInfosStatistiques();
			$pdf->Output('I');
    
    }
     
}