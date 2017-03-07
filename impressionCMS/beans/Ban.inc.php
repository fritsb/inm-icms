<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Admin.inc.php
 * Beschrijving: De klasse Ban
 */

class Ban {
	private $intBanID;
	private $strIPAdres;
	private $dtDatumTijd;
	private $strReden;

	// Constructor
	public function __construct( ) {
		$this->intBanID = "";
		$this->strIPAdres = "";
		$this->dtDatumTijd = "";
		$this->strReden = "";
	}

	// get-methodes
	public function getBanID() {
		return $this->intBanID;
	}
	public function getIPAdres() {
		return $this->strIPAdres;
	}
	public function getDatumTijd() {
		return $this->dtDatumTijd;
	}
	public function getReden() {
		return $this->strReden;
	}

	
	// set-methodes
	public function setValues( $mysqlResult ) {
		if(isset($mysqlResult['id']))
			$this->intBanID = $mysqlResult['id'];
		if(isset($mysqlResult['ipadres']))
			$this->strIPAdres = $mysqlResult['ipadres'];
		if(isset($mysqlResult['datumtijd']))
			$this->dtDatumTijd = $mysqlResult['datumtijd'];	
		if(isset($mysqlResult['reden']))
			$this->strReden = $mysqlResult['reden'];	
	}
	
	public function setBanID( $newID ) {
		$this->intBanID = $newID;
	}
	public function setIPAdres( $newIPAdres ) {
		$this->strIPAdres = $newIPAdres;
	}
	public function setDatumTijd( $newDatumTijd ) {
		$this->dtDatumTijd = $newDatumTijd;
	}
	public function setReden( $newReden ) {
		$this->strReden = $newReden;
	} 
}
?>