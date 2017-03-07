<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: xmlParser.inc.php
 * Beschrijving: De xmlParser-klasse. Deze zorgt voor het aanroepen en inladen van het XML-bestand.
 * Daarnaast zet deze klasse ook de XML om naar leesbare content, mbv. de stylesheets.
 */
 
class xmlParser {
 private $xml;
 private $xmlFile;
 private $strURL;
 private $stylesheet;
 private $processor;
 private $result;
 private $txtOutput;
 private $strFunctieURL;
 private $strXMLscript;
 private $strXSLTmenu;
 private $strXSLTpagina;
 private $strXSLTheadlines;
 private $strXSLTblok;
 private $strSiteURL;
 private $strSiteCode;
 private $intWebsiteID;
	
 public function __construct( ) {
	// Global vars van de variabelen uit config.php maken
	global $strFunctiesURL;
	global $strXMLscript;
	global $strXSLTpagina;
	global $strXSLTmenu;
	global $strXSLTblok;
	global $strXSLTheadlines;
	global $strSiteURL;
	global $strSiteCode;
	global $intWebsiteID;

	// Variabelen inladen in de klasse 
	$this->strFunctiesURL = $strFunctiesURL;
	$this->strXMLscript = $strXMLscript;
	$this->strXSLTpagina = $strXSLTpagina;
	$this->strXSLTmenu = $strXSLTmenu;
	$this->strXSLTblok = $strXSLTblok;
	$this->strXSLTheadlines = $strXSLTheadlines;
	$this->strSiteURL = $strSiteURL;
	$this->strSiteCode = $strSiteCode;
	$this->intWebsiteID = $intWebsiteID;
	setType($this->intWebsiteID, "integer");
 }
 
