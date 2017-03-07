<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: tekstafbContentBlok.inc.php
 * Beschrijving: De subklassen van ContentBlokken: tekstafbContentBlok
 */

// De klasse tekstafbContentBlok
class tekstafbContentBlok extends ContentBlok {
	private $strTekst;
	private $strLetterType;
	private $intLetterGrootte;
	private $strAfbAlias;
	private $strAfbURL;
	private $intAfbWidth;
	private $intAfbHeight;
	private $intAfbBorder;
	private $strAfbAlt;
	private $strKeuze;

	// De constructor	
	public function __construct( $strTekst = '', $strLetterType = 'Verdana', $intLetterGrootte = '12', $strAfbURL = '', $strAfbAlias = '', $intAfbWidth = '0', $intAfbHeight = '0', $intAfbBorder = '0', $strAfbAlt = 'Afbeelding', $strKeuze = '1' ) {
		parent::__construct();
		$this->strTekst = $strTekst;
		$this->strLetterType = $strLetterType;
		$this->intLetterGrootte = $intLetterGrootte;
		$this->strAfbURL = $strAfbURL;
		$this->strAfbAlias = $strAfbAlias;
		$this->intAfbWidth = $intAfbWidth;
		$this->intAfbHeight = $intAfbHeight;
		$this->intAfbBorder = $intAfbBorder;
		$this->strAfbAlt = $strAfbAlt;
		$this->strKeuze = $strKeuze;
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
    	if(isset($mysqlResult['tekst'])) 
    		$this->strTekst = $mysqlResult['tekst'];
    	if(isset($mysqlResult['alias'])) 
    		$this->strAfbAlias = $mysqlResult['alias'];
    	if(isset($mysqlResult['afburl'])) 
    		$this->strAfbURL = $mysqlResult['afburl'];
    	if(isset($mysqlResult['lettertype']))
    		$this->strLetterType = $mysqlResult['lettertype'];
    	if(isset($mysqlResult['lettergrootte'])) 
    		$this->intLetterGrootte = $mysqlResult['lettergrootte'];
    	if(isset($mysqlResult['width']))
    		$this->intAfbWidth = $mysqlResult['width'];
    	if(isset($mysqlResult['height']))
    		$this->intAfbHeight = $mysqlResult['height'];
    	if(isset($mysqlResult['border']))
    		$this->intAfbBorder = $mysqlResult['border'];
    	if(isset($mysqlResult['alt']))
    		$this->strAfbAlt = $mysqlResult['alt'];
    	if(isset($mysqlResult['keuze']))
    		$this->strKeuze = $mysqlResult['keuze'];
    }	
	// get-methodes
	public function getTekst() {
		return $this->strTekst;
	}
	public function getLetterType() {
		return $this->strLetterType;
	}
	public function getLetterGrootte() {
		return $this->intLetterGrootte;
	}
	public function getURL() {
		return $this->strAfbURL;
	}
	public function getAfbAlias() {
		return $this->strAfbAlias;
	}
	public function getAfbWidth() {
		return $this->intAfbWidth;
	}
	public function getAfbHeight() {
		return $this->intAfbHeight;
	}
	public function getAfbBorder() {
		return $this->intAfbBorder;
	}
	public function getAfbAlt() {
		return $this->strAfbAlt;
	}
	public function getKeuze() {
		return $this->strKeuze;
	}
	// set-methodes
	public function setTekst( $newTekst ) {
		$this->strTekst = $newTekst;
	}
	public function setLetterType( $newLetterType ) {
		$this->strLetterType = $newLetterType;
	}
	public function setLetterGrootte( $newLetterGrootte ) {
		$this->intLetterGrootte = $newLetterGrootte;
	}
	public function setURL( $newURL ) {
		$this->strAfbURL = $newURL;
	}
	public function setAfbAlias( $newAfbAlias ) {
		$this->strAfbAlias = $newAfbAlias;
	}
	public function setAfbWidth( $newAfbWidth ) {
		$this->intAfbWidth = $newAfbWidth;
	}
	public function setAfbHeight( $newAfbHeight ) {
		$this->intAfbHeight = $newAfbHeight;
	}
	public function setAfbBorder( $newAfbBorder ) {
		$this->intAfbBorder = $newAfbBorder;
	}
	public function setAfbAlt( $newAfbAlt ) {
		$this->strAfbAlt = $newAfbAlt;
	}
	public function setKeuze( $newKeuze ) {
		$this->strKeuze = $newKeuze;
	}
	// Functie om het content als HTML-code te krijgen
	public function getContent() {
		$html = "<div id=\"".$this->getContentID()."\" style=\"font-face: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; text-align: ".$this->getUitlijning()."; \">\n";
		if($this->strKeuze == "1") {
			$html .= "<table cellspacing=\"0\">\n";
//			$html .= "<tr><td style=\"font-face: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; \">".htmlentities(xmlentities($this->strTekst))."</td>\n";
			$html .= "<tr><td style=\"font-face: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; \">".htmlentities($this->strTekst)."</td>\n";
			$html .= "<td width=\"".($this->intAfbWidth + 5)."\" align=\"center\"><img src=\"".$this->strAfbURL."\" width=\"".$this->intAfbWidth."\" height=\"".$this->intAfbHeight."\" border=\"".$this->intAfbBorder."\" alt=\"".$this->strAfbAlt."\"></td></tr>\n";
			$html .= "</table>\n";
		}
		elseif($this->strKeuze == "2") {
			$html .= "<table cellspacing=\"0\">\n";
			$html .= "<tr><td width=\"".($this->intAfbWidth + 5)."\" align=\"center\"><img src=\"".$this->strAfbURL."\" width=\"".$this->intAfbWidth."\" height=\"".$this->intAfbHeight."\" border=\"".$this->intAfbBorder."\" alt=\"".$this->strAfbAlt."\"></td>\n";
//			$html .= "<td style=\"font-face: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; \">".htmlentities(xmlentities($this->strTekst))."</td></tr>\n";
			$html .= "<td style=\"font-face: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; \">".htmlentities($this->strTekst)."</td></tr>\n";
			$html .= "</table>\n";
		}
		elseif($this->strKeuze == "3") {
			$html .= "<table cellspacing=\"0\">\n";
			$html .= "<tr><td align=\"center\"><img src=\"".$this->strAfbURL."\" width=\"".$this->intAfbWidth."\" height=\"".$this->intAfbHeight."\" border=\"".$this->intAfbBorder."\" alt=\"".$this->strAfbAlt."\"></td></tr>\n";
//			$html .= "<tr><td style=\"font-face: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; \">".htmlentities(xmlentities($this->strTekst))."</td></tr>\n";
			$html .= "<tr><td style=\"font-face: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; \">".htmlentities($this->strTekst)."</td></tr>\n";
			$html .= "</table>\n";
		}
		elseif($this->strKeuze == "4") {
			$html .= "<table cellspacing=\"0\">\n";
//			$html .= "<tr><td style=\"font-face: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; \">".htmlentities(xmlentities($this->strTekst))."</td></tr>\n";
			$html .= "<tr><td style=\"font-face: ".$this->strLetterType."; font-size: ".$this->intLetterGrootte."px; \">".htmlentities($this->strTekst)."</td></tr>\n";
			$html .= "<tr><td align=\"center\"><img src=\"".$this->strAfbURL."\" width=\"".$this->intAfbWidth."\" height=\"".$this->intAfbHeight."\" border=\"".$this->intAfbBorder."\" alt=\"".$this->strAfbAlt."\"></td></tr>\n";
			$html .= "</table>\n";
		}
		$html .= "</div>\n";
		return $html;
	}
} 
?>