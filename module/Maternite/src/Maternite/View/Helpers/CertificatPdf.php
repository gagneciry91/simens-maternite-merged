<?php

namespace Maternite\View\Helpers;

use ZendPdf;
use ZendPdf\Page;
use ZendPdf\Font;
use Maternite\Model\Consultation;
use Maternite\View\Helpers\DateHelper;


class CertificatPdf  {
	protected $_page;
	protected $_yPosition;
	protected $_leftMargin;
	protected $_pageWidth;
	protected $_pageHeight;
	protected $_normalFont;
	protected $_boldFont;
	protected $_newTime;
	protected $_newTimeGras;
	protected $_year;
	protected $_headTitle;
	protected $_introText;
	protected $_graphData;
	protected $_patient;
	protected $_id_cons;
	protected $_date;
	protected $_note;
	protected $_idPersonne;
	protected $_Medicaments;
	protected $_DonneesPatient;
	protected $_DonneesMedecin;
	protected $_DonneesDemande;
	protected $_policeContenu;
	protected $_newPolice;
	protected $_Service;
	protected $_newStyle;
	protected $tabInformations ;
	protected $nomService;
	protected $infosComp;
	protected $periodeIntervention;
	
	
	
	public function __construct() {
		$this->_page = new Page ( Page::SIZE_A4 );
		
		$this->_yPosition = 750;
		$this->_leftMargin = 50;
		$this->_pageHeight = $this->_page->getHeight ();
		$this->_pageWidth = $this->_page->getWidth ();
		/**
		 * Pas encore utilisï¿½
		 */
		$this->_normalFont = Font::fontWithName ( ZendPdf\Font::FONT_HELVETICA );
		$this->_boldFont = Font::fontWithName ( ZendPdf\Font::FONT_HELVETICA_BOLD );
		/**
		 * ****************
		 */
		$this->_newTime = Font::fontWithName ( ZendPdf\Font::FONT_TIMES_ROMAN );
		$this->_newTimeGras = Font::fontWithName ( ZendPdf\Font::FONT_TIMES_BOLD_ITALIC );
		$this->_policeContenu = ZendPdf\Font::fontWithName ( ZendPdf\Font::FONT_TIMES );
		$this->_newPolice = ZendPdf\Font::fontWithName ( ZendPdf\Font::FONT_TIMES );
		
		$this->_newStyle = ZendPdf\Font::fontWithName ( ZendPdf\Font::FONT_COURIER_BOLD );
	}
	public function getPage() {
		//$this->layout()->setTemplate('layout/accouchement');
		return $this->_page;
	}
	public function addNoteTC() {
		$this->_page->saveGS ();
		
		$this->setEnTete ();
		$this->getNoteTC ();
		$this->getPiedPage ();
		
		$this->_page->restoreGS ();
	}
	
	public function setTabInformations($tabInformations)
	{
		$this->tabInformations = $tabInformations;
	}
	
	public function getTabInformations()
	{
		return $this->tabInformations;
	}
	
