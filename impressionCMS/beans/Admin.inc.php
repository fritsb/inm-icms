<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Admin.inc.php
 * Beschrijving: De klasse Admin
 */

class Admin extends Persoon {
	private $intAdminID;
	private $strSuperUser;
	
	// Constructor
	public function __construct( ) {
		parent::__construct();
		$this->intAdminID = "";
		$this->strSuperUser = "";
	}

	// get-methodes	
	public function getID() {
		return $this->intAdminID;		
	}
	public function getAdminID() {
		return $this->intAdminID;
	}
	public function getLoginNaam() {
		return parent::getGebruikersNaam();
	}
	public function getSuperUser() {
		return $this->strSuperUser;
	}

	// set-methodes
	public function setValues( $mysqlResult ) {
		if(isset($mysqlResult['id']))
			$this->intAdminID = $mysqlResult['id'];
		if(isset($mysqlResult['loginnaam']))
			parent::setGebruikersNaam( $mysqlResult['loginnaam'] );
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
		if(isset($mysqlResult['aanmelddatum']))
			parent::setAanmeldDatum( $mysqlResult['aanmelddatum'] );
		if(isset($mysqlResult['lastlogin']))
			parent::setLastLogin($mysqlResult['lastlogin']);
		if(isset($mysqlResult['actief']))
			parent::setActief($mysqlResult['actief']);
		if(isset($mysqlResult['superuser']))
			$this->strSuperUser = $mysqlResult['superuser'];
		if(isset($mysqlResult['ip']))
			parent::setIP($mysqlResult['ip']);
	}
	
	public function setAdminID( $newID ) {
		$this->intAdminID = $newID;
	}
	public function setLoginNaam( $newLoginNaam ) {
		parent::setGebruikersNaam( $newLoginNaam );
	}
	public function setSuperUser( $newSuperUser ) {
		$this->strSuperUser = $newSuperUser;
	}

}
?>