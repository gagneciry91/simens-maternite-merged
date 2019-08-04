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
use Maternite\Form\gynecologie\ConsultationForm;
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



class GynecologieController extends AbstractActionController
{
	protected $consultationTable;
	protected $admissionTable;
	protected $type_admissionTable;
	protected $type_accouchementTable;
	protected $antecedantsFamiliauxTable;
	protected $antecedantPersonnelTable;
	protected $motifAdmissionTable;
	protected $patientTable;
	protected $gynecologieTable;
	protected $formPatient;
	protected $formAdmission;
	protected $diagnosticsTable;
	protected $antecedenttype1Table;
	protected $antecedenttype2Table;
	protected $rvPatientConsTable;
	protected $ordonnanceTable;
	protected $ordonConsommableTable;
	protected $transfererPatientServiceTable;
	protected $demandeExamensTable;
	
	
	
	
	
	public function getAdmissionTable() {
		if (! $this->admissionTable) {
			$sm = $this->getServiceLocator ();
			$this->admissionTable = $sm->get ( 'Maternite\Model\AdmissionTable' );
		}
		return $this->admissionTable;
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
	public function getOrdonConsommableTable()
	{
		if (!$this->ordonConsommableTable) {
			$sm = $this->getServiceLocator();
			$this->ordonConsommableTable = $sm->get('Maternite\Model\OrdonConsommableTable');
		}
		return $this->ordonConsommableTable;
	}
	
	public function demandeExamensTable()
	{
		if (!$this->demandeExamensTable) {
			$sm = $this->getServiceLocator();
			$this->demandeExamensTable = $sm->get('Maternite\Model\DemandeTable');
		}
		return $this->demandeExamensTable;
	}
	
	
	public function getRvPatientConsTable()
	{
		if (!$this->rvPatientConsTable) {
			$sm = $this->getServiceLocator();
			$this->rvPatientConsTable = $sm->get('Maternite\Model\RvPatientConsTable');
		}
		return $this->rvPatientConsTable;
	}
	
	public function getGynecologieTable() {
		if (! $this->gynecologieTable) {
			$sm = $this->getServiceLocator ();
			$this->gynecologieTable = $sm->get ( 'Maternite\Model\GynecologieTable' );
		}
		return $this->gynecologieTable;
	}

	public function getOrdonnanceTable()
	{
		if (!$this->ordonnanceTable) {
			$sm = $this->getServiceLocator();
			$this->ordonnanceTable = $sm->get('Maternite\Model\OrdonnanceTable');
		}
		return $this->ordonnanceTable;
	}
	
	public function getDiagnosticsTable()
	{
		if (!$this->diagnosticsTable) {
			$sm = $this->getServiceLocator();
			$this->diagnosticsTable = $sm->get('Maternite\Model\DiagnosticsTable');
		}
		return $this->diagnosticsTable;
	}
	
	public function getConsultationTable()
	{
		if (!$this->consultationTable) {
			$sm = $this->getServiceLocator();
			$this->consultationTable = $sm->get('Maternite\Model\ConsultationTable');
		}
		return $this->consultationTable;
	}
	public function getPatientTable() {
		if (! $this->patientTable) {
			$sm = $this->getServiceLocator ();
			$this->patientTable = $sm->get ( 'Maternite\Model\PatientTable' );
		}
		return $this->patientTable;
	}
	
	public function getAntecedantsFamiliauxTable()
	{
		if (!$this->antecedantsFamiliauxTable) {
			$sm = $this->getServiceLocator();
			$this->antecedantsFamiliauxTable = $sm->get('Maternite\Model\AntecedentsFamiliauxTable');
		}
		return $this->antecedantsFamiliauxTable;
	}
	public function getAntecedantPersonnelTable()
	{
		if (!$this->antecedantPersonnelTable) {
			$sm = $this->getServiceLocator();
			$this->antecedantPersonnelTable = $sm->get('Maternite\Model\AntecedentPersonnelTable');
		}
		return $this->antecedantPersonnelTable;
	}
	
	
	public function getDemandeHospitalisationTable()
	{
		if (!$this->demandeHospitalisationTable) {
			$sm = $this->getServiceLocator();
			$this->demandeHospitalisationTable = $sm->get('Maternite\Model\DemandehospitalisationTable');
		}
		return $this->demandeHospitalisationTable;
	}
	
	public function getDateHelper()
	{
		$this->controlDate = new DateHelper ();
	}
	public function convertDate($date) {
		$nouv_date = substr ( $date, 8, 2 ) . '/' . substr ( $date, 5, 2 ) . '/' . substr ( $date, 0, 4 );
		return $nouv_date;
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
	public function getTypeAdmissionTable()
	{
		if (!$this->type_admissionTable) {
			$sm = $this->getServiceLocator();
			$this->type_admissionTable = $sm->get('Maternite\Model\TypeAdmissionTAble');
		}
	
		return $this->type_admissionTable;
	}

	public function getMotifAdmissionTable()
	{
		if (!$this->motifAdmissionTable) {
			$sm = $this->getServiceLocator();
			$this->motifAdmissionTable = $sm->get('Maternite\Model\MotifAdmissionTable');
		}
		return $this->motifAdmissionTable;
	}
	
	public function getForm() {
		if (! $this->formPatient) {
			$this->formPatient = new PatientForm();
		}
		return $this->formPatient;
	}
	public function admissionAction() {
		$layout = $this->layout ();
	
		$layout->setTemplate ( 'layout/gynecologie' );
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
	
		return $this->redirect()->toRoute('gynecologie', array(
				'action' =>'admission'));
	
	}
	
	public function ajouterAction() {
	
		$this->layout ()->setTemplate ( 'layout/gynecologie' );
		//$formAdmission = new AdmissionForm();
		$form = $this->getForm ();
		//var_dump($form); exit();
		$patientTable = $this->getPatientTable();
		$form->get('NATIONALITE_ORIGINE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$form->get('NATIONALITE_ACTUELLE')->setvalueOptions($patientTable->listeDeTousLesPays());
		$data = array('NATIONALITE_ORIGINE' => 'Sénégal', 'NATIONALITE_ACTUELLE' => 'Sénégal');
	
		$form->populateValues($data);
	
		return new ViewModel ( array (
				'form' => $form
		) );
	
	}

	public function gynecologieAction(){
		
			$this->layout()->setTemplate('layout/gynecologie');
		$user = $this->layout()->user;
		$idService = $user ['IdService'];
		$lespatients = $this->getConsultationTable()->listeDesGynecologie($idService);
		// RECUPERER TOUS LES PATIENTS AYANT UN RV aujourd'hui
		//var_dump(count($lespatients));exit();
		$tabPatientRV = $this->getConsultationTable()->getPatientsRV($idService);
		return new ViewModel (array(
				'donnees' => $lespatients,
				'tabPatientRV' => $tabPatientRV
		));
	
	}
	public function listeGynecologieAjaxAction() {
		$output = $this->getPatientTable ()->getListePatientsAdmisAjax();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	public function listeGynecologieAction() {
	
		$this->layout ()->setTemplate ( 'layout/gynecologie' );
		$user = $this->layout()->user;
		$idService = $user['IdService'];
	
		return new ViewModel ( array (
		) );
	}
	public function infoPrenataleAction() {
		$this->layout ()->setTemplate ( 'layout/gynecologie' );
		$id_pat = $this->params ()->fromRoute ( 'id_patient', 0 );
		 
		$user = $this->layout()->user;
		$idService = $user ['IdService'];
		$form = new ConsultationForm ();
		var_dump('test');exit();
	
		$formData = $this->getRequest ()->getPost ();
		$form->setData ( $formData );
		$id_cons = $form->get ( "id_cons" )->getValue ();
		$prenatale = $this->getConsultationTable()->listePrenatale($id_pat);
	
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getInformationPatient( $id_pat);
	
		return array (
				'donnees_pre'=>$prenatale ,
				'lesdetails' => $unPatient,
				'image' => $patient->getPhoto ( $id_pat ),
				'date_enregistrement' => $unPatient['DATE_ENREGISTREMENT']
		);
	}
	
		
	public function listeDesGynecologiesAction() {
		
		$layout = $this->layout ();
		$layout->setTemplate ( 'layout/gynecologie' );
		$view = new ViewModel ();
		return $view;
	}
	
	public function listeDesGynecologiesAjaxAction() {
		$id_pat = $this->params()->fromQuery('id_patient', 0);
		$output = $this->getPatientTable()->getPatientGynecologie();
		return $this->getResponse ()->setContent ( Json::encode ( $output, array (
				'enableJsonExprFinder' => true
		) ) );
	}
	
	
	public function complementGynecologieAction()
	{
		$this->layout()->setTemplate('layout/gynecologie');
		$user = $this->layout()->user;
		$IdDuService = $user ['IdService'];
		$id_medecin = $user ['id_personne'];
		$this->getDateHelper();	//var_dump('test');exit();
		
		$id_pat = $this->params()->fromQuery('id_patient', 0);
		$id = $this->params()->fromQuery('id_cons');
		$inf=$this->getConsultationTable()->infpat($id_pat, $id);
	
		//var_dump($id);exit();
		$id_admi = $this->params()->fromQuery('id_admission', 0);
		
		
		 
		// RECUPERER TOUS LES PATIENTS AYANT UN RV aujourd'hui
		$tabPatientRV = $this->getConsultationTable()->getPatientsRV($IdDuService);
		$resultRV = null;
		if (array_key_exists($id_pat, $tabPatientRV)) {
			$resultRV = $tabPatientRV [$id_pat];
		}
		
		$form = new ConsultationForm ();
		$listeMedicament = $this->getConsultationTable()->listeDeTousLesMedicaments();
		$listeForme = $this->getConsultationTable()->formesMedicaments();
		$listetypeQuantiteMedicament = $this->getConsultationTable()->typeQuantiteMedicaments();
		$donne_ante=$this->getAntecedentType1Table()->getAntecedentType1($id_pat);
		$donne_ante2=$this->getAntecedentType2Table()->getAntecedentType2($id);
		$liste = $this->getConsultationTable()->getInfoPatient($id_pat);
		$image = $this->getConsultationTable()->getPhoto($id_pat);
		
		// instancier la consultation et r�cup�rer l'enregistrement
		$consult = $this->getConsultationTable()->getConsult($id);
		
		// Les antecedents
		
		$donne_ant1=array(
					
				'enf_viv'=>$donne_ante['enf_viv'],
				'geste'=>$donne_ante['geste'],
				'parite'=>$donne_ante['parite'],
				'note_enf'=>$donne_ante['note_enf'],
				'note_geste'=>$donne_ante['note_geste'],
				'note_parite'=>$donne_ante['note_parite'],
				'mort_ne'=>$donne_ante['mort_ne'],
				'note_mort_ne'=>$donne_ante['note_mort_ne'],
				//'avortement'=>$donne_ante['avortement'],
				//'note_avortement'=>$donne_ante['note_avortement'],
				'cesar'=>$donne_ante['cesar'],
				'nombre_cesar'=>$donne_ante['nombre_cesar'],
				'indication'=>$donne_ante['indication'],
				'hta'=>$donne_ante['hta'],
				'NoteHtaAF'=>$donne_ante['NoteHtaAF'],
				'menarchie'=>$donne_ante['menarchie'],
				'groupe_sanguins'=>$donne_ante['groupe_sanguin'],
				'rhesus'=>$donne_ante['rhesus'],
				'note_gs'=>$donne_ante['note_gs'],
				'test_emmel'=>$donne_ante['test_emmel'],
				'profil_emmel'=>$donne_ante['profil_emmel'],
				'note_emmel'=>$donne_ante['note_emmel'],
				'duree_infertilite'=>$donne_ante['duree_infertilite'],
				'dg'=>$donne_ante['dg'],
				'note_dg'=>$donne_ante['note_dg'],
				'ddr'=>$donne_ante['ddr'],
		        'inv_uter'=>$donne_ante['inv_uter'],
		        'muqueuse'=>$donne_ante['muqueuse'],
		        'oeudeme'=>$donne_ante['oeudeme'],
		        'eg'=>$donne_ante['eg'], 
		        'seins'=>$donne_ante['seins'],
		        'note_sein'=>$donne_ante['note_sein'],
		        'tvagin'=>$donne_ante['tvagin'],
				'abdomen'=>$donne_ante['abdomen'],
				'mollets'=>$donne_ante['mollets'],
				'enf_viv_mari'=>$donne_ante['enf_viv_mari'],		
				'noteenf_viv'=>$donne_ante['noteenf_viv'],
				'Vivensemble'=>$donne_ante['Vivensemble'],
				'note_Vivensemble'=>$donne_ante['note_Vivensemble'],
				'enf_age'=>$donne_ante['enf_age'],
				'noteenf_age'=>$donne_ante['noteenf_age'],
				'regime'=>$donne_ante['regime'],
				'note_regime'=>$donne_ante['note_regime'],
				'nouvelleMotifs'=>$donne_ante['nouvelleMotifs'],
				'amenere'=>$donne_ante['amenere'],
				'kystectomie'=>$donne_ante['kystectomie'],
				'myomectomie'=>$donne_ante['myomectomie'],
				'kysteovarienne'=>$donne_ante['kysteovarienne'],
				'hysterectomie'=>$donne_ante['hysterectomie'],
				'autrescons'=>$donne_ante['autrescons'],
				'note_kystectomie'=>$donne_ante['note_kystectomie'],
				'note_myomectomie'=>$donne_ante['note_myomectomie'],
				'note_hysterectomie'=>$donne_ante['note_hysterectomie'],
				'note_kysteovarienne'=>$donne_ante['note_kysteovarienne'],
				'note_autrescons'=>$donne_ante['note_autrescons'],
				
				
				
				
		);
		//var_dump($donne_ant1);exit();
		$form->populateValues($donne_ant1);
		
		$donne_antecedent2=array(
				'dystocie'=>$donne_ante2['dystocie'],
				'eclampsie'=>$donne_ante2['eclampsie'],
				//'cycle'=>$donne_ante2['cycle'],
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
				'dateces'=>$donne_ante2['dateces'],
				
		);//var_dump($donne_antecedent2);exit();
		
		//$form->populateValues($donne_antecedent2);
		
		
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
		
		 
		// POUR LES HISTORIQUES OU TERRAIN PARTICULIER
		// POUR LES HISTORIQUES OU TERRAIN PARTICULIER
		// POUR LES HISTORIQUES OU TERRAIN PARTICULIER
		// *** Liste des consultations
		$listeConsultation = $this->getConsultationTable()->getConsultationPatient($id_pat, $id);
		
		// *** Liste des Hospitalisations
		
		// instancier le motif d'admission et recup�rer l'enregistrement
		$motif_admission = $this->getMotifAdmissionTable()->getMotifAdmission($id);
		$nbMotif = $this->getMotifAdmissionTable()->nbMotifs($id);
		
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
		// instancier la consultation et r�cup�rer l'enregistrement
		$consult = $this->getConsultationTable()->getConsult($id);
		$pos = strpos($consult->pression_arterielle, '/');
		$tensionmaximale = substr($consult->pression_arterielle, 0, $pos);
		$tensionminimale = substr($consult->pression_arterielle, $pos + 1);
		
	
		$data = array(
				'id_cons' => $consult->id_cons,
				'id_medecin' => $id_medecin,
				'id_patient' => $consult->id_patient,
				'date_cons' => $consult->date,
				'poids' => $consult->poids,
				'taille' => $consult->taille,
				'tensionmaximale' => $tensionmaximale,
				'tensionminimale' => $tensionminimale,
				'temperature' => $consult->temperature,
				'pouls' => $consult->pouls,
				'frequence_respiratoire' => $consult->frequence_respiratoire,
				'glycemie_capillaire' => $consult->glycemie_capillaire,
				'pressionarterielle' => $consult->pression_arterielle,
		);
		$k = 1;
		foreach ($motif_admission as $Motifs) {
			$data ['motif_admission' . $k] = $Motifs ['Libelle_motif'];
			$k++;
		}
		$gyneco=$this->getGynecologieTable()->getGynecologie($id);
		
		$donne_gyn=array(
				'infertilite'=>$gyneco['infertilite'],
				//'traitement_recu'=>$avortement['id_traitement'],
				//'periode_av'=>$avortement['periode_av'],
					
		);//var_dump($donne_av);exit();
		$form->populateValues($donne_gyn);
		$infoDiagnostics = $this->getDiagnosticsTable()->getDiagnostics($id);
		// POUR LES DIAGNOSTICS
		$k = 1;$tabdiagons=array();
		foreach ($infoDiagnostics as $diagnos) {
			$tabdiagons ['diagnostic' . $k] = $diagnos ['libelle_diagnostics'];
			//$data ['decisions']=$diagnos['decision'];
			$k++;
		}
		
		// RECUPERATION DES ANTECEDENTS
		// RECUPERATION DES ANTECEDENTS
		// RECUPERATION DES ANTECEDENTS
		$donneesAntecedentsPersonnels = $this->getAntecedantPersonnelTable()->getTableauAntecedentsPersonnels($id_pat);
		$donneesAntecedentsFamiliaux = $this->getAntecedantsFamiliauxTable()->getTableauAntecedentsFamiliaux($id_pat);
		// Recuperer les antecedents medicaux ajouter pour le patient
		// Recuperer les antecedents medicaux ajouter pour le patient
		$antMedPat = $this->getConsultationTable()->getAntecedentMedicauxPersonneParIdPatient($id_pat);
		
		// Recuperer les antecedents medicaux
		// Recuperer les antecedents medicaux
		$listeAntMed = $this->getConsultationTable()->getAntecedentsMedicaux();
	
		// FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
		// FIN ANTECEDENTS --- FIN ANTECEDENTS --- FIN ANTECEDENTS
	
		// Liste des examens biologiques
		$listeDesExamensBiologiques = $this->demandeExamensTable()->getDemandeDesExamensBiologiques();
		// Liste des examens Morphologiques
		$listeDesExamensMorphologiques = $this->demandeExamensTable()->getDemandeDesExamensMorphologiques();
		
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
		
		if ($leRendezVous) {
			$data ['heure_rv'] = $leRendezVous->heure;
			$data ['date_rv'] = $this->controlDate->convertDate($leRendezVous->date);
			$data ['motif_rv'] = $leRendezVous->note;
		}
		
		
		// Recuperer la liste des actes
		// Recuperer la liste des actes
		 
		$form->populateValues(array_merge($data,$donne_antecedent2, $tabdiagons,  $donneesAntecedentsPersonnels, $donneesAntecedentsFamiliaux));
		return array(
				'lesdetails' => $liste,
				'id_cons' => $id,
				'nbMotifs' => $nbMotif,
				'image' => $image,
				'form' => $form,
				'nbDiagnostics' => $infoDiagnostics->count(),
				'heure_cons' => $consult->heurecons,
				'dateonly' => $consult->dateonly,
				'liste_med' => $listeMedicament,
				'nb_med_prescrit' => $nbMedPrescrit,
				'liste_med_prescrit' => $listeMedicamentsPrescrits,
				'duree_traitement' => $duree_traitement,
				// 'temoinMotifAdmission' => $motif_admission['temoinMotifAdmission'],
				'listeForme' => $listeForme,
				'listetypeQuantiteMedicament' => $listetypeQuantiteMedicament,
				'donneesAntecedentsPersonnels' => $donneesAntecedentsPersonnels,
				'donneesAntecedentsFamiliaux' => $donneesAntecedentsFamiliaux,
				'liste' => $listeConsultation,
				'resultRV' => $resultRV,
				'verifieRV' => $leRendezVous,
				
				'listeAntMed' => $listeAntMed,
				'antMedPat' => $antMedPat,
				'nbAntMedPat' => $antMedPat->count(),
				'listeDesExamensBiologiques' => $listeDesExamensBiologiques,
				'listeDesExamensMorphologiques' => $listeDesExamensMorphologiques
		);
	}
	public function majComplementGynecologieAction()
	{$this->layout()->setTemplate('layout/gynecologie');}
	
	
	
	public function infoGynecologieAction() {
		$this->layout ()->setTemplate ( 'layout/gynecologie' );
		$id_pat = $this->params ()->fromRoute ( 'id_patient', 0 );
		 
		$user = $this->layout()->user;
		$idService = $user ['IdService'];
		$form = new ConsultationForm ();
		var_dump('test');exit();
	
		$formData = $this->getRequest ()->getPost ();
		$form->setData ( $formData );
		$id_cons = $form->get ( "id_cons" )->getValue ();
		$gyneco = $this->getConsultationTable()->listeGynecologie($id_pat);
	
		$patient = $this->getPatientTable ();
		$unPatient = $patient->getInformationPatient( $id_pat);
	
		return array (
				'donnees_gyn'=>$gyneco ,
				'lesdetails' => $unPatient,
				'image' => $patient->getPhoto ( $id_pat ),
				'date_enregistrement' => $unPatient['DATE_ENREGISTREMENT']
		);
	}

	public function updateComplementGynecologieAction(){
	
        $this->layout()->setTemplate('layout/gynecologie');
        $this->getDateHelper();
        $id_patient = $this->params()->fromPost('id_patient');
        $user = $this->layout()->user;
        $IdDuService = $user ['IdService'];
        $id_medecin = $user ['id_personne'];
        $id_cons = $this->params()->fromPost('id_cons');
        
        $form = new ConsultationForm ();
        
        $formData = $this->getRequest()->getPost();
        $form->setData($formData);
        //var_dump($id_cons);exit();
        
        // **********-- MODIFICATION DES CONSTANTES --********
        // **********-- MODIFICATION DES CONSTANTES --********
        // **********-- MODIFICATION DES CONSTANTES --********
 
        // les antecedents medicaux du patient a ajouter addAntecedentMedicauxPersonne
        $this->getConsultationTable()->addAntecedentMedicaux($formData);
        $this->getConsultationTable()->addAntecedentMedicauxPersonne($formData);
         //$this->getAntecedentType1Table()->addAntecedentType1($formData);
       
        // mettre a jour les motifs d'admission
        $this->getMotifAdmissionTable()->deleteMotifAdmission($id_cons);
        
        $motisAdmission = array(

            'id_cons' => $id_cons,
            'motif_admission' => $this->params()->fromPost('motif_admission1'),
            'nouvelleGrossesse' => $this->params()->fromPost('motif_admission2')
        );

        
        // mettre a jour la consultation
        $this->getConsultationTable()->updateLesConsultation($form);
     
        $id_antecedent1 = $this->getAntecedentType1Table ()-> updateAntecedentType1($formData);   //var_dump('test');exit();
        $id_antecedent2 = $this->getAntecedentType2Table ()-> updateAntecedentType2($formData);

        // **=== ANTECEDENTS FAMILIAUX
        // **=== ANTECEDENTS FAMILIAUX
        $donneesDesAntecedents=array(
        'DiabeteAF' => $this->params()->fromPost('DiabeteAF'),
        'NoteDiabeteAF' => $this->params()->fromPost('NoteDiabeteAF'),
        'DrepanocytoseAF' => $this->params()->fromPost('DrepanocytoseAF'),
        'NoteDrepanocytoseAF' => $this->params()->fromPost('NoteDrepanocytoseAF'),
        'htaAF' => $this->params()->fromPost('htaAF'),
        'NoteHtaAF' => $this->params()->fromPost('NoteHtaAF')
        );
        //var_dump($donneesDesAntecedents);exit();
        //$id_personne = $this->getAntecedantPersonnelTable()->getIdPersonneParIdCons($id_cons);
        //$this->getAntecedantPersonnelTable()->addAntecedentsPersonnels($donneesDesAntecedents, $id_personne, $id_medecin);
        $this->getAntecedantsFamiliauxTable()->addAntecedentsFamiliaux($donneesDesAntecedents, $id_patient, $id_medecin);
        
        // POUR LES DIAGNOSTICS
        // POUR LES DIAGNOSTICS
        // POUR LES DIAGNOSTICS
        $info_diagnostics = array(
        		'id_cons' => $id_cons,
        		'diagnostic1' => $this->params()->fromPost('diagnostic1'),
        		'diagnostic2' => $this->params()->fromPost('diagnostic2'),
        		'diagnostic3' => $this->params()->fromPost('diagnostic3'),
        		'diagnostic4' => $this->params()->fromPost('diagnostic4')
        );

        $this->getDiagnosticsTable()->updateDiagnostics($formData);  
        //var_dump($this);exit();     
        
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
        $Consommable = $this->getOrdonConsommableTable();//var_dump('test');exit();
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
        
        $idOrdonnance = $this->getOrdonnanceTable()->updateOrdonnance($tab, $formData);
        
        /* Mettre a jour les medicaments */
        $resultat = $Consommable->updateOrdonConsommable($tab, $idOrdonnance, $nomMedicament);
        
        /* si aucun m�dicament n'est ajout� ($resultat = false) on supprime l'ordonnance */
     if ($resultat == false) {
        	$this->getOrdonnanceTable()->deleteOrdonnance($idOrdonnance);
        }
        
        
       //var_dump($donnee_ant1);exit();
      
        $donne_gyneco = array(
        		'id_cons' => $this->params()->fromPost('id_cons'),
        		'infertilite' => $this->params()->fromPost('infertilite'),
        		'antepers' => $this->params()->fromPost('antepers'),
        		);
        
        $this->getGynecologieTable()->updateGyneco($donne_gyneco);
       // var_dump('tesy');exit();
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
        // POUR LA PAGE complement-consultation
        // POUR LA PAGE complement-consultation
        // POUR LA PAGE complement-consultation
        if ($id_cons != 'null') {
        
        	// VALIDER EN METTANT '1' DANS CONSPRISE Signifiant que le medecin a consulter le patient
        	// Ajouter l'id du medecin ayant consulter le patient
        	$valide = array(
        			'VALIDER' => 1,
        			'ID_CONS' => $id_cons,
        			//'ID_MEDECIN' => $this->params()->fromPost('med_id_personne')
        	);//var_dump($valide);exit();
        	$this->getConsultationTable()->validerConsultation1($valide);
        }
        
		return $this->redirect()->toRoute('gynecologie', array(
				'action' => 'gynecologie',
		));
		
	}
	public function vuePatientOpereBlocAction()
	{
		$this->getDateHelper();
	
		$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
		$idPatient = ( int )$this->params()->fromPost('idPatient');
		$idAdmission = ( int )$this->params()->fromPost('idAdmission');
	
		$unPatient = $this->getPatientTable()->getInfoPatient($idPatient);
		$photo = $this->getPatientTable()->getPhoto($idPatient);
	
		// Informations sur l'admission
		$InfoAdmis = $this->getAdmissionTable()->getPatientAdmisBloc($idAdmission);
	
		// Informations sur le protocole op�ratoire
		$InfoProtocoleOperatoire = $this->getAdmissionTable()->getProtocoleOperatoireBloc($idAdmission);
	
		// Verifier si le patient a un rendez-vous et si oui dans quel service et a quel heure
		$today = new \DateTime ();
		$dateAujourdhui = $today->format('Y-m-d');
	
		$controle = new DateHelper ();
		$date = $unPatient ['DATE_NAISSANCE'];
		if ($date) {
			$date = $controle->convertDate($unPatient ['DATE_NAISSANCE']);
		} else {
			$date = null;
		}
	
		$html = "<div style='width:100%;'>";
	
		$html .= "<div style='width: 18%; height: 210px; float:left;'>";
		$html .= "<div id='photo' style='float:left; margin-left:40px; margin-top:10px; margin-right:30px;'> <img style='width:105px; height:105px;' src='" . $this->baseUrl() . "public/img/photos_patients/" . $photo . "' ></div>";
		$html .= "<div style='margin-left:60px; margin-top: 150px;'> <div style='text-decoration:none; font-size:14px; float:left; padding-right: 7px; '>Age:</div>  <div style='font-weight:bold; font-size:19px; font-family: time new romans; color: green; font-weight: bold;'>" . $unPatient ['AGE'] . " ans</div></div>";
		$html .= "</div>";
	
		$html .= "<div style='width: 70%; height: 210px; float:left;'>";
		$html .= "<table id='vuePatientAdmission' style='margin-top:10px; float:left'>";
	
		$html .= "<tr style='width: 100%;'>";
		$html .= "<td style='width: 19%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nom:</a><br><div style='width: 150px; max-width: 160px; height:40px; overflow:auto; margin-bottom: 3px;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient ['NOM'] . "</p></div></td>";
		$html .= "<td style='width: 29%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Lieu de naissance:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['LIEU_NAISSANCE'] . "</p></div></td>";
		$html .= "<td style='width: 23%; vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute;  d'origine:</a><br><div style='width: 95%; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['NATIONALITE_ORIGINE'] . "</p></div></td>";
		$html .= "<td style='width: 29%; '></td>";
	
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Pr&eacute;nom:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['PRENOM'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>T&eacute;l&eacute;phone:</a><br><div style='width: 95%; max-width: 250px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['TELEPHONE'] . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Nationalit&eacute; actuelle:</a><br><div style='width: 95%; max-width: 135px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['NATIONALITE_ACTUELLE'] . "</p></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Email:</a><br><div style='width: 100%; max-width: 235px; height:40px; overflow:auto;'><p style='font-weight:bold; font-size:17px;'>" . $unPatient ['EMAIL'] . "</p></div></td>";
	
		$html .= "</tr><tr style='width: 100%;'>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Date de naissance:</a><br><div style='width: 95%; max-width: 130px; height:40px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $date . "</p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Adresse:</a><br><div style='width: 97%; max-width: 250px; height:50px; overflow:auto; margin-bottom: 3px;'><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['ADRESSE'] . " </p></div></td>";
		$html .= "<td style='vertical-align: top;'><a style='text-decoration:underline; font-size:12px;'>Profession:</a><br><div style='width: 95%; max-width: 235px; height:40px; overflow:auto; '><p style=' font-weight:bold; font-size:17px;'>" . $unPatient ['PROFESSION'] . "</p></div></td>";
	
		$html .= "</td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";
	
		$html .= "<div style='width: 12%; height: 210px; float:left; '>";
		$html .= "<div id='' style='color: white; opacity: 0.09; float:left; margin-right:0px; margin-left:0px; margin-top:5px;'> <img style='width:105px; height:105px;' src='" . $this->baseUrl() . "public/img/photos_patients/" . $photo . "'></div>";
		$html .= "</div>";
	
		$html .= "</div>";
	
		$html .= "<script> $('#id_patient').val('" . $idPatient . "');  $('#id_admission').val('" . $idAdmission . "'); </script>";
	
		$visitePA = '<span id="semaineDebutFin" style="cursor:pointer; padding-right: 20px; text-decoration: none;">  Re&ccedil;u le ' . $this->controlDate->convertDate($InfoAdmis ['date']) . ' &agrave; ' . $InfoAdmis ['heure'] . '</span>';
		$visitePA .= '<div style="border-bottom: 1px solid gray; margin-top: 10px; margin-bottom: 20px;"></div>';
	
		$visitePA .= '<table style="width: 100%;">';
		$visitePA .= '<tr style="width: 100%; ">';
		$visitePA .= '<td style="width: 35%; padding-top: 15px; padding-right: 15px;"><span style="text-decoration:underline; font-weight:bold; font-size:17px; color: #065d10; font-family: Times  New Roman;">Diagnostic</span><br><p id="zoneChampInfo1" style="background:#f8faf8; font-size:19px; padding-left: 5px;"> ' . str_replace("'", "\'", $InfoAdmis ['diagnostic']) . ' </p></td>';
		$visitePA .= '<td style="width: 30%; padding-top: 15px; padding-right: 15px;"><span style="text-decoration:underline; font-weight:bold; font-size:17px; color: #065d10; font-family: Times  New Roman;">Intervention pr&eacute;vue</span><br><p id="zoneChampInfo1" style="background:#f8faf8; font-size:19px; padding-left: 5px;"> ' . str_replace("'", "\'", $InfoAdmis ['intervention_prevue']) . ' </p></td>';
		$visitePA .= '<td style="width: 20%; padding-top: 15px;"><span style="text-decoration:underline; font-weight:bold; font-size:17px; color: #065d10; font-family: Times  New Roman;">VPA</span><br><p id="zoneChampInfo1" style="background:#f8faf8; font-size:19px; padding-left: 5px;"> ' . str_replace("'", "\'", $InfoAdmis ['vpa']) . ' </p></td>';
		$visitePA .= '<td style="width: 15%; padding-top: 15px;"><span style="text-decoration:underline; font-weight:bold; font-size:17px; color: #065d10; font-family: Times  New Roman;">Salle</span><br><p id="zoneChampInfo1" style="background:#f8faf8; font-size:19px; padding-left: 5px;"> ' . str_replace("'", "\'", $InfoAdmis ['salle']) . ' </p></td>';
		$visitePA .= '</tr>';
	
		$visitePA .= '</table>';
	
		$protocole_operatoire = str_replace("'", "\'", $InfoProtocoleOperatoire ['protocole_operatoire']);
		$soins_post_operatoire = str_replace("'", "\'", $InfoProtocoleOperatoire ['soins_post_operatoire']);
	
		$html .= "<script> $('#anesthesiste').val('" . str_replace("'", "\'", $InfoProtocoleOperatoire ['anesthesiste']) . "'); </script>";
		$html .= "<script> $('#indication').val('" . str_replace("'", "\'", $InfoProtocoleOperatoire ['indication']) . "'); </script>";
		$html .= "<script> $('#type_anesthesie').val('" . str_replace("'", "\'", $InfoProtocoleOperatoire ['type_anesthesie']) . "'); </script>";
		$html .= "<script> $('#protocole_operatoire').val('" . preg_replace("/(\r\n|\n|\r)/", "\\n", $protocole_operatoire) . "'); </script>";
		$html .= "<script> $('#soins_post_operatoire').val('" . preg_replace("/(\r\n|\n|\r)/", "", $soins_post_operatoire) . "'); </script>";
		$html .= "<script> $('#id_protocole').val(" . ( int )$InfoProtocoleOperatoire ['id_protocole'] . "); </script>";
	
		$html .= "<script> setTimeout(function(){ $('#tabs-1').html('" . $visitePA . "'); desactiverChampsInit(); }); </script>";
		$html .= "<script> $('#dateEnregistrement').html('Enregistr&eacute; le " . $this->controlDate->convertDate($InfoProtocoleOperatoire ['date']) . " &agrave; " . $InfoProtocoleOperatoire ['heure'] . "'); </script>";
	
		$this->getResponse()->getHeaders()->addHeaderLine('Content-Type', 'application/html; charset=utf-8');
		return $this->getResponse()->setContent(Json::encode($html));
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
			// R�cup�ration des donn�es
			$donneesDemande ['suite_de_couches'] = $this->params()->fromPost('suite_de_couches');
			// CREATION DU DOCUMENT PDF
			// Cr�er le document
			$DocPdf = new DocumentPdf ();
			// Cr�er la page
			$page = new SuiteDeCouchePdf();
	
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
?>