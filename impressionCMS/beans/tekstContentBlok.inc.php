<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: tekstContentBlok.inc.php
 * Beschrijving: De subklassen van ContentBlokken: tekstContentBlok
 */

// De klasse tekstContentBlok
class tekstContentBlok extends ContentBlok {
	private $strTekst;
	private $strLetterType;
	private $intletterGrootte;

	// De constructor
	public function __construct( $strTekst = '', $strLetterType = 'Verdana', $intLetterGrootte = '12') {
		parent::__construct();
		$this->strTekst = $strTekst;
		$this->strLetterType = $strLetterType;
		$this->intLetterGrootte = $intLetterGrootte;
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
    	if(isset($mysqlResult['tekst'])) 
    		$this->strTekst = $mysqlResult['tekst'];
    	if(isset($mysqlResult['lettertype']))
    		$this->strLetterType = $mysqlResult['lettertype'];
    	if(isset($mysqlResult['lettergrootte'])) 
    		$this->intLetterGrootte = $mysqlResult['lettergrootte'];	
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
	
	// Functie om het content als HTML-code te krijgen
	public function getContent() {
		$html = "<div id=\"".$this->getContentID()."\" style=\"font-face: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; text-align: ".parent::getUitlijning().";\">\n";
		$html .= htmlentities($this->strTekst);
		$html .= "</div>\n";
		return $html;
	}
} 
?>