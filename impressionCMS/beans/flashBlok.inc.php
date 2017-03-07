<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: flashBlok.inc.php
 * Beschrijving: De subklasse van Blok: flashBlok
 */

class flashBlok extends Blok {
	private $strFlashURL;
	private $intFlsWidth;
	private $intFlsHeight;
	private $strAutoPlay;
	private $strLoop;
	private $strKwaliteit;
	private $strAchtergrondKleur;
	private $intBestandID;
	
	// De constructor
	public function __construct( ) {
		parent::__construct();
		$this->strFlashURL = "";
		$this->intFlsWidth = "";
		$this->intFlsHeight = "";
		$this->strAutoPlay = "";
		$this->strLoop = "";
		$this->strKwaliteit = "";
		$this->strAchtergrondKleur = "";
		$this->intBestandID = "";
	}
	public function setValues( $mysqlResult ) {
     	parent::setValues( $mysqlResult );
    	if(isset($mysqlResult['flashurl'])) 
    		$this->strFlashURL = $mysqlResult['flashurl'];
    	if(isset($mysqlResult['flswidth'])) 
    		$this->intFlsWidth = $mysqlResult['flswidth'];
    	if(isset($mysqlResult['flsheight'])) 
    		$this->intFlsHeight = $mysqlResult['flsheight'];
    	if(isset($mysqlResult['autoplay'])) 
    		$this->strAutoPlay = $mysqlResult['autoplay'];
    	if(isset($mysqlResult['loop'])) 
    		$this->strLoop = $mysqlResult['loop'];
    	if(isset($mysqlResult['kwaliteit'])) 
    		$this->strKwaliteit = $mysqlResult['kwaliteit'];
    	if(isset($mysqlResult['achtergrond'])) 
    		$this->strAchtergrondKleur = $mysqlResult['achtergrond'];
    	if(isset($mysqlResult['bestandid'])) 
    		$this->intBestandID = $mysqlResult['bestandid'];
    }	
	// get-methodes
	public function getFlashURL() {
		return $this->strFlashURL;
	}
	public function getFlsWidth() {
		return $this->intFlsWidth;
	}
	public function getFlsHeight() {
		return $this->intFlsHeight;
	}
	public function getAutoPlay() {
		return $this->strAutoPlay;
	}
	public function getLoop() {
		return $this->strLoop;
	}
	public function getKwaliteit() {
		return $this->strKwaliteit;
	}
	public function getAchtergrondKleur() {
		return $this->strAchtergrondKleur;
	}
	public function getBestandID() {
		return $this->intBestandID;
	}
	// set-methodes
	public function setFlashURL( $newFlashURL ) {
		$this->strFlashURL = $newFlashURL;
	}
	public function setFlsWidth( $newWidth ) {
		$this->intFlsWidth = $newWidth;
	}
	public function setFlsHeight( $newHeight ) {
		$this->intFlsHeight = $newHeight;
	}
	public function setAutoPlay( $newAutoPlay ) {
		$this->strAutoPlay = $newAutoPlay;
	}
	public function setLoop( $newLoop ) {
		$this->strLoop = $newLoop;
	}
	public function setKwaliteit( $newKwaliteit ) {
		$this->strKwaliteit = $newKwaliteit;
	}	
	public function setAchtergrondKleur( $newAchtergrondKleur ) {
		$this->strAchtergrondKleur = $newAchtergrondKleur;
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
				$this->setFlashURL( $strCMSURL.$strCMSDir.$strUploadMap.parent::getWebsiteID()."/".$objBestand->getBestandsNaam() );
		}
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
		$html .= " text-align: ".parent::getUitlijning().";\">\n";
		
		$html .= "<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\"";
		if($this->intFlsWidth != "" && $this->intFlsWidth != "0")
			$html .= " width=\"".$this->intFlsWidth."\"";
		if($this->intFlsHeight != "" && $this->intFlsHeight != "0")
			$html .= " height=\"".$this->intFlsHeight."\"";
		$html .= " id=\"flashmenu\">\n";
		$html .= "<param name=movie value=\"".$this->strFlashURL."\">\n";
		$html .= "<param name=quality value=".$this->strKwaliteit.">\n";
		if($this->strAchtergrondKleur != "")
			$html .= "<param name=bgcolor value=".$this->strAchtergrondKleur.">\n";
		$html .= "<embed src=\"".$this->strFlashURL."\" quality=".$this->strKwaliteit." ";
		if($this->strAchtergrondKleur != "")
			$html .= "bgcolor=\"".$this->strAchtergrondKleur."\"";
		if($this->intFlsWidth != "" && $this->intFlsWidth != "0")
			$html .= " width=\"".$this->intFlsWidth."\"";
		if($this->intFlsHeight != "" && $this->intFlsHeight != "0")
			$html .= " height=\"".$this->intFlsHeight."\"";
		$html .= " name=\"flashmenu\" align=\"\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\">\n";
		$html .= "</embed></object>\n";
		$html .= "</div>\n";
		return $html;
	}
}
 ?>