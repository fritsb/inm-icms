<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: htmlContentBlok.inc.php
 * Beschrijving: De subklassen van ContentBlokken: htmlContentBlok
 */
 
// De klasse htmlContentBlok
class htmlContentBlok extends ContentBlok {
	private $strHTMLcode;
	
	// De constructor
	public function __construct($strHTMLcode = '') {
		parent::__construct();	
		$this->strHTMLcode = $strHTMLcode;
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
		$html = "<div id=\"".$this->getContentID()."\" style=\" text-align: ".$this->getUitlijning().";\">\n";
		$html .= html_entity_decode($this->getHTMLcode());
		$html .= "\n</div>\n";
		return $html;
	}
}
?>