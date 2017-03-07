<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: contentfuncties.php
 * Beschrijving: De functies mbt contentblokken
 */
 

  // Functie om contentblok in te voeren 
  function insertContentBlok( ContentBlok $objContentBlok) {  
 	$sql = "INSERT INTO contentblok (contentblokid, titel, type, uitlijning, positie, zichtbaar, bewerkbaar, pid, wid )";
 	$sql .= " VALUES ('".$objContentBlok->getContentID()."', '" . $objContentBlok->getTitel() . "',  '".$objContentBlok->getCType()."', '".$objContentBlok->getUitlijning()."', ";
 	$sql .= " '".getMaxPositie("contentblok", $objContentBlok->getPaginaID(), $objContentBlok->getWebsiteID())."', '".$objContentBlok->getZichtbaar()."', '".$objContentBlok->getBewerkbaar()."', ";
 	$sql .= " '".$objContentBlok->getPaginaID()."', '".$objContentBlok->getWebsiteID()."')";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
 	return true;
  }

  // Functie om het stukje afbeeldingcontent in te voeren
  function insertAfbeeldingContentBlok( afbeeldingContentBlok $objContentBlok) {
 	$sql = "INSERT INTO afbeeldingcontentblok (afburl, width, height, border, alt, cid, wid) VALUES ('".$objContentBlok->getURL()."', '".$objContentBlok->getWidth()."', '".$objContentBlok->getHeight()."', ";
 	$sql .= " '".$objContentBlok->getBorder()."', '".$objContentBlok->getAlt()."', '".$objContentBlok->getContentID()."', '".$objContentBlok->getWebsiteID()."')";
 	global $dbConnectie;    
    return $dbConnectie->setData($sql);
  }    
  // Functie om het stukje contactformcontent in te voeren
  function insertContactFormContentBlok( contactformContentBlok $objContentBlok) {
 	$sql = "INSERT INTO contactformcontentblok (mailadres, adresoptie, teloptie, taal, verstuurd, nietverstuurd, lettertype, lettergrootte, cid, wid) VALUES ('".$objContentBlok->getMailAdres()."', ";
 	$sql .= "'".$objContentBlok->getAdresOptie()."', '".$objContentBlok->getTelOptie()."', '".$objContentBlok->getTaal()."', '".$objContentBlok->getVerstuurdBericht()."', '".$objContentBlok->getNietVerstuurdBericht()."', ";
 	$sql .= " '".$objContentBlok->getLetterType()."', '".$objContentBlok->getLetterGrootte()."', ";
 	$sql .= "'".$objContentBlok->getContentID()."', '".$objContentBlok->getWebsiteID()."') ";
 	global $dbConnectie;    
    return $dbConnectie->setData($sql);
  } 
  // Functie om het stukje flash content in te voeren
  function insertFlashContentBlok( flashContentBlok $objContentBlok) {
 	$sql = "INSERT INTO flashcontentblok (flashurl, width, height, loop, kwaliteit, autoplay, achtergrond, cid, wid ) VALUES  ('".$objContentBlok->getFlashURL()."', '".$objContentBlok->getWidth()."', '".$objContentBlok->getHeight()."', ";
 	$sql .= " '".$objContentBlok->getLoop()."', '".$objContentBlok->getKwaliteit()."', '".$objContentBlok->getKwaliteit()."','".$objContentBlok->getAchtergrond()."',  ";
 	$sql .= "'".$objContentBlok->getContentID()."', '".$objContentBlok->getWebsiteID()."')";
 	global $dbConnectie;    
    return $dbConnectie->setData($sql);
  }
  // Functie om het stukje tekst content in te voeren
  function insertHtmlContentBlok( htmlContentBlok $objContentBlok) {
 	$sql = "INSERT INTO htmlcontentblok (htmlcode, cid, wid ) VALUES ( '".$objContentBlok->getHTMLCode()."','".$objContentBlok->getContentID()."', '".$objContentBlok->getWebsiteID()."')";
 	global $dbConnectie;    
    return $dbConnectie->setData($sql);
  }    
  // Functie om het stukje links-content in te voeren
  function insertLinksContentBlok( linksContentBlok $objContentBlok) {
 	$sql = "INSERT INTO linkscontentblok (url, naam, omschrijving, cid, wid ) VALUES ( '".$objContentBlok->getURL()."', '".$objContentBlok->getNaam()."', '".$objContentBlok->getOmschrijving()."',";
 	$sql .= "'".$objContentBlok->getContentID()."', '".$objContentBlok->getWebsiteID()."')";
 	global $dbConnectie;    
    return $dbConnectie->setData($sql);
  }
  // Functie om het stukje tekstafb content in te voeren
  function insertTekstAfbContentBlok( tekstafbContentBlok $objContentBlok) {
 	$sql = "INSERT INTO tekstafbcontentblok  (tekst, lettertype, lettergrootte, afburl, width, height, border, alt, keuze, cid, wid ) VALUES ('".$objContentBlok->getTekst()."', ";
 	$sql .= " '".$objContentBlok->getLetterType()."', '".$objContentBlok->getLetterGrootte()."', '".$objContentBlok->getURL()."', '".$objContentBlok->getAfbWidth()."',  '".$objContentBlok->getAfbHeight()."', ";
 	$sql .= " '".$objContentBlok->getAfbBorder()."', '".$objContentBlok->getAfbAlt()."', '".$objContentBlok->getKeuze()."','".$objContentBlok->getContentID()."', '".$objContentBlok->getWebsiteID()."')";
 	global $dbConnectie;    
    return $dbConnectie->setData($sql);
  }  
  // Functie om het stukje tekst content in te voeren
  function insertTekstContentBlok( tekstContentBlok $objContentBlok) {
 	$sql = "INSERT INTO tekstcontentblok (tekst, lettertype, lettergrootte, cid, wid ) VALUES ( '".$objContentBlok->getTekst()."',  '".$objContentBlok->getLetterType()."', '".$objContentBlok->getLetterGrootte()."',";
 	$sql .= "'".$objContentBlok->getContentID()."', '".$objContentBlok->getWebsiteID()."')";
 	global $dbConnectie;    
    return $dbConnectie->setData($sql);
  }  
  // Functie om contentblok uptedaten
  function updateContentBlok( ContentBlok $objContentBlok ) {
  	$strType = $objContentBlok->getCType();
  	if($strType == "downloads") 
  		$strType = "links";
  	
  	if($strType == "afbeelding") {
  		//$extraSQL = ", scb.alias = '".$objContentBlok->getAlias()."', scb.width = '".$objContentBlok->getWidth()."', scb.height = '".$objContentBlok->getHeight()."', ";
		$extraSQL = ", scb.afburl = '".$objContentBlok->getURL()."', scb.width = '".$objContentBlok->getWidth()."', scb.height = '".$objContentBlok->getHeight()."', ";
  		$extraSQL .= "scb.border = '".$objContentBlok->getBorder()."', scb.alt = '".$objContentBlok->getAlt()."' ";
  	}
  	elseif($strType == "contactform" ) {
  		$extraSQL = ", scb.mailadres = '".$objContentBlok->getMailAdres()."', scb.adresoptie = '".$objContentBlok->getAdresOptie()."', scb.teloptie = '".$objContentBlok->getTelOptie()."', ";
  		$extraSQL .= " scb.verstuurd = '".$objContentBlok->getVerstuurdBericht()."', scb.nietverstuurd = '".$objContentBlok->getNietVerstuurdBericht()."', scb.taal = '".$objContentBlok->getTaal()."', ";
  		$extraSQL .= " scb.lettertype = '".$objContentBlok->getLetterType()."', scb.lettergrootte = '".$objContentBlok->getLetterGrootte()."' ";
  	}
  	elseif($strType == "flash" ) {
  		$extraSQL = ", scb.flashurl = '".$objContentBlok->getFlashURL()."', scb.width = '".$objContentBlok->getWidth()."', scb.height = '".$objContentBlok->getHeight()."', ";
  		$extraSQL .= " scb.kwaliteit = '".$objContentBlok->getKwaliteit()."', scb.loop = '".$objContentBlok->getLoop()."', scb.autoplay = '".$objContentBlok->getAutoPlay()."', ";
  		$extraSQL .= " scb.achtergrond = '".$objContentBlok->getAchtergrondKleur()."' ";
  	}
  	elseif($strType == "html" ) {
  		$extraSQL = ", scb.htmlcode = '".$objContentBlok->getHTMLcode()."'";
  	}
  	elseif($strType == "links" ) {
  		$extraSQL = ", scb.url = '".$objContentBlok->getURL()."', scb.naam = '".$objContentBlok->getNaam()."', scb.omschrijving = '".$objContentBlok->getOmschrijving()."' ";
  	}
  	elseif($strType == "tekstafb" ) {
  		$extraSQL = ", scb.tekst = '".$objContentBlok->getTekst()."', scb.lettertype = '".$objContentBlok->getLetterType()."', scb.lettergrootte = '".$objContentBlok->getLetterGrootte()."', ";
  		//$extraSQL .= " scb.alias = '".$objContentBlok->getAfbAlias()."', scb.width = '".$objContentBlok->getAfbWidth()."', scb.height = '".$objContentBlok->getAfbHeight()."', scb.border = ";
  		$extraSQL .= " scb.afburl = '".$objContentBlok->getURL()."', scb.width = '".$objContentBlok->getAfbWidth()."', scb.height = '".$objContentBlok->getAfbHeight()."', scb.border = ";
  		$extraSQL .= "'".$objContentBlok->getAfbBorder()."', alt = '".$objContentBlok->getAfbAlt()."',  keuze = '".$objContentBlok->getKeuze()."' ";
  	}
  	elseif($strType == "tekst" ) {
  		$extraSQL = ", scb.tekst = '".$objContentBlok->getTekst()."', scb.lettertype = '".$objContentBlok->getLetterType()."', scb.lettergrootte = '".$objContentBlok->getLetterGrootte()."' ";
  	}
  	
 	$sql = "UPDATE contentblok AS cb, ".$strType."contentblok AS scb SET cb.titel = '".$objContentBlok->getTitel()."', cb.uitlijning = '".$objContentBlok->getUitlijning()."', ";
 	$sql .= "cb.zichtbaar = '".$objContentBlok->getZichtbaar()."', cb.bewerkbaar = '".$objContentBlok->getBewerkbaar()."' ".$extraSQL." WHERE cb.contentblokid = '".$objContentBlok->getContentID()."'";
 	$sql .= " AND scb.cid = '".$objContentBlok->getContentID()."' AND cb.wid = '".$objContentBlok->getWebsiteID()."'";
 	global $dbConnectie;    
   return $dbConnectie->setData($sql);
  }
  // Functie om contentblok te moven
  function moveContentBlok( $intPositieID, $intParentID, $intContentID, $intWebsiteID, $strVerplaatsing ) {
 	$sql = "UPDATE contentblok SET ";
	if($strVerplaatsing == "up") {
		$sql1 = $sql . " positie = (positie + 1) WHERE positie = ($intPositieID-1)";
		$sql .= " positie = (positie - 1) ";
	}
	elseif($strVerplaatsing == "down") {
		$sql1 = $sql . " positie = (positie - 1) WHERE positie = ($intPositieID+1)";
		$sql .= " positie = (positie + 1) ";
	}
	$sql .= " WHERE positie = '$intPositieID' AND pid = '$intParentID' AND wid = '$intWebsiteID' AND contentblokid = '$intContentID'";
	$sql1 .= " AND pid = '$intParentID' AND wid = '$intWebsiteID' AND contentblokid != '$intContentID'";
	global $dbConnectie;    
 	if(!$dbConnectie->setData($sql)) {
 		return false;
 	}
 	if(!$dbConnectie->setData($sql1)) {
 		return false;
 	}
 	else {
 		return true;
 	}
  }
  // Functie om contentblok van zichtbaarheid te veranderen
  function changeContentVisibility( $intContentID, $intWebsiteID, $strVisibility ) {
	$sql = "UPDATE contentblok SET zichtbaar = '$strVisibility'";
	$sql .= " WHERE contentblokid = '$intContentID' AND wid = '$intWebsiteID'";
	global $dbConnectie;    
    return $dbConnectie->setData($sql);    
  }  
  // Functie om contentblok te verwijderen
  function deleteContentBlok( $intContentBlokID, $intWebsiteID ) {
  	$objContentBlok = getContentBlok( $intContentBlokID, $intWebsiteID, "md5");
	if($objContentBlok != null && $objContentBlok != false) {
  		$intPaginaID = $objContentBlok->getPaginaID();
  		$intPositie = $objContentBlok->getPositie();
		veranderContentBlokkenPositie( $intContentBlokID, $intPaginaID, $intPositie, $intWebsiteID);
  		$strType = getContentType( $intContentBlokID, $intWebsiteID, "md5");
	  	if($strType == "downloads")
  		$strType = "links";
  		
  		$sql0 = "DELETE FROM ".$strType."contentblok WHERE cid = '$intContentBlokID'";
 		$sql = "DELETE FROM contentblok WHERE contentblokid = '$intContentBlokID' AND wid = '$intWebsiteID'";
	  	global $dbConnectie;
	  	if(!$dbConnectie->setData($sql0)) {
  			return false;	  		
	  	}
  		elseif(!$dbConnectie->setData($sql)) {
  			return false;
  		}
  		else {
  			return true;
  		}
  	}
  	else {
  		return false;
  	}
  }
  // Functie om contentblok te checken
  function checkContentBlok( $intContentBlokID, $intWebsiteID, $intPaginaID ) {
 	$sql = "SELECT contentblokid FROM contentblok WHERE contentblokid = '$intContentBlokID' AND wid = '$intWebsiteID' AND pid = '$intPaginaID'";	
  	global $dbConnectie;	
 	$arrContentBlokken  = $dbConnectie->getData($sql);
 	if($arrContentBlokken != false && $arrContentBlokken != null) {
		return true;
 	}
 	else {
 		return false;
 	}
  }
  // Functie om de positie te veranderen als er nog contentblokken zijn met een hogere positie
  // Deze functie wordt aangeroepen voordat een andere contentblok is verwijderd
  // Dit zodat de volgorde blijft kloppen
  function veranderContentBlokkenPositie( $intContentBlokID, $intPaginaID, $intPositie, $intWebsiteID ) {
  	$sql = "SELECT contentblokid FROM contentblok WHERE pid = (SELECT pid FROM contentblok WHERE md5(contentblokid) = '$intContentBlokID') AND positie > (SELECT positie FROM contentblok WHERE md5(contentblokid) = '$intContentBlokID') AND wid = '$intWebsiteID'";
  	global $dbConnectie;
  	$arrContentBlokken = $dbConnectie->getData($sql);
  	if($arrContentBlokken != null && $arrContentBlokken != false) {
		$sql2 = "UPDATE contentblok SET positie = positie - 1 WHERE pid = '$intPaginaID' AND positie > '$intPositie' AND wid = '$intWebsiteID'";
		return $dbConnectie->setData($sql2);
  	}
  }
  
  
  // Functie om paginatype op te vragen
  function getContentType( $intContentID, $intWebsiteID ) {
  	$sql = "SELECT type FROM contentblok WHERE wid = '$intWebsiteID' AND contentblokid = '$intContentID'";
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
	$sql = "SELECT id, contentblokid, titel, type, uitlijning, positie, bewerkbaar, zichtbaar, pid, wid FROM contentblok WHERE contentblokid = '$intContentID' AND wid = '$intWebsiteID'";
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
	$sql .= " acb.border, acb.alt FROM contentblok AS cb, afbeeldingcontentblok AS acb WHERE cb.contentblokid = '$intContentID' AND acb.cid = '$intContentID' ";
	$sql .= " AND cb.wid = '$intWebsiteID' AND acb.wid = '$intWebsiteID'";
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
	$sql = "SELECT cb.id, cb.contentblokid, cb.titel, cb.type, cb.uitlijning, cb.positie, cb.bewerkbaar, cb.zichtbaar, cb.pid, cb.wid, ccb.mailadres, ccb.adresoptie, ";
	$sql .= " ccb.teloptie, ccb.taal, ccb.verstuurd, ccb.nietverstuurd, ccb.lettertype, ccb.lettergrootte FROM contentblok AS cb, contactformcontentblok AS ";
	$sql .= " ccb WHERE cb.contentblokid = '$intContentID' AND ccb.cid = '$intContentID' AND cb.wid = '$intWebsiteID' AND ccb.wid = '$intWebsiteID'";

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
 // Functie om contentblok van type html op te vragen
  function getFlashContentBlok( $intContentID, $intWebsiteID ) {
	$sql = "SELECT cb.id, cb.contentblokid, cb.titel, cb.type, cb.uitlijning, cb.positie, cb.bewerkbaar, cb.zichtbaar, cb.pid, cb.wid, fcb.flashurl, fcb.width, ";
	$sql .= "fcb.height, fcb.kwaliteit, fcb.loop, fcb.autoplay, fcb.achtergrond FROM contentblok AS cb, flashcontentblok AS fcb WHERE ";	
	$sql .= "cb.contentblokid = '$intContentID' AND fcb.cid = '$intContentID' AND cb.wid = '$intWebsiteID' AND fcb.wid = '$intWebsiteID'";

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
	$sql .= " AND cb.wid = '$intWebsiteID' AND hcb.wid = '$intWebsiteID'";
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
	$sql .= "cb.contentblokid = '$intContentID' AND lcb.cid = '$intContentID' AND cb.wid = '$intWebsiteID' AND lcb.wid = '$intWebsiteID'";

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
	$sql .= "cb.contentblokid = '$intContentID' AND tcb.cid = '$intContentID' AND cb.wid = '$intWebsiteID' AND tcb.wid = '$intWebsiteID'";

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
	$sql .= "tacb.cid = '$intContentID' AND cb.wid = '$intWebsiteID' AND tacb.wid = '$intWebsiteID'";
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

  // Functie om contentblok te laten zien op het scherm
  function showContentBlok( $intContentID, $intWebsiteID, $objGebRechten ) {
  	$objContentBlok = getContentBlok( $intContentID, $intWebsiteID );
	$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);  	
  	echo "<h1>Bekijk contentblokinformatie</h1><br>\n";
	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  	if($objContentBlok != false && $objContentBlok != null) {
	  	$objPagina = getPagina( $objContentBlok->getPaginaID(), $intWebsiteID);
  		echo "<tr><td class=\"tabletitle\" colspan=\"4\">ContentBlok met titel '".$objContentBlok->getTitel()."' (".$objContentBlok->getContentID().")</td></tr>\n";
  		echo "<tr><td class=\"formvakb\">Type:</td><td class=\"formvak\" colspan=\"3\">".changeContentType($objContentBlok->getCType())."</td></tr>\n";  		
  		echo "<tr><td class=\"formvakb\">Zichtbaar:</td><td class=\"formvak\" colspan=\"3\">".$objContentBlok->getZichtbaar()."</td></tr>\n";
  		echo "<tr><td class=\"formvakb\">Bewerkbaar:</td><td class=\"formvak\" colspan=\"3\">".$objContentBlok->getBewerkbaar()."</td></tr>\n";
  		echo "<tr><td class=\"formvakb\">Uitlijning:</td><td class=\"formvak\" colspan=\"3\">";
  		showUitlijningNaam( $objContentBlok->getUitlijning() );
  		echo "</td></tr>\n";
  		echo "<tr><td class=\"formvakb\">Onderdeel van:</td><td class=\"formvak\" colspan=\"3\">";
  		showHoofdOnderdelen($objPagina->getOnderdeelID(), $intWebsiteID, $objGebRechten);  		
  		echo "--> <a href=\"".$_SERVER['PHP_SELF']."?pid=".$objPagina->getPaginaID()."&actie=view";
  		if($objGebRechten == "ja")
  			echo "&wid=".$intWebsiteID;
  		echo "\">".$objPagina->getTitel() . "</a></td></tr>\n";
  		echo "</td></tr>\n";
		if($objGebRechten == "ja" || (checkContentRechten($objGebRechten, $objContentBlok->getCType()) && $objContentBlok->getBewerkbaar() == "ja")) {
  			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?cid=".$objContentBlok->getContentID()."&actie=edit$strExtra\" class=\"linkitem\">Bewerk contentblok</a></td>\n";
	  		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?cid=".$objContentBlok->getContentID()."&pagid=".$objContentBlok->getPaginaID()."&actie=del$strExtra\" class=\"linkitem\">Verwijder contentblok</a></td>\n";			
		}
		else {
			echo "<tr><td class=\"tablelinks\" colspan=\"2\">&nbsp;</td>";
		}

  		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?pid=".$objContentBlok->getPaginaID()."&actie=view$strExtra\" class=\"linkitem\">Bekijk pagina</a></td>\n";
  		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
	  	echo "</table>\n<br><br>\n";
	 	echo "<table class=\"overzicht\" cellspacing=\"0\" colspan=\"2\">\n";
	 	echo "<tr><td class=\"tabletitle\" colspan=\"2\">Overzicht contentblokken bij pagina '<a href=\"".$_SERVER['PHP_SELF']."?pid=".$objContentBlok->getPaginaID()."&actie=view\" class=\"linkitem\">".$objPagina->getTitel()."</a>'</td></tr>\n";
	  	showContentByPID( $objContentBlok->getPaginaID(), $objContentBlok->getWebsiteID() , $objGebRechten, $objContentBlok->getContentID());
		if(checkContentRechten($objGebRechten)) {
			echo "<tr><td class=\"tablelinks\" colspan=\"2\"><a href=\"".$_SERVER['PHP_SELF']."?actie=newC&pid=".$objContentBlok->getPaginaID()."$strExtra\" class=\"linkitem\">Voeg content toe</a></td></tr>\n";
		}
		else {
			echo "<tr><td class=\"tablelinks\" colspan=\"2\">&nbsp;</td></tr>\n";
		}
  	}
  	else {
  		echo "<tr><td class=\"tabletitle\">Contentblok niet gevonden</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Het contentblok met id-nummer '$intContentID' is niet gevonden.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
  	}
	echo "</table>\n";
  }
  
  // Functie om contentblokken op te vragen
  function getContentBlokken( $intWebsiteID ) {
 	$sql = "SELECT id, contentblokid, titel, type, positie, bewerkbaar, zichtbaar, pid, wid FROM contentblok WHERE wid = '$intWebsiteID'";	
  	global $dbConnectie;	
 	$arrContentBlokken  = $dbConnectie->getData($sql);
 	return $arrContentBlokken;
  }
  // Functie om contentblokken op te vragen bij pagina-nummers
  function getContentByPID( $intPaginaID, $intWebsiteID ) {
 	$sql = "SELECT id, contentblokid,  titel, type, positie, bewerkbaar, zichtbaar, pid, wid FROM contentblok WHERE pid = '$intPaginaID' AND wid = '$intWebsiteID' ORDER BY positie";
  	global $dbConnectie;	
 	$arrContentBlokken  = $dbConnectie->getData($sql);
 	return $arrContentBlokken;
  }
  // Functie om contentblokken die bij een pagina horen te laten zien 
  function showContentByPID( $intPaginaID, $intWebsiteID, $objGebRechten, $intSelContentID = 0 ) {
	$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
  	$arrContentBlokken = getContentByPID( $intPaginaID, $intWebsiteID );
  	if($arrContentBlokken != false && $arrContentBlokken != null) {
  		$intArraySize = count($arrContentBlokken);
  		for($i = 0; $i < $intArraySize; $i++ ) {
	  		$objContentBlok = new ContentBlok();
  			$objContentBlok->setValues($arrContentBlokken[$i]);
  			if($objContentBlok->getTitel() == "")
  				$objContentBlok->setTitel("<i>Geen titel</i>");
  			if($intSelContentID != 0 && $intSelContentID == $objContentBlok->getContentID())
  				$objContentBlok->setTitel( "<b>".$objContentBlok->getTitel()."</b> (huidige contentblok)" );
  			echo "<tr><td class=\"formvak\"><a href=\"" . $_SERVER['PHP_SELF'] . "?cid=".$objContentBlok->getContentID()."&actie=view$strExtra\" title=\"Bekijk informatie over dit contentblok\">" . $objContentBlok->getTitel() . "</a></td>\n";
  			if($objGebRechten == "ja" || (checkContentRechten($objGebRechten, $objContentBlok->getCType()) && $objContentBlok->getBewerkbaar() == "ja")) {
	  			showInhoudMenu("cid", $objContentBlok->getContentID(), $intPaginaID, $intWebsiteID );
  				showZichtbaarKeuze("cid", $objContentBlok->getContentID(), $objContentBlok->getPaginaID() ,$objContentBlok->getZichtbaar(), $intWebsiteID);

				if($i == 0 && ($i + 1) == $intArraySize) {
					showUpAndDownMenu("cid", $objContentBlok->getContentID(), $objContentBlok->getPositie(), $objContentBlok->getPaginaID(), "beide", $intWebsiteID );
				}
	  			elseif(($i + 1) == $intArraySize) {
					showUpAndDownMenu("cid", $objContentBlok->getContentID(), $objContentBlok->getPositie(), $objContentBlok->getPaginaID(), "laatste", $intWebsiteID );  	
  				}
  				elseif($i == 0) {
	  				showUpAndDownMenu("cid", $objContentBlok->getContentID(), $objContentBlok->getPositie(), $objContentBlok->getPaginaID(), "eerste", $intWebsiteID );
  				}
  				else {
  					showUpAndDownMenu("cid", $objContentBlok->getContentID(), $objContentBlok->getPositie(), $objContentBlok->getPaginaID(), 'nvt', $intWebsiteID);
	  			}
			}
 			echo "</tr>\n";
  		}
  	}
  	else {
  		echo "<tr><td class=\"formvak\">Geen bijbehorende content aanwezig.</td></tr>";
  	}
  }
  // Functie om selectmenu te maken voor contenttypes
  function showContentTypes( $objGebRechten) {
 	echo "<select name=\"type\">\n";
  	if($objGebRechten == "ja" || $objGebRechten->getAfbeeldingRecht() == "ja")
	  	echo "<option value=\"afbeelding\">Afbeelding\n";  
  	if($objGebRechten == "ja" || $objGebRechten->getContactFormRecht() == "ja")
	  	echo "<option value=\"contactform\">Contactformulier";  	
	if($objGebRechten == "ja" || $objGebRechten->getDownloadsRecht() == "ja")
		echo "<option value=\"downloads\">Tekst met downloads (bestanden)";
  	if($objGebRechten == "ja" || $objGebRechten->getFlashRecht() == "ja")
	  	echo "<option value=\"flash\">Flash";
	if($objGebRechten == "ja" || $objGebRechten->getHTMLCodeRecht() == "ja")
	  	echo "<option value=\"html\">HTML\n";	
	if($objGebRechten == "ja" || $objGebRechten->getLinksRecht() == "ja")
	  	echo "<option value=\"links\">Links\n";	
  	if($objGebRechten == "ja" || $objGebRechten->getTekstAfbRecht() == "ja")
	  	echo "<option value=\"tekstafb\">Tekst met afbeeldingen";
  	if($objGebRechten == "ja" || $objGebRechten->getTekstRecht() == "ja")
	  	echo "<option value=\"tekst\">Tekst\n";
  	echo "</select>";
  }
  // Functie om te checken of er wel rechten voor contenttypes zijn
  function checkContentRechten( $objGebRechten, $strType = '' ) {
  	$strType = strtolower($strType);
	if($objGebRechten == false || $objGebRechten == null)
		return false;
	elseif($objGebRechten == "ja")
		return true;
  	elseif($strType == "afbeelding" && $objGebRechten->getAfbeeldingRecht() == "ja")
		return true;
  	elseif($strType == "contactform" && $objGebRechten->getContactFormRecht() == "ja")
		return true;
	elseif($strType == "download" && $objGebRechten->getDownloadsRecht() == "ja")
		return true;
  	elseif($strType == "flash" && $objGebRechten->getFlashRecht() == "ja")
		return true;
	elseif($strType == "html" && $objGebRechten->getHTMLCodeRecht() == "ja")
		return true;
	elseif($strType == "links" && $objGebRechten->getLinksRecht() == "ja")
		return true;
  	elseif($strType == "tekstafb" && $objGebRechten->getTekstAfbRecht() == "ja")
		return true;
  	elseif($strType == "tekst" && $objGebRechten->getTekstRecht() == "ja")
		return true;
  	elseif($objGebRechten->getAfbeeldingRecht() == "ja" && $strType == "")
		return true;
  	elseif($objGebRechten->getContactFormRecht() == "ja" && $strType == "")
		return true;
	elseif($objGebRechten->getDownloadsRecht() == "ja" && $strType == "")
		return true;
  	elseif($objGebRechten->getFlashRecht() == "ja" && $strType == "")
		return true;
	elseif($objGebRechten->getHTMLCodeRecht() == "ja" && $strType == "")
		return true;
	elseif($objGebRechten->getLinksRecht() == "ja" && $strType == "")
		return true;
  	elseif($objGebRechten->getTekstAfbRecht() == "ja" && $strType == "")
		return true;
  	elseif($objGebRechten->getTekstRecht() == "ja" && $strType == "")
		return true;
	else
		return false;
  }

  // Functie om formulier te maken om content toe te voegen
  function addContentForm( $intPaginaID, $intWebsiteID, $objGebRechten) {
	if(checkContentRechten($objGebRechten)) {
		$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
  		echo "<h1>Voeg contentblok toe (1/2)</h1><br>\n";
	  	echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" name=\"addContentForm\">\n";
  		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	  	echo "<tr><td class=\"tabletitle\" colspan=\"2\">Content toevoegen aan pagina</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Titel:</td><td class=\"formvak\"><input type=\"text\" name=\"titel\"></td></tr>";
		echo "<tr><td class=\"formvakb\">Type:</td><td class=\"formvak\">";
		showContentTypes($objGebRechten);
		echo "</td></tr>\n";
  		echo "<tr><td class=\"formvakb\">Uitlijning:</td><td class=\"formvak\" colspan=\"3\">";
  		showUitlijningMenu();
  		echo "</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Zichtbaar:</td><td class=\"formvak\">".getSelectMenu("zichtbaar", "ja")."</td></tr>\n";
		if($objGebRechten == "ja")
			echo "<tr><td class=\"formvakb\">Bewerkbaar:</td><td class=\"formvak\">".getSelectMenu("bewerkbaar", "nee")."</td></tr>\n";
		echo "<tr><td colspan=\"2\" class=\"buttonvak\"><input type=\"submit\" name=\"addContentKnop1\" value=\"Volgende pagina\" class=\"button\"></td></tr>";
		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=view&pid=$intPaginaID$strExtra\" class=\"linkitem\">Bekijk pagina</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
		echo "</table>\n";
  		echo "<input type=\"hidden\" name=\"pid\" value=\"$intPaginaID\">\n";
  		if($objGebRechten == "ja")
  			echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID\">";
	  	echo "</form>\n";
	}
	else {
  		echo "<h1>Voeg contentblok toe</h1><br>\n";
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Geen toegang</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Je hebt geen rechten om content toe te voegen.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
	  	echo "</table>\n";
	}
	

  }
  // Functie om formulier te maken om content toe te voegen
  function addContentForm2( $strContentType, $intContentID, $intWebsiteID, $objGebRechten ) {
  	echo "<h1>Voeg contentblok toe (2/2)</h1><br>\n";
  	echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" name=\"addContentForm\">\n";
  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
    $strtContentType = ucfirst($strContentType);
    $strFunctie = "maak".$strContentType."Form";
    $strFunctie();
	echo "<tr><td colspan=\"4\" class=\"buttonvak\"><input type=\"submit\" name=\"addContentKnop2\" value=\"Voeg contentblok toe\" class=\"button\"></td></tr>";
	echo "<tr><td class=\"tablelinks\" colspan=\"4\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Website overzicht</a></td></tr>";
	echo "</table>\n";  	    
  	echo "<input type=\"hidden\" name=\"cid\" value=\"$intContentID\">\n"; 
  	echo "<input type=\"hidden\" name=\"type\" value=\"$strContentType\">\n";
  	if($objGebRechten == "ja")
  		echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID\">\n";
  	echo "</form>\n";
  }
  // Functie om formulier te maken om afbeelding toe te voegen/bewerken
  function maakAfbeeldingForm( $objContentBlok = '') {
  	if($objContentBlok == '')
  		$objContentBlok = new afbeeldingContentBlok();
  	echo "<tr><td class=\"tabletitle\" colspan=\"4\">Contenttype: Afbeelding</td></tr>\n";
	echo "<tr><td class=\"formvakb\">Kies afbeelding:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"url\" value=\"".$objContentBlok->getURL()."\"><input type=\"button\" name=\"viewBestandenKnop\" value=\"Zoek bestand uit\" class=\"button\"></td></tr>\n";
	echo "<tr><td class=\"formvakb\">Breedte:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"breedte\" size=\"3\" maxlength=\"4\" value=\"".$objContentBlok->getWidth()."\"> pixels</td></tr>\n";
	echo "<tr><td class=\"formvakb\">Hoogte:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"hoogte\" size=\"3\" maxlength=\"4\" value=\"".$objContentBlok->getHeight()."\"> pixels</td></tr>\n";
	echo "<tr><td class=\"formvakb\">Border:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"border\" size=\"3\" maxlength=\"2\" value=\"".$objContentBlok->getBorder()."\"> pixels</td></tr>\n";
	echo "<tr><td class=\"formvakb\">Alt-tekst:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"alt\" value=\"".$objContentBlok->getAlt()."\"></td></tr>\n";
  }  
  // Functie om formulier te maken om downloads toe te voegen/bewerken
  function maakContactformForm( $objContentBlok = '' ) {
  	if($objContentBlok == '') 
  		$objContentBlok = new contactformContentBlok();
  	echo "<tr><td class=\"tabletitle\" colspan=\"4\">Contenttype: Contactformulier</td></tr>\n";
	echo "<tr><td class=\"formvakb\">E-mailadres:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"mailadres\" value=\"".$objContentBlok->getMailAdres()."\"></td></tr>\n";
	echo "<tr><td class=\"formvakb\">Vraag om adres:</td><td class=\"formvak\" colspan=\"3\"><input type=\"checkbox\" name=\"adresoptie\" value=\"ja\" ".checkedValue($objContentBlok->getAdresOptie())."></td></tr>\n";
	echo "<tr><td class=\"formvakb\">Vraag om telefoonnummer:</td><td class=\"formvak\" colspan=\"3\"><input type=\"checkbox\" name=\"teloptie\" value=\"ja\" ".checkedValue($objContentBlok->getTelOptie())."></td></tr>\n";
	echo "<tr><td class=\"formvakb\">Taal:</td><td class=\"formvak\" colspan=\"3\">";
	echo showTaalMenu($objContentBlok->getTaal());
	echo "</td></tr>\n";
	echo "<tr><td class=\"formvakb\">Tekst voor als het bericht verstuurd is:</td><td class=\"formvak\" colspan=\"3\"><textarea name=\"welverstuurd\" cols=50 rows=10>".fixData( $objContentBlok->getVerstuurdBericht(), "tekstvak")."</textarea></td></tr>\n";
	echo "<tr><td class=\"formvakb\">Tekst voor als het bericht niet verstuurd is:</td><td class=\"formvak\" colspan=\"3\"><textarea name=\"nietverstuurd\" cols=50 rows=10>".fixData( $objContentBlok->getNietVerstuurdBericht(), "tekstvak")."</textarea></td></tr>\n";
	echo "<tr><td class=\"formvakb\">Lettertype:</td><td class=\"formvak\" colspan=\"3\">";
	showLetterTypeMenu( "lettertype", $objContentBlok->getLetterType());
	echo "</td></tr>";
	echo "<tr><td class=\"formvakb\">Lettergrootte:</td><td class=\"formvak\" colspan=\"3\">";
	showLetterGrootteMenu( "lettergrootte", $objContentBlok->getLetterGrootte());
	echo "</td></tr>";
  }  
  // Functie om formulier om downloads toe te voegen te maken/bewerken
  function maakDownloadsForm( $objContentBlok = '') {
  	if($objContentBlok == '')
  		$objContentBlok = new linksContentBlok(); 
  	echo "<tr><td class=\"tabletitle\" colspan=\"4\">Contacttype: Downloads</td></tr>\n";
//	echo "<tr><td class=\"formvakb\">Kies download:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"alias\" value=\"".$objContentBlok->getURL()."\"><input type=\"button\" name=\"viewBestandenKnop\" value=\"Zoek bestand uit\"></td></tr>\n";
	echo "<tr><td class=\"formvakb\">URL download:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"alias\" value=\"".$objContentBlok->getURL()."\"></td></tr>\n";
	echo "<tr><td class=\"formvakb\">Naam download:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"naam\"  value=\"".$objContentBlok->getNaam()."\"></td></tr>\n";	
	echo "<tr><td class=\"formvakb\">Omschrijving:</td><td class=\"formvak\" colspan=\"3\">";
	echo "<textarea name=\"omschrijving\">".fixData($objContentBlok->getOmschrijving(), "tekstvak")."</textarea>";
	echo "</td></tr>\n";  
  }
  // Functie om formulier te maken om flashcontent toe te voegen/bewerken
  function maakFlashForm( $objContentBlok = '') {
  	if($objContentBlok == '')
  		$objContentBlok = new flashContentBlok();
  	echo "<tr><td class=\"tabletitle\" colspan=\"4\">Contenttype: Flash</td></tr>\n";
//	echo "<tr><td class=\"formvakb\">Flashbestand:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"flashurl\" value=\"".$objContentBlok->getFlashURL()."\"><input type=\"button\" name=\"viewBestandenKnop\" value=\"Zoek bestand uit\"></td></tr>\n";
	echo "<tr><td class=\"formvakb\">Flashbestand:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"flashurl\" value=\"".$objContentBlok->getFlashURL()."\"></td></tr>\n";
	echo "<tr><td class=\"formvakb\">Breedte:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"breedte\" size=\"3\" maxlength=\"4\" value=\"".$objContentBlok->getWidth()."\"> pixels</td></tr>\n";
	echo "<tr><td class=\"formvakb\">Hoogte:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"hoogte\" size=\"3\" maxlength=\"4\" value=\"".$objContentBlok->getHeight()."\"> pixels</td></tr>\n";
	echo "<tr><td class=\"formvakb\">Kwaliteit:</td><td class=\"formvak\" colspan=\"3\">";
	showKwaliteitMenu( "kwaliteit", $objContentBlok->getKwaliteit() );
	echo "</td></tr>\n";
	echo "<tr><td class=\"formvakb\">Loop:</td><td class=\"formvak\" colspan=\"3\"><input type=\"checkbox\" name=\"loop\" value=\"ja\" ".checkedValue($objContentBlok->getLoop())."></td></tr>\n";
	echo "<tr><td class=\"formvakb\">Automastisch afspelen:</td><td class=\"formvak\" colspan=\"3\"><input type=\"checkbox\" name=\"autoplay\" value=\"ja\" ".checkedValue($objContentBlok->getAutoPlay())."></td></tr>\n";	
	echo "<tr><td class=\"formvakb\">Achtergrondkleur:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"achtergrondkleur\" value=\"".$objContentBlok->getAchtergrondKleur()."\"></td></tr>\n";
  }  
  // Functie om formulier te maken om html toe te voegen/bewerken
  function maakHtmlForm( $objContentBlok = '') {
  	if($objContentBlok == '')
  		$objContentBlok = new htmlContentBlok();
  	echo "<tr><td class=\"tabletitle\" colspan=\"4\">Contenttype: HTML</td></tr>\n";
	echo "<tr><td class=\"formvakb\" colspan=\"4\">Voer hieronder de HTML-code in:</td></tr>\n";
	echo "<tr><td class=\"formvak\" colspan=\"4\"><textarea name=\"html\" cols=60 rows=10>".$objContentBlok->getHTMLcode()."</textarea></td></tr>\n";
	echo "</td></tr>\n";
  }
  // Functie om formulier om links toe te voegen te maken/bewerken
  function maakLinksForm( $objContentBlok = '') {
  	if($objContentBlok == '')
  		$objContentBlok = new linksContentBlok(); 
  	echo "<tr><td class=\"tabletitle\" colspan=\"4\">Contacttype: Links</td></tr>\n";
	echo "<tr><td class=\"formvakb\">URL link:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"url\" value=\"".$objContentBlok->getURL()."\"></td></tr>\n";
	echo "<tr><td class=\"formvakb\">Naam link:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"naam\"  value=\"".$objContentBlok->getNaam()."\"></td></tr>\n";	
	echo "<tr><td class=\"formvakb\">Omschrijving:</td><td class=\"formvak\" colspan=\"3\">";
	echo "<textarea name=\"omschrijving\">".fixData($objContentBlok->getOmschrijving(), "tekstvak")."</textarea>";
	echo "</td></tr>\n";  
  }
  // Functie om formulier te maken om tekst en afb. toe te voegen/bewerken
  function maakTekstafbForm( $objContentBlok = '') {
   	if($objContentBlok == '')
  		$objContentBlok = new tekstafbContentBlok();

  	echo "<tr><td class=\"tabletitle\" colspan=\"4\">Contenttype: Tekst met afbeelding</td></tr>\n";
	echo "<tr><td class=\"formvakb\" colspan=\"4\">Tekst:</td></tr>\n";
	echo "<tr><td class=\"formvak\" colspan=\"4\"><textarea name=\"tekst\" rows=6 cols=60>".fixData($objContentBlok->getTekst(), "tekstvak")."</textarea></td></tr>\n";
	echo "<tr><td class=\"formvakb\">Lettertype:</td><td class=\"formvak\" colspan=\"3\">";
	showLetterTypeMenu( "lettertype", $objContentBlok->getLetterType());
	echo "</td></tr>";
	echo "<tr><td class=\"formvakb\">Grootte:</td><td class=\"formvak\" colspan=\"3\">";
	showLetterGrootteMenu( "lettergrootte", $objContentBlok->getLetterGrootte());
	echo "</td></tr>\n";
//	echo "<tr><td class=\"formvakb\">Kies afbeelding:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"afburl\" value=\"".$objContentBlok->getURL()."\"><input type=\"button\" name=\"viewBestandenKnop\" value=\"Zoek bestand uit\"></td></tr>\n";
	echo "<tr><td class=\"formvakb\">URL afbeelding:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"afburl\" value=\"".$objContentBlok->getURL()."\"></td></tr>\n";
	echo "<tr><td class=\"formvakb\">Breedte:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"afbbreedte\" size=\"3\" maxlength=\"4\" value=\"".$objContentBlok->getAfbWidth()."\"> pixels</td></tr>\n";
	echo "<tr><td class=\"formvakb\">Hoogte:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"afbhoogte\" size=\"3\" maxlength=\"4\" value=\"".$objContentBlok->getAfbHeight()."\"> pixels</td></tr>\n";
	echo "<tr><td class=\"formvakb\">Border:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"afbborder\" size=\"3\" maxlength=\"2\" value=\"".$objContentBlok->getAfbBorder()."\"> pixels</td></tr>\n";
	echo "<tr><td class=\"formvakb\">Alt-tekst:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"afbalt\" value=\"".$objContentBlok->getAfbAlt()."\"></td></tr>\n";
	echo "<tr><td colspan=\"4\" class=\"formvakb\">Indeling:</td></tr>\n";
	echo "<tr><td colspan=\"4\">";
	showFiguurKeuzeMenu( $objContentBlok->getKeuze() );
	echo "</td></tr>";
  }  
  // Functie om formulier te maken om tekstcontent toe te voegen/bewerken 
  function maakTekstForm( $objContentBlok = '') {
  	if($objContentBlok == '')
  		$objContentBlok = new tekstContentBlok();
  	echo "<tr><td class=\"tabletitle\" colspan=\"4\">Contenttype: Tekst</td></tr>\n";
	echo "<tr><td class=\"formvakb\" colspan=\"4\">Voer hieronder de tekst in:</td></tr>\n";
	echo "<tr><td class=\"formvak\" colspan=\"4\"><textarea name=\"tekst\" rows=10 cols=60>".fixData($objContentBlok->getTekst(), "tekstvak")."</textarea>";
	echo "</td></tr>\n";
	echo "<tr><td class=\"formvakb\" colspan=\"2\">Lettertype:</td><td class=\"formvak\" colspan=\"2\">";
	showLetterTypeMenu( "lettertype", $objContentBlok->getLetterType());
	echo " pixels</td></tr>";
	echo "<tr><td class=\"formvakb\" colspan=\"2\">Lettergrootte:</td><td class=\"formvak\" colspan=\"2\">";
	showLetterGrootteMenu( "lettergrootte", $objContentBlok->getLetterGrootte());
	echo " pixels</td></tr>";
  }  
  
  // Functie om formulier te maken om content toe te voegen
  function editContentBlokForm( $intContentID, $intWebsiteID, $objGebRechten ) {
    $strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
    $strType = getContentType( $intContentID, $intWebsiteID);
    $strType = ucfirst($strType);
	$strFunctie = "get".$strType."ContentBlok";
	if($strFunctie == "getDownloadsContentBlok")
			$strFunctie = "getLinksContentBlok";	
	$objContentBlok = $strFunctie( $intContentID, $intWebsiteID );
   	echo "<h1>Bewerk contentblokinformatie</h1><br>\n";
	if($objContentBlok == false || $objContentBlok == null) {
 		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";    	
  		echo "<tr><td class=\"tabletitle\">Contentblok niet gevonden</td></tr>\n";
		echo "<tr><td class=\"formvak\">Het contentblok met id-nummer '$intContentID' is niet gevonden.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
		echo "</table>\n";
    }
    elseif(($objGebRechten != "ja" && (!checkContentRechten($objGebRechten, $strType) || $objContentBlok->getBewerkbaar() == "nee"))) {
 		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";    	
  		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Geen toegang</td></tr>\n";
		echo "<tr><td colspan=\"3\" class=\"formvak\">Je hebt geen rechten om de contentblokken te bewerken.</td></tr>\n";
  		echo "<tr><td colspan=\"2\" class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=view&pid=".$objContentBlok->getPaginaID()."\" class=\"linkitem\">Bekijk pagina</a></td><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Overzicht website</a></td></tr>";
		echo "</table>\n";
    }
    else {
		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" name=\"editContentForm\">\n";
 		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Contentblok bewerken: ".$objContentBlok->getTitel()."</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Titel:</td><td colspan=\"3\" class=\"formvak\"><input type=\"text\" name=\"titel\" value=\"".fixData($objContentBlok->getTitel())."\"></td></tr>\n";
  		echo "<tr><td class=\"formvakb\">Uitlijning:</td><td class=\"formvak\" colspan=\"3\">";
  		showUitlijningMenu($objContentBlok->getUitlijning());
  		echo "</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Zichtbaar:</td><td colspan=\"3\" class=\"formvak\">".getSelectMenu( "zichtbaar", $objContentBlok->getZichtbaar())."</td></tr>\n";
		if($objGebRechten == "ja")
			echo "<tr><td class=\"formvakb\">Bewerkbaar:</td><td class=\"formvak\">".getSelectMenu( "bewerkbaar", $objContentBlok->getBewerkbaar())."</td></tr>\n";
		$strMaakFunctie = "maak".$strType."Form";
		$strMaakFunctie( $objContentBlok );
  		echo "<tr><td colspan=\"4\" class=\"buttonvak\"><input type=\"submit\" name=\"editContentBlokKnop\" value=\"Bewerk gegevens\" class=\"button\"></td></tr>";
		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?cid=$intContentID&actie=view$strExtra\" class=\"linkitem\">Bekijk contentblok</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?cid=$intContentID&actie=del&pagid=".$objContentBlok->getPaginaID()."$strExtra\" class=\"linkitem\">Verwijder contentblok</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?pid=".$objContentBlok->getPaginaID()."&actie=view$strExtra\" class=\"linkitem\">Bekijk pagina</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
		echo "</table>\n";
	  	echo "<input type=\"hidden\" name=\"cid\" value=\"$intContentID\">\n";
	  	echo "<input type=\"hidden\" name=\"type\" value=\"".$objContentBlok->getCType()."\">\n";
		if($objGebRechten == "ja")
		  	echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID\">\n";
	  	echo "</form>\n";
    }

    
    
  }
  // Functie om formulier te maken om een contentblok te verwijderen
  function delContentBlokForm( $intContentID, $intPaginaID, $intWebsiteID, $objGebRechten ) {
	$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
	$objContentBlok = getContentBlok( $intContentID, $intWebsiteID );
  	echo "<h1>Contentblok verwijderen</h1><br>\n";
  	if($objContentBlok == false || $objContentBlok == null) {
 		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";    	
  		echo "<tr><td class=\"tabletitle\">Contentblok niet gevonden</td></tr>\n";
		echo "<tr><td class=\"formvak\">Het contentblok met id-nummer '$intContentID' is niet gevonden.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
		echo "</table>\n";
  	}
  	else {
		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" name=\"delContentBlokForm\">\n";
		echo "<input type=\"hidden\" name=\"cid\" value=\"$intContentID\">\n";
		echo "<input type=\"hidden\" name=\"pagid\" value=\"$intPaginaID\">\n";	
		if($objGebRechten == "ja")
			echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID	\">\n";	
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Contentblok verwijderen</td></tr>\n";
		echo "<tr><td colspan=\"4\" class=\"formvak\">Hieronder wordt om een bevestiging gevraagd om het contentblok met id-nummer '$intContentID' te verwijderen.</td></tr>\n";
		echo "<tr><td class=\"buttonvak\" colspan=\"2\"><input type=\"reset\" name=\"cancelDelContentBlokKnop\" value=\"Nee, contentblok niet verwijderen\" onclick=\"history.back()\" class=\"button\"></td><td class=\"buttonvak\" colspan=\"2\">\n";
		echo "<input type=\"submit\" name=\"delContentBlokKnop\" value=\"Ja, contentblok verwijderen\" class=\"button\">\n<br><br>\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?cid=$intContentID&actie=view$strExtra\"\" class=\"linkitem\">Bekijk contentblok</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?cid=$intContentID&actie=edit$strExtra\"\" class=\"linkitem\">Bewerk contentblok</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?pid=$intPaginaID&actie=view$strExtra\"\" class=\"linkitem\">Bekijk pagina</a></td>\n"; 
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
			if($objGebRechten == "ja")
		  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
		echo "</table>\n";	
		echo "</form>\n";
	}
  }
  // Functie om de naam van contenttype om te zetten tot een nettere naam
  function changeContentType( $strSelected ) {
  	$arrTypes['afbeelding'] = "Afbeelding";
  	$arrTypes['contactform'] = "Contactformulier";
  	$arrTypes['download'] = "Downloads";
  	$arrTypes['flash'] = "Flashbestand";
  	$arrTypes['html'] = "HTML";
  	$arrTypes['links'] = "Links";
  	$arrTypes['tekst'] = "Tekst";
  	$arrTypes['tekstafb'] = "Tekst met afbeelding";
	while (list($strKey, $strVal) = each($arrTypes)) {
   		if($strSelected == $strKey)
   			return $strVal;
	}
  }
?>