 public function getMenu( $strMenuType = 'small' ) {
 	// URL 
	$this->strURL = $this->strFunctiesURL.$this->strXMLscript."?menutype=".$strMenuType."&sitecode=".$this->strSiteCode."&wid=".$this->intWebsiteID; 
	// Checken of de URL wel geldig is en bestaat
	if(file($this->strURL)) {
		$this->xmlFile = simplexml_load_file($this->strURL);
	}
	else {
		$strError = "<website>\n";
		$strError .= "  <error>\n";
		$strError .= "    <errorcode>4</errorcode>\n";
		$strError .= "    <errorbericht>Het gegevensbestand kon niet worden gevonden.</errorbericht>\n";
		$strError .= "  </error>\n";
		$strError .= "</website>\n";
		return $strError;
	}	
	// Bestand bestaat, dus verder gaan 
	if(!$this->xmlFile) {
		return false;
	}
	else {
	 	if(isset($this->xmlFile->onderdeel)) {
  			$this->stylesheet = new DomDocument();
  			$this->stylesheet->load($this->strSiteURL . $this->strXSLTmenu);
  
  			$this->processor = new XSLTProcessor();
  			$this->processor->importStylesheet($this->stylesheet);
  
  			$this->result = $this->processor->transformToDoc($this->xmlFile);
  			return fixData($this->result->saveXML());
   		}
	}
 }
 // Functie om de inhoud van de pagina op te vragen.
 public function getInhoud( $intOnderdeelID, $intPaginaID, $intPaginaDeelNr = 0, $intBlokID = 0) {
	// Hier wordt gecheckt of er nog een aparte ID is meegegeven, zoja..dan wordt die meegegeven als nfID
	// De overige parameters in de URL zijn: oid (OnderdeelID), pid (PaginaID), sitecode (De unieke code) en wid (WebsiteID)
 	if($intBlokID != 0) {
 		$this->strURL = $this->strFunctiesURL.$this->strXMLscript."?oid=".$intOnderdeelID."&pid=".$intPaginaID."&pagdnr=".$intPaginaDeelNr."&bid=".$intBlokID."&sitecode=".$this->strSiteCode."&wid=".$this->intWebsiteID;
 	}
 	else {
 		$this->strURL = $this->strFunctiesURL.$this->strXMLscript."?oid=".$intOnderdeelID."&pid=".$intPaginaID."&pagdnr=".$intPaginaDeelNr."&sitecode=".$this->strSiteCode."&wid=".$this->intWebsiteID;
 	}

 	// Checkt of het bestand bestaat
	// Zo ja, dan wordt het ingeladen
	// Zo nee, dan wordt een errorcode in XML terug gestuurd
	if(file($this->strURL)) {
		$this->xmlFile = simplexml_load_file($this->strURL);
	}
	else {
		$strError = "<website>\n";
		$strError .= "  <error>\n";
		$strError .= "    <errorcode>4</errorcode>\n";
		$strError .= "    <errorbericht>Het gegevensbestand kon niet worden gevonden.</errorbericht>\n";
		$strError .= "  </error>\n";
		$strError .= "</website>\n";
		return $strError;
	}

	// Als het bestand bestaat, gaat het verder
	if(!$this->xmlFile) {
		$strError = "<website>\n";
		$strError .= "  <error>\n";
		$strError .= "    <errorcode>5</errorcode>\n";
		$strError .= "    <errorbericht>Het gegevensbestand is niet goed ingedeeld.</errorbericht>\n";
		$strError .= "  </error>\n";
		$strError .= "</website>\n";
		return $strError;
	}
	else {
   		if(isset($this->xmlFile->error) || isset($this->xmlFile->pagina->error) || isset($this->xmlFile->pagina)) {
  			$this->stylesheet = new DomDocument();
  			$this->stylesheet->load($this->strSiteURL . $this->strXSLTpagina);
  
  			$this->processor = new XSLTProcessor();
  			$this->processor->importStylesheet($this->stylesheet);
  
  			$this->result = $this->processor->transformToDoc($this->xmlFile);
  			return fixData($this->result->saveXML());
   		}
 	}
 }
// Functie om de headlines op te vragen 
public function getHeadlines( $intAantal = 0, $intPaginaID = 0, $strVolgorde = A) {
	$this->strURL = $this->strFunctiesURL.$this->strXMLscript."?sitecode=".$this->strSiteCode."&wid=".$this->intWebsiteID;

	if($intAantal > 0) 
		$this->strURL .= "&aantal=" . $intAantal;
	else
		$this->strURL .= "&aantal=0";
	if($intPaginaID != 0 && $intPaginaID > 0)
		$this->strURL .= "&pid=".$intPaginaID;
	$this->strURL .= "&volg=".$strVolgorde;

	if(file($this->strURL)) {
		$this->xmlFile = simplexml_load_file($this->strURL);
	}
	else {
		$strError = "<website>\n";
		$strError .= "  <error>\n";
		$strError .= "    <errorcode>4</errorcode>\n";
		$strError .= "    <errorbericht>Het gegevensbestand kon niet worden gevonden.</errorbericht>\n";
		$strError .= "  </error>\n";
		$strError .= "</website>\n";
		return $strError;
	}

	// Als het bestand bestaat, gaat het verder
	if(!$this->xmlFile) {
		$strError = "<website>\n";
		$strError .= "  <error>\n";
		$strError .= "    <errorcode>5</errorcode>\n";
		$strError .= "    <errorbericht>Het gegevensbestand is niet goed ingedeeld.</errorbericht>\n";
		$strError .= "  </error>\n";
		$strError .= "</website>\n";
		return $strError;
	}
	else {
   		if(isset($this->xmlFile->error) || isset($this->xmlFile->pagina->error) || isset($this->xmlFile->pagina)) {
  			$this->stylesheet = new DomDocument();
  			$this->stylesheet->load($this->strSiteURL . $this->strXSLTheadlines);
  
  			$this->processor = new XSLTProcessor();
  			$this->processor->importStylesheet($this->stylesheet);
  
  			$this->result = $this->processor->transformToDoc($this->xmlFile);
  			return fixData($this->result->saveXML());
   		}   		   		
 	}
 }
 // Functie om de inhoud van de pagina op te vragen.
 public function getEmailBericht( $intBlokID, $arrWaarden) {
	// Hier wordt de URL aangeroepen
	$this->strURL = $this->strFunctiesURL.$this->strXMLscript."?mail=true&bid=".$intBlokID."&sitecode=".$this->strSiteCode."&wid=".$this->intWebsiteID;
	// Checkt of het bestand bestaat
	// Zo ja, dan wordt het ingeladen
	// Zo nee, dan wordt een errorcode in XML terug gestuurd
	if(file($this->strURL)) {
		$this->xmlFile = simplexml_load_file($this->strURL);
	}
	else {
		$strError = "<website>\n";
		$strError .= "  <error>\n";
		$strError .= "    <errorcode>4</errorcode>\n";
		$strError .= "    <errorbericht>Het gegevensbestand kon niet worden gevonden.</errorbericht>\n";
		$strError .= "  </error>\n";
		$strError .= "</website>\n";
		return $strError;
	}

	// Als het bestand bestaat, gaat het verder
	if(!$this->xmlFile) {
		$strError = "<website>\n";
		$strError .= "  <error>\n";
		$strError .= "    <errorcode>5</errorcode>\n";
		$strError .= "    <errorbericht>Het gegevensbestand is niet goed ingedeeld.</errorbericht>\n";
		$strError .= "  </error>\n";
		$strError .= "</website>\n";
		return $strError;
	}
	else {
   		// Waarden vooraf:
   		$strEmailadres = "";
   		$strTekst = "";
		if(isset($arrWaarden['legevelden']) && $arrWaarden['legevelden'] == true)
			$booError = true;
		else
			$booError = false;

   		// Vraag e-mailadres op
   		if(isset($this->xmlFile->emailbericht->emailadres)) {
			foreach($this->xmlFile->emailbericht->emailadres[0]->attributes() as $a => $b) {
			  $strEmailadres = $b;
			}
		}

		if($strEmailadres == "") {
			$booError = true;
		}
		elseif($booError == false) {
			global $strEigenaarNaam;
			global $strEigenaarEmail;

			// Hieronder wordt het e-mailtje opgesteld wat de gebruiker krijgt.
			$arrData = convertDatumTijd(getDatumTijd());
			$strBericht = "Via uw website is er om ".$arrData['uur'].":".$arrData['minuten']." op ".$arrData['dag']."-".$arrData['maand']."-".$arrData['jaar']." een bericht verstuurd.\n\n";
			$strBericht .= "De gegevens staan hieronder vermeld:\n";
			$strBericht .= "Naam: ".$arrWaarden['naam']."\n";
			$strBericht .= "E-mailadres: ".$arrWaarden['email']."\n";
			if(isset($arrWaarden['straat']))
				$strBericht .= "Straatnaam: ".$arrWaarden['straat']."\n";
			if(isset($arrWaarden['huisnr']))
				$strBericht .= "Huisnummer: ".$arrWaarden['huisnr']."\n";
			if(isset($arrWaarden['postcode']))
				$strBericht .= "Postcode: ".$arrWaarden['postcode']."\n";
			if(isset($arrWaarden['woonplaats']))
				$strBericht .= "Woonplaats: ".$arrWaarden['woonplaats']."\n";
			if(isset($arrWaarden['telnr']))
				$strBericht .= "Telefoonnummer: ".$arrWaarden['telnr']."\n";
			if(isset($arrWaarden['mobielnr']))
				$strBericht .= "Mobielnummer: ".$arrWaarden['mobielnr']."\n";
			$strBericht .= "IP-Adres: ".$_SERVER['REMOTE_ADDR']."\n";
			$strBericht .= "Opmerkingen: \n".$arrWaarden['comment']."\n";
			$strBericht .= "\n\nEinde van dit automatisch gegenereerde bericht.\n";
			$strBericht .= "------------------------------------------------------------------\n";
			$strBericht .= "Neem contact op met ".$strEigenaarNaam." als iemand deze service misbruikt. \nStuur dan de bovenstaande gegevens door naar ".$strEigenaarEmail.".";
			
			// Verstuur de e-mail
			if(!mail($strEmailadres, "Bericht via uw website", $strBericht, getHeaders( $arrWaarden['naam'], $arrWaarden['email'] ))) {
				$booError = true;
			}
		}
		
		// Er heeft zich een error voor gedaan.
		if($booError == true) {
			$strTekst .= "<p class=\"contactKOP\">".$this->xmlFile->emailbericht->titel."</p>";
			$strTekst .= "<p class=\"contactKOP\">".$this->xmlFile->emailbericht->nietverstuurd."</p>";
		}
		// Er heeft zich geen error voor gedaan.
		else {
			$strTekst .= "<p class=\"contactKOP\">".$this->xmlFile->emailbericht->titel."</p>";
			$strTekst .= "<p class=\"contactKOP\">".$this->xmlFile->emailbericht->verstuurd."</p>";
		}
		// Stuurt de tekst decoded terug 
		return html_entity_decode($strTekst);

 	}
 }
 public function getBlok( $intBlokID ) {
 	// URL 
	$this->strURL = $this->strFunctiesURL.$this->strXMLscript."?blokid=".$intBlokID."&sitecode=".$this->strSiteCode."&wid=".$this->intWebsiteID; 
	// Checken of de URL wel geldig is en bestaat
	if(file($this->strURL)) {
		$this->xmlFile = simplexml_load_file($this->strURL);
	}
	else {
		$strError = "<website>\n";
		$strError .= "  <error>\n";
		$strError .= "    <errorcode>4</errorcode>\n";
		$strError .= "    <errorbericht>Het gegevensbestand kon niet worden gevonden.</errorbericht>\n";
		$strError .= "  </error>\n";
		$strError .= "</website>\n";
		return $strError;
	}
	
	// Bestand bestaat, dus verder gaan 
	if(!$this->xmlFile) {
		return false;
	}
	else {
   		if(isset($this->xmlFile->error) || isset($this->xmlFile->pagina->error) || isset($this->xmlFile->pagina)) {
	  			$this->stylesheet = new DomDocument();
	  			$this->stylesheet->load($this->strSiteURL . $this->strXSLTblok);
	  
	  			$this->processor = new XSLTProcessor();
	  			$this->processor->importStylesheet($this->stylesheet);
	  
	  			$this->result = $this->processor->transformToDoc($this->xmlFile);
	  			return fixData($this->result->saveXML());
   		}
	}

 		
 }

  
} 
 ?>