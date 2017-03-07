<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: tekstafbBlok.inc.php
 * Beschrijving: De subklasse van Blok: tekstafbBlok
 */

class tekstafbBlok extends Blok {
	private $strTekst;
	private $strLetterType;
	private $intLetterGrootte;
	private $strLetterKleur;
	private $strAfbURL;
	private $intAfbWidth;
	private $intAfbHeight;
	private $intAfbBorder;
	private $strAfbAlt;
	private $strKeuze;
	private $intBestandID;

	// De constructor	
	public function __construct( ) {
		parent::__construct();
		$this->strTekst = "";
		$this->strLetterType = "Arial";
		$this->intLetterGrootte = "10";
		$this->strLetterKleur = "#000000";
		$this->strAfbURL = "";
		$this->intAfbWidth = "";
		$this->intAfbHeight = "";
		$this->intAfbBorder = "0";
		$this->strAfbAlt = "Afbeelding";
		$this->strKeuze = "";
		$this->intBestandID = "";
	}
	public function setValues( $mysqlResult ) {
		parent::setValues( $mysqlResult );
    	if(isset($mysqlResult['tekst'])) 
    		$this->strTekst = $mysqlResult['tekst'];
    	if(isset($mysqlResult['afburl'])) 
    		$this->strAfbURL = $mysqlResult['afburl'];
    	if(isset($mysqlResult['lettertype']))
    		$this->strLetterType = $mysqlResult['lettertype'];
    	if(isset($mysqlResult['lettergrootte'])) 
    		$this->intLetterGrootte = $mysqlResult['lettergrootte'];
    	if(isset($mysqlResult['letterkleur'])) 
    		$this->strLetterKleur = $mysqlResult['letterkleur'];
    	if(isset($mysqlResult['afbwidth']))
    		$this->intAfbWidth = $mysqlResult['afbwidth'];
    	if(isset($mysqlResult['afbheight']))
    		$this->intAfbHeight = $mysqlResult['afbheight'];
    	if(isset($mysqlResult['afbborder']))
    		$this->intAfbBorder = $mysqlResult['afbborder'];
    	if(isset($mysqlResult['alt']))
    		$this->strAfbAlt = $mysqlResult['alt'];
    	if(isset($mysqlResult['keuze']))
    		$this->strKeuze = $mysqlResult['keuze'];
    	if(isset($mysqlResult['bestandid']))
    		$this->intBestandID = $mysqlResult['bestandid'];
    }	
	// get-methodes
	public function getTekst() {
		return $this->strTekst;
	}
	public function getLetterType() {
		return $this->strLetterType;
	}
	public function getLetterGrootte() {
		return $this->intLetterGrootte;
	}
	public function getLetterKleur() {
		return $this->strLetterKleur;
	}
	public function getURL() {
		return $this->strAfbURL;
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
	public function getAfbAlt() {
		return $this->strAfbAlt;
	}
	public function getKeuze() {
		return $this->strKeuze;
	}
	public function getBestandID() {
		return $this->intBestandID;
	}
	// set-methodes
	public function setTekst( $newTekst ) {
		$this->strTekst = $newTekst;
	}
	public function setLetterType( $newLetterType ) {
		$this->strLetterType = $newLetterType;
	}
	public function setLetterGrootte( $newLetterGrootte ) {
		$this->intLetterGrootte = $newLetterGrootte;
	}
	public function setLetterKleur( $newLetterKleur ) {
		$this->strLetterKleur = $newLetterKleur;
	}
	public function setURL( $newURL ) {
		$this->strAfbURL = $newURL;
	}
	public function setAfbWidth( $newAfbWidth ) {
		$this->intAfbWidth = $newAfbWidth;
	}
	public function setAfbHeight( $newAfbHeight ) {
		$this->intAfbHeight = $newAfbHeight;
	}
	public function setAfbBorder( $newAfbBorder ) {
		$this->intAfbBorder = $newAfbBorder;
	}
	public function setAfbAlt( $newAfbAlt ) {
		$this->strAfbAlt = $newAfbAlt;
	}
	public function setKeuze( $newKeuze ) {
		$this->strKeuze = $newKeuze;
	}
	public function setBestandID( $newBestandID ) {
		$this->intBestandID = $newBestandID;
	}	
	// Functie om het content als HTML-code te krijgen
	public function getContent() {
		$html = "<div id=\"d".parent::getBlokID()."\" style=\"";
		if(parent::getHoogte() != "0" && parent::getHoogte() != "")
			$html .= "height: ".parent::getHoogte()."px; ";
		if(parent::getBreedte() != "0" && parent::getBreedte() != "")
			$html .= "width: ".parent::getBreedte()."px; ";
		if(parent::getBorder() != "0" && parent::getBorder() != "")
			$html .= "border-width: ".parent::getBorder()."px;";
		if(parent::getBorder() != "0" && parent::getBorder() != "" && parent::getBorderType() != "")
			$html .= "border-style: ".parent::getBorderType().";";
		if(parent::getBorder() != "0" && parent::getBorder() != "" && parent::getBorderKleur() != "")
			$html .= "border-color: ".parent::getBorderKleur().";";
		if(parent::getAchtergrondKleur() != "")
			$html .= "background-color: ".parent::getAchtergrondKleur().";";
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
			
		$html .= " font-family: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; text-align: ".parent::getUitlijning()."; \">\n";
		if($this->strKeuze == "1") {
			$html .= "<table cellspacing=\"0\">\n";
			$html .= "<tr><td style=\"font-family: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; color: ".$this->strLetterKleur.";\">".htmlentities($this->strTekst)."</td>\n";
			$html .= "<td width=\"".($this->intAfbWidth + 5)."\" align=\"center\"><img src=\"".$this->strAfbURL."\" $strExtra alt=\"".$this->strAfbAlt."\"></td></tr>\n";
			$html .= "</table>\n";
		}
		elseif($this->strKeuze == "2") {
			$html .= "<table cellspacing=\"0\">\n";
			$html .= "<tr><td width=\"".($this->intAfbWidth + 5)."\" align=\"center\"><img src=\"".$this->strAfbURL."\" $strExtra alt=\"".$this->strAfbAlt."\"></td>\n";
			$html .= "<td style=\"font-family: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; color: ".$this->strLetterKleur."; \">".htmlentities($this->strTekst)."</td></tr>\n";
			$html .= "</table>\n";
		}
		elseif($this->strKeuze == "3") {
			$html .= "<table cellspacing=\"0\">\n";
			$html .= "<tr><td align=\"center\"><img src=\"".$this->strAfbURL."\" $strExtra alt=\"".$this->strAfbAlt."\"></td></tr>\n";
			$html .= "<tr><td style=\"font-family: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; \">".htmlentities($this->strTekst)."</td></tr>\n";
			$html .= "</table>\n";
		}
		elseif($this->strKeuze == "4") {
			$html .= "<table cellspacing=\"0\">\n";
			$html .= "<tr><td style=\"font-family: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; \">".htmlentities($this->strTekst)."</td></tr>\n";
			$html .= "<tr><td align=\"center\"><img src=\"".$this->strAfbURL."\" $strExtra alt=\"".$this->strAfbAlt."\"></td></tr>\n";
			$html .= "</table>\n";
		}
		$html .= "</div>\n";
		return $html;
	}
} 
?>