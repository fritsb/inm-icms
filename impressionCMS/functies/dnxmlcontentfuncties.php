<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: dnxmlcontentfuncties.php
 * Beschrijving: De functies mbt het omzetten van data uit de MySQL database naar XML.
 * Deze functies hebben allemaal betrekking tot het content.
 * Vergelijkbaar met contentfuncties.php, maar deze zijn aangepast
 */
 
  // Functie om paginatype op te vragen
  function getContentType( $intContentID, $intWebsiteID ) {
  	$sql = "SELECT type FROM contentblok WHERE wid = '$intWebsiteID' AND contentblokid = '$intContentID' AND zichtbaar = 'ja'";
  	global $dbConnectie;
  	$arrContentBlokken = $dbConnectie->getData($sql);
 	if($arrContentBlokken != false && $arrContentBlokken != null) {
	 	$objContentBlok = new ContentBlok();
    	$objContentBlok->setValues($arrContentBlokken[0]);
    	return $objContentBlok->getCType();
 	}
 	else {
 		return false;
 	}	
  } 
  // Functie om contentblok op te vragen
  function getContentBlok( $intContentID, $intWebsiteID ) {
	$sql = "SELECT id, contentblokid, titel, type, positie, bewerkbaar, zichtbaar, pid, wid FROM contentblok WHERE contentblokid = '$intContentID' AND wid = '$intWebsiteID' AND zichtbaar = 'ja'";
  	global $dbConnectie;	
 	$arrContentBlokken  = $dbConnectie->getData($sql);
 	if($arrContentBlokken != false && $arrContentBlokken != null) {
 	    $objContentBlok = new ContentBlok();
    	$objContentBlok->setValues($arrContentBlokken[0]);
    	return $objContentBlok;
 	}
 	else {
 		return false;
 	}
  }
  
  // Functie om contentblok van type afbeelding op te vragen
  function getAfbeeldingContentBlok( $intContentID, $intWebsiteID, $strManier = "normaal" ) {
	$sql = "SELECT cb.id, cb.contentblokid, cb.titel, cb.type, cb.uitlijning, cb.positie, cb.bewerkbaar, cb.zichtbaar, cb.pid, cb.wid, acb.afburl, acb.width, acb.height, ";
	$sql .= " acb.border, acb.alt FROM contentblok AS cb, afbeeldingcontentblok AS acb WHERE cb.contentblokid = '$intContentID' AND acb.cid = '$intContentID'  AND cb.wid = '$intWebsiteID' AND acb.wid = '$intWebsiteID' AND cb.zichtbaar = 'ja'";
  	global $dbConnectie;	
 	$arrContentBlokken  = $dbConnectie->getData($sql);
 	if($arrContentBlokken != false && $arrContentBlokken != null) {
 	    $objContentBlok = new afbeeldingContentBlok();
    	$objContentBlok->setValues($arrContentBlokken[0]);
    	return $objContentBlok;
 	}
 	else {
 		return false;
 	}
 }
   // Functie om contentblok van type contactform op te vragen
  function getContactformContentBlok( $intContentID, $intWebsiteID ) {
	$sql = "SELECT cb.id, cb.contentblokid, cb.titel, cb.type, cb.uitlijning, cb.positie, cb.bewerkbaar, cb.zichtbaar, cb.pid, p.oid, cb.wid, ccb.mailadres, ccb.adresoptie, ";
	$sql .= " ccb.teloptie, ccb.taal, ccb.verstuurd, ccb.nietverstuurd, ccb.lettergrootte, ccb.lettertype FROM contentblok AS cb, contactformcontentblok AS ccb, ";
	$sql .= " pagina AS p WHERE cb.contentblokid = '$intContentID' AND ccb.cid = '$intContentID' AND cb.wid = '$intWebsiteID' AND ccb.wid = '$intWebsiteID' AND ";
	$sql .= " cb.zichtbaar = 'ja' AND p.wid = cb.wid AND p.wid = ccb.wid AND p.paginaid = cb.pid";
  	global $dbConnectie;
 	$arrContentBlokken  = $dbConnectie->getData($sql);
 	if($arrContentBlokken != false && $arrContentBlokken != null) {
 	    $objContentBlok = new contactformContentBlok();
    	$objContentBlok->setValues($arrContentBlokken[0]);
    	return $objContentBlok;
 	}
 	else {
 		return false;
 	}
 } 
 function getContactBericht($intWebsiteID, $intOnderdeelID, $intPaginaID, $intContentID) {
	$sql = "SELECT cb.id, cb.contentblokid, cb.titel, cb.type, cb.uitlijning, cb.positie, cb.bewerkbaar, cb.zichtbaar, cb.pid, p.oid, cb.wid, ccb.mailadres, ccb.adresoptie, ";
	$sql .= " ccb.teloptie, ccb.taal, ccb.verstuurd, ccb.nietverstuurd, ccb.lettergrootte, ccb.lettertype FROM contentblok AS cb, contactformcontentblok AS ccb, ";
	$sql .= " pagina AS p WHERE cb.contentblokid = '$intContentID' AND ccb.cid = '$intContentID' AND cb.wid = '$intWebsiteID' AND ccb.wid = '$intWebsiteID' AND ";
	$sql .= " cb.zichtbaar = 'ja' AND p.wid = cb.wid AND p.wid = ccb.wid AND p.paginaid = cb.pid";
  	global $dbConnectie;
 	$arrContentBlokken  = $dbConnectie->getData($sql);
 	if($arrContentBlokken != false && $arrContentBlokken != null) {
 	    $objContentBlok = new contactformContentBlok();
    	$objContentBlok->setValues($arrContentBlokken[0]);
		$strXML = "    <emailbericht>\n";
		$strXML .= "      <id>".$objContentBlok->getContentID()."</id>\n";
		$strXML .= "      <titel>".htmlentities($objContentBlok->getTitel())."</titel>\n";
		$strXML .= "      <type>".$objContentBlok->getCType()."</type>\n";
		$strXML .= "      <positie>".$objContentBlok->getPositie()."</positie>\n";
		$strXML .= "        <verstuurd>".htmlentities("<div style=\"font-family: ".$objContentBlok->getLetterType()."; font-size: ".$objContentBlok->getLetterGrootte().";\">".$objContentBlok->getVerstuurdBericht()."</div>")."</verstuurd>\n";
		$strXML .= "        <nietverstuurd>".htmlentities("<div style=\"font-family: ".$objContentBlok->getLetterType()."; font-size: ".$objContentBlok->getLetterGrootte().";\">".$objContentBlok->getNietVerstuurdBericht()."</div>")."</nietverstuurd>\n";
	  	$strXML .= "        <emailadres email=\"".$objContentBlok->getMailAdres()."\"/>\n";
	  	$strXML .= "        <lettertype>".$objContentBlok->getLetterType()."</lettertype>\n";
	  	$strXML .= "        <lettergrootte>".$objContentBlok->getLetterGrootte()."</lettergrootte>\n";
	  	$strXML .= "      </emailbericht>\n";
	  	return $strXML;

 	}
 	else {
 		return false;
 	}
 }
 // Functie om contentblok van type html op te vragen
  function getFlashContentBlok( $intContentID, $intWebsiteID ) {
	$sql = "SELECT cb.id, cb.contentblokid, cb.titel, cb.type, cb.uitlijning, cb.positie, cb.bewerkbaar, cb.zichtbaar, cb.pid, cb.wid, fcb.flashurl, fcb.width, ";
	$sql .= "fcb.height, fcb.kwaliteit, fcb.loop, fcb.autoplay, fcb.achtergrond FROM contentblok AS cb, flashcontentblok AS fcb WHERE ";	
	$sql .= "cb.contentblokid = '$intContentID' AND fcb.cid = '$intContentID' AND cb.wid = '$intWebsiteID' AND fcb.wid = '$intWebsiteID' AND cb.zichtbaar = 'ja'";

  	global $dbConnectie;	
 	$arrContentBlokken  = $dbConnectie->getData($sql);
 	if($arrContentBlokken != false && $arrContentBlokken != null) {
 	    $objContentBlok = new flashContentBlok();
    	$objContentBlok->setValues($arrContentBlokken[0]);
    	return $objContentBlok;
 	}
 	else {
 		return false;
 	}
  }    
  // Functie om contentblok van type html op te vragen
  function getHtmlContentBlok( $intContentID, $intWebsiteID) {
	$sql = "SELECT cb.id, cb.contentblokid, cb.titel, cb.type, cb.uitlijning, cb.positie, cb.bewerkbaar, cb.zichtbaar, cb.pid, cb.wid, hcb.htmlcode ";
	$sql .= " FROM contentblok AS cb, htmlcontentblok AS hcb WHERE cb.contentblokid = '$intContentID' AND hcb.cid = '$intContentID'";
	$sql .= " AND cb.wid = '$intWebsiteID' AND hcb.wid = '$intWebsiteID' AND cb.zichtbaar = 'ja'";
  	global $dbConnectie;	
 	$arrContentBlokken  = $dbConnectie->getData($sql);
 	if($arrContentBlokken != false && $arrContentBlokken != null) {
 	    $objContentBlok = new htmlContentBlok();
    	$objContentBlok->setValues($arrContentBlokken[0]);
    	return $objContentBlok;
 	}
 	else {
 		return false;
 	}
  }
   // Functie om contentblok van type links op te vragen
  function getLinksContentBlok( $intContentID, $intWebsiteID) {
	$sql = "SELECT cb.id, cb.contentblokid, cb.titel, cb.type, cb.uitlijning, cb.positie, cb.bewerkbaar, cb.zichtbaar, cb.pid, cb.wid, ";
	$sql .= " lcb.url, lcb.naam, lcb.omschrijving FROM contentblok AS cb, linkscontentblok AS lcb WHERE ";	
	$sql .= "cb.contentblokid = '$intContentID' AND lcb.cid = '$intContentID' AND cb.wid = '$intWebsiteID' AND lcb.wid = '$intWebsiteID' AND cb.zichtbaar = 'ja'";

  	global $dbConnectie;	
 	$arrContentBlokken  = $dbConnectie->getData($sql);
 	if($arrContentBlokken != false && $arrContentBlokken != null) {
 	    $objContentBlok = new linksContentBlok();
    	$objContentBlok->setValues($arrContentBlokken[0]);
    	return $objContentBlok;
 	}
 	else {
 		return false;
 	}
 }   
  // Functie om contentblok van type html op te vragen
  function getTekstContentBlok( $intContentID, $intWebsiteID) {
	$sql = "SELECT cb.id, cb.contentblokid, cb.titel, cb.type, cb.uitlijning, cb.positie, cb.bewerkbaar, cb.zichtbaar, cb.pid, cb.wid, tcb.tekst, ";
	$sql .= " tcb.lettertype, tcb.lettergrootte FROM contentblok AS cb, tekstcontentblok AS tcb WHERE ";	
	$sql .= "cb.contentblokid = '$intContentID' AND tcb.cid = '$intContentID' AND cb.wid = '$intWebsiteID' AND tcb.wid = '$intWebsiteID' AND cb.zichtbaar = 'ja'";

  	global $dbConnectie;	
 	$arrContentBlokken  = $dbConnectie->getData($sql);
 	if($arrContentBlokken != false && $arrContentBlokken != null) {
 	    $objContentBlok = new tekstContentBlok();
    	$objContentBlok->setValues($arrContentBlokken[0]);
    	return $objContentBlok;
 	}
 	else {
 		return false;
 	}
 }  
  // Functie om contentblok van type afbeelding op te vragen
  function getTekstafbContentBlok( $intContentID, $intWebsiteID ) {
	$sql = "SELECT cb.id, cb.contentblokid, cb.titel, cb.type, cb.uitlijning, cb.positie, cb.bewerkbaar, cb.zichtbaar, cb.pid, cb.wid, tacb.afburl, ";
	$sql .= " tacb.width, tacb.height, tacb.border, tacb.alt, tacb.tekst, tacb.lettertype, tacb.lettergrootte, tacb.keuze FROM ";
	$sql .= " contentblok AS cb, tekstafbcontentblok AS tacb WHERE cb.contentblokid = '$intContentID' AND ";
	$sql .= "tacb.cid = '$intContentID' AND cb.wid = '$intWebsiteID' AND tacb.wid = '$intWebsiteID' AND cb.zichtbaar = 'ja'";
  	global $dbConnectie;	
 	$arrContentBlokken  = $dbConnectie->getData($sql);
 	if($arrContentBlokken != false && $arrContentBlokken != null) {
 	    $objContentBlok = new tekstafbContentBlok();
    	$objContentBlok->setValues($arrContentBlokken[0]);
    	return $objContentBlok;
 	}
 	else {
 		return false;
 	}
 }

 
 
 
 
 ?>