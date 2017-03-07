<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: FAQ.inc.php
 * Beschrijving: De klasse FAQ
 */
 
 class FAQ {
 	private $intID;
 	private $strMD5ID;
 	private $intFaqID;
 	private $strVraag;
 	private $strAntwoord;
 	private $strFaqPositie;
 	private $intPaginaID;
 	private $strPaginaMD5ID;
 	private $intWebsiteID;
 	
 	// De constructor voor PHP-5
 	public function __construct($intID = '', $intFaqID = '', $strVraag = '', $strAntwoord = '', $strFaqPositie = '', 
 								$faqDatum = '', $intPaginaID = '', $intWebsiteID = '') {
 		$this->intID = $intID;
 		$this->intFaqID = $intFaqID;
 		$this->strVraag = $strVraag;
 		$this->strAntwoord = $strAntwoord;
 		$this->strFaqPositie = $strFaqPositie;
 		$this->faqDatum = $faqDatum; 		
 		$this->intPaginaID = $intPaginaID;
 		$this->intWebsiteID = $intWebsiteID;
 	}
 	
 	// De get-methodes
 	public function getID() {
 		return $this->intID;
 	}
 	public function getMD5ID() {
 		return $this->strMD5ID;
 	}
 	public function getFAQID() {
 		return $this->intFaqID;
 	}
 	public function getVraag() {
 		return $this->strVraag;
 	}
 	public function getAntwoord() {
 		return $this->strAntwoord;
 	} 	
 	public function getPositie() {
 		return $this->strFaqPositie;
 	}
 	public function getPaginaID() {
 		return $this->intPaginaID;
 	}
 	public function getPaginaMD5ID() {
 		return $this->strPaginaMD5ID;
 	}
 	public function getWebsiteID() {
 		return $this->intWebsiteID;
 	}
 	
 	// De set-methodes
    public function setValues( $mysqlResult ) {
    	if(isset($mysqlResult['id'])) 
    		$this->intID = $mysqlResult['id'];
    	if(isset($mysqlResult['faqid'])) 
    		$this->intFaqID = $mysqlResult['faqid'];
    	if(isset($mysqlResult['vraag'])) 
    		$this->strVraag = $mysqlResult['vraag'];    		
    	if(isset($mysqlResult['antwoord'])) 	
    		$this->strAntwoord = $mysqlResult['antwoord'];    		
    	if(isset($mysqlResult['positie'])) 
    		$this->strFaqPositie = $mysqlResult['positie'];
    	if(isset($mysqlResult['pid'])) 
    		$this->intPaginaID = $mysqlResult['pid'];
    	if(isset($mysqlResult['wid'])) 
    		$this->intWebsiteID = $mysqlResult['wid'];	
    } 	
 	public function setID( $newID ) {
 		$this->intID = $newID;
 	}
 	public function setFAQID( $newID ) {
 		$this->intFaqID = $newID;
 	}
 	public function setVraag( $newVraag ) {
 		$this->strVraag = $newVraag;
 	} 	
 	public function setAntwoord( $newAntwoord ) {
 		$this->strAntwoord = $newAntwoord;
 	}
 	public function setPositie( $newPositie ) {
 		$this->strFaqPositie = $newPositie;
 	}
 	public function setPaginaID( $newPaginaID ) {
 		$this->intPaginaID = $newPaginaID;
 	}
 	public function setPaginaMD5ID( $newPaginaMD5ID ) {
 		$this->strPaginaMD5ID = $newPaginaMD5ID;
 	}
 	public function setWebsiteID( $newWebsiteID ) {
 		$this->intWebsiteID = $newWebsiteID;
 	}
 }

?>