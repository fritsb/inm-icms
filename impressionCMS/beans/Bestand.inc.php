<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Bestand.inc.php
 * Beschrijving: De klasse Bestand
 */

class Bestand {
	private $intID;
	private $intBestandID;
	private $strBestandsNaam;
	private $strLocatie;
	private $strLocatieDir;
	private $strLocatieURL;
	private $strOmschrijving;
	private $dtDatum;
	private $intWebsiteID;
	private $strBestandType;
	private $strBestandsGrootte;
	private $strBestandsError;
	private $strOrgineleBestandsNaam;
	
	// Constructor
	public function __construct( ) {
		$this->intID = "";
		$this->intBestandID = "";
		$this->strBestandsNaam = "";
		$this->strLocatie = "";
		$this->strLocatieDir = "";
		$this->strLocatieURL = "";
		$this->strOmschrijving = "";
		$this->dtDatum = "0000-00-00 00:00:00";
		$this->intWebsiteID = "";
	}

	// get-methodes
	public function getID() {
		return $this->intID;
	}
	public function getBestandsID() {
		return $this->intBestandID;
	}
	public function getBestandsNaam() {
		return $this->strBestandsNaam;
	}
	public function getLocatie() {
		return $this->strLocatie;
	}
	public function getLocatieDir() {
		return $this->strLocatieDir;
	}
	public function getLocatieURL() {
		return $this->strLocatieURL;
	}
	public function getOmschrijving() {
		return $this->strOmschrijving;
	}
	public function getDatum() {
		return $this->dtDatum;
	}
	public function getWebsiteID() {
		return $this->intWebsiteID;
	}
	public function getBestandsType() {
		return $this->strBestandType;
	}
	public function getBestandsGrootte( ) {
		return $this->strBestandsGrootte;
	}
	public function getBestandsError( ) {
		return $this->strBestandsError;
	}
	public function getOrgBestandsNaam() {
		return $this->strOrgineleBestandsNaam;
	}
	// set-methodes
	public function setValues( $mysqlResult ) {
		if(isset($mysqlResult['id']))
			$this->intID = $mysqlResult['id'];
		if(isset($mysqlResult['bestandid']))
			$this->intBestandID = $mysqlResult['bestandid'];
		if(isset($mysqlResult['bestandsnaam']))
			$this->strBestandsNaam = $mysqlResult['bestandsnaam'];
		if(isset($mysqlResult['locatie']))
			$this->strLocatie = $mysqlResult['locatie'];	
		if(isset($mysqlResult['omschrijving']))
			$this->strOmschrijving = $mysqlResult['omschrijving'];	
		if(isset($mysqlResult['datum']))
			$this->dtDatum = $mysqlResult['datum'];
		if(isset($mysqlResult['wid']))
			$this->intWebsiteID = $mysqlResult['wid'];
	}

	public function setID( $newID ) {
		$this->intID = $newID;
	}	
	public function setBestandsID( $newID ) {
		$this->intBestandID = $newID;
	}
	public function setBestandsNaam( $newBestandsNaam ) {
		$this->strBestandsNaam = $newBestandsNaam;
	}
	public function setLocatie( $newLocatie ) {
		$this->strLocatie = $newLocatie;
	}
	public function setLocatieDir( $newLocatieDir ) {
		$this->strLocatieDir = $newLocatieDir; 
	}
	public function setLocatieURL( $newLocatieURL ) {
		$this->strLocatieURL = $newLocatieURL; 
	}
	public function setOmschrijving( $newOmschrijving ) {
		$this->strOmschrijving = $newOmschrijving;
	}
	public function setDatum( $newDatum ) {
		$this->dtDatum = $newDatum;
	}
	public function setWebsiteID( $newWID ) {
		$this->intWebsiteID = $newWID;
	}
	public function setBestandsType( $newBestandsType ) {
		$this->strBestandType = $newBestandsType;
	}
	public function setBestandsGrootte( $newBestandsGrootte ) {
		$this->strBestandsGrootte = $newBestandsGrootte;
	}
	public function setBestandsError( $newBestandsError ) {
		$this->strBestandsError = $newBestandsError;
	}
	public function setOrgBestandsNaam( $newBestandsNaam ) {
		$this->strOrgineleBestandsNaam = $newBestandsNaam;
	}
}
?>