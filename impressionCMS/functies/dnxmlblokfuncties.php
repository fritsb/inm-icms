<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: dnxmlblokfuncties.php
 * Beschrijving: De functies mbt het omzetten van data uit de MySQL database naar XML.
 * Deze functies hebben allemaal betrekking tot de blokken.
 * Vergelijkbaar met blokfuncties.php, maar deze zijn aangepast
 */
 
  // Functie om paginatype op te vragen
  function getBlokType( $intBlokID, $intWebsiteID ) {
  	$sql = "SELECT subtype FROM blok WHERE wid = '$intWebsiteID' AND blokid = '$intBlokID' AND zichtbaar = 'ja'";
  	global $dbConnectie;
  	$arrBlokken = $dbConnectie->getData($sql);
 	if($arrBlokken != false && $arrBlokken != null) {
	 	$objBlok = new Blok();
    	$objBlok->setValues($arrBlokken[0]);
    	return $objBlok->getSubType();
 	}
 	else {
 		return false;
 	}	
  } 
  
  // Functie om Blok van type afbeelding op te vragen
  function getAfbeeldingBlok( $intBlokID, $intWebsiteID ) {
	$sql = "SELECT * FROM blok AS b, afbeeldingblok AS ab WHERE b.blokid = '$intBlokID' AND ab.blokid = '$intBlokID' ";
	$sql .= " AND b.wid = '$intWebsiteID' AND ab.wid = '$intWebsiteID' AND b.zichtbaar = 'ja'";
  	global $dbConnectie;	
 	$arrBlokken  = $dbConnectie->getData($sql);
 	if($arrBlokken != false && $arrBlokken != null) {
 	    $objBlok = new afbeeldingBlok();
    	$objBlok->setValues($arrBlokken[0]);
    	return $objBlok;
 	}
 	else {
 		return false;
 	}
 }
   // Functie om Blok van type contactform op te vragen
  function getContactformBlok( $intBlokID, $intWebsiteID ) {
	$sql = "SELECT b.id, b.blokid, b.titel, b.uitlijning, b.positie, b.bewerkbaar, b.zichtbaar, b.pid, p.oid, b.wid, cb.mailadres, cb.adresoptie, ";
	$sql .= " cb.teloptie, cb.taal, cb.verstuurd, cb.nietverstuurd, cb.lettergrootte, cb.lettertype FROM blok AS b, contactformblok AS cb, ";
	$sql .= " pagina AS p WHERE b.blokid = '$intBlokID' AND cb.blokid = '$intBlokID' AND b.wid = '$intWebsiteID' AND cb.wid = '$intWebsiteID' AND ";
	$sql .= " b.zichtbaar = 'ja' AND p.wid = b.wid AND p.wid = cb.wid AND p.paginaid = b.pid";
  	global $dbConnectie;
 	$arrBlokken  = $dbConnectie->getData($sql);
 	if($arrBlokken != false && $arrBlokken != null) {
 	    $objBlok = new contactformBlok();
    	$objBlok->setValues($arrBlokken[0]);
    	return $objBlok;
 	}
 	else {
 		return false;
 	}
 } 
 function getContactBericht($intWebsiteID, $intBlokID) {
	$sql = "SELECT b.id, b.blokid, b.titel, b.uitlijning, b.positie, b.bewerkbaar, b.zichtbaar, b.pid, p.oid, b.wid, cb.mailadres, cb.adresoptie, ";
	$sql .= " cb.teloptie, cb.taal, cb.verstuurd, cb.nietverstuurd, cb.lettergrootte, cb.lettertype FROM blok AS b, contactformblok AS cb, ";
	$sql .= " pagina AS p WHERE b.blokid = '$intBlokID' AND cb.blokid = '$intBlokID' AND b.wid = '$intWebsiteID' AND cb.wid = '$intWebsiteID' AND ";
	$sql .= " b.zichtbaar = 'ja' AND p.wid = b.wid AND p.wid = cb.wid AND p.paginaid = b.pid";
//	echo $sql;
  	global $dbConnectie;
 	$arrBlokken  = $dbConnectie->getData($sql);
 	if($arrBlokken != false && $arrBlokken != null) {
 	    $objBlok = new contactformBlok();
    	$objBlok->setValues($arrBlokken[0]);
		$strXML = "    <emailbericht>\n";
		$strXML .= "      <id>".$objBlok->getBlokID()."</id>\n";
		$strXML .= "      <titel>".htmlentities($objBlok->getTitel())."</titel>\n";
		$strXML .= "      <positie>".$objBlok->getPositie()."</positie>\n";
		$strXML .= "        <verstuurd>".htmlentities("<div style=\"font-family: ".$objBlok->getLetterType()."; font-size: ".$objBlok->getLetterGrootte()."px;\">".$objBlok->getVerstuurdBericht()."</div>")."</verstuurd>\n";
		$strXML .= "        <nietverstuurd>".htmlentities("<div style=\"font-family: ".$objBlok->getLetterType()."; font-size: ".$objBlok->getLetterGrootte()."px;\">".$objBlok->getNietVerstuurdBericht()."</div>")."</nietverstuurd>\n";
	  	$strXML .= "        <emailadres email=\"".$objBlok->getMailAdres()."\"/>\n";
	  	$strXML .= "        <lettertype>".$objBlok->getLetterType()."</lettertype>\n";
	  	$strXML .= "        <lettergrootte>".$objBlok->getLetterGrootte()."</lettergrootte>\n";
	  	$strXML .= "      </emailbericht>\n";
	  	return $strXML;

 	}
 	else {
 		return false;
 	}
 }
 // Functie om Blok van type html op te vragen
  function getFlashBlok( $intBlokID, $intWebsiteID ) {
	$sql = "SELECT * FROM blok AS b, flashblok AS fb WHERE b.blokid = '$intBlokID' AND ";	
	$sql .= " fb.blokid = '$intBlokID' AND b.wid = '$intWebsiteID' AND fb.wid = '$intWebsiteID' AND b.zichtbaar = 'ja'";

  	global $dbConnectie;	
 	$arrBlokken  = $dbConnectie->getData($sql);
 	if($arrBlokken != false && $arrBlokken != null) {
 	    $objBlok = new flashBlok();
    	$objBlok->setValues($arrBlokken[0]);
    	return $objBlok;
 	}
 	else {
 		return false;
 	}
  }    
  // Functie om Blok van type html op te vragen
  function getHtmlBlok( $intBlokID, $intWebsiteID) {
	$sql = "SELECT * FROM blok AS b, htmlblok AS hb WHERE b.blokid = '$intBlokID' AND hb.blokid = '$intBlokID'";
	$sql .= " AND b.wid = '$intWebsiteID' AND hb.wid = '$intWebsiteID' AND b.zichtbaar = 'ja'";
  	global $dbConnectie;
 	$arrBlokken  = $dbConnectie->getData($sql);
 	if($arrBlokken != false && $arrBlokken != null) {
 	    $objBlok = new htmlBlok();
    	$objBlok->setValues($arrBlokken[0]);
    	return $objBlok;
 	}
 	else {
 		return false;
 	}
  }
   // Functie om Blok van type links op te vragen
  function getLinksBlok( $intBlokID, $intWebsiteID) {
	$sql = "SELECT * FROM blok AS b, linksblok AS lb WHERE b.blokid = '$intBlokID' AND lb.blokid = '$intBlokID' AND";	
	$sql .= " b.wid = '$intWebsiteID' AND lb.wid = '$intWebsiteID' AND b.zichtbaar = 'ja'";

  	global $dbConnectie;	
 	$arrBlokken  = $dbConnectie->getData($sql);
 	if($arrBlokken != false && $arrBlokken != null) {
 	    $objBlok = new linksBlok();
    	$objBlok->setValues($arrBlokken[0]);
    	return $objBlok;
 	}
 	else {
 		return false;
 	}
 }   
  // Functie om Blok van type html op te vragen
  function getTekstBlok( $intBlokID, $intWebsiteID) {
   $dtVandaag = getDatumTijd();
	$sql = "SELECT * FROM blok AS b, tekstblok AS tb WHERE b.blokid = '$intBlokID' AND tb.blokid = '$intBlokID' ";	
	$sql .= " AND b.wid = '$intWebsiteID' AND tb.wid = '$intWebsiteID' AND b.zichtbaar = 'ja'";
	$sql .= " AND b.begindatum <= '".$dtVandaag."' AND b.einddatum >= '".$dtVandaag."' ";
	$sql .= " ORDER BY b.begindatum";
	//echo $sql;

  	global $dbConnectie;	
 	$arrBlokken  = $dbConnectie->getData($sql);
 	if($arrBlokken != false && $arrBlokken != null) {
 	    $objBlok = new tekstBlok();
    	$objBlok->setValues($arrBlokken[0]);
    	return $objBlok;
 	}
 	else {
 		return false;
 	}
 }  
  // Functie om Blok van type afbeelding op te vragen
  function getTekstafbBlok( $intBlokID, $intWebsiteID ) {
	$sql = "SELECT * FROM blok AS b, tekstafbblok AS tab WHERE b.blokid = '$intBlokID' AND ";
	$sql .= "tab.blokid = '$intBlokID' AND b.wid = '$intWebsiteID' AND tab.wid = '$intWebsiteID' AND b.zichtbaar = 'ja'";
  	global $dbConnectie;	
 	$arrBlokken  = $dbConnectie->getData($sql);
 	if($arrBlokken != false && $arrBlokken != null) {
 	    $objBlok = new tekstafbBlok();
    	$objBlok->setValues($arrBlokken[0]);
    	return $objBlok;
 	}
 	else {
 		return false;
 	}
 }

	// Functie om de juiste subtype terug te geven 
	function getGoedeSubType( $strSubType ) {
		if($strSubType == "downloads")
			return "links";
		elseif($strSubType == "wysiwyg")
			return "html";
		else return $strSubType;
	}
 
 
 ?>