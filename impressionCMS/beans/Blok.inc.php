<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Blok.inc.php
 * Beschrijving: De klasse Blok
 */
 
 class Blok {
 	private $intID;
 	private $intBlokID;
 	private $strTitel;
 	private $intBlokPositie;
 	private $strBlokZichtbaar;
 	private $strBlokBewerkbaar;
 	private $strSubType;
 	private $dtDatum;
	private $dtBeginDatum;
	private $dtEindDatum;
 	private $strUitlijning;
 	private $intBreedte;
 	private $intHoogte;
 	private $intBorder;
 	private $strBorderKleur;
 	private $strBorderType;
 	private $strAchtergrondKleur;
	private $strIntro;
 	private $intPaginaID;
	private $intOnderdeelID;
 	private $intWebsiteID;
 	
 	// De constructor
 	public function __construct() {
		$this->intID = "";
 		$this->intBlokID = "";
 		$this->strTitel = "";
 		$this->intBlokPositie = "";
 		$this->strBlokZichtbaar = "nee";
 		$this->strBlokBewerkbaar = "nee";
 		$this->strSubType = "";
 		$this->dtDatum = "";
		$this->dtBeginDatum = "";
		$this->dtEindDatum = "";
  		$this->strUitlijning = "left";
		$this->intBreedte = "";
		$this->intHoogte = "";
  		$this->intBorder = "";
  		$this->strBorderKleur = "";
  		$this->strBorderType = "";  		
  		$this->strAchtergrondKleur = "";
		$this->strIntro = "";
 		$this->intPaginaID = "";
 		$this->intOnderdeelID = "";
 		$this->intWebsiteID = "";
 	}
 	
 	// De get-methodes
 	public function getID() {
 		return $this->intID;
 	}
 	public function getBlokID() {
 		return $this->intBlokID;
 	}
 	public function getTitel() {
 		return $this->strTitel;
 	}
 	public function getPositie() {
 		return $this->intBlokPositie;
 	}
 	public function getZichtbaar() {
 		return $this->strBlokZichtbaar;
 	}
 	public function getBewerkbaar() {
 		return $this->strBlokBewerkbaar;
 	}
 	public function getSubType() {
 		return $this->strSubType;
 	}
 	public function getDatum() {
 		return $this->dtDatum;
 	}
	public function getBeginDatum() {
		return $this->dtBeginDatum;
	}
	public function getFormatedBeginDatum() {
		$arrDatumTijd =	explode(" ", $this->dtBeginDatum);
		$arrDatum = explode("-", $arrDatumTijd[0]);
		return $arrDatum[2]."-".$arrDatum[1]."-".$arrDatum[0]." ".$arrDatumTijd[1];
	}	
	public function getEindDatum() {
		return $this->dtEindDatum;
	}
	public function getFormatedEindDatum() {
		$arrDatumTijd =	explode(" ", $this->dtEindDatum);
		$arrDatum = explode("-", $arrDatumTijd[0]);
		return $arrDatum[2]."-".$arrDatum[1]."-".$arrDatum[0]." ".$arrDatumTijd[1];	
	}
 	public function getUitlijning() {
 		return $this->strUitlijning;
 	}
 	public function getBreedte() {
 		return $this->intBreedte;
 	}
 	public function getHoogte() {
 		return $this->intHoogte;
 	}
 	public function getBorder() {
 		return $this->intBorder;
 	}
 	public function getBorderKleur() {
 		return $this->strBorderKleur;
 	}
 	public function getBorderType() {
 		return $this->strBorderType;
 	}
 	public function getAchtergrondKleur() {
 		return $this->strAchtergrondKleur;
 	}
	public function getIntro() {
		return $this->strIntro;
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
    	if(isset($mysqlResult['blokid'])) 
    		$this->intBlokID = $mysqlResult['blokid'];
    	if(isset($mysqlResult['titel'])) 
    		$this->strTitel = $mysqlResult['titel'];
    	if(isset($mysqlResult['positie'])) 
    		$this->intBlokPositie = $mysqlResult['positie'];
    	if(isset($mysqlResult['zichtbaar'])) 
    		$this->strBlokZichtbaar = $mysqlResult['zichtbaar'];
    	if(isset($mysqlResult['bewerkbaar'])) 
    		$this->strBlokBewerkbaar = $mysqlResult['bewerkbaar'];
    	if(isset($mysqlResult['subtype']))
    		$this->strSubType = $mysqlResult['subtype'];
    	if(isset($mysqlResult['datum']))
    		$this->dtDatum = $mysqlResult['datum'];
    	if(isset($mysqlResult['begindatum'])) 
    		$this->dtBeginDatum = $mysqlResult['begindatum'];
    	if(isset($mysqlResult['einddatum'])) 
    		$this->dtEindDatum = $mysqlResult['einddatum'];
     	if(isset($mysqlResult['uitlijning'])) 
    		$this->strUitlijning = $mysqlResult['uitlijning'];
     	if(isset($mysqlResult['breedte'])) 
    		$this->intBreedte = $mysqlResult['breedte'];
     	if(isset($mysqlResult['hoogte'])) 
    		$this->intHoogte = $mysqlResult['hoogte'];
     	if(isset($mysqlResult['border'])) 
    		$this->intBorder = $mysqlResult['border'];
     	if(isset($mysqlResult['bordercolor'])) 
    		$this->strBorderKleur = $mysqlResult['bordercolor'];
     	if(isset($mysqlResult['bordertype'])) 
    		$this->strBorderType = $mysqlResult['bordertype'];
     	if(isset($mysqlResult['backgroundcolor'])) 
    		$this->strAchtergrondKleur = $mysqlResult['backgroundcolor'];
    	if(isset($mysqlResult['intro'])) 
    		$this->strIntro = $mysqlResult['intro'];
    	if(isset($mysqlResult['pid'])) 
    		$this->intPaginaID = $mysqlResult['pid'];
    	if(isset($mysqlResult['wid'])) 
    		$this->intWebsiteID = $mysqlResult['wid'];
   } 	
 	public function setID( $newID ) {
 		$this->intID = $newID;
 	}
 	public function setBlokID( $newID ) {
 		$this->intBlokID = $newID;
 	}
 	public function setTitel( $newTitel ) {
 		$this->strTitel = $newTitel;
 	}
 	public function setPositie( $newPositie ) {
 		$this->intBlokPositie = $newPositie;
 	}
 	public function setZichtbaar( $newZichtbaar ) {
 		$this->strBlokZichtbaar = $newZichtbaar;
 	}
 	public function setBewerkbaar( $newBewerkbaar ) {
 		$this->strBlokBewerkbaar = $newBewerkbaar;
 	}
 	public function setSubType( $newSubType ) {
		$this->strSubType = $newSubType; 	
 	}
 	public function setDatum( $newDatum ) {
 		$this->dtDatum = $newDatum;
 	}
	public function setBeginDatum( $newBeginDatum ) {
		$this->dtBeginDatum = $newBeginDatum;
	}
	public function setFormatedBeginDatum( $strFormatedBeginDatum ) {
		$arrDatumTijd =	explode(" ", $strFormatedBeginDatum);
		$arrDatum = explode("-", $arrDatumTijd[0]);
		$this->dtBeginDatum = $arrDatum[2]."-".$arrDatum[1]."-".$arrDatum[0]." ".$arrDatumTijd[1];	
	}
	public function setEindDatum( $newEindDatum ) {
		$this->dtEindDatum = $newEindDatum;
	}
	public function setFormatedEindDatum( $strFormatedEindDatum ) {
		$arrDatumTijd =	explode(" ", $strFormatedEindDatum);
		$arrDatum = explode("-", $arrDatumTijd[0]);
		$this->dtEindDatum = $arrDatum[2]."-".$arrDatum[1]."-".$arrDatum[0]." ".$arrDatumTijd[1];	
	}
 	public function setUitlijning( $newUitlijning ) {
 		$this->strUitlijning = $newUitlijning;
 	}
 	public function setBreedte( $newBreedte ) {
 		$this->intBreedte = $newBreedte;
 	}
 	public function setHoogte( $newHoogte ) {
 		$this->intHoogte = $newHoogte;
 	}
 	public function setBorder( $newBorder ) {
 		$this->intBorder = $newBorder;
 	}
 	public function setBorderKleur( $newBorderKleur ) {
 		$this->strBorderKleur = $newBorderKleur;
 	}
 	public function setBorderType( $newBorderType ) {
 		$this->strBorderType = $newBorderType;
 	}
 	public function setAchtergrondKleur( $newAchtergrondKleur ) {
 		$this->strAchtergrondKleur = $newAchtergrondKleur;
 	}
	public function setIntro( $newIntro ) {
		$this->strIntro = $newIntro;	
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