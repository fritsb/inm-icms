<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Website.inc.php
 * Beschrijving: De klasse Website
 */

class Website {
	private $intWebsiteID;
	private $strURL;
	private $strEMail;
	private $strTitel;
	private $strOmschrijving;
	private $dtAanmeldDatum;
	private $strFTPhost;
	private $strFTPuser;
	private $strFTPpass;
   private $strSitecode;
	
	// Constructor voor PHP5
	public function __construct( ) {
		$this->intWebsiteID = "";
		$this->strURL = "";
		$this->strEMail = "";
		$this->strTitel = "";
		$this->strOmschrijving = "";
		$this->dtAanmeldDatum = "0000-00-00 00:00:00";
		$this->strSitecode = getRandomPass();
	}
	
	// get-methodes
	public function getWebsiteID() {
		return $this->intWebsiteID;
	}
	public function getURL() {
		return $this->strURL;
	}
	public function getEMail() {
		return $this->strEMail;
	}
	public function getTitel() {
		return $this->strTitel;
	}
	public function getOmschrijving() {
		return $this->strOmschrijving;
	}
	public function getAanmeldDatum() {
		return $this->dtAanmeldDatum;
	}
	public function getFTPhost() {
		return $this->strFTPhost;
	}
	public function getFTPuser() {
		return $this->strFTPuser;
	}
	public function getFTPpass() {
		return $this->strFTPpass;
	}
	public function getSiteCode() {
		return $this->strSitecode;
	}
	
	// set-methodes
	public function setValues( $mysqlResult ) {
		if(isset($mysqlResult['id']))
			$this->intWebsiteID = $mysqlResult['id'];		
		if(isset($mysqlResult['url']))
			$this->strURL = $mysqlResult['url'];
		if(isset($mysqlResult['email']))
			$this->strEMail = $mysqlResult['email'];
		if(isset($mysqlResult['titel']))
			$this->strTitel = $mysqlResult['titel'];
		if(isset($mysqlResult['omschrijving']))
			$this->strOmschrijving = $mysqlResult['omschrijving'];
		if(isset($mysqlResult['aanmelddatum']))
			$this->dtAanmeldDatum = $mysqlResult['aanmelddatum'];
		if(isset($mysqlResult['ftphost']))
			$this->strFTPhost = $mysqlResult['ftphost'];
		if(isset($mysqlResult['ftpuser']))
			$this->strFTPuser = $mysqlResult['ftpuser'];
		if(isset($mysqlResult['ftppass']))
			$this->strFTPpass = $mysqlResult['ftppass'];	
		if(isset($mysqlResult['sitecode']))
			$this->strSitecode = $mysqlResult['sitecode'];			
	}
	public function setWebsiteID( $newID ) {
		$this->intWebsiteID = $newID;
	}
	public function setURL( $newstrURL ){
		$this->strURL = $newstrURL;
	}
	public function setEMail( $newEMail ) {
		$this->strEMail = $newEMail;
	}
	public function setTitel( $newTitel ) {
		$this->strTitel = $newTitel;
	}
	public function setOmschrijving( $newOmschrijving ) {
		$this->strOmschrijving = $newOmschrijving;
	} 
	public function setAanmeldDatum( $newAanmeldDatum ) {
		$this->dtAanmeldDatum = $newAanmeldDatum;
	}
	public function setFTPhost( $newFTPhost ) {
		$this->strFTPhost = $newFTPhost;
	}
	public function setFTPuser( $newFTPuser ) {
		$this->strFTPuser = $newFTPuser;
	}
	public function setFTPpass( $newFTPpass ) {
		$this->strFTPpass = $newFTPpass;
	}
	public function setSiteCode( $newSitecode ) {
		$this->strSitecode = $newSitecode;
	}
}




?>