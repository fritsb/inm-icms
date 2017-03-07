<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: LogRegel.inc.php
 * Beschrijving: De klasse LogRegel
 */

class LogRegel {
	private $intLogID;
	private $strTekst;
	private $strIPAdres;
	private $intGebruikersID;
	private $intAdminID;
	private $intWebsiteID;
	private $dtDatumTijd;
	private $strSoort;

	// Constructor
	public function __construct( ) {
		$this->intLogID = "";
		$this->strTekst = "";
		$this->strIPAdres = "";
		$this->intGebruikersID = "";
		$this->intAdminID = "";
		$this->intWebsiteID = "";
		$this->dtDatumTijd = "";
		$this->strSoort = "";
	}

	// get-methodes
	public function getLogID() {
		return $this->intLogID;
	}
	public function getTekst() {
		return $this->strTekst;
	}
	public function getIPAdres() {
		return $this->strIPAdres;
	}
	public function getGebruikersID() {
		return $this->intGebruikersID;
	}	
	public function getAdminID() {
		return $this->intAdminID;
	}
	public function getWebsiteID() {
		return $this->intWebsiteID;
	}
	public function getDatumTijd() {
		return $this->dtDatumTijd;
	}
	public function getDatum() {
		$arrDatumTijd =	explode(" ", $this->dtDatumTijd);
		$arrDatum = explode("-", $arrDatumTijd[0]);
		return $arrDatum[2]."-".$arrDatum[1]."-".$arrDatum[0];
	}
	public function getTijd() {
		$arrDatumTijd =	explode(" ", $this->dtDatumTijd);
		return $arrDatumTijd[1];
	}
	public function getConvertedDatumTijd() {
		$arrDatumTijd =	explode(" ", $this->dtDatumTijd);
		$arrDatum = explode("-", $arrDatumTijd[0]);
		return $arrDatum[2]."-".$arrDatum[1]."-".$arrDatum[0]." ".$arrDatumTijd[1];
	}
	public function getSoort() {
		return $this->strSoort;
	}
	
	// set-methodes
	public function setValues( $mysqlResult ) {
		if(isset($mysqlResult['id']))
			$this->intLogID = $mysqlResult['id'];
		if(isset($mysqlResult['tekst']))
			$this->strTekst = $mysqlResult['tekst'];
		if(isset($mysqlResult['ipadres']))
			$this->strIPAdres = $mysqlResult['ipadres'];
		if(isset($mysqlResult['gid']))
			$this->intGebruikersID = $mysqlResult['gid'];
		if(isset($mysqlResult['aid']))
			$this->intAdminID = $mysqlResult['aid'];
		if(isset($mysqlResult['wid']))
			$this->intWebsiteID = $mysqlResult['wid'];
		if(isset($mysqlResult['datumtijd']))
			$this->dtDatumTijd = $mysqlResult['datumtijd'];		
		if(isset($mysqlResult['soort']))
			$this->strSoort = $mysqlResult['soort'];
	}
	
	public function setLogID( $newID ) {
		$this->intLogID = $newID;
	}
	public function setTekst( $newTekst ) {
		$this->strTekst = $newTekst;
	}
	public function setIPAdres( $newIPAdres ) {
		$this->strIPAdres = $newIPAdres;
	}
	public function setGebruikersID( $newGebruikersID ) {
		$this->intGebruikersID = $newGebruikersID;
	}
	public function setAdminID( $newAdminID ) {
		$this->intAdminID = $newAdminID;
	}
	public function setWebsiteID( $newWebsiteID ) {
		$this->intWebsiteID = $newWebsiteID;
	}	
	public function setDatumTijd( $newDatumTijd ) {
		$this->dtDatumTijd = $newDatumTijd;
	}
	public function setSoort( $newSoort ) {
		$this->strSoort = $newSoort;
	}
}
?>