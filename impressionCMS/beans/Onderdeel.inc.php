<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Onderdeel.inc.php
 * Beschrijving: De klasse Onderdeel
 */
 
 class Onderdeel {
 	private $intID;
 	private $intOnderdeelID;
 	private $strOnderdeelTitel;
 	private $strOnderdeelOmschrijving; 	
 	private $strOnderdeelPositie;
 	private $strOnderdeelZichtbaar;
 	private $strOnderdeelBewerkbaar;
 	private $intOnderdeelParentID;
 	private $intWebsiteID;
 	
 	// De constructor voor PHP-5
 	public function __construct() {
		$this->intID = "";
 		$this->intOnderdeelID = "";
 		$this->strOnderdeelTitel = "";
 		$this->strOnderdeelOmschrijving = "";
 		$this->strOnderdeelPositie = "";
 		$this->strOnderdeelZichtbaar = "nee";
 		$this->strOnderdeelBewerkbaar = "nee";
 		$this->intOnderdeelParentID = "0";
 		$this->intWebsiteID = "";
 	}
 	
 	// De get-methodes
 	public function getID() {
 		return $this->intID;
 	}
 	public function getOnderdeelID() {
 		return $this->intOnderdeelID;
 	}
 	public function getTitel() {
 		return $this->strOnderdeelTitel;
 	}
 	public function getOmschrijving() {
 		return $this->strOnderdeelOmschrijving;
 	} 	
 	public function getPositie() {
 		return $this->strOnderdeelPositie;
 	}
 	public function getZichtbaar() {
 		return $this->strOnderdeelZichtbaar;
 	}
 	public function getBewerkbaar() {
 		return $this->strOnderdeelBewerkbaar;
 	}
 	public function getParentID() {
 		return $this->intOnderdeelParentID;
 	}
 	public function getWebsiteID() {
 		return $this->intWebsiteID;
 	}
 	
 	// De set-methodes
    public function setValues( $mysqlResult ) {
    	if(isset($mysqlResult['id'])) 
    		$this->intID = $mysqlResult['id'];
    	if(isset($mysqlResult['onderdeelid'])) 
    		$this->intOnderdeelID = $mysqlResult['onderdeelid'];
    	if(isset($mysqlResult['titel'])) 	
    		$this->strOnderdeelTitel = $mysqlResult['titel'];
    	if(isset($mysqlResult['omschrijving'])) 
    		$this->strOnderdeelOmschrijving = $mysqlResult['omschrijving'];    		
    	if(isset($mysqlResult['positie'])) 
    		$this->strOnderdeelPositie = $mysqlResult['positie'];
    	if(isset($mysqlResult['zichtbaar'])) 
    		$this->strOnderdeelZichtbaar = $mysqlResult['zichtbaar'];
    	if(isset($mysqlResult['bewerkbaar'])) 
    		$this->strOnderdeelBewerkbaar = $mysqlResult['bewerkbaar'];
    	if(isset($mysqlResult['parent_id'])) 
    		$this->intOnderdeelParentID = $mysqlResult['parent_id'];
    	if(isset($mysqlResult['wid'])) 
    		$this->intWebsiteID = $mysqlResult['wid'];	
    } 	
 	public function setID( $newID ) {
 		$this->intID = $newID;
 	}
 	public function setOnderdeelID( $newID ) {
 		$this->intOnderdeelID = $newID;
 	}
 	public function setTitel( $newTitel ) {
 		$this->strOnderdeelTitel = $newTitel;
 	}
 	public function setOmschrijving( $newOmschrijving ) {
 		$this->strOnderdeelOmschrijving = $newOmschrijving;
 	} 	 	
 	public function setPositie( $newPositie ) {
 		$this->strOnderdeelPositie = $newPositie;
 	}
 	public function setZichtbaar( $newZichtbaar ) {
 		$this->strOnderdeelZichtbaar = $newZichtbaar;
 	}
 	public function setBewerkbaar( $newBewerkbaar ) {
 		$this->strOnderdeelBewerkbaar = $newBewerkbaar;
 	}
 	public function setParentID( $newParentID )  {
 		$this->intOnderdeelParentID = $newParentID;
 	}
 	public function setWebsiteID( $newWebsiteID ) {
 		$this->intWebsiteID = $newWebsiteID;
 	}
 }

?>