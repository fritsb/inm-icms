<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: faqfuncties.php
 * Beschrijving: De functies mbt de FAQ's
 */
 
  // Functie om een faq in te voeren 
  function insertFAQ( FAQ $objFAQ) {  
 	$sql = "INSERT INTO faq (faqid, vraag, antwoord, positie, datum, pid, wid )";
 	$sql .= " VALUES ('".getHighestIDNummer("faq", $objFAQ->getWebsiteID())."', '" . $objFAQ->getVraag() . "', '" . $objFAQ->getAntwoord() . "', '".getMaxPositie("faq", $objFAQ->getPaginaID(), $objFAQ->getWebsiteID() )."', "; 
 	$sql .= " '".getDatumTijd()."', '" . $objFAQ->getPaginaID() . "', '" . $objFAQ->getWebsiteID() ."')";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
  }
  // Functie om een faq uptedaten
  function updateFAQ( FAQ $objFAQ ) {
 	$sql = "UPDATE faq SET vraag = '" . $objFAQ->getVraag() . "', antwoord = '" . $objFAQ->getAntwoord() . "' ";
 	$sql .= " WHERE faqid = '" . $objFAQ->getFAQID() . "' AND wid = '" . $objFAQ->getWebsiteID() . "'";
 	global $dbConnectie;    
    return $dbConnectie->setData($sql);
  }
  // Functie om een faq te moven
  function moveFAQ( $intPositieID, $intPaginaID, $intFAQID, $intWebsiteID, $strVerplaatsing ) {
 	$sql = "UPDATE faq SET ";
	if($strVerplaatsing == "up") {
		$sql1 = $sql . " positie = positie + 1 WHERE positie = ( $intPositieID - 1 )";
		$sql .= " positie = (positie - 1) ";
	}
	elseif($strVerplaatsing == "down") {
		$sql1 = $sql . " positie = positie - 1 WHERE positie = ( $intPositieID + 1 )";	
		$sql .= " positie =  (positie + 1) ";
	}
	$sql .= "WHERE positie = '$intPositieID' AND wid = '$intWebsiteID' AND pid = '$intPaginaID' AND faqid = '$intFAQID'";
	$sql1 .= " AND wid = '$intWebsiteID' AND pid = '$intPaginaID'";
	global $dbConnectie;    
 	if(!$dbConnectie->setData($sql1)) {
 	    return false;
 	}
 	elseif(!$dbConnectie->setData($sql)) {
	    return false;
 	}
 	else {
 		return true;
 	}
  }
  // Functie om de positie te veranderen als er nog faqs zijn met een hogere positie
  // Deze functie wordt aangeroepen voordat een andere faq is verwijderd
  // Dit zodat de volgorde blijft kloppen
  function veranderFAQPositie( $intFAQID, $intPaginaID, $intPositie, $intWebsiteID ) {
  	$sql = "SELECT faqid FROM faq WHERE pid = (SELECT pid FROM faq WHERE faqid = '$intFAQID' AND wid = '$intWebsiteID') AND positie > (SELECT positie FROM faq WHERE faqid = '$intFAQID' AND wid = '$intWebsiteID') AND wid = '$intWebsiteID'";
  	global $dbConnectie;
  	$arrFAQs = $dbConnectie->getData($sql);
  	if($arrFAQs != null && $arrFAQs != false) {
		$sql2 = "UPDATE faq SET positie = positie - 1 WHERE pid = '$intPaginaID' AND positie > '$intPositie' AND wid = '$intWebsiteID'";
		return $dbConnectie->setData($sql2);
  	}
  }  
  // Functie om een faq te verwijderen
  function deleteFAQ( $intFAQID, $intWebsiteID ) {
  	$objFAQ = getFAQ( $intFAQID, $intWebsiteID );
  	if($objFAQ != false) {		
    	$intPaginaID = $objFAQ->getPaginaID();
	  	$intPositie = $objFAQ->getPositie();
		veranderFAQPositie( $intFAQID, $intPaginaID, $intPositie, $intWebsiteID);
	 	$sql = "DELETE FROM faq WHERE faqid = '$intFAQID' AND wid = '$intWebsiteID'";
  		global $dbConnectie;	
	 	return $dbConnectie->setData($sql);
	 }
	 else {
	 	return false;
	 }
  }
  // Functie om een faq op te vragen
  function getFAQ( $intFAQID, $intWebsiteID ) {
 	$sql = "SELECT id,  faqid, vraag, antwoord, positie, pid, wid FROM faq WHERE faqid = '$intFAQID' AND wid = '$intWebsiteID'";
  	global $dbConnectie;	
 	$arrFAQs  = $dbConnectie->getData($sql);
 	if($arrFAQs != false) {
 	    $objFAQ = new FAQ();
    	$objFAQ->setValues($arrFAQs[0]);
    	return $objFAQ;
 	}
 	else {
 		return false;
 	}
  }
  // Functie om alle FAQ's op te vragen
  function getFAQs( $intWebsiteID, $intVan = 0, $intLimit = 50  ) {
  	$sql = "SELECT id, faqid, vraag, antwoord, positie, pid, wid FROM faq WHERE wid = '$intWebsiteID' ORDER BY positie LIMIT '$intVan', '$intLimit'";
  	global $dbConnectie;
  	$arrFAQs = $dbConnectie->getData($sql);
  	return $arrFAQs;
  }
  // Functie om het totale nummer van FAQ's op te vragen
  function getTotalNummerFAQs($intWebsiteID) {
  	$sql = "SELECT * FROM faq";
  	global $dbConnectie;
  	$arrFAQs = $dbConnectie->getData($sql);
  	return count($arrFAQs);
  }
  
  
  // Functie om alle FAQ's te laten zien
  function showFAQ( $intFAQID, $intWebsiteID, $objGebRechten ) {
  	$objFAQ = getFAQ( $intFAQID, $intWebsiteID );
  	$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
  	if($objFAQ != false && $objFAQ != null) {
		$objPagina = getPagina($objFAQ->getPaginaID(), $intWebsiteID);
		$strPBewerkbaar = $objPagina->getBewerkbaar();
  		echo "<h1>FAQitem bekijken</h1>\n";
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Informatie van faqitem</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Vraag:</td><td class=\"formvak\" colspan=\"3\">".$objFAQ->getVraag()."</td></tr>\n";
		echo "<tr><td class=\"formvakb\" colspan=\"4\"><b>Antwoord:</b></td></tr>";
		echo "<tr><td class=\"formvak\" colspan=\"4\">".$objFAQ->getAntwoord()."</td></tr>\n";
		if(checkPaginaRechten($objGebRechten, "faq") && $strPBewerkbaar == "ja") {
	  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?fid=".$objFAQ->getFAQID()."&actie=edit$strExtra\" class=\"linkitem\">Bewerk faqitem</a></td>\n";
		  	echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?fid=".$objFAQ->getFAQID()."&pagid=".$objFAQ->getPaginaID()."&actie=del$strExtra\" class=\"linkitem\">Verwijder faqitem</a></td>\n";	  		
	  	}
	  	else {
	  		echo "<tr><td class=\"tablelinks\" colspan=\"2\">&nbsp</td>";
	  	}
  		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?pid=".$objFAQ->getPaginaID()."&actie=view$strExtra\" class=\"linkitem\">Bekijk pagina</a></td>\n";
  		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
		echo "</table>\n";
  	}
  }
  
  // Functie om alle FAQ's te laten zien
  function showFAQOverzicht( $intWebstieID, $intVan = 0, $intLimit = 50 ) {
  	echo "<h1>FAQ Overzicht</h1>";
  	$arrFAQS = getFAQs( $intWebsiteID, $intVan, $intLimit );
	if($arrFAQS == null || $arrFAQS == false) {
		echo "Geen faqs aanwezig!<br>";
	}
	else {
	    $intArraySize = count($arrFAQS);
	    $objFAQ = new Nieuws();
	    for( $i = 0; $i < $intArraySize; $i++ ) {
	      $objFAQ->setValues($arrFAQS[$i]);
		  echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		  echo "<tr><td class=\"tabletitle\"  colspan=\"3\"> " . $objFAQ->getVraag() . "</td></tr>\n";
		  echo "<tr><td class=\"formvak\" colspan=\"3\">" . $objFAQ->getTitel() . "</td></tr>\n";
		  	echo "</table>\n";
		  echo "<br/>";
		}
	}
	echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?actie=an\">Voeg vraag toe</a>";  	
  }
  // Functie om alle vragen op het scherm te laten zien
  function showVragenLijst( $intWebsiteID, $intVan = 0, $intLimit = 50) {
  	echo "<h1>Vraag-Overzicht</h1>";
  	$arrFAQS = getFAQs( $intWebsiteID, $intVan, $intLimit );
	if($arrFAQS == null || $arrFAQS == false) {
		echo "Geen faqs aanwezig!<br>";
	}
	else {
	    $intArraySize = count($arrFAQS);
	    $objFAQ = new Nieuws();
	    for( $i = 0; $i < $intArraySize; $i++ ) {
	      $objFAQ->setValues($arrFAQS[$i]);
		  echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?id=" . $objFAQ->getFAQID() . "\">" . $objFAQ->getVraag() . "</a>\n";
		  echo "<br/>";
		}
	}  	
  }

  // Functie om faqs op te vragen bij pagina-nummers
  function getFAQByPID( $intPaginaID, $intWebsiteID ) {
 	$sql = "SELECT id, faqid, vraag, positie, pid, wid FROM faq WHERE pid = '$intPaginaID' AND wid = '$intWebsiteID' ORDER BY positie ASC";
  	global $dbConnectie;
 	$arrFAQs  = $dbConnectie->getData($sql);
 	return $arrFAQs;
  }
  // Functie om nieuwsitems die bij een pagina horen te laten zien 
  function showFAQByPID( $intPaginaID, $intWebsiteID, $objGebRechten, $intSelNieuws = 0 ) {
  	$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
  	$arrFAQjes = getFAQByPID( $intPaginaID, $intWebsiteID );
  	$objPagina = getPagina($intPaginaID, $intWebsiteID);
  	$strPBewerkbaar = $objPagina->getBewerkbaar();
  	if($arrFAQjes != false && $arrFAQjes != null) {
  		$intArraySize = count($arrFAQjes);
  		for($i = 0; $i < $intArraySize; $i++ ) {
	  		$objFAQ = new FAQ();
  			$objFAQ->setValues($arrFAQjes[$i]);
	      	if($objFAQ->getVraag() == "")
	      		$objFAQ->setVraag("<i>Geen titel</i>");
	      	
  			if($intSelNieuws != 0 && $intSelNieuws == $objFAQ->getID())
  				$objFAQ->setVraag( "<b>".$objNieuws->getVraag()."</b> (huidige faq-item)" );
  			echo "<tr><td class=\"formvak\"><a href=\"" . $_SERVER['PHP_SELF'] . "?fid=".$objFAQ->getFAQID()."&actie=view$strExtra\" title=\"Bekijk informatie over dit faqitem\">" . $objFAQ->getVraag() . "</a></td>\n";
  			if(checkPaginaRechten($objGebRechten, "faq") && $strPBewerkbaar == "ja") {
  				showInhoudMenu("fid",  $objFAQ->getID(), $intPaginaID, $intWebsiteID );
				if($i == 0 && ($i + 1) == $intArraySize) {
		  			showUpAndDownMenu("fid", $objFAQ->getID(), $objFAQ->getPositie(), $objFAQ->getPaginaID(), "beide", $intWebsiteID );
		  		}
  				elseif(($i + 1) == $intArraySize) {
  					showUpAndDownMenu("fid", $objFAQ->getID(), $objFAQ->getPositie(), $objFAQ->getPaginaID(), "laatste", $intWebsiteID );
	  			}
  				elseif($i == 0) {
					showUpAndDownMenu("fid", $objFAQ->getID(), $objFAQ->getPositie(), $objFAQ->getPaginaID(), "eerste", $intWebsiteID );
	  			}
  				else {
					showUpAndDownMenu("fid", $objFAQ->getID(), $objFAQ->getPositie(), $objFAQ->getPaginaID(), '', $intWebsiteID );
	  			}
  			}
 			echo "</tr>\n";
  		}
  	}
  	else {
  		echo "<tr><td class=\"formvak\">Geen bijbehorende faq-items aanwezig.</td></tr>";
  	}
  }
  // Functie om een FAQ-formulier te maken om toe te voegen of te bewerken
  function maakFAQForm( $intFAQID = '', $intPaginaID = '', $intWebsiteID, $objGebRechten) {
 	if($intFAQID == '' && $intPaginaID != "") {
  		echo "<h1>Voeg FAQ-item toe</h1>\n";
  		$strAction = "add";
  		$strKnopTitel = "Voeg FAQ toe";
  		$objFAQ = new FAQ();
  		$objPagina = getPagina($intPaginaID, $intWebsiteID);
	  	$strPBewerkbaar = $objPagina->getBewerkbaar();
  	}
  	else {
  		echo "<h1>Bewerk FAQ-item</h1>\n";
  		$strAction = "edit";
  		$strKnopTitel = "Bewerk FAQ";
  		$objFAQ = getFAQ($intFAQID, $intWebsiteID);
  		$intPaginaID = $objFAQ->getPaginaID();
  		$objPagina = getPagina($intPaginaID, $intWebsiteID);
	  	$strPBewerkbaar = $objPagina->getBewerkbaar();  
  	}
	if(checkPaginaRechten($objGebRechten, "faq") && $strPBewerkbaar == "ja" && $objPagina != false && $objPagina != null && $objFAQ != false && $objFAQ != null) {
	  	echo "<form action=\"".$_SERVER['PHP_SELF']."\" name=\"".$strAction."FAQ\" method=\"POST\">\n";
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n"; 
		echo "<tr><td class=\"tabletitle\" colspan=\"4\">FAQ Gegevens formulier</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Vraag:</td><td class=\"formvak\" colspan=\"3\"><input tyep=\"text\" name=\"vraag\" value=\"".fixData($objFAQ->getVraag())."\" size=\"52\" maxlength=\"70\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\" style=\"vertical-align: top;\">Antwoord:</td><td class=\"formvak\" colspan=\"3\"><textarea name=\"antwoord\" cols=50 rows=6>".fixData($objFAQ->getAntwoord(),"tekstvak")."</textarea></td></tr>\n";
		echo "<tr><td class=\"buttonvak\" colspan=\"4\"><input type=\"submit\" name=\"".$strAction."FAQKnop\" value=\"".$strKnopTitel."\" class=\"button\">\n</td></tr>\n";
	  	echo "<tr><td class=\"tablelinks\">";
  		if($objFAQ->getFAQID() != '')
		  	echo "<a href=\"".$_SERVER['PHP_SELF']."?fid=".$objFAQ->getFAQID()."&actie=view\" class=\"linkitem\">Bekijk faq</a>";
		else
			echo "&nbsp;";
		echo "</td>\n";
  		echo "<td class=\"tablelinks\">";
	  	if($objFAQ->getFAQID() != '')
		  	echo "<a href=\"".$_SERVER['PHP_SELF']."?fid=".$objFAQ->getFAQID()."&pagid=".$objFAQ->getPaginaID()."&actie=del\" class=\"linkitem\">Verwijder faq</a>";
		else
			echo "&nbsp;";
		echo "</td>\n";
	  	echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?pid=".$intPaginaID."&actie=view\" class=\"linkitem\">Bekijk pagina</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Overzicht website</a></td></tr>\n";		
		echo "</table>\n";
		echo "<input type=\"hidden\" name=\"pid\" value=\"$intPaginaID\">\n";
		if($objFAQ->getFAQID() != '')
			echo "<input type=\"hidden\" name=\"fid\" value=\"".$objFAQ->getFAQID()."\">\n";
		if($objGebRechten == "ja")
			echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID\">\n";
	  	echo "</form>\n";
	 }
	 elseif($objFAQ == null || $objFAQ == false) {
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">FAQ-item niet gevonden</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Het opgegeven FAQ-ID-nummer komt niet voor in onze database.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Overzicht website</a></td></tr>";
	  	echo "</table>\n";
	 }
	 else {
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Geen toegang</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Je hebt geen rechten om faqs te beheren.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Overzicht website</a></td></tr>";
	  	echo "</table>\n";
	 }
  }
  // Functie om een formulier te maken om faq te verwijderen
  function delFAQForm( $intFAQID, $intPaginaID, $intWebsiteID, $objGebRechten ) {
	echo "<h1>Verwijder FAQ-item</h1>\n";
	if(checkPaginaRechten($objGebRechten, "faq")) {
  	 	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	  	 echo "<tr><td class=\"tabletitle\" colspan=\"4\">Verwijder FAQitem</td></tr>";
  		 echo "<tr><td class=\"formvak\" colspan=\"4\">Weet u zeker dat u dit faqitem wilt verwijderen?\n";
	  	 echo "<br/><form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" name=\"delFAQitem\">\n";
	  	 echo "<input type=\"hidden\" name=\"fid\" value=\"".$intFAQID."\">\n";
  		 echo "<input type=\"hidden\" name=\"pid\" value=\"".$intPaginaID."\">\n</td></tr>";
  		 if($objGebRechten == "ja")
  		 	echo "<input type=\"hidden\" name=\"wid\" value=\"".$intWebsiteID."\">\n</td></tr>";
	  	 echo "<tr><td class=\"buttonvak\" colspan=\"2\"><input type=\"reset\" name=\"geenDelKnop\" value=\"Nee, niet verwijderen\" class=\"button\" onclick=\"history.back()\" class=\"button\"></td><td colspan=\"2\" class=\"buttonvak\"><input type=\"submit\" name=\"delFAQKnop\" value=\"Verwijder FAQitem\" class=\"button\">\n</td></tr>";
  		 echo "</form>\n</td></tr>";
    	 echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?fid=$intFAQID&actie=view\" class=\"linkitem\">Bekijk faqitem</a></td>\n";
		 echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?fid=$intFAQID&actie=edit\" class=\"linkitem\">Bewerk faqitem</a></td>\n";
		 echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?pid=$intPaginaID&actie=view\" class=\"linkitem\">Bekijk pagina</a></td>\n";
	     echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Overzicht website</a></td></tr>\n"; 
  		 echo "</table>";
  	}
  	else {
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Geen toegang</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Je hebt geen rechten om faqs te beheren.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Overzicht website</a></td></tr>";
	  	echo "</table>\n";
  	}
  }  
?>