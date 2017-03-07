<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: afbeeldingContentBlok.inc.php
 * Beschrijving: De subklassen van ContentBlokken: afbeeldingContentBlok
 */

// De klasse afbeeldingContentBlok
class afbeeldingContentBlok extends ContentBlok {
	private $strURL;
	private $strAlias;
	private $intWidth;
	private $intHeight;
	private $intBorder;
	private $strAlt;

	// De constructor
	public function __construct( $strURL = '', $strAlias = '', $intWidth = '0', $intHeight = '0', $intBorder = '0', $strAlt = 'Afbeelding') {
		parent::__construct();
		$this->strURL = $strURL;
		$this->strAlias = $strAlias;
		$this->intWidth = $intWidth;
		$this->intHeight = $intHeight;
		$this->intBorder = $intBorder;
		$this->strAlt = $strAlt;
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
    	if(isset($mysqlResult['alias'])) 
    		$this->strAlias = $mysqlResult['alias'];
    	if(isset($mysqlResult['afburl'])) 
    		$this->strURL = $mysqlResult['afburl'];
    	if(isset($mysqlResult['width'])) 
    		$this->intWidth = $mysqlResult['width'];
    	if(isset($mysqlResult['height'])) 
    		$this->intHeight = $mysqlResult['height'];
    	if(isset($mysqlResult['border'])) 
    		$this->intBorder = $mysqlResult['border'];
    	if(isset($mysqlResult['alt'])) 
    		$this->strAlt = $mysqlResult['alt'];
    }
	// get-methodes
	public function getURL() {
		return $this->strURL;
	}
	public function getAlias() {
		return $this->strAlias;
	}
	public function getWidth() {
		return $this->intWidth;
	}
	public function getHeight() {
		return $this->intHeight;
	}
	public function getBorder() {
		return $this->intBorder;
	}
	public function getAlt() {
		return $this->strAlt;
	}
	// set-methodes
	public function setAlias( $newAlias ) {
		$this->strAlias = $newAlias;
	}
	public function setURL( $newURL ) {
		$this->strURL = $newURL;
	}
	public function setWidth( $newWidth ) {
		$this->intWidth = $newWidth;
	}
	public function setHeight( $newHeight ) {
		$this->intHeight = $newHeight;
	}
	public function setBorder( $newBorder ) {
		$this->intBorder = $newBorder;
	}
	public function setAlt( $newAlt ) {
		$this->strAlt = $newAlt;
	}
	
	// Functie om het content als HTML-code te krijgen
	public function getContent() {
		$html = "<div style=\" text-align: ".$this->getUitlijning().";\">\n";
		$html .= "<img src=\"".$this->strURL."\" border=\"".$this->intBorder."\" width=\"".$this->intWidth."\" height=\"".$this->intHeight."\" alt=\"".$this->strAlt."\">\n";
		$html .= "</div>\n";
		return $html;
	}
}  
?>