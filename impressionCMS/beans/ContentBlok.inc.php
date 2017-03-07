<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: ContentBlok.inc.php
 * Beschrijving: De klasse ContentBlok
 */
 
 class ContentBlok {
 	private $intID;
 	private $intContentBlokID;
 	private $strContentTitel;
 	private $strContentType;
 	private $strUitlijning;
 	private $strContentPositie;
 	private $strContentZichtbaar;
 	private $strContentBewerkbaar;
 	private $intPaginaID;
	private $intOnderdeelID;
 	private $intWebsiteID;
 	
 	// De constructor
 	public function __construct($intID = '', $intContentBlokID = '', $strContentTitel = '', $strContentType = '', $strUitlijning = 'left', $strContentPositie = '', 
 								$strContentZichtbaar = 'nee', $strContentBewerkbaar = 'nee', $intPaginaID = '', $intOnderdeelID = '', $intWebsiteID = '') {
		$this->intID = $intID;
 		$this->intContentBlokID = $intContentBlokID;
 		$this->strContentTitel = $strContentTitel;
  		$this->strContentType = $strContentType;		
  		$this->strUitlijning = $strUitlijning;
 		$this->strContentPositie = $strContentPositie;
 		$this->strContentZichtbaar = $strContentZichtbaar;
 		$this->strContentBewerkbaar = $strContentBewerkbaar;
 		$this->intPaginaID = $intPaginaID;
 		$this->intOnderdeelID = $intOnderdeelID;
 		$this->intWebsiteID = $intWebsiteID;
 	}
 	
 	// De get-methodes
 	public function getID() {
 		return $this->intID;
 	}
 	public function getContentID() {
 		return $this->intContentBlokID;
 	}
 	public function getContentBlokID() {
 		return $this->getContentID();
 	}
 	public function getTitel() {
 		return $this->strContentTitel;
 	}
 	public function getCType() {
 		return $this->strContentType;
 	}
 	public function getUitlijning() {
 		return $this->strUitlijning;
 	}
 	public function getPositie() {
 		return $this->strContentPositie;
 	}
 	public function getZichtbaar() {
 		return $this->strContentZichtbaar;
 	}
 	public function getBewerkbaar() {
 		return $this->strContentBewerkbaar;
 	}
 	public function getPaginaID() {
 		return $this->intPaginaID;
 	}
 	public function getOnderdeelID() {
 		return $this->intOnderdeelID;
 	}
 	public function getWebsiteID() {
 		return $this->intWebsiteID;
 	}
 	
 	// De set-methodes
    public function setValues( $mysqlResult ) {
    	if(isset($mysqlResult['id'])) 
    		$this->intID = $mysqlResult['id'];
    	if(isset($mysqlResult['contentblokid'])) 
    		$this->intContentBlokID = $mysqlResult['contentblokid'];
    	if(isset($mysqlResult['titel'])) 
    		$this->strContentTitel = $mysqlResult['titel'];
    	if(isset($mysqlResult['type'])) 
    		$this->strContentType = $mysqlResult['type'];
    	if(isset($mysqlResult['uitlijning'])) 
    		$this->strUitlijning = $mysqlResult['uitlijning'];
    	if(isset($mysqlResult['positie'])) 
    		$this->strContentPositie = $mysqlResult['positie'];
    	if(isset($mysqlResult['zichtbaar'])) 
    		$this->strContentZichtbaar = $mysqlResult['zichtbaar'];
    	if(isset($mysqlResult['bewerkbaar'])) 
    		$this->strContentBewerkbaar = $mysqlResult['bewerkbaar'];
    	if(isset($mysqlResult['pid'])) 
    		$this->intPaginaID = $mysqlResult['pid'];
    	if(isset($mysqlResult['wid'])) 
    		$this->intWebsiteID = $mysqlResult['wid'];	
    } 	
 	public function setID( $newID ) {
 		$this->intID = $newID;
 	}
 	public function setContentID( $newID ) {
 		$this->intContentBlokID = $newID;
 	}
 	public function setContentBlokID( $newID ) {
 		$this->intContentBlokID = $newID;
 	}
 	public function setTitel( $newTitel ) {
 		$this->strContentTitel = $newTitel;
 	}
 	public function setCType( $newContentType ) {
 		$this->strContentType = $newContentType;
 	}
 	public function setUitlijning( $newUitlijning ) {
 		$this->strUitlijning = $newUitlijning;
 	}
 	public function setPositie( $newPositie ) {
 		$this->strContentPositie = $newPositie;
 	}
 	public function setZichtbaar( $newZichtbaar ) {
 		$this->strContentZichtbaar = $newZichtbaar;
 	}
 	public function setBewerkbaar( $newBewerkbaar ) {
 		$this->strContentBewerkbaar = $newBewerkbaar;
 	}
 	public function setPaginaID( $newPaginaID )  {
 		$this->intPaginaID = $newPaginaID;
 	}
 	public function setOnderdeelID( $newOnderdeelID ) {
 		$this->intOnderdeelID = $newOnderdeelID;
 	}
 	public function setWebsiteID( $newWebsiteID ) {
 		$this->intWebsiteID = $newWebsiteID;
 	} 	
 }

?>