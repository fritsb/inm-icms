<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Gebruiker.inc.php
 * Beschrijving: De klasse Gebruiker
 */
 
class Gebruiker extends Persoon {
	private $intGebruikerID;
	private $strStraat;
	private $strHuisNr;
	private $strPostcode;	
	private $strWoonplaats;
	private $strTelefoonNummer;
	private $strFaxNummer;	
	private $strMobielNummer;
	private $intWebsiteID;

	// Constructor
	public function __construct() {
		parent::__construct();
		$this->intGebruikerID = "";
		$this->strStraat = "";
		$this->strHuisNr = "";
		$this->strPostcode = "";
		$this->strWoonplaats = "";
		$this->strTelefoonNummer = "";
		$this->strFaxNummer = "";
		$this->strMobielNummer = "";
		$this->intWebsiteID = "";
	}
	// De get-methodes
	public function getID() {
		return $this->intGebruikerID;		
	}
	public function getGebruikerID() {
		return $this->intGebruikerID;
	}	
	public function getGebruikersID() {
		return $this->intGebruikerID;
	}
	public function getStraat() {
		return $this->strStraat;
	}
	public function getHuisNr() {
		return $this->strHuisNr;
	}
	public function getPostcode() {
		return $this->strPostcode;
	}
	public function getWoonplaats() {
		return $this->strWoonplaats;
	}
	public function getTelNr() {
		return $this->strTelefoonNummer;
	}
	public function getFaxNr() {
		return $this->strFaxNummer;
	}
	public function getMobielNr() {
		return $this->strMobielNummer;
	}
	public function getWebsiteID() {
		return $this->intWebsiteID;
	}
	
	// De set-methodes
    public function setValues( $mysqlResult ) {
       if(isset($mysqlResult['id'])) 
       	  $this->intGebruikerID = $mysqlResult['id'];
       if(isset($mysqlResult['gebruikersnaam'])) 
       	  parent::setGebruikersNaam( $mysqlResult['gebruikersnaam'] );
	   if(isset($mysqlResult['wachtwoord']))
		  parent::setWachtWoord( $mysqlResult['wachtwoord'] );
	   if(isset($mysqlResult['email']))
		  parent::setEMail( $mysqlResult['email'] );
	   if(isset($mysqlResult['voornaam']))
		  parent::setVoorNaam( $mysqlResult['voornaam'] );
   	   if(isset($mysqlResult['tussenvoegsel']))
		  parent::setTussenvoegsel( $mysqlResult['tussenvoegsel'] );
	   if(isset($mysqlResult['achternaam']))
		  parent::setAchterNaam( $mysqlResult['achternaam'] );
       if(isset($mysqlResult['straat'])) 
       	  $this->strStraat = $mysqlResult['straat'];
       if(isset($mysqlResult['huisnr'])) 
       	  $this->strHuisNr = $mysqlResult['huisnr'];       	  
       if(isset($mysqlResult['postcode'])) 
       	  $this->strPostcode = $mysqlResult['postcode'];
       if(isset($mysqlResult['woonplaats']))
       	  $this->strWoonplaats = $mysqlResult['woonplaats'];
       if(isset($mysqlResult['telnr'])) 
       	  $this->strTelefoonNummer = $mysqlResult['telnr'];
       if(isset($mysqlResult['faxnr'])) 
       	  $this->strFaxNummer = $mysqlResult['faxnr'];
       if(isset($mysqlResult['mobielnr'])) 
       	  $this->strMobielNummer = $mysqlResult['mobielnr'];
	   if(isset($mysqlResult['aanmelddatum']))
		  parent::setAanmeldDatum( $mysqlResult['aanmelddatum'] );
	   if(isset($mysqlResult['lastlogin']))
		  parent::setLastLogin($mysqlResult['lastlogin']);
	   if(isset($mysqlResult['actief']))
		  parent::setActief($mysqlResult['actief']);
	   if(isset($mysqlResult['ip']))
		  parent::setIP($mysqlResult['ip']);
       if(isset($mysqlResult['wid'])) 
       	  $this->intWebsiteID = $mysqlResult['wid'];
    }
    public function setGebruikersID( $newID ) {
	    $this->intGebruikerID = $newID;
	}
	public function setStraat( $newStraat) {
		$this->strStraat = $newStraat;
	}
	public function setHuisNr( $newHuisNr) {
		$this->strHuisNr = $newHuisNr;
	}	
	public function setPostcode( $newPC) {
		$this->strPostcode = $newPC;
	}
	public function setWoonplaats( $newWP) {
		$this->strWoonplaats = $newWP;
	}
	public function setTelNr( $newTelNr) {
		$this->strTelefoonNummer = $newTelNr;
	}
	public function setFaxNr( $newFaxNr ) {
		$this->strFaxNummer = $newFaxNr;
	}
	public function setMobielNr( $newMobielNr ) {
		$this->strMobielNummer = $newMobielNr;
	}
	public function setWebsiteID( $newWID) {
		$this->intWebsiteID = $newWID;
	}	
}

?>