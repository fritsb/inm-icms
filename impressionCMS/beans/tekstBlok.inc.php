<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: tekstBlok.inc.php
 * Beschrijving: De subklasse van Blok: tekstBlok
 */

class tekstBlok extends Blok {
	private $strTekst;
	private $strLetterType;
	private $intletterGrootte;
	private $strLetterKleur;

	// De constructor
	public function __construct( ) {
		parent::__construct();
		$this->strTekst = "";
		$this->strLetterType = "Arial";
		$this->intLetterGrootte = "10";
		$this->strLetterKleur = "#000000";
	}
	public function setValues( $mysqlResult ) {
		parent::setValues( $mysqlResult );
    	if(isset($mysqlResult['tekst'])) 
    		$this->strTekst = $mysqlResult['tekst'];
    	if(isset($mysqlResult['lettertype']))
    		$this->strLetterType = $mysqlResult['lettertype'];
    	if(isset($mysqlResult['lettergrootte'])) 
    		$this->intLetterGrootte = $mysqlResult['lettergrootte'];	
    	if(isset($mysqlResult['letterkleur'])) 
    		$this->strLetterKleur = $mysqlResult['letterkleur'];
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
	
	// Functie om het content als HTML-code te krijgen
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
			$html .= "border-color: ".parent::getBorderKleur().";";
		if(parent::getAchtergrondKleur() != "")
			$html .= "background-color: ".parent::getAchtergrondKleur()."; ";
		$html .=" font-family: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; color: ".$this->strLetterKleur."; text-align: ".parent::getUitlijning().";\">\n";
		$html .= htmlentities($this->strTekst);
		$html .= "</div>\n";
		return $html;
	}
} 
?>