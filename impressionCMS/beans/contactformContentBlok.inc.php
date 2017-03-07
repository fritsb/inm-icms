<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: contactformContentBlok.inc.php
 * Beschrijving: De subklassen van ContentBlokken: contactformContentBlok
 */

// De klasse contactformContentBlok
class contactformContentBlok extends ContentBlok {
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
	public function __construct( $strMailAdres = '', $strAdresOptie = 'nee', $strTelOptie = 'nee', $strTaal = "nl", $strVerstuurdBericht = '', $strNietVerstuurdBericht = '', $strLetterType = 'Verdana', $strLetterGrootte = '10') {
		parent::__construct();
		$this->strMailAdres = $strMailAdres;
		$this->strAdresOptie = $strAdresOptie;
		$this->strTelOptie = $strTelOptie;
		$this->strTaal = $strTaal;
		$this->strVerstuurdBericht = $strVerstuurdBericht;
		$this->strNietVerstuurdBericht = $strNietVerstuurdBericht;
		$this->strLetterType = $strLetterType;
		$this->strLetterGrootte = $strLetterGrootte;
		$this->objTaal = new taalKlasse($this->strTaal);
		
	}
	public function setValues( $mysqlResult ) {
     	if(isset($mysqlResult['id'])) 
    		parent::setID( $mysqlResult['id'] );
     	if(isset($mysqlResult['contentblokid'])) 
    		parent::setContentID( $mysqlResult['contentblokid'] );
    	if(isset($mysqlResult['titel'])) 
    		parent::setTitel( $mysqlResult['titel'] );
    	if(isset($mysqlResult['type'])) 
    		parent::setCType( $mysqlResult['type'] );
    	if(isset($mysqlResult['uitlijning'])) 
    		parent::setUitlijning( $mysqlResult['uitlijning'] );
    	if(isset($mysqlResult['positie'])) 
    		parent::setPositie( $mysqlResult['positie'] );
    	if(isset($mysqlResult['zichtbaar'])) 
    		parent::setZichtbaar( $mysqlResult['zichtbaar'] );
    	if(isset($mysqlResult['bewerkbaar'])) 
    		parent::setBewerkbaar( $mysqlResult['bewerkbaar'] );
    	if(isset($mysqlResult['pid'])) 
    		parent::setPaginaID( $mysqlResult['pid'] );
    	if(isset($mysqlResult['wid']))
    		parent::setWebsiteID( $mysqlResult['wid'] );    		
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
		$html = "<div id=\"input".$this->getContentID()."\" style=\" text-align: ".$this->getUitlijning().";\">\n";
		$html .= "<form action=\"index.php\" method=\"POST\" name=\"contactForm\">\n";
		$html .= "<input type=\"hidden\" name=\"cid\" value=\"".$this->getContentBlokID()."\">\n";
		$html .= "<input type=\"hidden\" name=\"pid\" value=\"".$this->getPaginaID()."\">\n";
		$html .= "<input type=\"hidden\" name=\"oid\" value=\"".$this->getOnderdeelID()."\">\n";
		$html .= "<fieldset class=\"fieldset".$this->getContentID()."\">\n";
		$html .= "<label for=\"naam".$this->getContentID()."\">".$this->objTaal->getNaam().": *</label><br class=\"nobr\"/>\n";
		$html .= "<input type=\"text\" name=\"naam\" id=\"naam".$this->getContentID()."\" class=\"textfield\">\n<br/>";
		$html .= "<label for=\"email".$this->getContentID()."\">".$this->objTaal->getEmail().": *</label><br class=\"nobr\"/>\n";
		$html .= "<input type=\"text\" name=\"email\" id=\"email".$this->getContentID()."\" class=\"textfield\">\n<br/>";
		if($this->strAdresOptie == "ja") {
			$html .= "<label for=\"straat".$this->getContentID()."\">".$this->objTaal->getStraat().":</label><br class=\"nobr\"/>\n";
			$html .= "<input type=\"text\" name=\"straat\" id=\"straat".$this->getContentID()."\" class=\"textfield\">\n<br/>";
			$html .= "<label for=\"huisnr".$this->getContentID()."\">".$this->objTaal->getHuisNr().":</label><br class=\"nobr\"/>\n";
			$html .= "<input type=\"text\" name=\"huisnr\" id=\"huisnr".$this->getContentID()."\" class=\"textfield\">\n<br/>";
			$html .= "<label for=\"postcode".$this->getContentID()."\">".$this->objTaal->getPostcode().":</label><br class=\"nobr\"/>\n";
			$html .= "<input type=\"text\" name=\"postcode\" id=\"postcode".$this->getContentID()."\" class=\"textfield\">\n<br/>";
			$html .= "<label for=\"woonplaats".$this->getContentID()."\">".$this->objTaal->getPlaats().":</label><br class=\"nobr\"/>\n";
			$html .= "<input type=\"text\" name=\"woonplaats\" id=\"woonplaats".$this->getContentID()."\" class=\"textfield\">\n<br/>";
		}
		if($this->strTelOptie == "ja")  {
			$html .= "<label for=\"telnr".$this->getContentID()."\">".$this->objTaal->getTelNr().":  *</label><br class=\"nobr\"/>\n";
			$html .= "<input type=\"text\" name=\"telnr\" id=\"telnr".$this->getContentID()."\" class=\"textfield\">\n<br/>";
			$html .= "<label for=\"mobielnr".$this->getContentID()."\">".$this->objTaal->getMobielNr().":</label><br class=\"nobr\"/>\n";
			$html .= "<input type=\"text\" name=\"mobielnr\" id=\"mobielnr".$this->getContentID()."\" class=\"textfield\">\n<br/>";
		}
		$html .= "<label for=\"comment".$this->getContentID()."\">".$this->objTaal->getOpmerking().": *</label><br class=\"nobr\"/>\n";
		$html .= "<textarea name=\"comment\" class=\"textarea\" id=\"comment".$this->getContentID()."\"></textarea>\n<br/>";
		$html .= "<label for=\"verstuurMailKnop".$this->getContentID()."\">".htmlentities(xmlentities("&nbsp;"))."</label><br class=\"nobr\"/>\n";
		$html .= "<input type=\"submit\" name=\"verstuurMailKnop\" id=\"verstuurMailKnop".$this->getContentID()."\" value=\"".$this->objTaal->getKnop()."\" class=\"submit\">\n<br/>";
		$html .= "</fieldset>";
		$html .= "</div>\n";
		
		return $html;
	}
}  
?>