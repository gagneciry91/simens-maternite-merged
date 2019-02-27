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



class GynecologieController extends AbstractActionController
{
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
	
	public function getDemandeHospitalisationTable()
	{
		if (!$this->demandeHospitalisationTable) {
			$sm = $this->getServiceLocator();
			$this->demandeHospitalisationTable = $sm->get('Maternite\Model\DemandehospitalisationTable');
		}
		return $this->demandeHospitalisationTable;
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
		//var_dump(count($lespatients)); exit();
		
		$tabPatientRV = $this->getConsultationTable()->getPatientsRV($idService);
		//var_dump('test'); exit();
		//var_dump($lespatients->current()); exit();
		return new ViewModel (array(
				'donnees' => $lespatients,
				'tabPatientRV' => $tabPatientRV
		));
	
	
	
	}
	public function complementGynecologieAction()
	{
		$this->layout()->setTemplate('layout/gynecologie');
	
		$user = $this->layout()->user;
		$IdDuService = $user ['IdService'];
		$id_medecin = $user ['id_personne'];
		$this->getDateHelper();
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
		// Liste des examens biologiques
		$listeDesExamensBiologiques = $this->demandeExamensTable()->getDemandeDesExamensBiologiques();
		// Liste des examens Morphologiques
		$listeDesExamensMorphologiques = $this->demandeExamensTable()->getDemandeDesExamensMorphologiques();
		
		// *** Liste des Hospitalisations
		$listeHospitalisation = $this->getDemandeHospitalisationTable()->getDemandeHospitalisationWithIdPatient($id_pat);
		
		// instancier le motif d'admission et recup�rer l'enregistrement
		$motif_admission = $this->getMotifAdmissionTable()->getMotifAdmission($id);
		$nbMotif = $this->getMotifAdmissionTable()->nbMotifs($id);
		 
		// r�cup�ration de la liste des hopitaux
		$hopital = $this->getTransfererPatientServiceTable()->fetchHopital();
		$form->get('hopital_accueil')->setValueOptions($hopital);
		// RECUPERATION DE L'HOPITAL DU SERVICE
		$transfertPatientHopital = $this->getTransfererPatientServiceTable()->getHopitalPatientTransfert($IdDuService);
		$idHopital = $transfertPatientHopital ['ID_HOPITAL'];
		
		// RECUPERATION DE LA LISTE DES SERVICES DE L'HOPITAL OU SE TROUVE LE SERVICE OU LE MEDECIN TRAVAILLE
		$serviceHopital = $this->getTransfererPatientServiceTable()->fetchServiceWithHopitalNotServiceActual($idHopital, $IdDuService);
		
		// LISTE DES SERVICES DE L'HOPITAL
		$form->get('service_accueil')->setValueOptions($serviceHopital);
		
		// liste des heures rv
		$heure_rv = array(
				'08:00' => '08:00',
				'09:00' => '09:00',
				'10:00' => '10:00',
				'15:00' => '15:00',
				'16:00' => '16:00'
		);
		$form->get('heure_rv')->setValueOptions($heure_rv);
		
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
				'hopital_accueil' => $idHopital
		);
		$k = 1;
		foreach ($motif_admission as $Motifs) {
			$data ['motif_admission' . $k] = $Motifs ['Libelle_motif'];
			$k++;
		}
		
		// Pour recuper les bandelettes
		$bandelettes = $this->getConsultationTable()->getBandelette($id);
		
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
		 
		$form->populateValues(array_merge($data, $bandelettes, $donneesAntecedentsPersonnels, $donneesAntecedentsFamiliaux));
		return array(
				'lesdetails' => $liste,
				'id_cons' => $id,
				'nbMotifs' => $nbMotif,
				'image' => $image,
				'form' => $form,
				'heure_cons' => $consult->heurecons,
				'dateonly' => $consult->dateonly,
				'liste_med' => $listeMedicament,
				'temoin' => $bandelettes ['temoin'],
				// 'temoinMotifAdmission' => $motif_admission['temoinMotifAdmission'],
				'listeForme' => $listeForme,
				'listetypeQuantiteMedicament' => $listetypeQuantiteMedicament,
				'donneesAntecedentsPersonnels' => $donneesAntecedentsPersonnels,
				'donneesAntecedentsFamiliaux' => $donneesAntecedentsFamiliaux,
				'liste' => $listeConsultation,
				'resultRV' => $resultRV,
				'listeHospitalisation' => $listeHospitalisation,
				'listeDesExamensBiologiques' => $listeDesExamensBiologiques,
				'listeDesExamensMorphologiques' => $listeDesExamensMorphologiques,
				'listeAntMed' => $listeAntMed,
				'antMedPat' => $antMedPat,
				'nbAntMedPat' => $antMedPat->count(),
		); var_dump('test');exit();
	}
}
?>