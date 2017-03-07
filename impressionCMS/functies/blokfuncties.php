<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: blokfuncties.php
 * Beschrijving: De functies mbt blokken
 */

	// Functie om een blok in te voeren 
	function insertBlok( Blok $objBlok) {
	 	$sql = "INSERT INTO blok (blokid, positie, zichtbaar, bewerkbaar, titel, datum, begindatum, einddatum, ";
	 	$sql .= " subtype, uitlijning, breedte, hoogte, border, bordercolor, bordertype, backgroundcolor, intro, pid, wid )";
	 	$sql .= " VALUES ('".$objBlok->getBlokID()."', '".$objBlok->getPositie()."', ";
	 	$sql .= " '".$objBlok->getZichtbaar()."', '".$objBlok->getBewerkbaar()."','".$objBlok->getTitel()."', ";
	 	$sql .= "'".$objBlok->getDatum()."', '".$objBlok->getBeginDatum()."', '".$objBlok->getEindDatum()."',";
	 	$sql .= " '".$objBlok->getSubType()."', '".$objBlok->getUitlijning()."', '".$objBlok->getBreedte()."', ";
	 	$sql .= " '".$objBlok->getHoogte()."', '".$objBlok->getBorder()."', '".$objBlok->getBorderKleur()."', ";
	 	$sql .= " '".$objBlok->getBorderType()."', '".$objBlok->getAchtergrondKleur()."', '".$objBlok->getIntro()."', ";
	 	$sql .= " '".$objBlok->getPaginaID()."', '".$objBlok->getWebsiteID()."')";
	 	global $dbConnectie;
	 	return $dbConnectie->setData($sql);
	}
	// Functie om een afbeeldingblok in te voeren
	function insertAfbeeldingBlok( afbeeldingBlok $objBlok) {
	 	$sql = "INSERT INTO afbeeldingblok (afburl, afbwidth, afbheight, afbborder, alt, bestandid, blokid, wid) VALUES ('";
	 	$sql .= $objBlok->getURL()."', '".$objBlok->getAfbWidth()."', '".$objBlok->getAfbHeight()."', '".$objBlok->getAfbBorder()."', ";
	 	$sql .= " '".$objBlok->getAlt()."', '".$objBlok->getBestandID()."','".$objBlok->getBlokID()."', '".$objBlok->getWebsiteID()."')";
	 	global $dbConnectie;    
	   return $dbConnectie->setData($sql);
	}    
  	// Functie om een contactformblok in te voeren
	function insertContactFormBlok( contactformBlok $objBlok) {
	 	$sql = "INSERT INTO contactformBlok (mailadres, adresoptie, teloptie, taal, verstuurd, nietverstuurd, lettertype, ";
	 	$sql .= "lettergrootte, blokid, wid) VALUES ('".$objBlok->getMailAdres()."', '".$objBlok->getAdresOptie()."',";
	 	$sql .= " '".$objBlok->getTelOptie()."', '".$objBlok->getTaal()."', '".$objBlok->getVerstuurdBericht()."', ";
	 	$sql .= " '".$objBlok->getNietVerstuurdBericht()."', '".$objBlok->getLetterType()."', '".$objBlok->getLetterGrootte()."', ";
	 	$sql .= "'".$objBlok->getBlokID()."', '".$objBlok->getWebsiteID()."') ";
	 	global $dbConnectie;    
	   return $dbConnectie->setData($sql);
	} 
	// Functie om een flashblok in te voeren
	function insertFlashBlok( flashBlok $objBlok) {
	 	$sql = "INSERT INTO flashblok (flashurl, flswidth, flsheight, loop, kwaliteit, autoplay, achtergrond, bestandid, blokid, wid ) VALUES";
	 	$sql .= "  ('".$objBlok->getFlashURL()."', '".$objBlok->getFlsWidth()."', '".$objBlok->getFlsHeight()."', ";
	 	$sql .= " '".$objBlok->getLoop()."', '".$objBlok->getKwaliteit()."', '".$objBlok->getAutoPlay()."',";
	 	$sql .= " '".$objBlok->getAchtergrondKleur()."', '".$objBlok->getBestandID()."', '".$objBlok->getBlokID()."', '".$objBlok->getWebsiteID()."')";
	 	global $dbConnectie;    
	   return $dbConnectie->setData($sql);
	}
	// Functie om een tekstblok in te voeren
	function insertHtmlBlok( htmlBlok $objBlok) {
	 	$sql = "INSERT INTO htmlblok (htmlcode, blokid, wid ) VALUES ( '".$objBlok->getHTMLCode()."', ";
	 	$sql .= "'".$objBlok->getBlokID()."', '".$objBlok->getWebsiteID()."')";
	 	global $dbConnectie;    
	   return $dbConnectie->setData($sql);
	}    
	// Functie om een linksblok in te voeren
	function insertLinksBlok( linksBlok $objBlok) {
	 	$sql = "INSERT INTO linksblok (url, naam, bestandid, blokid, wid ) VALUES ( '".$objBlok->getURL()."',";
	 	$sql .= " '".$objBlok->getNaam()."', '".$objBlok->getBestandID()."','".$objBlok->getBlokID()."', '".$objBlok->getWebsiteID()."')";
		global $dbConnectie;    
		return $dbConnectie->setData($sql);
	}
	// Functie om een tekstafbeelding-blok in te voeren
	function insertTekstAfbBlok( tekstafbBlok $objBlok) {
		$sql = "INSERT INTO tekstafbBlok  (tekst, lettertype, lettergrootte, letterkleur, afburl, afbwidth, afbheight, ";
		$sql .= " afbborder, alt,  keuze, bestandid, blokid, wid ) VALUES ('".$objBlok->getTekst()."', '".$objBlok->getLetterType()."',";
		$sql .= " '".$objBlok->getLetterGrootte()."', '".$objBlok->getLetterKleur()."', '".$objBlok->getURL()."', ";
		$sql .= " '".$objBlok->getAfbWidth()."','".$objBlok->getAfbHeight()."', '".$objBlok->getAfbBorder()."', ";
		$sql .= " '".$objBlok->getAfbAlt()."','".$objBlok->getKeuze()."', '".$objBlok->getBestandID()."', ";
		$sql .= " '".$objBlok->getBlokID()."','".$objBlok->getWebsiteID()."')";
		global $dbConnectie;    
		return $dbConnectie->setData($sql);
	}  
	// Functie om een tekstblok in te voeren
	function insertTekstBlok( tekstBlok $objBlok) {
		$sql = "INSERT INTO tekstBlok (tekst, lettertype, lettergrootte, letterkleur, blokid, wid ) VALUES ( ";
		$sql .= "'".$objBlok->getTekst()."',  '".$objBlok->getLetterType()."', '".$objBlok->getLetterGrootte()."',";
		$sql .= " '".$objBlok->getLetterKleur()."', '".$objBlok->getBlokID()."', '".$objBlok->getWebsiteID()."')";
		global $dbConnectie;    
		return $dbConnectie->setData($sql);
	}  
	// Functie om een blok bij te werken
	function updateBlok( Blok $objBlok ) {
		$strType = getGoedeSubType( $objBlok->getSubType() );
  	
	 	if($strType == "afbeelding") {
			$extraSQL = ", sb.afburl = '".$objBlok->getURL()."', sb.afbwidth = '".$objBlok->getAfbWidth()."', ";
			$extraSQL .= " sb.afbheight = '".$objBlok->getAfbHeight()."', sb.afbborder = '".$objBlok->getAfbBorder()."', ";
  			$extraSQL .= " sb.alt = '".$objBlok->getAlt()."', sb.bestandid = '".$objBlok->getBestandID()."' ";
		}
  		elseif($strType == "contactform" ) {
  			$extraSQL = ", sb.mailadres = '".$objBlok->getMailAdres()."', sb.adresoptie = '".$objBlok->getAdresOptie()."', ";
  			$extraSQL .= " sb.teloptie = '".$objBlok->getTelOptie()."', sb.verstuurd = '".$objBlok->getVerstuurdBericht()."', ";
	  		$extraSQL .= " sb.nietverstuurd = '".$objBlok->getNietVerstuurdBericht()."', sb.taal = '".$objBlok->getTaal()."', ";
  			$extraSQL .= " sb.lettertype = '".$objBlok->getLetterType()."', sb.lettergrootte = '".$objBlok->getLetterGrootte()."' ";
	  	}
  		elseif($strType == "flash" ) {
  			$extraSQL = ", sb.flashurl = '".$objBlok->getFlashURL()."', sb.flswidth = '".$objBlok->getFlsWidth()."', ";
  			$extraSQL .= " sb.flsheight = '".$objBlok->getFlsHeight()."', sb.kwaliteit = '".$objBlok->getKwaliteit()."', ";
  			$extraSQL .= " sb.loop = '".$objBlok->getLoop()."', sb.autoplay = '".$objBlok->getAutoPlay()."', ";
  			$extraSQL .= " sb.achtergrond = '".$objBlok->getAchtergrondKleur()."',sb.bestandid = '".$objBlok->getBestandID()."' ";
  		}
  		elseif($strType == "html" ) {
  			$extraSQL = ", sb.htmlcode = '".$objBlok->getHTMLcode()."'";
  		}
  		elseif($strType == "links" ) {
  			$extraSQL = ", sb.url = '".$objBlok->getURL()."', sb.naam = '".$objBlok->getNaam()."',sb.bestandid = '".$objBlok->getBestandID()."' ";
  		}
  		elseif($strType == "tekstafb" ) {
  			$extraSQL = ", sb.tekst = '".$objBlok->getTekst()."', sb.lettertype = '".$objBlok->getLetterType()."', ";
  			$extraSQL .= " sb.lettergrootte = '".$objBlok->getLetterGrootte()."', sb.afburl = '".$objBlok->getURL()."', ";
  			$extraSQL .= " sb.afbwidth = '".$objBlok->getAfbWidth()."', sb.afbheight = '".$objBlok->getAfbHeight()."', ";
  			$extraSQL .= " sb.afbborder = '".$objBlok->getAfbBorder()."', sb.alt = '".$objBlok->getAfbAlt()."', ";
  			$extraSQL .= " sb.keuze = '".$objBlok->getKeuze()."', sb.bestandid = '".$objBlok->getBestandID()."', ";
  			$extraSQL .= " sb.letterkleur = '".$objBlok->getLetterKleur()."' ";
  		}
  		elseif($strType == "tekst" ) {
  			$extraSQL = ", sb.tekst = '".$objBlok->getTekst()."', sb.lettertype = '".$objBlok->getLetterType()."', ";
  			$extraSQL .= " sb.lettergrootte = '".$objBlok->getLetterGrootte()."', sb.letterkleur = '".$objBlok->getLetterKleur()."' ";
  		}
  	
 		$sql = "UPDATE blok AS b, ".$strType."Blok AS sb SET b.titel = '".$objBlok->getTitel()."', ";
 		$sql .= "b.zichtbaar = '".$objBlok->getZichtbaar()."', b.bewerkbaar = '".$objBlok->getBewerkbaar()."', ";
 		$sql .= " b.begindatum = '".$objBlok->getBeginDatum()."', b.einddatum = '".$objBlok->getEindDatum()."', ";
 		$sql .= " b.uitlijning = '".$objBlok->getUitlijning()."', b.breedte = '".$objBlok->getBreedte()."', ";
 		$sql .= " b.hoogte = '".$objBlok->getHoogte()."', b.border = '".$objBlok->getBorder()."', ";
 		$sql .= " b.bordercolor = '".$objBlok->getBorderKleur()."', b.bordertype = '".$objBlok->getBorderType()."', ";
 		$sql .= " b.backgroundcolor = '".$objBlok->getAchtergrondKleur()."', b.intro = '".$objBlok->getIntro()."' ";
 		$sql .= " ".$extraSQL." ";
 		$sql .= " WHERE b.blokid = '".$objBlok->getBlokID()."'";
 		$sql .= " AND sb.blokid = '".$objBlok->getBlokID()."' AND b.wid = '".$objBlok->getWebsiteID()."'";
 		global $dbConnectie;    
   	return $dbConnectie->setData($sql);
	}
	// Functie om Blok te moven
	function moveBlok( $intPositieNr, $intPaginaID, $intBlokID, $intWebsiteID, $strVerplaatsing ) {
		$sql = "UPDATE blok SET ";
		if($strVerplaatsing == "up") {
			$sql1 = $sql . " positie = (positie + 1) WHERE positie = ($intPositieNr-1)";
			$sql .= " positie = (positie - 1) ";
		}
		elseif($strVerplaatsing == "down") {
			$sql1 = $sql . " positie = (positie - 1) WHERE positie = ($intPositieNr+1)";
			$sql .= " positie = (positie + 1) ";
		}
		$sql .= " WHERE positie = '$intPositieNr' AND pid = '$intPaginaID' AND wid = '$intWebsiteID' AND blokid = '$intBlokID'";
		$sql1 .= " AND pid = '$intPaginaID' AND wid = '$intWebsiteID' AND blokid != '$intBlokID'";
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
	// Functie om Blok van zichtbaarheid te veranderen
	function changeBlokVisibility( $intBlokID, $intWebsiteID, $strVisibility ) {
		$objBlok = getBlok($intBlokID, $intWebsiteID);
		if($objBlok != false && $objBlok != null) {
			$sql = "UPDATE blok SET zichtbaar = '$strVisibility'";
			$sql .= " WHERE blokid = '$intBlokID' AND wid = '$intWebsiteID'";
			global $dbConnectie;    
			return $dbConnectie->setData($sql);
		}
		else return false;
	}  
	// Functie om Blok te verwijderen
	function deleteBlok( $intBlokID, $intWebsiteID ) {
		$objBlok = getBlok( $intBlokID, $intWebsiteID);
		if($objBlok != null && $objBlok != false) {
			veranderBlokkenPositie( $intBlokID, $objBlok->getPaginaID(), $objBlok->getPositie(), $intWebsiteID);
			$strType = getGoedeSubType( $objBlok->getSubType() );
  		
			$sql0 = "DELETE FROM ".$strType."Blok WHERE blokid = '$intBlokID' AND wid = '$intWebsiteID'";
			$sql = "DELETE FROM blok WHERE blokid = '$intBlokID' AND wid = '$intWebsiteID'";
			global $dbConnectie;
			if(!$dbConnectie->setData($sql0)) {
				return false;	  		
			}
			elseif(!$dbConnectie->setData($sql)) {
				return false;
			}
			else return true;
		}
  		else return false;
	}
	// Functie om Blok te checken
	function checkBlok( $intBlokID, $intWebsiteID, $intPaginaID ) {
		$sql = "SELECT blokid FROM blok WHERE blokid = '$intBlokID' AND wid = '$intWebsiteID' AND pid = '$intPaginaID'";	
		global $dbConnectie;	
		$arrBlokken  = $dbConnectie->getData($sql);
		if($arrBlokken != false && $arrBlokken != null) return true;
 		else return false;
	}
	// Functie om de juiste subtype terug te geven 
	function getGoedeSubType( $strSubType ) {
		if($strSubType == "downloads")
			return "links";
		elseif($strSubType == "wysiwyg")
			return "html";
		else return $strSubType;
	}
	// Functie om de positie te veranderen als er nog Blokken zijn met een hogere positie
	// Deze functie wordt aangeroepen voordat een andere Blok is verwijderd
	// Dit zodat de volgorde blijft kloppen
	function veranderBlokkenPositie( $intBlokID, $intPaginaID, $intPositie, $intWebsiteID ) {
		$sql = "SELECT blokid FROM blok WHERE pid = (SELECT pid FROM blok WHERE blokid = '$intBlokID' AND wid = '$intWebsiteID') ";
		$sql .= " AND positie > (SELECT positie FROM blok WHERE blokid = '$intBlokID' AND wid = '$intWebsiteID') AND wid = '$intWebsiteID'";
		global $dbConnectie;
		$arrBlokken = $dbConnectie->getData($sql);
		if($arrBlokken != null && $arrBlokken != false) {
			$sql2 = "UPDATE blok SET positie = positie - 1 WHERE pid = '$intPaginaID' AND positie > '$intPositie' ";
			$sql2 .= " AND wid = '$intWebsiteID'";
			return $dbConnectie->setData($sql2);
		}
	}
	// Functie om paginatype op te vragen
	function getSubType( $intBlokID, $intWebsiteID ) {
		$sql = "SELECT subtype FROM blok WHERE wid = '$intWebsiteID' AND blokid = '$intBlokID'";
		global $dbConnectie;
		$arrBlokken = $dbConnectie->getData($sql);
		if($arrBlokken != false && $arrBlokken != null) {
			$objBlok = new Blok();
			$objBlok->setValues($arrBlokken[0]);
			return $objBlok->getSubType();
		}
 		else return false;	
	}  
	// Functie om Blok op te vragen
	function getBlok( $intBlokID, $intWebsiteID ) {
		$sql = "SELECT * FROM blok WHERE blokid = '$intBlokID' AND wid = '$intWebsiteID'";
		global $dbConnectie;	
		$arrBlokken  = $dbConnectie->getData($sql);
		if($arrBlokken != false && $arrBlokken != null) {
			$objBlok = new Blok();
			$objBlok->setValues($arrBlokken[0]);
			return $objBlok;
		}
		else {
			return false;
		}
	}
	// Functie om Blok van type afbeelding op te vragen
	function getAfbeeldingBlok( $intBlokID, $intWebsiteID ) {
		$sql = "SELECT * FROM blok AS b, afbeeldingBlok AS ab WHERE b.blokid = '$intBlokID' AND ab.blokid = '$intBlokID' ";
		$sql .= " AND b.wid = '$intWebsiteID' AND ab.wid = '$intWebsiteID'";
		global $dbConnectie;	
		$arrBlokken  = $dbConnectie->getData($sql);
		if($arrBlokken != false && $arrBlokken != null) {
			$objBlok = new afbeeldingBlok();
			$objBlok->setValues($arrBlokken[0]);
			return $objBlok;
		}
		else return false;
	}
	// Functie om Blok van type contactform op te vragen
	function getContactformBlok( $intBlokID, $intWebsiteID ) {
		$sql = "SELECT *FROM blok AS b, contactformBlok AS cb WHERE b.blokid = '$intBlokID' ";
		$sql .= "  AND b.blokid = '$intBlokID' AND b.wid = '$intWebsiteID' AND b.wid = '$intWebsiteID'";
		global $dbConnectie;	
		$arrBlokken  = $dbConnectie->getData($sql);
		if($arrBlokken != false && $arrBlokken != null) {
			$objBlok = new contactformBlok();
			$objBlok->setValues($arrBlokken[0]);
			return $objBlok;
		}
		else return false;
	} 
	// Functie om Blok van type html op te vragen
	function getFlashBlok( $intBlokID, $intWebsiteID ) {
		$sql = "SELECT * FROM blok AS b, flashBlok AS fb WHERE b.blokid = '$intBlokID' ";	
		$sql .= " AND fb.blokid = '$intBlokID' AND b.wid = '$intWebsiteID' AND fb.wid = '$intWebsiteID'";
		global $dbConnectie;	
		$arrBlokken  = $dbConnectie->getData($sql);
		if($arrBlokken != false && $arrBlokken != null) {
			$objBlok = new flashBlok();
			$objBlok->setValues($arrBlokken[0]);
			return $objBlok;
		}
		else return false;
	}    
	// Functie om Blok van type html op te vragen
	function getHtmlBlok( $intBlokID, $intWebsiteID) {
		$sql = "SELECT * FROM blok AS b, htmlBlok AS hb WHERE b.blokid = '$intBlokID' AND hb.blokid = '$intBlokID'";
		$sql .= " AND b.wid = '$intWebsiteID' AND hb.wid = '$intWebsiteID'";
		global $dbConnectie;	
		$arrBlokken  = $dbConnectie->getData($sql);
		if($arrBlokken != false && $arrBlokken != null) {
			$objBlok = new htmlBlok();
			$objBlok->setValues($arrBlokken[0]);
			return $objBlok;
		}
		else return false;
	}
	// Functie om Blok van type links op te vragen
	function getLinksBlok( $intBlokID, $intWebsiteID) {
		$sql = "SELECT * FROM blok AS b, linksBlok AS lb WHERE b.blokid = '$intBlokID'";	
		$sql .= " AND lb.blokid = '$intBlokID' AND b.wid = '$intWebsiteID' AND lb.wid = '$intWebsiteID'";
		global $dbConnectie;	
		$arrBlokken  = $dbConnectie->getData($sql);
		if($arrBlokken != false && $arrBlokken != null) {
			$objBlok = new linksBlok();
			$objBlok->setValues($arrBlokken[0]);
			return $objBlok;
		}
		else return false;
	}   
	// Functie om Blok van type html op te vragen
	function getTekstBlok( $intBlokID, $intWebsiteID) {
		$sql = "SELECT * FROM blok AS b, tekstBlok AS tb WHERE b.blokid = '$intBlokID' ";	
		$sql .= "AND tb.blokid = '$intBlokID' AND b.wid = '$intWebsiteID' AND tb.wid = '$intWebsiteID'";
		global $dbConnectie;	
		$arrBlokken  = $dbConnectie->getData($sql);
		if($arrBlokken != false && $arrBlokken != null) {
			$objBlok = new tekstBlok();
			$objBlok->setValues($arrBlokken[0]);
			return $objBlok;
		}
		else return false;
	}  
	// Functie om Blok van type afbeelding op te vragen
	function getTekstafbBlok( $intBlokID, $intWebsiteID ) {
		$sql = "SELECT * FROM blok AS b, tekstafbBlok AS tab WHERE b.blokid = '$intBlokID' AND ";
		$sql .= "tab.blokid = '$intBlokID' AND b.wid = '$intWebsiteID' AND tab.wid = '$intWebsiteID'";
		global $dbConnectie;	
		$arrBlokken  = $dbConnectie->getData($sql);
		if($arrBlokken != false && $arrBlokken != null) {
			$objBlok = new tekstafbBlok();
			$objBlok->setValues($arrBlokken[0]);
			return $objBlok;
		}
		else return false;
	}

	// Functie om Blok te laten zien op het scherm
	function showBlok( $intBlokID, $intWebsiteID, $objGebRechten ) {
		$objBlok = getBlok( $intBlokID, $intWebsiteID );
		$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);  	
		echo "<h1>Bekijk blokinformatie</h1><br>\n";
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		if($objBlok != false && $objBlok != null) {
			$objPagina = getPagina( $objBlok->getPaginaID(), $intWebsiteID);
			echo "<tr><td class=\"tabletitle\" colspan=\"4\">Blok met titel '".$objBlok->getTitel()."' (".$objBlok->getBlokID().")</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Type blok:</td><td class=\"formvak\" colspan=\"3\">".changeBlokType($objBlok->getSubType())."</td></tr>\n";  		
			echo "<tr><td class=\"formvakb\">Toegevoegd op:</td><td class=\"formvak\" colspan=\"3\">";
			DisplayConvertedDatumTijd($objBlok->getDatum());
			echo "</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Zichtbaar:</td><td class=\"formvak\" colspan=\"3\">".ucfirst($objBlok->getZichtbaar())."</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Bewerkbaar:</td><td class=\"formvak\" colspan=\"3\">".ucfirst($objBlok->getBewerkbaar())."</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Onderdeel van:</td><td class=\"formvak\" colspan=\"3\">";
			showHoofdOnderdelen($objPagina->getOnderdeelID(), $intWebsiteID, $objGebRechten);  		
			echo "--> <a href=\"".$_SERVER['PHP_SELF']."?pid=".$objPagina->getPaginaID()."&amp;actie=view".$strExtra;
			echo "\">".$objPagina->getTitel() . "</a></td></tr>\n";
			echo "</td></tr>\n";
			echo "<tr><td class=\"tabletitle\" colspan=\"4\">Lay-out eigenschappen van blok</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Uitlijning:</td><td class=\"formvak\" colspan=\"3\">";
			showUitlijningNaam( $objBlok->getUitlijning() );
			echo "</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Breedte:</td><td class=\"formvak\" colspan=\"3\">";
			if($objBlok->getBreedte() != "0") echo $objBlok->getBreedte()." pixels </td></tr>\n";
			else echo " <i>Niet van toepassing</i></td></tr>\n";
			echo "<tr><td class=\"formvakb\">Hoogte:</td><td class=\"formvak\" colspan=\"3\">";
			if($objBlok->getHoogte() != "0") echo $objBlok->getHoogte()." pixels </td></tr>\n";
			else echo " <i>Niet van toepassing</i></td></tr>\n";
			echo "<tr><td class=\"formvakb\">Kader-breedte:</td><td class=\"formvak\" colspan=\"3\">";
			if($objBlok->getBorder() != "0") echo $objBlok->getBorder()." pixels </td></tr>\n";
			else echo " <i>Niet van toepassing</i></td></tr>\n";
			echo "<tr><td class=\"formvakb\">Kader-kleur:</td><td class=\"formvak\" colspan=\"3\">";
			if($objBlok->getBorderKleur() != "") echo $objBlok->getBorderKleur()."</td></tr>\n";
			else echo " <i>Niet van toepassing</i></td></tr>\n";
			echo "<tr><td class=\"formvakb\">Kader-stijl:</td><td class=\"formvak\" colspan=\"3\">";
			if($objBlok->getBorderType() != "") echo changeBorderType($objBlok->getBorderType())." </td></tr>\n";
			else echo " <i>Niet van toepassing</i></td></tr>\n";
			echo "<tr><td class=\"formvakb\">Achtergrondkleur:</td><td class=\"formvak\" colspan=\"3\">";
			if($objBlok->getAchtergrondKleur() != "") echo $objBlok->getAchtergrondKleur()." </td></tr>\n";
			else echo " <i>Niet van toepassing</i></td></tr>\n";
			echo "<tr><td class=\"tabletitle\" colspan=\"4\">Extra Opties</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Begindatum:</td><td class=\"formvak\" colspan=\"3\">";
			if($objBlok->getBeginDatum() != "0000-00-00 00:00:00") echo $objBlok->getFormatedBeginDatum();
			else echo "<i>Niet van toepassing</i>";
			echo "</td></tr>";
			echo "<tr><td class=\"formvakb\">Einddatum:</td><td class=\"formvak\" colspan=\"3\">";
			if($objBlok->getEindDatum() != "9999-12-31 23:59:59") echo $objBlok->getFormatedEindDatum();
			else echo "<i>Niet van toepassing</i>";
			echo "</td></tr>";
			echo "<tr><td class=\"formvakb\" colspan=\"4\">Intro:</td></tr>\n";
			echo "<tr><td class=\"formvak\" colspan=\"4\">";
			if($objBlok->getIntro() != "") echo $objBlok->getIntro();
			else echo "<i>Niet van toepassing</i>";
			echo "</td></tr>";
			
			if($objGebRechten == "ja" || (checkBlokRechten($objGebRechten, $objBlok->getSubType()) && $objBlok->getBewerkbaar() == "ja")) {
				echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?bid=".$objBlok->getBlokID()."&amp;actie=edit$strExtra\" class=\"linkitem\">Bewerk blok</a></td>\n";
				echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?bid=".$objBlok->getBlokID()."&amp;pagid=".$objBlok->getPaginaID()."&amp;actie=del$strExtra\" class=\"linkitem\">Verwijder blok</a></td>\n";			
			}
			else {
				echo "<tr><td class=\"tablelinks\" colspan=\"2\">&nbsp;</td>";
			}
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?pid=".$objBlok->getPaginaID()."&amp;actie=view$strExtra\" class=\"linkitem\">Bekijk pagina</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
			if($objGebRechten == "ja")
				echo "?wid=$intWebsiteID";
			echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
			echo "</table>\n<br><br>\n";
			echo "<table class=\"overzicht\" cellspacing=\"0\" colspan=\"2\">\n";
			echo "<tr><td class=\"tabletitle\" colspan=\"2\">Overzicht Blokken bij pagina '<a href=\"".$_SERVER['PHP_SELF']."?pid=".$objBlok->getPaginaID()."&amp;actie=view\" class=\"linkitem\">".$objPagina->getTitel()."</a>'</td></tr>\n";
			showBlokkenByPID( $objBlok->getPaginaID(), $objBlok->getWebsiteID() , $objGebRechten, $objBlok->getBlokID());
			if(checkBlokRechten($objGebRechten)) 
				echo "<tr><td class=\"tablelinks\" colspan=\"2\"><a href=\"".$_SERVER['PHP_SELF']."?actie=newB&amp;pid=".$objBlok->getPaginaID()."$strExtra\" class=\"linkitem\">Blok toevoegen</a></td></tr>\n";
			else 
				echo "<tr><td class=\"tablelinks\" colspan=\"2\">&nbsp;</td></tr>\n";
		}
  		else {
  			echo "<tr><td class=\"tabletitle\">Blok niet gevonden</td></tr>\n";
  			echo "<tr><td class=\"formvak\">Het Blok met id-nummer '$intBlokID' is niet gevonden.</td></tr>\n";
  			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
			if($objGebRechten == "ja")
	  			echo "?wid=$intWebsiteID";
  			echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
  		}
		echo "</table>\n";
	}
  
  // Functie om Blokken op te vragen
  function getBlokken( $intWebsiteID ) {
 	$sql = "SELECT * FROM blok WHERE wid = '$intWebsiteID'";	
  	global $dbConnectie;	
 	$arrBlokken  = $dbConnectie->getData($sql);
 	return $arrBlokken;
  }
  // Functie om Blokken op te vragen bij pagina-nummers
  function getBlokkenByPID( $intPaginaID, $intWebsiteID ) {
 	$sql = "SELECT * FROM blok WHERE pid = '$intPaginaID' AND wid = '$intWebsiteID' ORDER BY positie";
  	global $dbConnectie;	
 	$arrBlokken  = $dbConnectie->getData($sql);
 	return $arrBlokken;
  }
  // Functie om Blokken die bij een pagina horen te laten zien 
  function showBlokkenByPID( $intPaginaID, $intWebsiteID, $objGebRechten, $intSelBlokID = 0 ) {
	$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
  	$arrBlokken = getBlokkenByPID( $intPaginaID, $intWebsiteID );
  	if($arrBlokken != false && $arrBlokken != null) {
  		$intArraySize = count($arrBlokken);
  		for($i = 0; $i < $intArraySize; $i++ ) {
	  		$objBlok = new Blok();
  			$objBlok->setValues($arrBlokken[$i]);
  			if($objBlok->getTitel() == "")
  				$objBlok->setTitel("<i>Geen titel</i>");
  			if($intSelBlokID != 0 && $intSelBlokID == $objBlok->getBlokID())
  				$objBlok->setTitel( "<b>".$objBlok->getTitel()."</b> (huidige Blok)" );
  			echo "<tr><td class=\"formvak\"><a href=\"" . $_SERVER['PHP_SELF'] . "?bid=".$objBlok->getBlokID()."&amp;actie=view$strExtra\" title=\"Bekijk informatie over dit Blok\">" . $objBlok->getTitel() . "</a></td>\n";
  			if($objGebRechten == "ja" || (checkBlokRechten($objGebRechten, $objBlok->getSubType()) && $objBlok->getBewerkbaar() == "ja")) {
	  			showInhoudMenu("bid", $objBlok->getBlokID(), $intPaginaID, $intWebsiteID );
  				showZichtbaarKeuze("bid", $objBlok->getBlokID(), $objBlok->getPaginaID() ,$objBlok->getZichtbaar(), $intWebsiteID);

				if($i == 0 && ($i + 1) == $intArraySize) {
					showUpAndDownMenu("bid", $objBlok->getBlokID(), $objBlok->getPositie(), $objBlok->getPaginaID(), "beide", $intWebsiteID );
				}
	  			elseif(($i + 1) == $intArraySize) {
					showUpAndDownMenu("bid", $objBlok->getBlokID(), $objBlok->getPositie(), $objBlok->getPaginaID(), "laatste", $intWebsiteID );  	
  				}
  				elseif($i == 0) {
	  				showUpAndDownMenu("bid", $objBlok->getBlokID(), $objBlok->getPositie(), $objBlok->getPaginaID(), "eerste", $intWebsiteID );
  				}
  				else {
  					showUpAndDownMenu("bid", $objBlok->getBlokID(), $objBlok->getPositie(), $objBlok->getPaginaID(), 'nvt', $intWebsiteID);
	  			}
			}
 			echo "</tr>\n";
  		}
  	}
  	else {
  		echo "<tr><td class=\"formvak\">Geen bijbehorende blokken aanwezig.</td></tr>";
  	}
  }
  // Functie om selectmenu te maken voor blokttypes
  function showBlokTypes( $objGebRechten) {
 	echo "<select name=\"type\" class=\"groot\">\n";
  	if($objGebRechten == "ja" || $objGebRechten->getAfbeeldingRecht() == "ja")
	  	echo "<option value=\"afbeelding\">Afbeelding\n";  
  	if($objGebRechten == "ja" || $objGebRechten->getContactFormRecht() == "ja")
	  	echo "<option value=\"contactform\">Contactformulier";  	
	if($objGebRechten == "ja" || $objGebRechten->getDownloadsRecht() == "ja")
		echo "<option value=\"downloads\">Downloadslink (naar een bestand)";
  	if($objGebRechten == "ja" || $objGebRechten->getFlashRecht() == "ja")
	  	echo "<option value=\"flash\">Flash";
	if($objGebRechten == "ja" || $objGebRechten->getHTMLCodeRecht() == "ja")
	  	echo "<option value=\"html\">HTML\n";	
	if($objGebRechten == "ja" || $objGebRechten->getLinksRecht() == "ja")
	  	echo "<option value=\"links\">Links\n";	
  	if($objGebRechten == "ja" || $objGebRechten->getTekstAfbRecht() == "ja")
	  	echo "<option value=\"tekstafb\">Tekst met afbeeldingen\n";
  	if($objGebRechten == "ja" || $objGebRechten->getTekstRecht() == "ja")
	  	echo "<option value=\"tekst\">Tekst\n";
  	if($objGebRechten == "ja" || $objGebRechten->getWYSIWYGRecht() == "ja")
	  	echo "<option value=\"wysiwyg\">What You See Is What You Get\n";
  	echo "</select>";
  }
  // Functie om te checken of er wel rechten voor blokttypes zijn
  function checkBlokRechten( $objGebRechten, $strType = '' ) {
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
  	elseif($strType == "wysiwyg" && $objGebRechten->getWYSIWYGRecht() == "ja")
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
  	elseif($objGebRechten->getWYSIWYGRecht() == "ja" && $strType == "")
		return true;
	else
		return false;
  }

	// Functie om formulier te maken om een blok toe te voegen
	function addBlokForm( $intPaginaID, $intWebsiteID, $objGebRechten) {
		$objPagina = getPagina( $intPaginaID, $intWebsiteID );
		if($objPagina == false || $objPagina == null) {
			echo "<h1>Blok toevoegen</h1><br>\n";
			echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
			echo "<tr><td class=\"tabletitle\">Bijbehorende pagina niet gevonden</td></tr>\n";
			echo "<tr><td class=\"formvak\">Het is niet mogelijk om een blok toe te voegen aan de pagina, want de bijbehorende pagina is niet gevonden in de database.</td></tr>\n";
			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
			if($objGebRechten == "ja")
				echo "?wid=$intWebsiteID";
			echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
			echo "</table>\n";
		}
		elseif(checkBlokRechten($objGebRechten)) {
			$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
			echo "<h1>Blok toevoegen (1/2)</h1><br>\n";
			echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" id=\"addBlokForm\">\n";
			echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
			echo "<tr><td class=\"tabletitle\" colspan=\"2\">Blok toevoegen aan een pagina</td></tr>\n";
			echo "<tr><td class=\"formvakb\" style=\" width: 150px;\">Titel:</td><td class=\"formvak\"><input type=\"text\" name=\"titel\"></td></tr>";
			echo "<tr><td class=\"formvakb\">Bloktype:</td><td class=\"formvak\">";
			showBlokTypes($objGebRechten);
			echo "</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Zichtbaar:</td><td class=\"formvak\">".getSelectMenu("zichtbaar", "ja")."</td></tr>\n";
			if($objGebRechten == "ja")
				echo "<tr><td class=\"formvakb\">Bewerkbaar:</td><td class=\"formvak\">".getSelectMenu("bewerkbaar", "nee")."</td></tr>\n";
			echo "<tr><td class=\"tabletitle\" colspan=\"2\">Lay-out eigenschappen van blok</td></tr>\n";
			echo "<tr><td class=\"tableinfo\" colspan=\"2\">Het is niet verplicht om onderstaande velden in te vullen. Als er een veld wordt leeggelaten, dan worden gewoon de standaardinstellingen gebruikt.</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Uitlijning:</td><td class=\"formvak\">";
			showUitlijningMenu();
			echo "</td></tr>\n";			
			echo "<tr><td class=\"formvakb\">Breedte:</td>";
			echo "	<td class=\"formvak\" ><input type=\"text\" name=\"breedte\" size=\"3\" maxlength=\"4\"> pixels </td></tr>\n";
			echo "<tr><td class=\"formvakb\">Hoogte:</td>";
			echo "	<td class=\"formvak\"><input type=\"text\" name=\"hoogte\" size=\"3\" maxlength=\"4\"> pixels </td></tr>\n";
			echo "<tr><td class=\"formvakb\">Kader-stijl:</td>";
			echo "	<td class=\"formvak\">";
			showKaderMenu();
			echo "</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Kader-breedte:</td>";
			echo "	<td class=\"formvak\"><input type=\"text\" name=\"border\" size=\"3\" maxlength=\"2\"> pixels </td></tr>\n";
			echo "<tr><td class=\"formvakb\">Kader-kleur:</td>";
			echo "	<td class=\"formvak\"><input type=\"text\" name=\"bordercolor\" size=\"10\">";
			echo " <a href=\"#\" onClick=\"cpBK.select(document.forms[0].bordercolor,'pickBK');return false;\" name=\"pickBK\" id=\"pickBK\" style=\"font-weight: bold;\">Kies kleur</a></td></tr>\n";
			echo "<tr><td class=\"formvakb\">Achtergrondkleur:</td><td class=\"formvak\">";
			echo "<input type=\"text\" name=\"backgroundcolor\" size=\"10\"> <a href=\"#\" onClick=\"cpAK.select(document.forms[0].backgroundcolor,'pickAK');return false;\" name=\"pickAK\" id=\"pickAK\" style=\"font-weight: bold;\">Kies kleur</a>";
			echo "</td></tr>\n";
			echo "<tr><td class=\"tabletitle\" colspan=\"2\">Extra opties</td></tr>\n";
			echo "<tr><td class=\"tableinfo\" colspan=\"2\">Het is niet verplicht om onderstaande gegevens in te vullen. Selecteer hieronder eerst of er gebruik gemaakt moet worden van de gegevens, daarna kunnen de gegevens ingevuld worden.</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Gebruik intro:</td><td class=\"formvak\"><input type=\"checkbox\" name=\"introcheck\" value=\"ja\" onClick=\"showhide('introdiv')\"></td></tr>\n";
			// Trucje met divje 
			echo "<tr><td colspan=\"2\">\n";
			echo "<div id=\"introdiv\" style=\"display: none;\">\n<table style=\"width: 100%;\">";
			echo "<tr><td class=\"formvakb\" style=\"vertical-align: top; width: 150px;\">Intro:</td>";
			echo "<td class=\"formvak\"><textarea name=\"intro\" rows=3 cols=45></textarea></td>";
			echo "</tr>\n</table>\n</div>\n";
			echo "</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Gebruik data:</td><td class=\"formvak\"><input type=\"checkbox\" name=\"datacheck\" value=\"ja\" onClick=\"showhide('datadiv')\"></td></tr>\n";
			// Trucje met de divjes 
			echo "<tr><td colspan=\"2\">\n";
			echo "<div id=\"datadiv\" style=\"display: none;\">\n<table style=\"width: 100%;\">";
			echo "<tr><td class=\"formvakb\" style=\" width: 150px;\">Begindatum:</td>";
			echo "<td class=\"formvak\"><input type=\"text\" name=\"begindatum\" id=\"begindatum\" size=\"19\" maxsize=\"19\"> <a href=\"javascript:NewCal('begindatum','ddMMyyyy',true,24);\"><img src=\"images/cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Kies een begindatum\" title=\"Kies een begindatum\"></a></td></tr>\n";
			echo "<tr><td class=\"formvakb\">Einddatum:</td>";
			echo "<td class=\"formvak\"><input type=\"text\" name=\"einddatum\" id=\"einddatum\" size=\"19\" maxsize=\"19\"> <a href=\"javascript:NewCal('einddatum','ddMMyyyy',true,24);\"><img src=\"images/cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Kies een einddatum\" title=\"Kies een einddatum\"></a></td>";
			echo "</tr>\n</table>\n</div>\n";
			echo "</td></tr>\n";
			echo "<tr><td colspan=\"2\" class=\"buttonvak\"><input type=\"submit\" name=\"addBlokKnop1\" value=\"Ga naar het 2e formulier om een blok toe te voegen\" class=\"button\"></td></tr>";
			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=view&amp;pid=$intPaginaID$strExtra\" class=\"linkitem\">Bekijk pagina</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
			if($objGebRechten == "ja")
				echo "?wid=$intWebsiteID";
			echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
			echo "</table>\n";
			echo "<input type=\"hidden\" name=\"pid\" value=\"$intPaginaID\">\n";
			if($objGebRechten == "ja")
				echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID\">";
			echo "<input type=\"hidden\" name=\"bloktype\" value=\"".$objPagina->getPType()."\">\n";
			echo "</form>\n";
			echo "<script language=\"JavaScript\"  type=\"text/javascript\">\n";
			echo "<!--\n";
			echo "  var cpBK = new ColorPicker('window');\n";
			echo "  var cpAK = new ColorPicker('window');\n";
			echo "//-->\n";
			echo "</script>\n";
		}
		else {
			echo "<h1>Blok toevoegen</h1><br>\n";
			echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
			echo "<tr><td class=\"tabletitle\">Geen toegang</td></tr>\n";
			echo "<tr><td class=\"formvak\">Je hebt geen rechten om een blok toe te voegen.</td></tr>\n";
			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
			if($objGebRechten == "ja")
				echo "?wid=$intWebsiteID";
			echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
			echo "</table>\n";
		}
	}
	// Functie om formulier te maken om een blok toe te voegen
	function addBlokForm2( $strBlokType, $intBlokID, $intWebsiteID, $objGebRechten ) {
		echo "<h1>Blok toevoegen (2/2)</h1><br>\n";
		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" id=\"addBlokForm\">\n";
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		$strtBlokType = ucfirst($strBlokType);
		$strFunctie = "maak".$strBlokType."Form";
		$strFunctie('', $intWebsiteID );
		echo "<tr><td colspan=\"4\" class=\"buttonvak\"><input type=\"submit\" name=\"addBlokKnop2\" value=\"Blok toevoegen\" class=\"button\"></td></tr>";
		echo "<tr><td class=\"tablelinks\" colspan=\"4\">&nbsp;</td></tr>";
		echo "</table>\n";  	    
		echo "<input type=\"hidden\" name=\"bid\" value=\"$intBlokID\">\n"; 
		echo "<input type=\"hidden\" name=\"type\" value=\"$strBlokType\">\n";
		if($objGebRechten == "ja")
			echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID\">\n";
		echo "</form>\n";
	}
	// Functie om formulier te maken om een afbeeldingblok toe te voegen/bewerken
	function maakAfbeeldingForm( $objBlok = '', $intWebsiteID) {
		if($objBlok == '')
			$objBlok = new afbeeldingBlok();
		if($objBlok->getAfbWidth() == "0") $objBlok->setAfbWidth( "" );
		if($objBlok->getAfbHeight() == "0") $objBlok->setAfbHeight( "" );

		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Bloktype: Afbeelding</td></tr>\n";
		echo "<tr><td class=\"tableinfo\" colspan=\"4\">De velden Breedte en Hoogte zijn niet verplicht om in te vullen. Als ze leeg worden gelaten, dan worden de standaardmaten gebruikt.</td></tr>\n";
		if($objBlok->getURL() != "") {
			$strStyleBestand = "display: none;";
			$strStyleURL = "";
			$strValue = "url";
		}
		else {
			$strStyleBestand = " ";
			$strStyleURL = "display: none;";
			$strValue = "bestand";
		}
		echo "<tr><td colspan=\"4\">";
		echo "<div id=\"afbeeldinglijst\" style=\"$strStyleBestand\">";
		echo "<table cellspacing=\"0\" style=\"width: 100%;\">\n";
		echo "  <tr><td class=\"formvakb\" style=\"width: 150px; vertical-align: top;\">Afbeelding:</td>\n<td class=\"formvak\">";
			showBestandenMenu( $intWebsiteID, $objBlok->getBestandID(), "afbeeldingen" );
		echo "</td></tr>\n";
		echo "  <tr><td class=\"formvak\" colspan=\"4\"><a href=\"javascript:showhide('afbeeldinglijst');\" onClick=\"showhide('afbeeldingurl');document.forms[0].urlofbestand.value='url'\">Of geef een internetadres van een afbeelding op</a></td></tr>\n";
		echo " </table>\n";
		echo "</div>\n";
		echo "<div id=\"afbeeldingurl\" style=\"$strStyleURL\">\n";
		echo " <table cellspacing=\"0\" style=\"width: 100%;\">\n";
		echo "  <tr><td class=\"formvakb\" style=\"width: 150px;\">URL afbeelding:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"afburl\" value=\"".$objBlok->getURL()."\"></td></tr>\n";
		echo "  <tr><td class=\"formvak\" colspan=\"4\"><a href=\"javascript:showhide('afbeeldingurl');\" onClick=\"showhide('afbeeldinglijst');document.forms[0].urlofbestand.value='bestand'\">Of selecteer een bestand uit het overzicht</a></td></tr>\n";
		echo " </table>\n";
		echo "</div>\n";
		echo "<input type=\"hidden\" name=\"urlofbestand\" value=\"$strValue\">\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Breedte:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"afbbreedte\" size=\"3\" maxlength=\"4\" value=\"".$objBlok->getAfbWidth()."\"> pixels</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Hoogte:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"afbhoogte\" size=\"3\" maxlength=\"4\" value=\"".$objBlok->getAfbHeight()."\"> pixels</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Kader:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"afbborder\" size=\"3\" maxlength=\"2\" value=\"".$objBlok->getAfbBorder()."\"> pixels</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Alt-tekst:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"alt\" value=\"".$objBlok->getAlt()."\"></td></tr>\n";
	}  
	// Functie om formulier te maken om een contactformblok toe te voegen/bewerken
	function maakContactformForm( $objBlok = '', $intWebsiteID ) {
		if($objBlok == '') 
			$objBlok = new contactformBlok();
		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Bloktype: Contactformulier</td></tr>\n";
		echo "<tr><td class=\"formvakb\">E-mailadres:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"mailadres\" value=\"".$objBlok->getMailAdres()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Vraag om adres:</td><td class=\"formvak\" colspan=\"3\"><input type=\"checkbox\" name=\"adresoptie\" value=\"ja\" ".checkedValue($objBlok->getAdresOptie())."></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Vraag om telefoonnummer:</td><td class=\"formvak\" colspan=\"3\"><input type=\"checkbox\" name=\"teloptie\" value=\"ja\" ".checkedValue($objBlok->getTelOptie())."></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Taal:</td><td class=\"formvak\" colspan=\"3\">";
		echo showTaalMenu($objBlok->getTaal());
		echo "</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Tekst voor als het bericht verstuurd is:</td><td class=\"formvak\" colspan=\"3\"><textarea name=\"welverstuurd\" cols=50 rows=10>".fixData( $objBlok->getVerstuurdBericht(), "tekstvak")."</textarea></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Tekst voor als het bericht niet verstuurd is:</td><td class=\"formvak\" colspan=\"3\"><textarea name=\"nietverstuurd\" cols=50 rows=10>".fixData( $objBlok->getNietVerstuurdBericht(), "tekstvak")."</textarea></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Lettertype:</td><td class=\"formvak\" colspan=\"3\">";
		showLetterTypeMenu( "lettertype", $objBlok->getLetterType());
		echo "</td></tr>";
		echo "<tr><td class=\"formvakb\">Lettergrootte:</td><td class=\"formvak\" colspan=\"3\">";
		showLetterGrootteMenu( "lettergrootte", $objBlok->getLetterGrootte());
		echo "</td></tr>";
	}  
	// Functie om formulier te maken om een downloadsblok toe te voegen/bewerken
	function maakDownloadsForm( $objBlok = '', $intWebsiteID) {
		if($objBlok == '')
			$objBlok = new linksBlok();
			
		if($objBlok->getURL() != "") {
			$strStyleBestand = "display: none;";
			$strStyleURL = "";
			$strValue = "url";
		}
		else {
			$strStyleBestand = " ";
			$strStyleURL = "display: none;";
			$strValue = "bestand";
		}
		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Bloktype: Downloads</td></tr>\n";
		echo "<tr><td class=\"formvakb\" style=\"width: 150 px;\">Naam link:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"naam\"  value=\"".$objBlok->getNaam()."\"></td></tr>\n";
		echo "<tr><td colspan=\"4\">";
		echo "<div id=\"bestandenlijst\" style=\"$strStyleBestand\">";
		echo "<table cellspacing=\"0\" style=\"width: 100%;\">\n";
		echo "  <tr><td class=\"formvakb\" style=\"width: 150px; vertical-align: top;\">Bestand:</td>\n<td class=\"formvak\">";
			showBestandenMenu( $intWebsiteID, $objBlok->getBestandID() );
		echo "</td></tr>\n";
		echo "  <tr><td class=\"formvak\" colspan=\"4\"><a href=\"javascript:showhide('bestandenlijst');\" onClick=\"showhide('url');document.forms[0].urlofbestand.value='url'\">Of geef een internetadres van een bestand op</a></td></tr>\n";
		echo " </table>\n";
		echo "</div>\n";
		echo "<div id=\"url\" style=\"$strStyleURL\">\n";
		echo " <table cellspacing=\"0\" style=\"width: 100%;\">\n";
		echo "  <tr><td class=\"formvakb\" style=\"width: 150px;\">Internetadres:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"url\" value=\"".$objBlok->getURL()."\"></td></tr>\n";
		echo "  <tr><td class=\"formvak\" colspan=\"4\"><a href=\"javascript:showhide('url');\" onClick=\"showhide('bestandenlijst');document.forms[0].urlofbestand.value='bestand'\">Of selecteer een bestand uit het overzicht</a></td></tr>\n";
		echo " </table>\n";
		echo "</div>\n";
		echo "  <input type=\"hidden\" name=\"urlofbestand\" value=\"$strValue\">\n";
		echo "  </td></tr>\n";
	}
	// Functie om formulier te maken om een flashblok toe te voegen/bewerken
	function maakFlashForm( $objBlok = '', $intWebsiteID) {
		if($objBlok == '')
			$objBlok = new flashBlok();
		
		if($objBlok->getFlsWidth() == "0") $objBlok->setFlsWidth( "" );
		if($objBlok->getFlsHeight() == "0") $objBlok->setFlsHeight( "" );
		
		if($objBlok->getFlashURL() != "") {
			$strStyleBestand = "display: none;";
			$strStyleURL = "";
			$strValue = "url";
		}
		else {
			$strStyleBestand = " ";
			$strStyleURL = "display: none;";
			$strValue = "bestand";
		}
		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Bloktype: Flash</td></tr>\n";
		echo "<tr><td colspan=\"4\">";
		echo "<div id=\"flashlijst\" style=\"$strStyleBestand\">";
		echo "<table cellspacing=\"0\" style=\"width: 100%;\">\n";
		echo "  <tr><td class=\"formvakb\" style=\"width: 150px; vertical-align: top;\">Flash-bestand:</td>\n<td class=\"formvak\">";
			showBestandenMenu( $intWebsiteID, $objBlok->getBestandID(), "flash" );
		echo "</td></tr>\n";
		echo "  <tr><td class=\"formvak\" colspan=\"4\"><a href=\"javascript:showhide('flashlijst');\" onClick=\"showhide('flashurl');document.forms[0].urlofbestand.value='url'\">Of geef een internetadres van een flash-bestand op</a></td></tr>\n";
		echo " </table>\n";
		echo "</div>\n";
		echo "<div id=\"flashurl\" style=\"$strStyleURL\">\n";
		echo " <table cellspacing=\"0\" style=\"width: 100%;\">\n";
		echo "  <tr><td class=\"formvakb\" style=\"width: 150px;\">Internetadres:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"flashurl\" value=\"".$objBlok->getFlashURL()."\"></td></tr>\n";
		echo "  <tr><td class=\"formvak\" colspan=\"4\"><a href=\"javascript:showhide('flashurl');\" onClick=\"showhide('flashlijst');document.forms[0].urlofbestand.value='bestand'\">Of selecteer een bestand uit het overzicht</a></td></tr>\n";
		echo " </table>\n";
		echo "</div>\n";
		echo "<input type=\"hidden\" name=\"urlofbestand\" value=\"$strValue\">\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"formvakb\" style=\"width: 150px;\">Breedte:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"flsbreedte\" size=\"3\" maxlength=\"4\" value=\"".$objBlok->getFlsWidth()."\"> pixels</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Hoogte:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"flshoogte\" size=\"3\" maxlength=\"4\" value=\"".$objBlok->getFlsHeight()."\"> pixels</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Kwaliteit:</td><td class=\"formvak\" colspan=\"3\">";
		showKwaliteitMenu( "kwaliteit", $objBlok->getKwaliteit() );
		echo "</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Loop:</td><td class=\"formvak\" colspan=\"3\"><input type=\"checkbox\" name=\"loop\" value=\"ja\" ".checkedValue($objBlok->getLoop())."></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Automastisch afspelen:</td><td class=\"formvak\" colspan=\"3\"><input type=\"checkbox\" name=\"autoplay\" value=\"ja\" ".checkedValue($objBlok->getAutoPlay())."></td></tr>\n";	
		echo "<tr><td class=\"formvakb\">Achtergrondkleur:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"achtergrondkleur\" value=\"".$objBlok->getAchtergrondKleur()."\"></td></tr>\n";
	}  
   // Functie om formulier te maken om een htmlblok toe te voegen/bewerken
	function maakHtmlForm( $objBlok = '', $intWebsiteID) {
		if($objBlok == '')
			$objBlok = new htmlBlok();
		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Bloktype: HTML</td></tr>\n";
		echo "<tr><td class=\"formvakb\" colspan=\"4\">Voer hieronder de HTML-code in:</td></tr>\n";
		echo "<tr><td class=\"formvak\" colspan=\"4\"><textarea name=\"html\" cols=60 rows=10>".$objBlok->getHTMLcode()."</textarea></td></tr>\n";
		echo "</td></tr>\n";
	}
	// Functie om formulier te maken om een linksblok toe te voegen/bewerken
	function maakLinksForm( $objBlok = '', $intWebsiteID) {
		if($objBlok == '')
			$objBlok = new linksBlok(); 
		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Bloktype: Links</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Internetadres:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"url\" value=\"".$objBlok->getURL()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Naam link:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"naam\"  value=\"".$objBlok->getNaam()."\"></td></tr>\n";	
	}
	// Functie om formulier te maken om een tekst en afbeeldingblok toe te voegen/bewerken
	function maakTekstafbForm( $objBlok = '', $intWebsiteID) {
		if($objBlok == '')
			$objBlok = new tekstafbBlok();

		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Bloktype: Tekst met afbeelding</td></tr>\n";
		echo "<tr><td class=\"tableinfo\" colspan=\"4\">De velden Breedte en Hoogte zijn niet verplicht om in te vullen. Als ze leeg worden gelaten, dan worden de standaardmaten gebruikt.</td></tr>\n";
		if($objBlok->getURL() != "") {
			$strStyleBestand = "display: none;";
			$strStyleURL = "";
			$strValue = "url";
		}
		else {
			$strStyleBestand = " ";
			$strStyleURL = "display: none;";
			$strValue = "bestand";
		}
		echo "<tr><td colspan=\"4\">";
		echo "<div id=\"afbeeldinglijst\" style=\"$strStyleBestand\">";
		echo "<table cellspacing=\"0\" style=\"width: 100%;\">\n";
		echo "  <tr><td class=\"formvakb\" style=\"width: 150px; vertical-align: top;\">Afbeelding:</td>\n<td class=\"formvak\">";
			showBestandenMenu( $intWebsiteID, $objBlok->getBestandID(), "afbeeldingen" );
		echo "</td></tr>\n";
		echo "  <tr><td class=\"formvak\" colspan=\"4\"><a href=\"javascript:showhide('afbeeldinglijst');\" onClick=\"showhide('afbeeldingurl');document.forms[0].urlofbestand.value='url'\">Of geef een internetadres van een afbeelding op</a></td></tr>\n";
		echo " </table>\n";
		echo "</div>\n";
		echo "<div id=\"afbeeldingurl\" style=\"$strStyleURL\">\n";
		echo " <table cellspacing=\"0\" style=\"width: 100%;\">\n";
		echo "  <tr><td class=\"formvakb\" style=\"width: 150px;\">URL afbeelding:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"afburl\" value=\"".$objBlok->getURL()."\"></td></tr>\n";
		echo "  <tr><td class=\"formvak\" colspan=\"4\"><a href=\"javascript:showhide('afbeeldingurl');\" onClick=\"showhide('afbeeldinglijst');document.forms[0].urlofbestand.value='bestand'\">Of selecteer een bestand uit het overzicht</a></td></tr>\n";
		echo " </table>\n";
		echo "</div>\n";
		echo "<input type=\"hidden\" name=\"urlofbestand\" value=\"$strValue\">\n";
		echo "</td></tr>\n";
		if($objBlok->getAfbWidth() == "0") $objBlok->setAfbWidth( "" );
		if($objBlok->getAfbHeight() == "0") $objBlok->setAfbHeight( "" );
		echo "<tr><td class=\"formvakb\">Breedte:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"afbbreedte\" size=\"3\" maxlength=\"4\" value=\"".$objBlok->getAfbWidth()."\"> pixels</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Hoogte:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"afbhoogte\" size=\"3\" maxlength=\"4\" value=\"".$objBlok->getAfbHeight()."\"> pixels</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Kader:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"afbborder\" size=\"3\" maxlength=\"2\" value=\"".$objBlok->getAfbBorder()."\"> pixels</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Alt-tekst:</td><td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"afbalt\" value=\"".$objBlok->getAfbAlt()."\"></td></tr>\n";
		echo "<tr><td colspan=\"4\" class=\"formvakb\">Indeling:</td></tr>\n";
		echo "<tr><td colspan=\"4\">";
		showFiguurKeuzeMenu( $objBlok->getKeuze() );
		echo "</td></tr>";
		echo "<tr><td class=\"formvakb\" colspan=\"4\">Tekst:</td></tr>\n";
		echo "<tr><td class=\"formvak\" colspan=\"4\"><textarea name=\"tekst\" rows=6 cols=60>".fixData($objBlok->getTekst(), "tekstvak")."</textarea></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Lettertype:</td><td class=\"formvak\" colspan=\"3\">";
		showLetterTypeMenu( "lettertype", $objBlok->getLetterType());
		echo "</td></tr>";
		echo "<tr><td class=\"formvakb\">Lettergrootte:</td><td class=\"formvak\" colspan=\"3\">";
		showLetterGrootteMenu( "lettergrootte", $objBlok->getLetterGrootte());
		echo "</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Letterkleur:</td><td class=\"formvak\">";
		echo "<input type=\"text\" name=\"letterkleur\" size=\"10\" value=\"".$objBlok->getLetterKleur()."\"></td>\n";
		echo "<td class=\"formvak\" colspan=\"3\"> <a href=\"#\" onClick=\"cpLK.select(document.forms[0].letterkleur,'pickAK');return false;\" name=\"pickAK\" id=\"pickAK\" style=\"font-weight: bold;\">Kies kleur</a>";
		echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
		echo "<!--\n";
		echo "  var cpLK = new ColorPicker('window', document.forms[0].letterkleur);\n";
		echo "//-->\n";
		echo "</script>\n";
		echo "</td></tr>\n";
	}  
   // Functie om formulier te maken om een tekstblok toe te voegen/bewerken 
	function maakTekstForm( $objBlok = '', $intWebsiteID) {
		if($objBlok == '')
			$objBlok = new tekstBlok();
		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Bloktype: Tekst</td></tr>\n";
		echo "<tr><td class=\"formvakb\" colspan=\"4\">Voer hieronder de tekst in:</td></tr>\n";
		echo "<tr><td class=\"formvak\" colspan=\"4\"><textarea name=\"tekst\" rows=10 cols=60>".fixData($objBlok->getTekst(), "tekstvak")."</textarea>";
		echo "</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Lettertype:</td><td class=\"formvak\" colspan=\"3\">";
		showLetterTypeMenu( "lettertype", $objBlok->getLetterType());
		echo " </td></tr>\n";
		echo "<tr><td class=\"formvakb\">Lettergrootte:</td><td class=\"formvak\" colspan=\"3\">";
		showLetterGrootteMenu( "lettergrootte", $objBlok->getLetterGrootte());
		echo " pixels</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Letterkleur:</td><td class=\"formvak\">";
		echo "<input type=\"text\" name=\"letterkleur\" size=\"10\" value=\"".$objBlok->getLetterKleur()."\"></td>\n";
		echo "<td colspan=\"2\" class=\"formvak\"><a href=\"#\" onClick=\"cpLK.select(document.forms[0].letterkleur,'pickAK');return false;\" name=\"pickAK\" id=\"pickAK\" style=\"font-weight: bold;\">Kies kleur</a>";
		echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
		echo "<!--\n";
		echo "  var cpLK = new ColorPicker('window', document.forms[0].letterkleur);\n";
		echo "//-->\n";
		echo "</script>\n";
		echo "</td></tr>\n";
	}  
	// Functie om formulier te maken om een wysiwygblok toe te voegen of te bewerken
	function maakWysiwygForm( $objBlok = '', $intWebsiteID) {
		if($objBlok == '')
			$objBlok = new htmlBlok();
		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Bloktype: What See Is What You Get</td></tr>\n";
		echo "<tr><td class=\"tableinfo\" colspan=\"4\">De lay-out van de eigenschappen, zoals de achtergrondkleur, zijn in het venster hieronder nog <i>niet</i> toegepast. Dit wordt later automatisch gedaan.</td></tr>\n";
		echo "<tr><td class=\"formvakb\" colspan=\"4\">Voer hieronder de gegevens in:</td></tr>\n";
		echo "<tr><td class=\"formvak\" colspan=\"4\"><textarea name=\"html\" id=\"html\" style=\"width: 500px; height: 400px;\">".fixData($objBlok->getHTMLcode()	)."</textarea>";
		echo "<tr><td class=\"formvak\" colspan=\"4\">\n";
		echo "</td></tr>\n";
	}
	// Functie om formulier te maken om blok te bewerken
	function editBlokForm( $intBlokID, $intWebsiteID, $objGebRechten ) {
		$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
		$strSubType = getSubType( $intBlokID, $intWebsiteID );
 		$strFunctie = "get".ucfirst(getGoedeSubType( $strSubType )) . "Blok";
		$objBlok = $strFunctie( $intBlokID, $intWebsiteID );
		echo "<h1>Bewerk blokinformatie</h1><br>\n";
		if($objBlok == false || $objBlok == null) {
			echo "<table class=\"overzicht\" cellspacing=\"0\">\n";    	
			echo "<tr><td class=\"tabletitle\">Blok niet gevonden</td></tr>\n";
			echo "<tr><td class=\"formvak\">Het blok met id-nummer '$intBlokID' is niet gevonden.</td></tr>\n";
			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
			if($objGebRechten == "ja")
				echo "?wid=$intWebsiteID";
			echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
			echo "</table>\n";
		}
		elseif(($objGebRechten != "ja" && (!checkBlokRechten($objGebRechten, $objBlok->getSubType()) || $objBlok->getBewerkbaar() == "nee"))) {
			echo "<table class=\"overzicht\" cellspacing=\"0\">\n";    	
			echo "<tr><td class=\"tabletitle\" colspan=\"4\">Geen toegang</td></tr>\n";
			echo "<tr><td colspan=\"3\" class=\"formvak\">Je hebt geen rechten om de blokken te bewerken.</td></tr>\n";
			echo "<tr><td colspan=\"2\" class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=view&amp;pid=".$objBlok->getPaginaID()."\" class=\"linkitem\">Bekijk pagina</a></td>";
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Overzicht website</a></td></tr>";
			echo "</table>\n";
		}
		else {
			if($objBlok->getBreedte() == "0") $objBlok->setBreedte( "" );
			if($objBlok->getHoogte() == "0") $objBlok->setHoogte( "" );
			echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" id=\"editBlokForm\">\n";
			echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
			echo "<tr><td class=\"tabletitle\" colspan=\"4\">Blok bewerken: ".$objBlok->getTitel()."</td></tr>\n";
			echo "<tr><td class=\"formvakb\" style=\"width: 150px;\">Titel:</td><td colspan=\"3\" class=\"formvak\"><input type=\"text\" name=\"titel\" value=\"".fixData($objBlok->getTitel())."\"></td></tr>\n";
			echo "<tr><td class=\"formvakb\">Zichtbaar:</td><td colspan=\"3\" class=\"formvak\">".getSelectMenu( "zichtbaar", $objBlok->getZichtbaar())."</td></tr>\n";
			if($objGebRechten == "ja")
				echo "<tr><td class=\"formvakb\">Bewerkbaar:</td><td class=\"formvak\" colspan=\"3\">".getSelectMenu( "bewerkbaar", $objBlok->getBewerkbaar())."</td></tr>\n";
			echo "<tr><td class=\"tabletitle\" colspan=\"4\">Lay-out eigenschappen van blok</td></tr>\n";
			echo "<tr><td class=\"tableinfo\" colspan=\"4\">Het is niet verplicht om onderstaande velden in te vullen. Als er een veld wordt leeggelaten, dan worden gewoon de standaardinstellingen gebruikt.</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Uitlijning:</td><td class=\"formvak\" colspan=\"3\">";
			showUitlijningMenu($objBlok->getUitlijning() );
			echo "</td></tr>\n"; 
			echo "<tr><td class=\"formvakb\">Breedte:</td>";
			echo "	<td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"breedte\" size=\"3\" maxlength=\"4\" value=\"".$objBlok->getBreedte()."\"> pixels </td></tr>\n";
			echo "<tr><td class=\"formvakb\">Hoogte:</td>";
			echo "	<td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"hoogte\" size=\"3\" maxlength=\"4\" value=\"".$objBlok->getHoogte()."\"> pixels </td></tr>\n";
			echo "<tr><td class=\"formvakb\">Kader-stijl::</td>";
			echo "	<td class=\"formvak\" colspan=\"3\">";
			showKaderMenu($objBlok->getBorderType());
			echo "</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Kader-breedte:</td>";
			echo "	<td class=\"formvak\" colspan=\"3\"><input type=\"text\" name=\"border\" size=\"3\" maxlength=\"2\" value=\"".$objBlok->getBorder()."\"> pixels </td></tr>\n";
			echo "<tr><td class=\"formvakb\">Kader-kleur:</td>";
			echo "	<td class=\"formvak\"><input type=\"text\" name=\"bordercolor\" size=\"10\" value=\"".$objBlok->getBorderKleur()."\"></td>\n";
			echo "<td class=\"formvak\" colspan=\"2\"><a href=\"#\" onClick=\"cpBK.select(document.forms[0].bordercolor,'pickBK');return false;\" name=\"pickBK\" id=\"pickBK\" style=\"font-weight: bold;\">Kies kleur</a></td></tr>\n";
			echo "<tr><td class=\"formvakb\">Achtergrondkleur:</td><td class=\"formvak\"><input type=\"text\" name=\"backgroundcolor\" size=\"10\" value=\"".$objBlok->getAchtergrondKleur()."\"></td>\n";
			echo "<td class=\"formvak\" colspan=\"2\"><a href=\"#\" onClick=\"cpAK.select(document.forms[0].backgroundcolor,'pickAK');return false;\" name=\"pickAK\" id=\"pickAK\" style=\"font-weight: bold;\">Kies kleur</a>";
			echo "</td></tr>\n";
			echo "<tr><td class=\"tabletitle\" colspan=\"4\">Extra opties</td></tr>\n";
			echo "<tr><td class=\"tableinfo\" colspan=\"4\">Het is niet verplicht om onderstaande gegevens in te vullen. Selecteer hieronder eerst of er gebruik gemaakt moet worden van de gegevens, daarna kunnen de gegevens ingevuld worden.</td></tr>\n";
			if($objBlok->getIntro() != "") {
				$strChecked = " CHECKED";
				$strStyle = "";
			}
			else {
				$strChecked = "";
				$strStyle = " none";
			}
			if($objBlok->getBeginDatum() == "0000-00-00 00:00:00" && $objBlok->getEindDatum() == "9999-12-31 23:59:59") {
				$strChecked2 = "";
				$strStyle2 = " none";
			}
			else {
				$strChecked2 = " CHECKED	";
				$strStyle2 = "";
			}
			echo "<tr><td class=\"formvakb\">Gebruik intro:</td><td class=\"formvak\" colspan=\"3\"><input type=\"checkbox\" name=\"introcheck\" value=\"ja\" onClick=\"showhide('introdiv')\" $strChecked></td></tr>\n";
			// Trucje met divje 
			echo "<tr><td colspan=\"4\">\n";
			echo "<div id=\"introdiv\" style=\"display: $strStyle;\">\n<table style=\"width: 100%;\">";
			echo "<tr><td class=\"formvakb\" style=\"vertical-align: top; width: 150px;\">Intro:</td>";
			echo "<td class=\"formvak\"><textarea name=\"intro\" rows=3 cols=45>".$objBlok->getIntro()."</textarea></td>";
			echo "</tr>\n</table>\n</div>\n";
			echo "</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Gebruik data:</td><td class=\"formvak\" colspan=\"3\"><input type=\"checkbox\" name=\"datacheck\" value=\"ja\" onClick=\"showhide('datadiv')\" $strChecked2></td></tr>\n";
			// Trucje met de divjes 
			echo "<tr><td colspan=\"4\">\n";
			echo "<div id=\"datadiv\" style=\"display: $strStyle2;\">\n<table style=\"width: 100%;\">";
			echo "<tr><td class=\"formvakb\" style=\" width: 150px;\">Begindatum:</td>";
			echo "<td class=\"formvak\"><input type=\"text\" name=\"begindatum\" id=\"begindatum\" size=\"19\" maxsize=\"19\" value=\"".$objBlok->getFormatedBeginDatum()."\"> <a href=\"javascript:NewCal('begindatum','ddMMyyyy',true,24);\"><img src=\"images/cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Kies een begindatum\" title=\"Kies een begindatum\"></a></td></tr>\n";
			echo "<tr><td class=\"formvakb\">Einddatum:</td>";
			echo "<td class=\"formvak\"><input type=\"text\" name=\"einddatum\" id=\"einddatum\" size=\"19\" maxsize=\"19\" value=\"".$objBlok->getFormatedEindDatum()."\"> <a href=\"javascript:NewCal('einddatum','ddMMyyyy',true,24);\"><img src=\"images/cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Kies een einddatum\" title=\"Kies een einddatum\"></a></td>";
			echo "</tr>\n</table>\n</div>\n";
			echo "</td></tr>\n";

			$strMaakFunctie = "maak".$strSubType."Form";
			$strMaakFunctie( $objBlok, $intWebsiteID );
			echo "<tr><td colspan=\"4\" class=\"buttonvak\"><input type=\"submit\" name=\"editBlokKnop\" value=\"Bewerk gegevens\" class=\"button\"></td></tr>\n";
			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?bid=$intBlokID&amp;actie=view$strExtra\" class=\"linkitem\">Bekijk blok</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?bid=$intBlokID&amp;actie=del&amp;pagid=".$objBlok->getPaginaID()."$strExtra\" class=\"linkitem\">Verwijder blok</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?pid=".$objBlok->getPaginaID()."&amp;actie=view$strExtra\" class=\"linkitem\">Bekijk pagina</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
			if($objGebRechten == "ja")
				echo "?wid=$intWebsiteID";
			echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
			echo "</table>\n";
			echo "<input type=\"hidden\" name=\"bid\" value=\"$intBlokID\">\n";
			echo "<input type=\"hidden\" name=\"type\" value=\"".$objBlok->getSubType()."\">\n";
			if($objGebRechten == "ja")
				echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID\">\n";
			echo "</form>\n";
			echo "<script language=\"JavaScript\"  type=\"text/javascript\">\n";
			echo "<!--\n";
			echo "  var cpBK = new ColorPicker('window', document.forms[0].bordercolor);\n";
			echo "  var cpAK = new ColorPicker('window', document.forms[0].backgroundcolor);\n";
			echo "//-->\n";
			echo "</script>\n";

		}
	}
   // Functie om formulier te maken om een blok te verwijderen
	function delBlokForm( $intBlokID, $intPaginaID, $intWebsiteID, $objGebRechten ) {
		$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
		$objBlok = getBlok( $intBlokID, $intWebsiteID );
		echo "<h1>Blok verwijderen</h1><br>\n";
		if($objBlok == false || $objBlok == null) {
			echo "<table class=\"overzicht\" cellspacing=\"0\">\n";    	
			echo "<tr><td class=\"tabletitle\">Blok niet gevonden</td></tr>\n";
			echo "<tr><td class=\"formvak\">Het blok met id-nummer '$intBlokID' is niet gevonden.</td></tr>\n";
			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
			if($objGebRechten == "ja")
				echo "?wid=$intWebsiteID";
			echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
			echo "</table>\n";
		}
		else {
			echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" id=\"delBlokForm\">\n";
			echo "<input type=\"hidden\" name=\"bid\" value=\"$intBlokID\">\n";
			echo "<input type=\"hidden\" name=\"pagid\" value=\"$intPaginaID\">\n";	
			if($objGebRechten == "ja")
				echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID	\">\n";	
			echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
			echo "<tr><td class=\"tabletitle\" colspan=\"4\">Blok verwijderen</td></tr>\n";
			echo "<tr><td colspan=\"4\" class=\"formvak\">Hieronder wordt om een bevestiging gevraagd om het blok met id-nummer '$intBlokID' te verwijderen.</td></tr>\n";
			echo "<tr><td class=\"buttonvak\" colspan=\"2\"><input type=\"reset\" name=\"cancelDelBlokKnop\" value=\"Blok niet verwijderen\" onclick=\"history.back()\" class=\"button\"></td>\n";
			echo "<td class=\"buttonvak\" colspan=\"2\">\n";
			echo "<input type=\"submit\" name=\"delBlokKnop\" value=\"Blok verwijderen\" class=\"button\">\n<br><br>\n";
			echo "</td></tr>\n";
			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?bid=$intBlokID&amp;actie=view$strExtra\"\" class=\"linkitem\">Bekijk blok</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?bid=$intBlokID&amp;actie=edit$strExtra\"\" class=\"linkitem\">Bewerk blok</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?pid=$intPaginaID&amp;actie=view$strExtra\"\" class=\"linkitem\">Bekijk pagina</a></td>\n"; 
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
			if($objGebRechten == "ja")
		  		echo "?wid=$intWebsiteID";
  			echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
			echo "</table>\n";	
			echo "</form>\n";
		}
	}
  // Functie om de naam van een bloktype om te zetten tot een nettere naam
  function changeBlokType( $strSelected ) {
		$arrTypes['afbeelding'] = "Afbeelding";
		$arrTypes['contactform'] = "Contactformulier";
		$arrTypes['downloads'] = "Downloadslink";
		$arrTypes['flash'] = "Flash";
		$arrTypes['html'] = "HTML code";
		$arrTypes['links'] = "Links";
		$arrTypes['tekst'] = "Tekst";
		$arrTypes['tekstafb'] = "Tekst met afbeelding";
		$arrTypes['wysiwyg'] = "What You See Is What You Get";
		while (list($strKey, $strVal) = each($arrTypes)) {
			if($strSelected == $strKey)
				return $strVal;
		}
	}
  // Functie om de naam van een bloktype om te zetten tot een nettere naam   function changeBorderType( $strSelected = 'none') {
		$arrKaders['none'] = "Geen kader";
		$arrKaders['solid'] = "Vlakke kader";
		$arrKaders['dotted'] = "Kader bestaande uit punten";
		$arrKaders['dashed'] = "Kader bestaande uit streepjes";
		$arrKaders['double'] = "Dubbele kader";
		$arrKaders['groove'] = "Ingesneden kader";
		$arrKaders['ridge'] = "Richel";
		$arrKaders['inset'] = "Verdiept";
		$arrKaders['outset'] = "Uitstekend";
		while (list($strKey, $strVal) = each($arrKaders)) {
			if($strSelected == $strKey)
				return $strVal;
		}
		return $strSelected;
	}
?>