<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: afbeeldingBlok.inc.php
 * Beschrijving: De subklasse van Blok: afbeeldingBlok
 */

class afbeeldingBlok extends Blok {
	private $strURL;
	private $intAfbWidth;
	private $intAfbHeight;
	private $intBorder;
	private $strAlt;
	private $intBestandID;

	// De constructor
	public function __construct( ) {
		parent::__construct();
		$this->strURL = "";
		$this->intAfbWidth = "0";
		$this->intAfbHeight = "0";
		$this->intAfbBorder = "0";
		$this->strAlt = "Afbeelding";
		$this->intBestandID = "";
	}
	public function setValues( $mysqlResult ) {
		parent::setValues($mysqlResult);
    	if(isset($mysqlResult['afburl'])) 
    		$this->strURL = $mysqlResult['afburl'];
    	if(isset($mysqlResult['afbwidth'])) 
    		$this->intAfbWidth = $mysqlResult['afbwidth'];
    	if(isset($mysqlResult['afbheight'])) 
    		$this->intAfbHeight = $mysqlResult['afbheight'];
    	if(isset($mysqlResult['afbborder'])) 
    		$this->intAfbBorder = $mysqlResult['afbborder'];
    	if(isset($mysqlResult['alt'])) 
    		$this->strAlt = $mysqlResult['alt'];
     	if(isset($mysqlResult['bestandid'])) 
    		$this->intBestandID = $mysqlResult['bestandid'];
   }
	// get-methodes
	public function getURL() {
		return $this->strURL;
	}
	public function getAfbWidth() {
		return $this->intAfbWidth;
	}
	public function getAfbHeight() {
		return $this->intAfbHeight;
	}
	public function getAfbBorder() {
		return $this->intAfbBorder;
	}
	public function getAlt() {
		return $this->strAlt;
	}
	public function getBestandID() {
		return $this->intBestandID;
	}
	// set-methodes
	public function setURL( $newURL ) {
		$this->strURL = $newURL;
	}
	public function setAfbWidth( $newWidth ) {
		$this->intAfbWidth = $newWidth;
	}
	public function setAfbHeight( $newHeight ) {
		$this->intAfbHeight = $newHeight;
	}
	public function setAfbBorder( $newBorder ) {
		$this->intAfbBorder = $newBorder;
	}
	public function setAlt( $newAlt ) {
		$this->strAlt = $newAlt;
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
		$strExtra = "";
		if($this->intAfbWidth != "" && $this->intAfbWidth != "0")
			$strExtra .= " width=\"".$this->intAfbWidth."\" ";
		if($this->intAfbHeight != "" && $this->intAfbHeight != "0")
			$strExtra .= " height=\"".$this->intAfbHeight."\" ";
		if($this->intAfbBorder != "")
			$strExtra .= " border=\"".$this->intAfbBorder."\" ";
		$html = "<div id=\"d".parent::getBlokID()."\" style=\"";
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
		$html .=" text-align: ".$this->getUitlijning().";\">\n";
		$html .= "<img src=\"".$this->strURL."\" $strExtra alt=\"".$this->strAlt."\">\n";
		$html .= "</div>\n";
		return $html;
	}
}  
?>