<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: GebruikersRechten.inc.php
 * Beschrijving: De klasse GebruikersRechten
 */
 
class GebruikersRechten {
	private $intGebruikersID;
	private $strOnderdeel;
	private $strSubOnderdeel;
	private $strPagina;
	private $strAfbeelding;
	private $strContactForm;
	private $strDownloads;
	private $strFlash;
	private $strHTMLCode;
	private $strLinks;
	private $strTekstAfb;
	private $strTekst;
	private $strWYSIWYG;
	private $strBekijken;
	private $strUpload;
	private $strVerwijderen;
	private $intMaxSize;
	private $strExtensies;
	
	public function __construct( ) {
		$this->intGebruikersID = "";
		$this->strOnderdeel = "nee";
		$this->strSubOnderdeel = "nee";
		$this->strPagina = "ja";
		$this->strAfbeelding = "nee";
		$this->strContactForm = "nee";
		$this->strDownloads = "nee";
		$this->strFlash = "nee";
		$this->strHTMLCode = "nee";
		$this->strLinks = "nee";
		$this->strTekstAfb = "nee";
		$this->strTekst = "ja";
		$this->strWYSIWYG = "nee";
		$this->strBekijken = "ja";
		$this->strUpload = "nee";
		$this->strVerwijderen = "nee";
		$this->intMaxSize = "1024000";
		$this->strExtensies = "";
	}
	
	// De get-methodes
	public function getGebruikersID() {
		return $this->intGebruikersID;
	}
	public function getOnderdeelRecht() {
		return $this->strOnderdeel;
	}
	public function getSubOnderdeelRecht() {
		return $this->strSubOnderdeel;
	}
	public function getPaginaRecht() {
		return $this->strPagina;
	}
	public function getAfbeeldingRecht() {
		return $this->strAfbeelding;
	}
	public function getContactFormRecht() {
		return $this->strContactForm;
	}	
	public function getDownloadsRecht() {
		return $this->strDownloads;
	}
	public function getFlashRecht() {
		return $this->strFlash;
	}
	public function getHTMLCodeRecht() {
		return $this->strHTMLCode;
	}
	public function getLinksRecht() {
		return $this->strLinks;
	}
	public function getTekstAfbRecht() {
		return $this->strTekstAfb;
	}
	public function getTekstRecht() {
		return $this->strTekst;
	}
	public function getWYSIWYGRecht() {
		return $this->strWYSIWYG;
	}
	public function getBekijkRecht() {
		return $this->strBekijken;
	}
	public function getUploadRecht() {
		return $this->strUpload;
	}
	public function getVerwijderRecht() {
		return $this->strVerwijderen;
	}
	public function getMaxSize() {
		return $this->intMaxSize;
	}
	public function getExtensies() {
	 	return $this->strExtensies;
	}
	
 	// De set-methodes
 	public function setValues( $mysqlResult ) {
       if(isset($mysqlResult['gid'])) 
       	  $this->intGebruikersID = $mysqlResult['gid'];
       if(isset($mysqlResult['onderdelen'])) 
       	  $this->strOnderdeel = $mysqlResult['onderdelen'];
       if(isset($mysqlResult['subonderdelen'])) 
       	  $this->strSubOnderdeel = $mysqlResult['subonderdelen'];
       if(isset($mysqlResult['pagina'])) 
       	  $this->strPagina = $mysqlResult['pagina'];
       if(isset($mysqlResult['afbeelding']))
       	  $this->strAfbeelding = $mysqlResult['afbeelding'];
       if(isset($mysqlResult['contactform']))
       	  $this->strContactForm = $mysqlResult['contactform'];       	  
       if(isset($mysqlResult['downloads'])) 
       	  $this->strDownloads = $mysqlResult['downloads'];
       if(isset($mysqlResult['flash'])) 
       	  $this->strFlash = $mysqlResult['flash'];
       if(isset($mysqlResult['htmlcode'])) 
       	  $this->strHTMLCode = $mysqlResult['htmlcode'];
       if(isset($mysqlResult['links'])) 
       	  $this->strLinks = $mysqlResult['links'];       	  
       if(isset($mysqlResult['tekstafb']))
       	  $this->strTekstAfb = $mysqlResult['tekstafb'];
       if(isset($mysqlResult['tekst'])) 
       	  $this->strTekst = $mysqlResult['tekst'];
       if(isset($mysqlResult['wysiwyg'])) 
       	  $this->strWYSIWYG = $mysqlResult['wysiwyg'];
       if(isset($mysqlResult['uploaden'])) 
       	  $this->strUpload = $mysqlResult['uploaden'];
       if(isset($mysqlResult['bekijken'])) 
       	  $this->strBekijken = $mysqlResult['bekijken'];
       if(isset($mysqlResult['verwijderen'])) 
       	  $this->strVerwijderen = $mysqlResult['verwijderen'];
       if(isset($mysqlResult['maxsize']))
       	  $this->intMaxSize = $mysqlResult['maxsize']; 
       if(isset($mysqlResult['extensies']))
       	  $this->strExtensies = $mysqlResult['extensies']; 	  
 	}
	public function setGebruikersID( $newID ) {
		$this->intGebruikersID = $newID;
	}
	public function setOnderdeelRecht( $newOnderdeel ) {
		$this->strOnderdeel = $newOnderdeel;
	}
	public function setSubOnderdeelRecht( $newSubOnderdeel ) {
		$this->strSubOnderdeel = $newSubOnderdeel;
	}
	public function setPaginaRecht( $newPagina ) {
		$this->strPagina = $newPagina;
	}	
	public function setAfbeeldingRecht( $newAfbeelding ) {
		$this->strAfbeelding = $newAfbeelding;
	}
	public function setContactFormRecht( $newContactForm ) {
		$this->strContactForm = $newContactForm;
	}
	public function setDownloadsRecht( $newDownloads ) {
		$this->strDownloads = $newDownloads;
	}
	public function setFlashRecht( $newFlash ) {
		$this->strFlash = $newFlash;
	}	
	public function setHTMLCodeRecht( $newHTMLCode ) {
		$this->strHTMLCode = $newHTMLCode;
	}
	public function setLinksRecht( $newLinks ) {
		$this->strLinks = $newLinks;
	}		
	public function setTekstRecht( $newTekst ) {
		$this->strTekst = $newTekst;
	}	
	public function setTekstAfbRecht( $newTekstAfb ) {
		$this->strTekstAfb = $newTekstAfb;
	}
	public function setWYSIWYGRecht( $newWYSIWYG ) {
		$this->strWYSIWYG = $newWYSIWYG;
	}
	public function setBekijkRecht( $newBekijken ) {
		$this->strBekijken = $newBekijken;
	}
	public function setUploadRecht( $newUpload ) {
		$this->strUpload = $newUpload;
	}
	public function setVerwijderRecht( $newVerwijder ) {
		$this->strVerwijderen = $newVerwijder;
	}
	public function setMaxSize( $newSize ) {
		$this->intMaxSize = $newSize;
	}
	public function setExtensies( $newExtensies ) {
		$this->strExtensies = $newExtensies;
	}

}