	public function setNomService($nomService)
	{
		$this->nomService = $nomService;
	}
	public function setInfosComp($infosComp)
	{
		$this->infosComp = $infosComp;
	}
public function setEnTete() {
		$baseUrl = $_SERVER ['SCRIPT_FILENAME'];
		$tabURI = explode ( 'public', $baseUrl );
		$imageHeader = ZendPdf\Image::imageWithPath ( $tabURI [0] . 'public\images_icons\hrs1.png' );
		$this->_page->drawImage ( $imageHeader, 445, 		// -x
		$this->_pageHeight - 140, 		// -y
		548, 		// +x
		787 ); // +y
		
		$this->_page->setFont ( $this->_newTime, 10 );
		$this->_page->drawText ( 'République du Sénégal', $this->_leftMargin, $this->_pageHeight - 50 );
		$this->_page->setFont ( $this->_newTime, 10 );
		$this->_page->drawText ( 'Ministère de la santé et de l\'action sociale', $this->_leftMargin, $this->_pageHeight - 65 );
		$this->_page->setFont ( $this->_newTime, 10 );
		$this->_page->drawText ( 'C.H.R de Saint-Louis', $this->_leftMargin, $this->_pageHeight - 80 );
		$this->_page->setFont ( $this->_newTime, 10 );
		$this->_page->drawText ( 'Service: ' . iconv ( 'UTF-8', 'ISO-8859-1', $this->_Service ), $this->_leftMargin, $this->_pageHeight - 95 );
		$font = ZendPdf\Font::fontWithName ( ZendPdf\Font::FONT_TIMES_ROMAN );
		$this->_page->setFont ( $font, 8 );
		$today = new \DateTime ();
		$dateNow = $today->format ( 'd/m/Y' );
		$this->_page->drawText ( 'Saint-Louis le, ' . $dateNow, 450, $this->_pageHeight - 50 );
	}
	public function setDonneesPatientTC($donneesPatient) {
		$this->_DonneesPatient = $donneesPatient;
	}
	public function setDonneesMedecinTC($donneesMedecin) {
		$this->_DonneesMedecin = $donneesMedecin;
	}
	public function setDonneesDemandeTC($donneesDemande) {
		$this->_DonneesDemande = $donneesDemande;
	}
	public function setService($service) {
		$this->_Service = $service;
	}
	public function setIdConsTC($id_cons) {
		$this->_id_cons = $id_cons;
	}
	public function getNewItalique() {
		$font = ZendPdf\Font::fontWithName ( ZendPdf\Font::FONT_HELVETICA_OBLIQUE );
		$this->_page->setFont ( $font, 12 );
	}
	public function getNewTime() {
		$font = ZendPdf\Font::fontWithName ( ZendPdf\Font::FONT_TIMES_ROMAN );
		$this->_page->setFont ( $font, 12 );
	}
	protected function scinderText($Text) {
		$tab = array ();
		$tab [1] = substr ( $Text, 0, 95 );
		$tab [2] = substr ( $Text, 95, 110 );
		$tab [3] = substr ( $Text, 205, 110 );
		return $tab;
	}
	protected function scinderTextO($Text) {
		$tab = array ();
		$tab [1] = substr ( $Text, 0, 90 );
		$tab [2] = substr ( $Text, 90, 110 );
		$tab [3] = substr ( $Text, 200, 110 );
		return $tab;
	}
	protected function scinderTextPO($Text) {
		$tab = array ();
		$tab [1] = substr ( $Text, 0, 80 );
		$tab [2] = substr ( $Text, 80, 110 );
		$tab [3] = substr ( $Text, 190, 110 );
		$tab [4] = substr ( $Text, 300, 110 );
		$tab [5] = substr ( $Text, 410, 110 );
		$tab [6] = substr ( $Text, 520, 110 );
		return $tab;
	}
	protected function nbAnnees($debut, $fin) {
		// 60 secondes X 60 minutes X 24 heures dans une journee
		$nbSecondes = 60 * 60 * 24 * 365;
		
		$debut_ts = strtotime ( $debut );
		$fin_ts = strtotime ( $fin );
		$diff = $fin_ts - $debut_ts;
		return ( int ) ($diff / $nbSecondes);
	}
	protected function getNoteTC() {
		$Control = new DateHelper ();
		
		$this->_yPosition -= 35;
		$this->_page->setFont ( $this->_newTime, 15 );
		$this->_page->setFillColor ( new ZendPdf\Color\Html ( 'green' ) );
		$this->_page->drawText ( 'Certificat d\'Accouchement', $this->_leftMargin + 160, $this->_yPosition );
		$this->_yPosition -= 5;
		$this->_page->setlineColor ( new ZendPdf\Color\Html ( 'green' ) );
		$this->_page->drawLine ( $this->_leftMargin, $this->_yPosition, $this->_pageWidth - $this->_leftMargin, $this->_yPosition );
		$noteLineHeight = 30;
		$this->_yPosition -= 15;
		
		$this->_page->setFillColor ( new ZendPdf\Color\Html ( 'black' ) );
		
		$this->_page->setLineColor ( new ZendPdf\Color\Html ( '#999999' ) );
		
		$today = new \DateTime ();
		$date_actu = $today->format ( 'Y-m-d' );
		$this->_yPosition -= 15; // allez a ligne suivante
	
		
		$this->_page->setFont ( $this->_newTime, 13 );
		$this->_page->drawText ('Je soussigné(e) ', 
				$this->_leftMargin, 
				$this->_yPosition 
		);
// 		if($this->_DonneesMedecin ['sexeMedecin']=='Masculin'){
// 		$this->_page->setFont ( $this->_newStyle, 12 );
// 		$this->_page->drawText ( 'Mr '.$this->_DonneesMedecin ['prenomMedecin'].'  '.$this->_DonneesMedecin ['nomMedecin'], 
// 				$this->_leftMargin + 100, 
// 				$this->_yPosition );
// 		}
		//else{
			$this->_page->setFont ( $this->_newStyle, 12 );
			$this->_page->drawText ( '',//.$this->_DonneesMedecin ['prenomMedecin'].'  '.$this->_DonneesMedecin ['nomMedecin'],
					$this->_leftMargin + 100,
					$this->_yPosition );
		//}
		$this->_yPosition -= $noteLineHeight;
		
		$this->_page->setFont ( $this->_newTime, 13 );
		$this->_page->drawText ('certifie que Madame ',
				$this->_leftMargin,
				$this->_yPosition
		);
		
		$this->_page->setFont ( $this->_newStyle, 12 );
		$this->_page->drawText ( $this->_DonneesPatient ['PRENOM'] . ' ' . $this->_DonneesPatient ['NOM'],
				$this->_leftMargin + 130,
				$this->_yPosition ); 
		
		$date_naissance = $this->_DonneesPatient ['DATE_NAISSANCE'];
		if ($date_naissance) {
			$date_naissance = $Control->convertDate ( $date_naissance );
		} else {
			$date_naissance = null;
		}
		$this->_yPosition -= $noteLineHeight;
		if ($date_naissance) {
			$this->_page->setFont ( $this->_newTime, 13 );
			$this->_page->drawText ('née le ',
					$this->_leftMargin,
					$this->_yPosition
			);
			$this->_page->setFont ( $this->_newStyle, 12 );
			$this->_page->drawText ( $date_naissance,
					$this->_leftMargin + 50,
					$this->_yPosition );
			
		} else {
			$this->_page->setFont ( $this->_newTime, 13 );
			$this->_page->drawText ('âgée de ',
					$this->_leftMargin,
					$this->_yPosition
			);
			
			$this->_page->setFont ( $this->_newStyle, 12 );
			$this->_page->drawText ( $this->_DonneesPatient ['AGE'].' ans',
					$this->_leftMargin + 50,
					$this->_yPosition );
		}
		
	
		$this->_yPosition -= $noteLineHeight;
		
		$this->_page->setFont ( $this->_newTime, 13 );
		$this->_page->drawText ('A accouché le ',
				$this->_leftMargin,
				$this->_yPosition
		);
		
		$this->_page->setFont ( $this->_newStyle, 12 );
		$this->_page->drawText (  $this->_DonneesDemande ['date_accouchement'],
				$this->_leftMargin + 80,
				$this->_yPosition );
		
		
		
		
		$this->_page->setFont ( $this->_newTime, 13 );
		$this->_page->drawText ('à ',
				$this->_leftMargin+170,
				$this->_yPosition
		);
			
		$this->_page->setFont ( $this->_newStyle, 12 );
		$this->_page->drawText ( $this->_DonneesDemande ['heure_accouchement'],
				$this->_leftMargin + 190,
				$this->_yPosition );
		
		
		
		

		
		
		$this->_page->setFont ( $this->_newTime, 13 );
		$this->_page->drawText ('de  ',
				$this->_leftMargin+270,
				$this->_yPosition
		);
		$this->_page->setFont ( $this->_newStyle, 12 );
		$this->_page->drawText ( $this->_DonneesDemande ['nb_bb'].' enfant(s)',
				$this->_leftMargin + 290,
				$this->_yPosition );
		$this->_yPosition -= $noteLineHeight;
		$this->_page->setFont ( $this->_newTime, 13 );
		$this->_page->drawText ('Sexe ',
				$this->_leftMargin+70,
				$this->_yPosition
		);
		$this->_page->setFont ( $this->_newTime, 13 );
		$this->_page->drawText ('Vivant et bien Portant ',
				$this->_leftMargin +150,
				$this->_yPosition
		);
		$this->_page->setFont ( $this->_newTime, 13 );
		$this->_page->drawText ('Mort-Né ',
				$this->_leftMargin+330,
				$this->_yPosition
		);
		for($i=1;$i<=$this->_DonneesDemande ['nb_bb'];$i++){
		$this->_yPosition -= $noteLineHeight;
		
		$this->_page->setFont ( $this->_newTime, 13 );
		$this->_page->drawText ('- Enfant '.$i.' :',
				$this->_leftMargin,
				$this->_yPosition
		);
		
$this->_page->setFont ( $this->_newStyle, 12 );
		$this->_page->drawText ( $this->_DonneesDemande ['sexe_'.$i],
				$this->_leftMargin +80,
				$this->_yPosition );
		
		
		$this->_page->setFont ( $this->_newStyle, 12 );
		$this->_page->drawText ( $this->_DonneesDemande  ['viv_bien_portant_'.$i],
				$this->_leftMargin + 200,
				$this->_yPosition );
		//$this->_yPosition -= $noteLineHeight;
		
		
		$this->_page->setFont ( $this->_newStyle, 12 );
		$this->_page->drawText ( $this->_DonneesDemande  ['decede_'.$i],
				$this->_leftMargin + 340,
				$this->_yPosition );
		}

		$this->_yPosition -= $noteLineHeight;
		$this->_page->setFont ( $this->_newTime, 13 );
		$this->_page->drawText ('Prénommé(s) :',
				$this->_leftMargin,
				$this->_yPosition
		);
		$this->_page->setFont ( $this->_newStyle, 12 );
		$this->_page->drawText ('bébé(s) '. $this->_DonneesDemande ['prenome'],
				$this->_leftMargin + 80,
				$this->_yPosition );
		
		
		
		
		
		
		
		
		
 		$this->_page->setFont ( $this->_policeContenu, 14 );
 		$this->_page->drawText ( 'Signature', $this->_leftMargin + 300, 230 );
	}
	public function getPiedPage() {
		$this->_page->setlineColor ( new ZendPdf\Color\Html ( 'green' ) );
		$this->_page->setLineWidth ( 1.5 );
		$this->_page->drawLine ( $this->_leftMargin, 120, $this->_pageWidth - $this->_leftMargin, 120 );
		
		$this->_page->setFont ( $this->_newTime, 10 );
		$this->_page->drawText ( 'Téléphone: 33 961 00 21', $this->_leftMargin, $this->_pageWidth - (100 + 390) );
		
		$this->_page->setFont ( $this->_newTime, 10 );
		$this->_page->drawText ( 'SIMENS+: ', $this->_leftMargin + 355, $this->_pageWidth - (100 + 390) );
		$this->_page->setFont ( $this->_newTimeGras, 11 );
		$this->_page->drawText ( 'www.simens.sn', $this->_leftMargin + 405, $this->_pageWidth - (100 + 390) );
	}

