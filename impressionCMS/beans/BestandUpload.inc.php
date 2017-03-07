<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: BestandUpload.inc.php
 * Beschrijving: De klasse om het uploaden van bestanden af te handelen
 */
 
 class BestandUpload {
 	private $darrBestand;
 	private $strVeldNaam;
 	
 	public function __construct( $darrBestand, $strVeldNaam ) {
 		$this->darrBestand = $darrBestand;
 		$this->strVeldNaam = $strVeldNaam;
 	}
 	
 	// Functie om te checken of de grootte van het bestand niet hoger is dan het maximum.
 	public function checkSize( $intMaxSize ) {
 		if($this->darrBestand[''][''] > $intMaxSize) {
 			return false;
 		}
 		else {
 			return true;
 		}
 	}
 	// Functie om te checken of de extensie wel is toegestaan
 	public function checkExtensies( $arrExtensies ) {
 		$arrBestandOpgedeeld = explode("\\",$this->darrBestand[$this->strVeldNaam]['name']);
 		$strExtensie = strtoupper($arrBestandOpgedeeld[ (count($this->darrBestand[$this->strVeldNaam]['name']) - 1) ]);
 		
		$intArraySize = count($arrExtensies);
		for($intTeller = 0; $intTeller < $intArraySize; $intTeller++) {
			if($arrExtensies[$intTeller] == $strExtensies)
				return true;
		}
		return false;
 	}
 	// Functie om de naam van het bestant te checken
 	public function checkNaam( $strNaam ) {
 		$strNaam = getNaam();
 	}
 	// Functie om een bestand te verplaatsen
 	public function verplaatstBestand( ) {
 		//verplaatst
 	}
 	// Functie om de naam op te vragen
	public function getNaam() {
		return $this->darrBestand[$this->strVeldNaam][''];
	}
 	// Functie om tijdelijke naam op te vragen
 	public function getTmpNaam() {
 		return $this->darrBestand[$this->strVeldNaam]['tmp_name'];
 	}
 	// Functie om bestandsgrootte op te vragen
 	public function getBestandsGrootte() {
 		return $this->darrBestand[$this->strVeldNaam]['size'];
 	}
 	// Functie om de errorcode op te vragen
 	public function getErrorCode() {
 		return $this->darrBestand[$this->strVeldNaam]['error'];
 	}
 	// Functie om de type op te vragen
 	public function getMimeType() {
 		return $this->darrBestand[$this->strVeldNaam]['type'];
 	}
 	
 }
 
 
 
 ?>