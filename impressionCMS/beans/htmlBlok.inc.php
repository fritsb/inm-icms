<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: htmlBlok.inc.php
 * Beschrijving: De subklasse van Blok: htmlBlok
 */
 
class htmlBlok extends Blok {
	private $strHTMLcode;
	
	// De constructor
	public function __construct() {
		parent::__construct();	
		$this->strHTMLcode = "";
	}
	public function setValues( $mysqlResult ) {
     	parent::setValues( $mysqlResult );
    	if(isset($mysqlResult['htmlcode'])) 
    		$this->strHTMLcode = $mysqlResult['htmlcode'];	
    }
	// get-methodes
	public function getHTMLcode() {
		return $this->strHTMLcode;
	}
	// set-methodes
	public function setHTMLcode( $newHTMLcode ) {
		$this->strHTMLcode = $newHTMLcode;
	}
	
	// getContent()-methode
	public function getContent() {
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
		$html .= " text-align: ".$this->getUitlijning().";\">\n";
		$html .= htmlentities($this->getHTMLcode());
		$html .= "\n</div>\n";
		return $html;
	}
}
?>