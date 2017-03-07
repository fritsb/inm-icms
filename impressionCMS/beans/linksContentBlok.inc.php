<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: linksContentBlok.inc.php
 * Beschrijving: De subklassen van ContentBlokken: linksContentBlok
 */

// De klasse linksContentBlok
class linksContentBlok extends ContentBlok {
	private $strURL;
	private $strNaam;
	private $strOmschrijving;
	
	// De constructor
	public function __construct($strURL = '', $strNaam = '', $strOmschrijving = '') {
		parent::__construct();
		$this->strURL = $strURL;
		$this->strNaam = $strNaam;
		$this->strOmschrijving = $strOmschrijving;
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
    	if(isset($mysqlResult['url'])) 
    		$this->strURL = $mysqlResult['url'];
    	if(isset($mysqlResult['naam'])) 
    		$this->strNaam = $mysqlResult['naam'];
    	if(isset($mysqlResult['omschrijving'])) 
    		$this->strOmschrijving = $mysqlResult['omschrijving'];
    }
	// get-methodes
	public function getURL() {
		return $this->strURL;
	}
	public function getNaam() {
		return $this->strNaam;
	}
	public function getOmschrijving() {
		return $this->strOmschrijving;
	}
	// set-methodes
	public function setURL( $newURL ) {
		$this->strURL = $newURL;
	}
	public function setNaam( $newNaam ) {
		$this->strNaam = $newNaam;
	}
	public function setOmschrijving( $newOmschrijving ) {
		$this->strOmschrijving = $newOmschrijving;
	}
	// Functie om het content als HTML-code te krijgen
	public function getContent() {
		$html = "<div id=\"".$this->getContentID()."\" style=\"text-align: ".$this->getUitlijning().";\">";
		$html .= "<a href=\"".$this->getURL()."\">".$this->getNaam()."</a>\n<br>";
		$html .= htmlentities(xmlentities($this->getOmschrijving()));
		$html .= "</div>\n";
		
		return $html;
	}
}
?>