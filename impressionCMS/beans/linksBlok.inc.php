<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: linksBlok.inc.php
 * Beschrijving: De subklasse van Blok: linksBlok
 */

class linksBlok extends Blok {
	private $strURL;
	private $strNaam;
	private $intBestandID;
	
	// De constructor
	public function __construct() {
		parent::__construct();
		$this->strURL = "";
		$this->strNaam = "";
		$this->intBestandID = "";
	}
	public function setValues( $mysqlResult ) {
		parent::setValues( $mysqlResult );
    	if(isset($mysqlResult['url'])) 
    		$this->strURL = $mysqlResult['url'];
    	if(isset($mysqlResult['naam'])) 
    		$this->strNaam = $mysqlResult['naam'];
    	if(isset($mysqlResult['bestandid']))
    		$this->intBestandID = $mysqlResult['bestandid'];
    }
	// get-methodes
	public function getURL() {
		return $this->strURL;
	}
	public function getNaam() {
		return $this->strNaam;
	}
	public function getBestandID() {
		return $this->intBestandID;
	}
	// set-methodes
	public function setURL( $newURL ) {
		$this->strURL = $newURL;
	}
	public function setNaam( $newNaam ) {
		$this->strNaam = $newNaam;
	}
	public function setBestandID( $newBestandID ) {
		$this->intBestandID = $newBestandID;
	}
	// Functie om het content als HTML-code te krijgen
	public function getContent() {
		if($this->intBestandID != "") {
			global $strCMSURL;
			global $strCMSDir;
			global $strUploadMap;
			$objBestand = getBestand( $this->intBestandID, parent::getWebsiteID() );
			if($objBestand != false && $objBestand != null) 
				$this->setURL( $strCMSURL.$strCMSDir.$strUploadMap.parent::getWebsiteID()."/".$objBestand->getBestandsNaam() );
		}
		$html = "<span id=\"d".parent::getBlokID()."\" style=\"";
		if(parent::getHoogte() != "0" && parent::getHoogte() != "")
			$html .= "height: ".parent::getHoogte()."px; ";
		if(parent::getBreedte() != "0" && parent::getBreedte() != "")
			$html .= "width: ".parent::getBreedte()."px; ";
		if(parent::getBorder() != "0" && parent::getBorder() != "")
			$html .= "border-width: ".parent::getBorder()."px; ";
		if(parent::getBorder() != "0" && parent::getBorder() != "" && parent::getBorderType() != "")
			$html .= "border-style: ".parent::getBorderType()."; ";
		if(parent::getBorder() != "0" && parent::getBorder() != "" && parent::getBorderKleur() != "")
			$html .= "border-color: ".parent::getBorderKleur()."; ";
		if(parent::getAchtergrondKleur() != "")
			$html .= "background-color: ".parent::getAchtergrondKleur()."; ";
		$html .= " text-align: ".$this->getUitlijning().";\">";
		$html .= "<a href=\"".$this->getURL()."\">".$this->getNaam()."</a>\n<br>";
		$html .= "</span>\n";
		
		return $html;
	}
}
?>