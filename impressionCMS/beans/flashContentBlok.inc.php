<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: flashContentBlok.inc.php
 * Beschrijving: De subklassen van ContentBlokken: flashContentBlok
 */

// De klasse flashContentBlok
class flashContentBlok extends ContentBlok {
	private $strFlashURL;
	private $intWidth;
	private $intHeight;
	private $strAutoPlay;
	private $strLoop;
	private $strKwaliteit;
	private $strAchtergrondKleur;
	
	// De constructor
	public function __construct( $strFlashURL = '', $intWidth ='0', $intHeight = '0', $strAutoPlay = 'nee', $strLoop = 'nee', $strKwaliteit = 'high', $strAchtergrondKleur = '') {
		parent::__construct();
		$this->strFlashURL = $strFlashURL;
		$this->intWidth = $intWidth;
		$this->intHeight = $intHeight;
		$this->strAutoPlay = $strAutoPlay;
		$this->strLoop = $strLoop;
		$this->strKwaliteit = $strKwaliteit;
		$this->strAchtergrondKleur = $strAchtergrondKleur;
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
    	if(isset($mysqlResult['flashurl'])) 
    		$this->strFlashURL = $mysqlResult['flashurl'];
    	if(isset($mysqlResult['width'])) 
    		$this->intWidth = $mysqlResult['width'];
    	if(isset($mysqlResult['height'])) 
    		$this->intHeight = $mysqlResult['height'];
    	if(isset($mysqlResult['autoplay'])) 
    		$this->strAutoPlay = $mysqlResult['autoplay'];
    	if(isset($mysqlResult['loop'])) 
    		$this->strLoop = $mysqlResult['loop'];
    	if(isset($mysqlResult['kwaliteit'])) 
    		$this->strKwaliteit = $mysqlResult['kwaliteit'];
    	if(isset($mysqlResult['achtergrond'])) 
    		$this->strAchtergrondKleur = $mysqlResult['achtergrond'];
    		
    }	
	// get-methodes
	public function getFlashURL() {
		return $this->strFlashURL;
	}
	public function getWidth() {
		return $this->intWidth;
	}
	public function getHeight() {
		return $this->intHeight;
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
	// set-methodes
	public function setFlashURL( $newFlashURL ) {
		$this->strFlashURL = $newFlashURL;
	}
	public function setWidth( $newWidth ) {
		$this->intWidth = $newWidth;
	}
	public function setHeight( $newHeight ) {
		$this->intHeight = $newHeight;
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
	// Functie om het content als HTML-code te krijgen
	public function getContent() {
		$html = "<div id=\"".$this->getContentID()."\" style=\" text-align: ".parent::getUitlijning().";\">\n";
		$html .= "<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\"".$this->intWidth."\" height=\"".$this->intHeight."\" id=\"flashmenu\">\n";
		$html .= "<param name=movie value=\"".$this->strFlashURL."\">\n";
		$html .= "<param name=quality value=".$this->strKwaliteit.">\n";
		if($this->strAchtergrondKleur != "")
			$html .= "<param name=bgcolor value=".$this->strAchtergrondKleur.">\n";
		$html .= "<embed src=\"".$this->strFlashURL."\" quality=".$this->strKwaliteit." ";
		if($this->strAchtergrondKleur != "")
			$html .= "bgcolor=\"".$this->strAchtergrondKleur."\"";
		$html .= " width=\"".$this->intWidth."\" height=\"".$this->intHeight."\" name=\"flashmenu\" align=\"\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\">\n";
		$html .= "</embed></object>\n";
		$html .= "</div>\n";
		return $html;
	}
}
 ?>