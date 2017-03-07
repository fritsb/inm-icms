<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: contactformBlok.inc.php
 * Beschrijving: De subklasse van Blok: contactformBlok
 */

class contactformBlok extends Blok {
	private $strMailAdres;
	private $strAdresOptie;
	private $strTelOptie;
	private $strTaal;
	private $strNietVerstuurdBericht;
	private $strVerstuurdBericht;
	private $strLetterType;
	private $strLetterGrootte;
	private $objTaal;

	// De constructor
	public function __construct( ) {
		parent::__construct();
		$this->strMailAdres = "";
		$this->strAdresOptie = "nee";
		$this->strTelOptie = "nee";
		$this->strTaal = "nl";
		$this->strVerstuurdBericht = "";
		$this->strNietVerstuurdBericht = "";
		$this->strLetterType = "Arial";
		$this->strLetterGrootte = "10";
		$this->objTaal = new taalKlasse();
	}
	public function setValues( $mysqlResult ) {
     	parent::setValues( $mysqlResult );    		
    	if(isset($mysqlResult['mailadres'])) 
    		$this->strMailAdres = $mysqlResult['mailadres'];
    	if(isset($mysqlResult['adresoptie'])) 
    		$this->strAdresOptie = $mysqlResult['adresoptie'];
    	if(isset($mysqlResult['teloptie'])) 
    		$this->strTelOptie = $mysqlResult['teloptie'];
    	if(isset($mysqlResult['taal']))
    		$this->setTaal( $mysqlResult['taal'] );
    	if(isset($mysqlResult['verstuurd']))
    		$this->strVerstuurdBericht = $mysqlResult['verstuurd'];
    	if(isset($mysqlResult['nietverstuurd']))
    		$this->strNietVerstuurdBericht = $mysqlResult['nietverstuurd'];
    	if(isset($mysqlResult['lettertype']))
    		$this->strLetterType = $mysqlResult['lettertype'];
    	if(isset($mysqlResult['lettergrootte']))
    		$this->strLetterGrootte = $mysqlResult['lettergrootte'];
   }
	// get-methodes
	public function getMailAdres() {
		return $this->strMailAdres;
	}
	public function getAdresOptie() {
		return $this->strAdresOptie;
	}
	public function getTelOptie() {
		return $this->strTelOptie;
	}
	public function getTaal() {
		return $this->strTaal;
	}
	public function getVerstuurdBericht() {
		return $this->strVerstuurdBericht;
	}
	public function getNietVerstuurdBericht() {
		return $this->strNietVerstuurdBericht;
	}
	public function getLetterType() {
		return $this->strLetterType;
	}
	public function getLetterGrootte() {
		return $this->strLetterGrootte;
	}
	
