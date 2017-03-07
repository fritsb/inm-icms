<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Template.php
 * Beschrijving: De Template-klasse. Deze zorgt voor het inladen van de templatefile en voor het 
 * vervangen van de tags door content.
 */

class Template {
	private $txtContent;
	private $txtHeadlines;
	private $txtMenu;
	private $txtBlok;
	private $intSiteID;
	private $strBestandsNaam;
	private $site;
	private $intOnderdeelID;
	private $intPaginaID;
	private $intPagDeelNr;
	private $intBlokID;
	private $intWebsiteID;
	private $strBekeken;
	
	// Functie om de klasse aan te maken
	public function __construct( $strBestandsNaam ) {
		// Checkt of het bestand wel bestaat
		if(!file($strBestandsNaam)) {
			$this->strBestandsNaam = false;
		}
		else {
			$this->strBestandsNaam = $strBestandsNaam;			
		}
		// Standaard instellingen
		$this->intOnderdeelID = 1;
		$this->intPaginaID = 0;
		$this->intPagDeelNr = 0;
		$this->strBekeken = "nee";
	   $this->site = file_get_contents($this->strBestandsNaam);
	}
	// Functie om de variabelen te setten
	public function set($varNaam, $strInhoud) {
		$this->$varNaam = $strInhoud;
	}
	// De get-methodes
	public function get($varNaam) {
		return $this->$varNaam;
	}
	public function getOID() {
		return $this->intOnderdeelID;
	}
	public function getPID() {
		return $this->intPaginaID;
	}
	public function getPagNr() {
		return $this->intPagNr;
	}

	// Functie om site te laten zien 
	public function displaySite() {
		if($this->strBekeken == "nee" && $this->strBestandsNaam != false) {
			$this->objXMLParser = new xmlParser();
			// De content-tag wordt vervangen
			if(eregi("<%-CONTENT-%>", $this->site)) {
				$this->txtContent = $this->objXMLParser->getInhoud( $this->intOnderdeelID, $this->intPaginaID, $this->intPagDeelNr, $this->intBlokID );
			  	$this->site = eregi_replace("<%-CONTENT-%>", $this->txtContent, $this->site);
			}
			// De headlinestags en menutag worden vervangen
			$this->site = $this->replaceHeadlinesTag( $this->site);
			$this->site = $this->replaceMenuTag( $this->site );
			$this->site = $this->replaceBlokTag( $this->site );
			
			$this->strBekeken = "ja";
			return $this->site;
		}
	}
	// Functie om melding te laten zien als een e-mail via het contactformulier verstuurd is
	public function verwerkEmail( $arrWaarden ) {
		if($this->strBekeken == "nee" && $this->strBestandsNaam != false) {
			$this->objXMLParser = new xmlParser();
			// De content-tag wordt vervangen
			if(eregi("<%-CONTENT-%>", $this->site)) {
				$this->txtContent = $this->objXMLParser->getEmailBericht( $this->intBlokID, $arrWaarden );
			  	$this->site = eregi_replace("<%-CONTENT-%>", $this->txtContent, $this->site);
			}
			// De headlinestags en menutag worden vervangen
			$this->site = $this->replaceHeadlinesTag( $this->site);
			$this->site = $this->replaceMenuTag( $this->site );
			$this->site = $this->replaceBlokTag( $this->site );
			
			$this->strBekeken = "ja";
			return $this->site;
		}
	}
	
	// Functie om alle headline-tags te vervangen door content.
	public function replaceHeadlinesTag( $strContent ) {
			$intAantal = "";
			$intPaginaID = 0;
			$strVolgorde = "A";
			// Alle contentheadlines-tags worden vervangen met eigen opgegeven instellingen
			while(eregi("<%-HEADLINES-%>", $strContent) && eregi("</%-HEADLINES-%>", $strContent)) {
				// De opties opvragen
			  	$intPosBegin = strripos($strContent, "<%-HEADLINES-%>") + 15;
		  		$intPosEind = strripos($strContent, "</%-HEADLINES-%>");
			  	$strOpties = substr($strContent, $intPosBegin, $intPosEind - $intPosBegin);
			  	// Checken of er meerdere opties zijn en opvragen
			  	if(eregi("-",$strOpties)) {
			  		$arrOpties = explode("-", $strOpties);
			  		if(isset($arrOpties[0]))
				  		$intAantal = $arrOpties[0];
			  		if(isset($arrOpties[1]))
				  		$intPaginaID = $arrOpties[1];
				  	if(isset($arrOpties[2]))
				  		$strVolgorde = $arrOpties[2];
			  		setType( $intAantal, "integer");
			  		setType( $intPaginaID , "integer");
			  		$strVolgorde = substr($strVolgorde, 0, 1);
			  	}
			  	else {
			  		$intAantal = $strOpties;
			  		setType($intAantal, "integer" );
			  	}

				// De headlines opvragen en de tags vervangen
			  	$this->txtHeadlines = $this->objXMLParser->getHeadlines($intAantal, $intPaginaID, $strVolgorde);
			  	$strContent = eregi_replace("<%-HEADLINES-%>".$strOpties."</%-HEADLINES-%>", $this->txtHeadlines , $strContent);
			}
		// Data wordt terug gestuurd
		return $strContent;
	}
	// Functie om de menu-tag te vervangen door het menu
	public function replaceMenuTag( $strContent ) {
			// De menu-tags worden vervangen door een menu. Menu kan small, middle of large zijn
			if(eregi("<%-MENU-%>", $strContent) && eregi("</%-MENU-%>", $strContent)) {
			  	$intPosBegin = strripos($strContent, "<%-MENU-%>") + 10;
		  		$intPosEind = strripos($strContent, "</%-MENU-%>");
			  	$strOpties = substr($strContent, $intPosBegin, $intPosEind - $intPosBegin);
				$this->txtMenu = $this->objXMLParser->getMenu( $strOpties );
				$strContent = eregi_replace("<%-MENU-%>".$strOpties."</%-MENU-%>", $this->txtMenu, $strContent);
			}
			elseif(eregi("<%-MENU-%>", $strContent)) {
				$this->txtMenu = $this->objXMLParser->getMenu();
				$strContent = eregi_replace("<%-MENU-%>", $this->txtMenu, $strContent );
			}
		// Data wordt terug gestuurd
		return $strContent;
	}
	// Functie om de blok-tag te vervangen door een blok 
	public function replaceBlokTag( $strContent ) {
			// De blok-tags worden vervangen door een blok 
			while(eregi("<%-BLOK-%>", $strContent) && eregi("</%-BLOK-%>", $strContent)) {
			  	$intPosBegin = strripos($strContent, "<%-BLOK-%>") + 10;
		  		$intPosEind = strripos($strContent, "</%-BLOK-%>");
			  	$this->intBlokID = substr($strContent, $intPosBegin, $intPosEind - $intPosBegin);
				$this->txtBlok = $this->objXMLParser->getBlok( $this->intBlokID );
				$strContent = eregi_replace("<%-BLOK-%>".$this->intBlokID."</%-BLOK-%>", $this->txtBlok, $strContent);
			}
		// Data wordt terug gestuurd
		return $strContent;
	}
}