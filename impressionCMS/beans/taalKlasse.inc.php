<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: contactformContentBlok.inc.php
 * Beschrijving: De subklassen van ContentBlokken: contactformContentBlok
 */

// De klasse contactformContentBlok
class taalKlasse {
	private $strTaal;

	// De constructor
	public function __construct( $strTaal = "nl" ) {
		$this->strTaal = $strTaal;
	}
	// setTaal-functie
	public function setTaal( $newTaal ) {
		$this->strTaal = $newTaal;	
	}
	// De getfuncties voor de woorden
	public function getNaam() {
		if($this->strTaal == "nl")
			return "Naam";
		elseif($this->strTaal == "en")
			return "Name";
	}
	public function getEmail() {
		if($this->strTaal == "nl")
			return "E-mailadres";
		elseif($this->strTaal == "en")
			return "E-mailadress";
	}
	public function getStraat() {
		if($this->strTaal == "nl")
			return "Straatnaam";
		elseif($this->strTaal == "en")
			return "Streetname";
	}
	public function getHuisNr() {
		if($this->strTaal == "nl")
			return "Huisnummer";
		elseif($this->strTaal == "en")
			return "No.";
	}
	public function getPostcode() {
		if($this->strTaal == "nl")
			return "Postcode";
		elseif($this->strTaal == "en")
			return "Zipcode";
	}
	public function getPlaats() {
		if($this->strTaal == "nl")
			return "Woonplaats";
		elseif($this->strTaal == "en")
			return "Place";
	}
	public function getTelNr() {
		if($this->strTaal == "nl")
			return "Telefoonnummer";
		elseif($this->strTaal == "en")
			return "Phonenumber";
	}
	public function getMobielNr() {
		if($this->strTaal == "nl")
			return "Mobiele nummer";
		elseif($this->strTaal == "en")
			return "Mobile phone";
	}
	public function getOpmerking() {
		if($this->strTaal == "nl")
			return "Opmerkingen";
		elseif($this->strTaal == "en")
			return "Comment";
	}
	public function getKnop() {
		if($this->strTaal == "nl")
			return "Verstuur e-mail";
		elseif($this->strTaal == "en")
			return "Send message";
	}

}  
?>