	// set-methodes
	public function setMailAdres( $newMailAdres ) {
		$this->strMailAdres = $newMailAdres;
	}
	public function setAdresOptie( $newAdresOptie ) {
		$this->strAdresOptie = $newAdresOptie;
	}
	public function setTelOptie( $newTelOptie ) {
		$this->strTelOptie = $newTelOptie;
	}
	public function setTaal( $newTaal ) {
		$this->strTaal = $newTaal;
		$this->objTaal->setTaal( $newTaal );
	}
	public function setVerstuurdBericht( $newVerstuurdBericht ) {
		$this->strVerstuurdBericht = $newVerstuurdBericht;
	}
	public function setNietVerstuurdBericht( $newNietVerstuurdBericht ) {
		$this->strNietVerstuurdBericht = $newNietVerstuurdBericht;
	}
	public function setLetterType( $newLetterType ) {
		$this->strLetterType = $newLetterType;
	}
	public function setLetterGrootte($newLetterGrootte) {
		$this->strLetterGrootte = $newLetterGrootte;
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
			$html .= "border-color: ".parent::getBorderKleur()."; ";
		if(parent::getAchtergrondKleur() != "")
			$html .= "background-color: ".parent::getAchtergrondKleur()."; ";	
		
		$html .= " text-align: ".$this->getUitlijning().";\">\n";
		$html .= "<form action=\"index.php\" method=\"POST\" name=\"contactForm\">\n";
		$html .= "<input type=\"hidden\" name=\"bid\" value=\"".$this->getBlokID()."\">\n";
		$html .= "<input type=\"hidden\" name=\"pid\" value=\"".$this->getPaginaID()."\">\n";
		$html .= "<input type=\"hidden\" name=\"oid\" value=\"".$this->getOnderdeelID()."\">\n";
		$html .= "<fieldset class=\"fieldset".$this->getBlokID()."\">\n";
		$html .= "<label for=\"naam".$this->getBlokID()."\">".$this->objTaal->getNaam().": *</label><br class=\"nobr\"/>\n";
		$html .= "<input type=\"text\" name=\"naam\" id=\"naam".$this->getBlokID()."\" class=\"textfield\">\n<br/>";
		$html .= "<label for=\"email".$this->getBlokID()."\">".$this->objTaal->getEmail().": *</label><br class=\"nobr\"/>\n";
		$html .= "<input type=\"text\" name=\"email\" id=\"email".$this->getBlokID()."\" class=\"textfield\">\n<br/>";
		if($this->strAdresOptie == "ja") {
			$html .= "<label for=\"straat".$this->getBlokID()."\">".$this->objTaal->getStraat().":</label><br class=\"nobr\"/>\n";
			$html .= "<input type=\"text\" name=\"straat\" id=\"straat".$this->getBlokID()."\" class=\"textfield\">\n<br/>";
			$html .= "<label for=\"huisnr".$this->getBlokID()."\">".$this->objTaal->getHuisNr().":</label><br class=\"nobr\"/>\n";
			$html .= "<input type=\"text\" name=\"huisnr\" id=\"huisnr".$this->getBlokID()."\" class=\"textfield\">\n<br/>";
			$html .= "<label for=\"postcode".$this->getBlokID()."\">".$this->objTaal->getPostcode().":</label><br class=\"nobr\"/>\n";
			$html .= "<input type=\"text\" name=\"postcode\" id=\"postcode".$this->getBlokID()."\" class=\"textfield\">\n<br/>";
			$html .= "<label for=\"woonplaats".$this->getBlokID()."\">".$this->objTaal->getPlaats().":</label><br class=\"nobr\"/>\n";
			$html .= "<input type=\"text\" name=\"woonplaats\" id=\"woonplaats".$this->getBlokID()."\" class=\"textfield\">\n<br/>";
		}
		if($this->strTelOptie == "ja")  {
			$html .= "<label for=\"telnr".$this->getBlokID()."\">".$this->objTaal->getTelNr().":  </label><br class=\"nobr\"/>\n";
			$html .= "<input type=\"text\" name=\"telnr\" id=\"telnr".$this->getBlokID()."\" class=\"textfield\">\n<br/>";
			$html .= "<label for=\"mobielnr".$this->getBlokID()."\">".$this->objTaal->getMobielNr().":</label><br class=\"nobr\"/>\n";
			$html .= "<input type=\"text\" name=\"mobielnr\" id=\"mobielnr".$this->getBlokID()."\" class=\"textfield\">\n<br/>";
		}
		$html .= "<label for=\"comment".$this->getBlokID()."\">".$this->objTaal->getOpmerking().": *</label><br class=\"nobr\"/>\n";
		$html .= "<textarea name=\"comment\" class=\"textarea\" id=\"comment".$this->getBlokID()."\"></textarea>\n<br/>";
		$html .= "<label for=\"verstuurMailKnop".$this->getBlokID()."\">".htmlentities(xmlentities("&nbsp;"))."</label><br class=\"nobr\"/>\n";
		$html .= "<input type=\"submit\" name=\"verstuurMailKnop\" id=\"verstuurMailKnop".$this->getBlokID()."\" value=\"".$this->objTaal->getKnop()."\" class=\"submit\">\n<br/>";
		$html .= "</fieldset>";
		$html .= "</div>\n";
		
		return $html;
	}
}  
?>