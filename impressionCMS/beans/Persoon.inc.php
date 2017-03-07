<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Persoon.inc.php
 * Beschrijving: De klasse Persoon
 */
 
class Persoon {
	private $strGebruikersNaam;
	private $strWachtwoord;
	private $strEMail;
	private $strVoorNaam;
	private $strTussenvoegsel;
	private $strAchterNaam;	
	private $dtAanmeldDatum;
	private $dtLastLogin;
	private $strActief;
	private $strSuperUser;
	private $strIP;

	// Constructor
	public function __construct() {
		$this->strGebruikersNaam = "";
		$this->strWachtwoord = "";
		$this->strEMail = "";
		$this->strVoorNaam = "";
		$this->strTussenvoegsel = "";
		$this->strAchterNaam = "";
		$this->dtAanmeldDatum = "0000-00-00 00:00:00";
		$this->dtLastLogin = "0000-00-00 00:00:00";
		$this->strActief = "ja";
		$this->strSuperUser = "nee";
		$this->strIP = "";
	}
	
	// De get-methodes
	public function getGebruikersNaam() {
		return $this->strGebruikersNaam;
	}
	public function getWachtwoord() {
		return $this->strWachtwoord;
	}
	public function getEMail() {
		return $this->strEMail;
	}
	public function getVoorNaam() {
		return $this->strVoorNaam;
	}
	public function getTussenvoegsel() {
		return $this->strTussenvoegsel;
	}	
	public function getAchterNaam() {
		return $this->strAchterNaam;
	}
	public function getVolledigeNaam() {
		return $this->strVoorNaam." ".$this->strTussenvoegsel." ".$this->strAchterNaam;
	}
	public function getAanmeldDatum() {
		return $this->dtAanmeldDatum;
	}
	public function getLastLogin() {
		return $this->dtLastLogin;
	}
	public function getActief() {
		return $this->strActief;
	}	
	public function getIP() {
		return $this->strIP;
	}

	// De set-methodes
    public function setValues( $mysqlResult ) {
       if(isset($mysqlResult['gebruikersnaam'])) 
       	  $this->strGebruikersNaam = $mysqlResult['gebruikersnaam'];
       if(isset($mysqlResult['wachtwoord'])) 
       	  $this->strWachtwoord = $mysqlResult['wachtwoord'];
       if(isset($mysqlResult['email'])) 
       	  $this->strEMail = $mysqlResult['email'];
       if(isset($mysqlResult['voornaam']))
       	  $this->strVoorNaam = $mysqlResult['voornaam'];
       if(isset($mysqlResult['tussenvoegsel']))
       	  $this->strTussenvoegsel = $mysqlResult['tussenvoegsel'];       	  
       if(isset($mysqlResult['achternaam']))
       	  $this->strAchterNaam = $mysqlResult['achternaam'];
       if(isset($mysqlResult['aanmelddatum'])) 
       	  $this->dtAanmeldDatum = $mysqlResult['aanmelddatum'];
       if(isset($mysqlResult['lastlogin'])) 
       	  $this->dtLastLogin = $mysqlResult['lastlogin'];
	   if(isset($mysqlResult['actief']))
		  $this->strActief = $mysqlResult['actief'];
	   if(isset($mysqlResult['ip']))
		  $this->strIP = $mysqlResult['ip'];

    }
	public function setGebruikersNaam( $newGebrNaam ) {
		$this->strGebruikersNaam = $newGebrNaam;
	}
	public function setWachtwoord( $newWW) {
		$this->strWachtwoord = $newWW;
	}
	public function setEMail( $newMail ) {
		$this->strEMail = $newMail;
	}
	public function setVoorNaam( $newVoorNaam ) {
		$this->strVoorNaam = $newVoorNaam;
	}
	public function setTussenvoegsel( $newTussenvoegsel) {
		$this->strTussenvoegsel = $newTussenvoegsel;
	}
	public function setAchterNaam( $newAchterNaam) {
		$this->strAchterNaam = $newAchterNaam;
	}
	public function setAanmeldDatum( $newAanmeldDatum ) {
		$this->dtAanmeldDatum = $newAanmeldDatum;
	}
	public function setLastLogin( $newLastLogin ) {
		$this->dtLastLogin = $newLastLogin;
	}
	public function setActief( $newActief ) {
		$this->strActief = $newActief;
	}	
	public function setIP( $newIP) {
		$this->strIP = $newIP;
	}	
}

?>