<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Nieuws.inc.php
 * Beschrijving: De klasse Nieuws
 */
 
class Nieuws {
	private $intID;
	private $intNieuwsID;
	private $strTitel;
	private $strIntro;
	private $strTekst;
	private $dtBeginDatum;
	private $dtEindDatum;
	private $strBovenaan;
	private $intPaginaID;
	private $intWebsiteID;	
	
	// Constructor
	public function __construct( $intID = '', $intNieuwsID = '', $strTitel = '', $strIntro = '', $strTekst = '', $dtBeginDatum = '', $dtEindDatum = '', $strBovenaan = 'nee', $strZichtbaar = 'nee', $intPaginaID = '', $intWebsiteID = '' ) {
		$this->intID = $intID;
		$this->intNieuwsID = $intNieuwsID;
		$this->strTitel = $strTitel;
		$this->strIntro = $strIntro;
		$this->strTekst = $strTekst;
		$this->dtBeginDatum = $dtBeginDatum;
		$this->dtEindDatum = $dtEindDatum;
		$this->strBovenaan = $strBovenaan;
	    $this->intPaginaID = $intPaginaID;
		$this->intWebsiteID = $intWebsiteID;
	}
	
	// De get-methodes
	public function getID() {
		return $this->intID;
	}
	public function getNieuwsID() {
		return $this->intNieuwsID;
	}
	public function getTitel() {
		return $this->strTitel;
	}
	public function getIntro() {
		return $this->strIntro;
	}
	public function getTekst() {
		return $this->strTekst;
	}
	public function getBeginDatum() {
		return $this->dtBeginDatum;
	}
	public function getEindDatum() {
		return $this->dtEindDatum;
	}
	public function getBovenaan() {
		return $this->strBovenaan;
	}
    public function getPaginaID() {
	    return $this->intPaginaID;
	} 
	public function getWebsiteID() {
		return $this->intWebsiteID;
	}
	
	// De set-methodes
    public function setValues( $mysqlResult ) {
    	if(isset($mysqlResult['id'])) 
    		$this->intID = $mysqlResult['id'];
    	if(isset($mysqlResult['nieuwsid'])) 
    		$this->intNieuwsID = $mysqlResult['nieuwsid'];
    	if(isset($mysqlResult['titel'])) 
    		$this->strTitel = $mysqlResult['titel'];
    	if(isset($mysqlResult['intro'])) 
    		$this->strIntro = $mysqlResult['intro'];
    	if(isset($mysqlResult['tekst'])) 
    		$this->strTekst = $mysqlResult['tekst'];
    	if(isset($mysqlResult['nieuwsdatum'])) 
    		$this->dtNieuwsDatum = $mysqlResult['nieuwsdatum'];
    	if(isset($mysqlResult['begindatum'])) 
    		$this->dtBeginDatum = $mysqlResult['begindatum'];
    	if(isset($mysqlResult['einddatum'])) 
    		$this->dtEindDatum = $mysqlResult['einddatum'];
    	if(isset($mysqlResult['bovenaan'])) 
    		$this->strBovenaan = $mysqlResult['bovenaan'];
    	if(isset($mysqlResult['pid'])) 
    		$this->intPaginaID = $mysqlResult['pid'];
    	if(isset($mysqlResult['wid'])) 
    		$this->intWebsiteID = $mysqlResult['wid'];	
    }
	public function setID( $newID ) {
		$this->intID = $newID;
	}
	public function setNieuwsID( $newId ) {
		$this->intNieuwsID = $newId;
	}
	public function setTitel( $newTitel ) {
		$this->strTitel = $newTitel;
	}
	public function setIntro( $newIntro ) {
		$this->strIntro = $newIntro;	
	}
	public function setTekst( $newTekst ) {
		$this->strTekst = $newTekst;
	}
	public function setBeginDatum( $newBeginDatum ) {
		$this->dtBeginDatum = $newBeginDatum;
	}
	public function setEindDatum( $newEindDatum ) {
		$this->dtEindDatum = $newEindDatum;
	}
	public function setBovenaan( $newBovenaan ) {
		$this->strBovenaan = $newBovenaan;
	}
	public function setPaginaID( $intPaginaID ) {
		$this->intPaginaID = $intPaginaID;
	}
 	public function setWebsiteID( $newWebsiteID ) {
		$this->intWebsiteID = $newWebsiteID;
	}
}
?>