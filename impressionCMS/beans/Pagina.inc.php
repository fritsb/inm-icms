<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Pagina.inc.php
 * Beschrijving: De klasse Pagina
 */
 
 class Pagina {
 	private $intID;
 	private $intPaginaID;
 	private $strPaginaType;
 	private $strPaginaTitel;
 	private $strPaginaLimiet;
 	private $strPaginaPositie;
 	private $strPaginaZichtbaar;
 	private $strPaginaBewerkbaar;
 	private $intOnderdeelID;
 	private $intWebsiteID;
 	
 	// De constructor voor PHP-5
 	public function __construct() {
		$this->intID = "";
 		$this->intPaginaID = "";
 		$this->strPaginaType = "content";
 		$this->strPaginaTitel = "";
 		$this->strPaginaLimiet = "";
 		$this->strPaginaPositie = "";
 		$this->strPaginaZichtbaar = "nee";
 		$this->strPaginaBewerkbaar = "nee";
 		$this->intOnderdeelID = "";
 		$this->intWebsiteID = "";
 	}
 	
 	// De get-methodes
 	public function getID() {
 		return $this->intID;
 	}
 	public function getPaginaID() {
 		return $this->intPaginaID;
 	}
 	public function getPType() {
 		return $this->strPaginaType;
 	} 	
 	public function getTitel() {
 		return $this->strPaginaTitel;
 	}
 	public function getLimiet() {
 		return $this->strPaginaLimiet;
 	}
 	public function getPositie() {
 		return $this->strPaginaPositie;
 	}
 	public function getZichtbaar() {
 		return $this->strPaginaZichtbaar;
 	}
 	public function getBewerkbaar() {
 		return $this->strPaginaBewerkbaar;
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
    	if(isset($mysqlResult['paginaid'])) 
    		$this->intPaginaID = $mysqlResult['paginaid'];
    	if(isset($mysqlResult['type'])) 
    		$this->strPaginaType = $mysqlResult['type'];
    	if(isset($mysqlResult['titel'])) 
    		$this->strPaginaTitel = $mysqlResult['titel'];
    	if(isset($mysqlResult['limiet'])) 
    		$this->strPaginaLimiet = $mysqlResult['limiet'];
    	if(isset($mysqlResult['positie'])) 
    		$this->strPaginaPositie = $mysqlResult['positie'];
    	if(isset($mysqlResult['zichtbaar'])) 
    		$this->strPaginaZichtbaar = $mysqlResult['zichtbaar'];
    	if(isset($mysqlResult['bewerkbaar'])) 
    		$this->strPaginaBewerkbaar = $mysqlResult['bewerkbaar'];
    	if(isset($mysqlResult['oid'])) 
    		$this->intOnderdeelID = $mysqlResult['oid'];
    	if(isset($mysqlResult['wid'])) 
    		$this->websiteID = $mysqlResult['wid'];	
    } 	
 	public function setID( $newID ) {
 		$this->intID = $newID;
 	}
 	public function setPaginaID( $newID ) {
 		$this->intPaginaID = $newID;
 	}
 	public function setPType( $newPType ) {
 		$this->strPaginaType = $newPType;
 	} 	
 	public function setTitel( $newTitel ) {
 		$this->strPaginaTitel = $newTitel;
 	}
 	public function setLimiet( $newLimiet ) {
 		if($newLimiet == "")
 			$newLimiet = 10;
 		$this->strPaginaLimiet = $newLimiet;
 	}
 	public function setPositie( $newPositie ) {
 		$this->strPaginaPositie = $newPositie;
 	}
 	public function setZichtbaar( $newZichtbaar ) {
 		$this->strPaginaZichtbaar = $newZichtbaar;
 	}
 	public function setBewerkbaar( $newBewerkbaar ) {
 		$this->strPaginaBewerkbaar = $newBewerkbaar;
 	}
 	public function setOnderdeelID( $newOnderdeelID )  {
 		$this->intOnderdeelID = $newOnderdeelID;
 	}
 	public function setWebsiteID( $newWebsiteID ) {
 		$this->intWebsiteID = $newWebsiteID;
 	}
 }

?>