	function CorpsDocument(){
	
		$tabInformations = $this->getTabInformations();
	
		if($tabInformations){
	
			for($i=0 ; $i < count($tabInformations) ; $i++){
	
				if($i%2==0){
						
					$this->Ln(5.4);
					$this->SetFillColor(220,220,220);
					$this->SetDrawColor(205,193,197);
					$this->SetTextColor(0,0,0);
					//$this->AddFont('zap','','zapfdingbats.php');
					//$this->SetFont('zap','',13);
	
					$this->AddFont('timesb','','timesb.php');
					$this->AddFont('timesi','','timesi.php');
					$this->AddFont('times','','times.php');
						
					$this->Cell(25,7,($i+1).')','BT',0,'L',1);
	
					$this->SetFont('times','',12.5);
					$this->Cell(78,7,iconv ('UTF-8' , 'windows-1252', $tabInformations[0][$i]),'BT',0,'L',1);
					$this->Cell(80,7,iconv ('UTF-8' , 'windows-1252', $tabInformations[1][$tabInformations[0][$i]]),'BT',0,'L',1);
						
					$this->Ln(2);
					$this->SetFillColor(249,249,249);
					$this->SetDrawColor(220,220,220);
						
				}else {
						
					$this->Ln(5.4);
					$this->SetFillColor(240,240,240);
					$this->SetDrawColor(205,193,197);
					$this->SetTextColor(0,0,0);
					//$this->AddFont('zap','','zapfdingbats.php');
					//$this->SetFont('zap','',13);
	
					$this->AddFont('timesb','','timesb.php');
					$this->AddFont('timesi','','timesi.php');
					$this->AddFont('times','','times.php');
						
					$this->Cell(25,7,($i+1).')','BT',0,'L',1);
	
					$this->SetFont('times','',12.5);
					$this->Cell(78,7,iconv ('UTF-8' , 'windows-1252', $tabInformations[0][$i]),'BT',0,'L',1);
					$this->Cell(80,7,iconv ('UTF-8' , 'windows-1252', $tabInformations[1][$tabInformations[0][$i]]),'BT',0,'L',1);
	
					$this->Ln(2);
					$this->SetFillColor(249,249,249);
					$this->SetDrawColor(220,220,220);
				}
					
			}
				
		}else{
			echo  "<div align='center' style='font-size: 30px; font-family: times new roman;'> Aucune information à afficher </div>"; exit();
		}
	
	
	}
	//IMPRESSION DES INFOS STATISTIQUES
	//IMPRESSION DES INFOS STATISTIQUES
	function ImpressionInfosStatistiques()
	{
		//$this->AddPage();
		//$this->setEnTete();
		//$this->CorpsDocument();
	}
}