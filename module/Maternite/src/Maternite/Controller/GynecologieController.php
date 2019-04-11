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
	protected $gynecoTable;
	protected $formPatient;
	protected $formAdmission;
	protected $diagnosticsTable;
	
	
	
	public function getAdmissionTable() {
		if (! $this->admissionTable) {
			$sm = $this->getServiceLocator ();
			$this->admissionTable = $sm->get ( 'Maternite\Model\AdmissionTable' );
		}
		return $this->admissionTable;
	}
	public function getGynecoTable() {
		if (! $this->gynecoTable) {
			$sm = $this->getServiceLocator ();
			$this->gynecoTable = $sm->get ( 'Maternite\Model\GynecoTable' );
		}
		return $this->gynecoTable;
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
		//var_dump($user); exit();
	
		$lespatients = $this->getConsultationTable()->listeDesGynecologie($idService);
		// RECUPERER TOUS LES PATIENTS AYANT UN RV aujourd'hui
		
		$tabPatientRV = $this->getConsultationTable()->getPatientsRV($idService);
		return new ViewModel (array(
				'donnees' => $lespatients,
				'tabPatientRV' => $tabPatientRV
		));
	
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
		
		$listeMedicament = $this->getConsultationTable()->listeDeTousLesMedicaments();
		$listeForme = $this->getConsultationTable()->formesMedicaments();
		$listetypeQuantiteMedicament = $this->getConsultationTable()->typeQuantiteMedicaments();
		
		$liste = $this->getConsultationTable()->getInfoPatient($id_pat);
		$image = $this->getConsultationTable()->getPhoto($id_pat);
		 
		// RECUPERER TOUS LES PATIENTS AYANT UN RV aujourd'hui
		$tabPatientRV = $this->getConsultationTable()->getPatientsRV($IdDuService);
		$resultRV = null;
		if (array_key_exists($id_pat, $tabPatientRV)) {
			$resultRV = $tabPatientRV [$id_pat];
		}
		
		$form = new ConsultationForm ();
		
		// instancier la consultation et r�cup�rer l'enregistrement
		$consult = $this->getConsultationTable()->getConsult($id);
		 
		// POUR LES HISTORIQUES OU TERRAIN PARTICULIER
		// POUR LES HISTORIQUES OU TERRAIN PARTICULIER
		// POUR LES HISTORIQUES OU TERRAIN PARTICULIER
		// *** Liste des consultations
		$listeConsultation = $this->getConsultationTable()->getConsultationPatient($id_pat, $id);
		
		// *** Liste des Hospitalisations
		
		// instancier le motif d'admission et recup�rer l'enregistrement
		$motif_admission = $this->getMotifAdmissionTable()->getMotifAdmission($id);
		$nbMotif = $this->getMotifAdmissionTable()->nbMotifs($id);
		
	
	
		$data = array(
				'id_cons' => $consult->id_cons,
				'id_medecin' => $id_medecin,
				'id_patient' => $consult->id_patient,
				'date_cons' => $consult->date,
				'poids' => $consult->poids,
				'taille' => $consult->taille,
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
		
		// Recuperer la liste des actes
		// Recuperer la liste des actes
		 
		$form->populateValues(array_merge($data,$tabdiagons,  $donneesAntecedentsPersonnels, $donneesAntecedentsFamiliaux));
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
				// 'temoinMotifAdmission' => $motif_admission['temoinMotifAdmission'],
				'listeForme' => $listeForme,
				'listetypeQuantiteMedicament' => $listetypeQuantiteMedicament,
				'donneesAntecedentsPersonnels' => $donneesAntecedentsPersonnels,
				'donneesAntecedentsFamiliaux' => $donneesAntecedentsFamiliaux,
				'liste' => $listeConsultation,
				'resultRV' => $resultRV,
				'listeAntMed' => $listeAntMed,
				'antMedPat' => $antMedPat,
				'nbAntMedPat' => $antMedPat->count(),
		);
	}
	public function updateComplementGynecologie(){
		
		
		$this->getDateHelper();
		$id_cons = $this->params()->fromPost('id_cons');
		$id_patient = $this->params()->fromPost('id_patient');
		// var_dump($id_cons);
		$user = $this->layout()->user;
		$IdDuService = $user ['IdService'];
		$id_medecin = $user ['id_personne'];
		//var_dump('test');exit();
		// **********-- MODIFICATION DES CONSTANTES --********
		// **********-- MODIFICATION DES CONSTANTES --********
		// **********-- MODIFICATION DES CONSTANTES --********
		$form = new ConsultationForm ();
		$formData = $this->getRequest()->getPost();
		$form->setData($formData);
		// les antecedents medicaux du patient a ajouter addAntecedentMedicauxPersonne
		$this->getConsultationTable()->addAntecedentMedicaux($formData);
		$this->getConsultationTable()->addAntecedentMedicauxPersonne($formData);
		 
		// mettre a jour les motifs d'admission
		$this->getMotifAdmissionTable()->deleteMotifAdmission($id_cons);
		
		
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
		// **=== ANTECEDENTS FAMILIAUX
		'DiabeteAF' => $this->params()->fromPost('DiabeteAF'),
		'NoteDiabeteAF' => $this->params()->fromPost('NoteDiabeteAF'),
		'DrepanocytoseAF' => $this->params()->fromPost('DrepanocytoseAF'),
		'NoteDrepanocytoseAF' => $this->params()->fromPost('NoteDrepanocytoseAF'),
		'htaAF' => $this->params()->fromPost('htaAF'),
		'NoteHtaAF' => $this->params()->fromPost('NoteHtaAF')
		);
		
		$id_personne = $this->getAntecedantPersonnelTable()->getIdPersonneParIdCons($id_cons);
		$this->getAntecedantPersonnelTable()->addAntecedentsPersonnels($donneesDesAntecedents, $id_personne, $id_medecin);
		$this->getAntecedantsFamiliauxTable()->addAntecedentsFamiliaux($donneesDesAntecedents, $id_personne, $id_medecin);
		
		$id_grossesse= $this->getGrossesseTable()->updateGrossesse($formData);
		$this->getConsultationMaterniteTable()->addConsultationMaternite($id_cons,$id_grossesse);
		$id_antecedent1 = $this->getAntecedentType1Table ()-> updateAntecedentType1($formData);
		$id_antecedent2 = $this->getAntecedentType2Table ()-> updateAntecedentType2($formData);
		
		
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
		
		$this->getDiagnosticsTable()->updateDiagnostics($info_diagnostics);
		$info_gyneco=array(
				'id_cons' => $id_cons,
				'toucherVaginal' => $this->params()->fromPost('toucherVaginal')
				
		);//$this->get
		
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