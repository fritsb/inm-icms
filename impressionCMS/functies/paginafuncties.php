<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: paginafuncties.php
 * Beschrijving: De functies mbt pagina's
 */
 
  // Functie om pagina in te voeren 
  function insertPagina( Pagina $objPagina) {  
 	$sql = "INSERT INTO pagina (paginaid, titel, type, limiet, positie, zichtbaar, bewerkbaar, oid, wid )";
 	$sql .= " VALUES ('".getHighestIDNummer( "pagina", $objPagina->getWebsiteID())."' ,'" . $objPagina->getTitel() . "', '" . $objPagina->getPType() . "', ";
 	$sql .= " '".$objPagina->getLimiet()."' ,'".$objPagina->getPositie()."', '" . $objPagina->getZichtbaar() . "', ";
 	$sql .= " '" . $objPagina->getBewerkbaar() . "', '".$objPagina->getOnderdeelID()."' , '" . $objPagina->getWebsiteID() ."')";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
  }
  // Functie om pagina uptedaten
  function updatePagina( Pagina $objPagina ) {
 	$sql = "UPDATE pagina SET titel = '" . $objPagina->getTitel() . "', limiet = '".$objPagina->getLimiet()."', zichtbaar = '" . $objPagina->getZichtbaar() . "',";
 	$sql .= " bewerkbaar = '" . $objPagina->getBewerkbaar() . "', oid = '".$objPagina->getOnderdeelID()."', positie = '".$objPagina->getPositie()."' ";
 	$sql .= " WHERE paginaid = '" . $objPagina->getPaginaID() . "' AND wid = '" . $objPagina->getWebsiteID() . "'";
 	global $dbConnectie;    
    return $dbConnectie->setData($sql);
  }
  // Functie om pagina van positie te veranderen
  function movePagina( $intPositieID, $intParentID, $intPaginaID, $intWebsiteID, $strVerplaatsing ) {
 	$sql = "UPDATE pagina SET ";
	if($strVerplaatsing == "up") {
		$sql1 = $sql . " positie = (positie + 1) WHERE positie = ($intPositieID-1)";
		$sql .= " positie = (positie - 1) ";
	}
	elseif($strVerplaatsing == "down") {
		$sql1 = $sql . " positie = (positie - 1) WHERE positie = ($intPositieID+1)";
		$sql .= " positie = (positie + 1) ";
	}
	$sql .= " WHERE positie = '$intPositieID' AND oid = '$intParentID' AND wid = '$intWebsiteID' AND paginaid = '$intPaginaID'";
	$sql1 .= " AND oid = '$intParentID' AND wid = '$intWebsiteID' AND paginaid != '$intPaginaID'";
	global $dbConnectie;    
 	if(!$dbConnectie->setData($sql)) {
 		return false;
 	}
 	elseif(!$dbConnectie->setData($sql1)) {
 		return false;
 	}
 	else {
 		return true;
 	}  
  }
  // Functie om pagina van zichtbaarheid te veranderen
  function changePaginaVisibility( $intPaginaID, $intWebsiteID, $strVisibility ) {
   $objBlok = getPagina( $intPaginaID, $intWebsiteID );
   if($objBlok != false && $objBlok != null) {
		$sql = "UPDATE pagina SET zichtbaar = '$strVisibility' WHERE paginaid = '$intPaginaID' AND wid = '$intWebsiteID'";
		global $dbConnectie;    
   	return $dbConnectie->setData($sql);
   }
   else return false;
    
  }
  
  // Functie om pagina te verwijderen
  // Inclusief alle blokken
  function deletePagina( $intPaginaID, $intWebsiteID ) {
  	$objPagina = getPagina( $intPaginaID, $intWebsiteID);
  	if($objPagina != false && $objPagina != null) {
  		$intOnderdeelID = $objPagina->getOnderdeelID();
	  	$intPositie = $objPagina->getPositie();
		veranderPaginaPositie( $intPaginaID, $intOnderdeelID, $intPositie, $intWebsiteID);
		$sql1 = "DELETE ab FROM blok AS b, afbeeldingblok AS ab WHERE b.pid = '$intPaginaID' AND b.wid = '$intWebsiteID' AND ab.blokid = b.blokid";
		$sql2 = "DELETE cb FROM blok AS b, contactformblok AS cb WHERE b.pid = '$intPaginaID' AND b.wid = '$intWebsiteID' AND cb.blokid = b.blokid";
		$sql3 = "DELETE fb FROM blok AS b, flashblok AS fb WHERE b.pid = '$intPaginaID' AND b.wid = '$intWebsiteID' AND fb.blokid = b.blokid";
		$sql4 = "DELETE hb FROM blok AS b, htmlblok AS hb WHERE b.pid = '$intPaginaID' AND b.wid = '$intWebsiteID' AND hb.blokid = b.blokid";
		$sql5 = "DELETE lb FROM blok AS b, linksblok AS lb WHERE b.pid = '$intPaginaID' AND b.wid = '$intWebsiteID' AND lb.blokid = b.blokid";
		$sql6 = "DELETE tb FROM blok AS b, tekstblok AS tb WHERE b.pid = '$intPaginaID' AND b.wid = '$intWebsiteID' AND tb.blokid = b.blokid";
		$sql7 = "DELETE tab FROM blok AS b, tekstafbblok AS tab WHERE b.pid = '$intPaginaID' AND b.wid = '$intWebsiteID' AND tab.blokid = b.blokid";
		$sql8 = "DELETE FROM blok WHERE pid = '$intPaginaID' AND wid = '$intWebsiteID'";
	 	$sql = "DELETE FROM pagina WHERE paginaid = '$intPaginaID' AND wid = '$intWebsiteID'";
  	
  		global $dbConnectie;
	  	if(!$dbConnectie->setData($sql1)) {
  			return false;
  		}
	  	elseif(!$dbConnectie->setData($sql2)) {
  			return false;
  		}
	  	elseif(!$dbConnectie->setData($sql3)) {
  			return false;
  		}
	  	elseif(!$dbConnectie->setData($sql4)) {
  			return false;
  		}
	  	elseif(!$dbConnectie->setData($sql5)) {
  			return false;
  		}
	  	elseif(!$dbConnectie->setData($sql6)) {
  			return false;
  		}
	  	elseif(!$dbConnectie->setData($sql7)) {
  			return false;
	  	}
  		elseif(!$dbConnectie->setData($sql8)) {
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
  // Functie om alle pagina's die bij een onderdeel horen te verwijderen
  // Inclusief alle blokken 
  function deletePaginasByOID( $intOnderdeelID, $intWebsiteID ) {
	$sql1 = "DELETE ab FROM blok AS b, afbeeldingblok AS ab, pagina AS p WHERE p.oid = '$intOnderdeelID' AND p.wid = '$intWebsiteID' AND p.paginaid = b.pid AND ab.blokid = b.blokid";
	$sql2 = "DELETE cb FROM blok AS b, contactformblok AS cb, pagina AS p WHERE p.oid = '$intOnderdeelID' AND p.wid = '$intWebsiteID' AND p.paginaid = b.pid AND cb.blokid = b.blokid";
	$sql3 = "DELETE fb FROM blok AS b, flashblok AS fb, pagina AS p WHERE p.oid = '$intOnderdeelID' AND p.wid = '$intWebsiteID' AND p.paginaid = b.pid AND fb.blokid = b.blokid";
	$sql4 = "DELETE hb FROM blok AS b, htmlblok AS hb, pagina AS p WHERE p.oid = '$intOnderdeelID' AND p.wid = '$intWebsiteID' AND p.paginaid = b.pid AND hb.blokid = b.blokid";
	$sql5 = "DELETE lb FROM blok AS b, linksblok AS lb, pagina AS p WHERE p.oid = '$intOnderdeelID' AND p.wid = '$intWebsiteID' AND p.paginaid = b.pid AND lb.blokid = b.blokid";
	$sql6 = "DELETE tb FROM blok AS b, tekstblok AS tb, pagina AS p WHERE p.oid = '$intOnderdeelID' AND p.wid = '$intWebsiteID' AND p.paginaid = b.pid AND tb.blokid = b.blokid";
	$sql7 = "DELETE tab FROM blok AS b, tekstafbblok AS tab, pagina AS p WHERE p.oid = '$intOnderdeelID' AND p.wid = '$intWebsiteID' AND p.paginaid = b.pid AND tab.blokid = b.blokid";
	$sql8 = "DELETE b FROM blok AS b, pagina AS p WHERE p.oid = '$intOnderdeelID' AND p.paginaid = b.pid";
 	$sql = "DELETE FROM pagina WHERE oid = '$intOnderdeelID' AND wid = '$intWebsiteID'";
  	global $dbConnectie;
  	if(!$dbConnectie->setData($sql1)) {
  		return false;
  	}
  	elseif(!$dbConnectie->setData($sql2)) {
		return false;  		
  	}
  	elseif(!$dbConnectie->setData($sql3)) {
		return false;  		
  	}
  	elseif(!$dbConnectie->setData($sql4)) {
		return false;  		
  	}
  	elseif(!$dbConnectie->setData($sql5)) {
		return false;  		
  	}
  	elseif(!$dbConnectie->setData($sql6)) {
		return false;  		
  	}
  	elseif(!$dbConnectie->setData($sql7)) {
		return false;  		
  	}
  	elseif(!$dbConnectie->setData($sql8)) {
		return false;  		
  	}
  	elseif(!$dbConnectie->setData($sql)) {
		return false;  		
  	}
  	else {
  		return true;
  	}
  }

  // Functie om de positie te veranderen als er nog blokken zijn met een hogere positie
  // Deze functie wordt aangeroepen voordat een andere blok is verwijderd
  // Dit zodat de volgorde blijft kloppen
  function veranderPaginaPositie( $intPaginaID, $intOnderdeelID, $intPositie, $intWebsiteID ) {
//  	$sql = "SELECT paginaid FROM pagina WHERE oid = (SELECT oid FROM pagina WHERE paginaid = '$intPaginaID' AND wid = '$intWebsiteID') AND positie > (SELECT positie FROM pagina WHERE paginaid = '$intPaginaID' AND wid = '$intWebsiteID') AND wid = '$intWebsiteID'";
  	$sql = "SELECT paginaid FROM pagina WHERE oid = '$intOnderdeelID' AND positie > '$intPositie' AND wid = '$intWebsiteID'";
  	global $dbConnectie;
  	$arrPaginas = $dbConnectie->getData($sql);
  	if($arrPaginas != null && $arrPaginas != false) {
		$sql2 = "UPDATE pagina SET positie = (positie - 1) WHERE oid = '$intOnderdeelID' AND positie > '$intPositie' AND wid = '$intWebsiteID'";
		return $dbConnectie->setData($sql2);
  	}
  }  
  // Functie om paginatype op te vragen
  function getPaginaType( $intPaginaID, $intOnderdeelID ) {
  	$sql = "SELECT type FROM pagina WHERE oid = '$intOnderdeelID' AND paginaid = '$intPaginaID'";
  	global $dbConnectie;
  	$arrPaginas = $dbConnectie->getData($sql);
 	if($arrPaginas != false && $arrPaginas != null) {
	 	$objPagina = new Pagina();
    	$objPagina->setValues($arrPaginas[0]);
    	return $objPagina->getPType();
 	}
 	else {
 		return false;
 	}	
  }
  // Functie om pagina op te vragen
  function getPagina( $intPaginaID, $intWebsiteID ) {
   	$sql = "SELECT id, paginaid, type, limiet, titel, positie, zichtbaar, bewerkbaar, oid, wid FROM pagina WHERE paginaid = '$intPaginaID' AND wid = '$intWebsiteID'";
    global $dbConnectie;	
 	$arrPaginas  = $dbConnectie->getData($sql);
 	if($arrPaginas != false && $arrPaginas != null) {
	 	$objPagina = new Pagina();
    	$objPagina->setValues($arrPaginas[0]);
    	return $objPagina;
 	}
 	else {
 		return false;
 	}	
  }
  // Functie om een onderdeelitem te laten zien
  function showPagina( $intPaginaID, $intWebsiteID, $objGebRechten, $strManier = "normaal" ) {
	$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
  	$objPagina = getPagina( $intPaginaID, $intWebsiteID, $strManier );
  	echo "<h1>Bekijk paginainformatie</h1><br>\n";
  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  	if($objPagina != false && $objPagina != null) {
  		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Pagina: ".$objPagina->getTitel()." (".$objPagina->getPaginaID().")</td></tr>\n";
  		echo "<tr><td class=\"formvakb\">Aantal blokken:</td><td class=\"formvak\" colspan=\"3\">".$objPagina->getLimiet()." per pagina</td></tr>\n";
  		echo "<tr><td class=\"formvakb\">Zichtbaar:</td><td colspan=\"3\" class=\"formvak\">".$objPagina->getZichtbaar()."</td><tr>\n";
  		echo "<tr><td class=\"formvakb\">Bewerkbaar:</td><td colspan=\"3\" class=\"formvak\">".$objPagina->getBewerkbaar()."</td><tr>\n";
  		echo "<tr><td class=\"formvakb\">Onderdeel van:</td><td colspan=\"3\" class=\"formvak\">";
  		showHoofdOnderdelen( $objPagina->getOnderdeelID(), $intWebsiteID, $objGebRechten );
  		echo "</td></tr>\n";
  		if($objGebRechten == "ja" || (checkPaginaRechten($objGebRechten) && $objPagina->getBewerkbaar() == "ja")) {
	  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?pid=".$objPagina->getPaginaID()."&amp;actie=edit$strExtra	\" class=\"linkitem\">Bewerk pagina</a></td>\n";
	  		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?pid=".$objPagina->getPaginaID()."&amp;actie=del$strExtra\" class=\"linkitem\">Verwijder pagina</a></td>\n";
  		}
	  	else {
	  		echo "<tr><td class=\"tablelinks\" colspan=\"2\">&nbsp;</td>\n";
	  	}
  		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?oid=".$objPagina->getOnderdeelID()."&amp;actie=view$strExtra\" class=\"linkitem\">Bekijk onderdeel</a></td>\n";
  		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
	  	echo "</table>\n<br><br>\n";
  		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\" colspan=\"2\">Bijbehorende blokken</td></tr>\n";
		showBlokkenByPID($objPagina->getPaginaID(), $intWebsiteID, $objGebRechten);

		if($objGebRechten == "ja" || (checkBlokRechten( $objGebRechten ) && $objPagina->getBewerkbaar() == "ja")) {
			echo "<tr><td class=\"tablelinks\" colspan=\"2\"><a href=\"".$_SERVER['PHP_SELF']."?actie=newB&amp;pid=$intPaginaID$strExtra\" class=\"linkitem\">Voeg blok toe</a></td></tr>\n";
		}
		else {
			echo "<tr><td class=\"tablelinks\" colspan=\"2\">&nbsp;</td></tr>\n";
		}
	}
 	elseif($intWebsiteID == "" || !isset($intWebsiteID)) {
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Geen website opgegeven</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Er is geen website opgegeven.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\">&nbsp;</td></tr>";
	  	echo "</table>\n";
  	}
	else {
  		echo "<tr><td class=\"tabletitle\">Pagina niet gevonden</td></tr>\n";
  		echo "<tr><td class=\"formvak\">De pagina met id-nummer '$intPaginaID' is niet gevonden.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
	}
	echo "</table>\n";	
  }   
  // Functie om pagina's op te vragen
  function getPaginas( $intWebsiteID, $intVan = '0', $intTot = '50' ) {
 	$sql = "SELECT id, type, titel, positie, zichtbaar, bewerkbaar, wid FROM pagina WHERE wid = '$intWebsiteID' LIMIT '$intVan', '$intTot'";	
  	global $dbConnectie;	
 	$arrPaginas  = $dbConnectie->getData($sql);
 	return $arrPaginas;
 	
  }
  // Functie om pagina's te laten zien
  function showPaginas( $intWebsiteID, $intVan = '0', $intTot = '50') {
  	$arrPaginas = getPaginas( $intWebsiteID, $intVan, $intTot );
  	  		
  	if($arrPaginas != false && $arrPaginas != null) {
  		$intArraySize = count($arrPaginas);
  		echo "<ul>\n";
  		for($i = 0; $i < $intArraySize; $i++ ) {
	  		$objPagina = new Pagina();
  			$objPagina->setValues( $arrPaginas[$i] );
  			echo "<li><a href=\"" . $_SERVER['PHP_SELF'] . "?actie=edit&amp;id=" . $objPagina->getPaginaID() ."\">" . $objPagina->getTitel() .  "</a>\n";
  		}
  		echo "</ul>";
  	}
  }
  
  // Functie om pagina's op te vragen mbv onderdeelID
  function getPaginasByOID( $intOnderdeelID, $intWebsiteID ) {
 	$sql = "SELECT id, type, titel, positie, zichtbaar, bewerkbaar, paginaid, oid, wid FROM pagina WHERE oid = '$intOnderdeelID' AND wid = '$intWebsiteID' ORDER BY positie";	
  	global $dbConnectie;	
 	$arrPaginas  = $dbConnectie->getData($sql);
 	return $arrPaginas;	
  }
  // Functie om pagina's te laten zien die bij 1 onderdeel horen
  function showPaginasByOID( $intOnderdeelID, $intWebsiteID, $objGebRechten, $strMessage = "nee" ) {
	$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
  	$arrPaginas = getPaginasByOID( $intOnderdeelID, $intWebsiteID );
  	if($arrPaginas != false && $arrPaginas != null ) {
  		$intArraySize = count($arrPaginas);
  		for($i = 0; $i < $intArraySize; $i++ ) {
	  		$objPagina = new Pagina();	
  			$objPagina->setValues($arrPaginas[$i]);
	      	if($objPagina->getTitel() == "")
	      		$objPagina->getTitel("<i>Geen titel</i>");
  			echo "<tr><td class=\"inhoudPagina\" colspan=\"2\"><b>P:</b> <a href=\"" . $_SERVER['PHP_SELF'] . "?pid=" . $objPagina->getPaginaID() . "&amp;actie=view$strExtra\" title=\"Bekijk informatie over deze pagina\">" . $objPagina->getTitel() . "</a>\n</td>";
			if($objGebRechten == "ja" || ($objPagina->getBewerkbaar() == "ja" && checkPaginaRechten($objGebRechten))) {
  				showInhoudMenu("pid", $objPagina->getPaginaID(), '0', $intWebsiteID );
	  			showZichtbaarKeuze("pid", $objPagina->getPaginaID(), $objPagina->getOnderdeelID() ,$objPagina->getZichtbaar(), $intWebsiteID);
  				if($i == 0  && ($i + 1) == $intArraySize) {
  					showUpAndDownMenu("pid", $objPagina->getPaginaID(), $objPagina->getPositie(), $intOnderdeelID, "beide", $intWebsiteID);
  				}
	  			elseif(($i + 1) == $intArraySize) {
					showUpAndDownMenu("pid", $objPagina->getPaginaID(), $objPagina->getPositie(), $intOnderdeelID, "laatste", $intWebsiteID);
  				}
	  			elseif($i == 0) {
  					showUpAndDownMenu("pid", $objPagina->getPaginaID(), $objPagina->getPositie(), $intOnderdeelID, "eerste", $intWebsiteID);	
  				}
  				else {
		  			showUpAndDownMenu("pid", $objPagina->getPaginaID(), $objPagina->getPositie(), $intOnderdeelID, 'nvt', $intWebsiteID);	
	  			}
  			}
 			echo "</tr>\n";
  		}
  	}
  	elseif($strMessage == "ja") {
  		echo "<tr><td class=\"formvak\" colspan=\"2\">Er zijn geen pagina's aanwezig</td></tr>\n";
  	}
  }

  // Functie om formulier te maken om pagina toe te voegen
  function addPaginaForm( $intWebsiteID, $objGebRechten, $intSelectedOID = 0 ) {
	$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
 	echo "<h1>Pagina toevoegen</h1><br>\n";

	$arrOnderdelen = getOnderdelen( $intWebsiteID );
	if(($arrOnderdelen == null || $arrOnderdelen == false)) {
		  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	  		echo "<tr><td class=\"tabletitle\">Pagina aanmaken onmogelijk</td></tr>\n";
  			echo "<tr><td class=\"formvak\">Het is niet mogelijk om een pagina aan te maken, omdat er nog geen onderdelen aanwezig zijn.</td></tr>\n";
  			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=newO".$strExtra;
  			echo "\" class=\"linkitem\">Voeg onderdeel toe</a></td></tr>";
		  	echo "</table>\n";
  	}
 	elseif(checkPaginaRechten($objGebRechten)) {
  		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" id=\"addPaginaForm\">\n";
  		if($objGebRechten == "ja")
  			echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID\">\n";
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\" colspan=\"2\">Gegevens van pagina</td></tr>\n";
	  	echo "<tr><td class=\"formvakb\">Titel:</td><td class=\"formvak\"><input type=\"text\" name=\"titel\" size=\"50\" maxlength=\"50\"></td></tr>\n";
	  	echo "<tr><td class=\"formvakb\">Aantal blokken:</td><td class=\"formvak\"><input type=\"text\" name=\"limiet\" size=\"4\" maxlength=\"4\">  per pagina</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Onderdeel van:</td><td class=\"formvak\">\n";
		if($intSelectedOID != 0) {
			showOnderdelenSelectMenu( $intWebsiteID, $objGebRechten, false, $intSelectedOID );
		}
		else {
		 	showOnderdelenSelectMenu( $intWebsiteID, $objGebRechten, false );
		}
  		echo "</td></tr>\n";
	  	echo "<tr><td class=\"formvakb\">Zichtbaar:</td><td class=\"formvak\">".getSelectMenu("zichtbaar", "nee")."</td></tr>\n";
  		if($objGebRechten == "ja")
  			echo "<tr><td class=\"formvakb\">Bewerkbaar:</td><td class=\"formvak\">".getSelectMenu("bewerkbaar", "nee")."</td></tr>\n"; 		
	  	echo "<tr><td colspan=\"2\" class=\"buttonvak\"><input type=\"submit\" name=\"addPaginaKnop\" value=\"Voeg gegevens toe\" class=\"button\"></td></tr>\n";
  		echo "<tr>";
	  	if($intSelectedOID != 0) {
	  		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=view&amp;oid=$intSelectedOID$strExtra\" class=\"linkitem\">Bekijk onderdeel</a></td>";
	  	}
	  	else {
  			echo "<td class=\"tablelinks\">&nbsp;</td>";
	  	}
	  	echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
		echo "</table>\n";
	  	echo "</form>\n"; 		
 	}
 	elseif($intWebsiteID == "" || !isset($intWebsiteID)) {
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Geen website opgegeven</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Er is geen website opgegeven.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\">&nbsp;</td></tr>";
	  	echo "</table>\n";
  	}
 	else {
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Geen toegang</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Je hebt geen rechten om een pagina toe te voegen.</td></tr>\n";
  		echo "<tr><<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Overzicht website</a></td></tr>";
	  	echo "</table>\n";
 	}

  }
  // Functie om formulier te maken om pagina te bewerken
  function editPaginaForm( $intPaginaID, $intWebsiteID, $objGebRechten ) {
    $objPagina = getPagina( $intPaginaID, $intWebsiteID );
    $strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
 	echo "<h1>Pagina bewerken</h1><br>\n";
  	if($objGebRechten != "ja" && ($objPagina != false && $objPagina != null) && (!checkPaginaRechten($objGebRechten) || $objPagina->getBewerkbaar() == "nee")) {
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Geen toegang</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Je hebt geen rechten om deze pagina te bewerken.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
	  	echo "</table>\n";
  	}
  	elseif($intWebsiteID == "" || !isset($intWebsiteID)) {
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Geen website opgegeven</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Er is geen website opgegeven.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\">&nbsp;</td></tr>";
	  	echo "</table>\n";
  	}
  	elseif($objPagina != false && $objPagina != null) {
  		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" id=\"editPaginaForm\">\n";
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Pagina bewerken: '".$objPagina->getTitel()."'</td></tr>\n";
  		echo "<tr><td class=\"formvakb\" width=\"120\">Titel:</td><td colspan=\"3\" class=\"formvak\"><input type=\"text\" name=\"titel\" value=\"".fixData($objPagina->getTitel())."\" size=\"50\" maxlength=\"50\"></td></tr>\n";
	  	echo "<tr><td class=\"formvakb\">Aantal blokken:</td><td class=\"formvak\"><input type=\"text\" name=\"limiet\" size=\"4\" maxlength=\"4\" value=\"".$objPagina->getLimiet()."\"> per pagina</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Bovenliggend onderdeel:</td><td colspan=\"3\" class=\"formvak\">\n";
 		showOnderdelenSelectMenu( $intWebsiteID, $objGebRechten, false, $objPagina->getOnderdeelID() );
  		echo "</td></tr>\n";
  		echo "<tr><td class=\"formvakb\">Zichtbaar:</td><td colspan=\"3\" class=\"formvak\">".getSelectMenu("zichtbaar" ,$objPagina->getZichtbaar())."</td></tr>\n";
  		if($objGebRechten == "ja")
  			echo "<tr><td class=\"formvakb\">Bewerkbaar:</td><td class=\"formvak\">".getSelectMenu("bewerkbaar" ,$objPagina->getBewerkbaar())."</td></tr>\n"; 		
  		echo "<tr><td colspan=\"4\" class=\"buttonvak\"><input type=\"submit\" name=\"editPaginaKnop\" value=\"Bewerk gegevens\" class=\"button\"></td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?pid=$intPaginaID&amp;actie=view$strExtra\" class=\"linkitem\">Bekijk pagina</a></td>\n";
  		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?pid=$intPaginaID&amp;actie=del$strExtra\" class=\"linkitem\">Verwijder pagina</a></td>\n";
  		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?oid=".$objPagina->getOnderdeelID()."&amp;actie=view$strExtra\" class=\"linkitem\">Bekijk onderdeel</a></td>";
  		echo "\n<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
	  	echo "</table>\n";
	 	if($objGebRechten == "ja")
	 		echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID\">\n";
  		echo "<input type=\"hidden\" name=\"pid\" value=\"$intPaginaID\">\n</form>\n";
  	}
  	else {
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Pagina niet gevonden</td></tr>\n";
  		echo "<tr><td class=\"formvak\">De pagina met id-nummer '$intPaginaID' is niet gevonden.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
	  	echo "</table>\n";
  	}
  }
  // Functie om formulier te maken om pagina te verwijderen
  function delPaginaForm( $intPaginaID, $intWebsiteID, $objGebRechten ) {
    $objPagina = getPagina( $intPaginaID, $intWebsiteID );
    $strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
  	echo "<h1>Pagina verwijderen</h1><br>\n";
  	if($objGebRechten != "ja" && ($objPagina != false && $objPagina != null) && (!checkPaginaRechten($objGebRechten) || $objPagina->getBewerkbaar() == "nee")) {
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Geen toegang</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Je hebt geen rechten om deze pagina te bewerken.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
	  	echo "</table>\n";  		
  	}
  	elseif($intWebsiteID == "" || !isset($intWebsiteID)) {
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Geen website opgegeven</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Er is geen website opgegeven.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\">&nbsp;</td></tr>";
	  	echo "</table>\n";
  	}
  	elseif($objPagina != false && $objPagina != null) {
		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" id=\"delPaginaForm\">\n";
		echo "<input type=\"hidden\" name=\"pid\" value=\"$intPaginaID\">\n";
	 	echo "<input type=\"hidden\" name=\"oid\" value=\"".$objPagina->getOnderdeelID()."\">\n";
	 	if($objGebRechten == "ja")
	 		echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID\">\n";
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Pagina verwijderen</td></tr>\n";
		echo "<tr><td colspan=\"4\" class=\"formvak\">Hieronder wordt om een bevestiging gevraagd om de pagina met nummer '$intPaginaID' te verwijderen.<br><br></td></tr>\n";
		echo "<tr><td colspan=\"2\" class=\"buttonvak\"><input type=\"reset\" name=\"cancelDelPaginaKnop\" value=\"Pagina niet verwijderen\" onclick=\"history.back()\" class=\"button\"></td><td class=\"buttonvak\" colspan=\"2\"><input type=\"submit\" name=\"delPaginaKnop\" value=\"Pagina verwijderen\" class=\"button\">\n<br><br>\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?pid=$intPaginaID&amp;actie=view$strExtra\" class=\"linkitem\">Bekijk pagina</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?pid=$intPaginaID&amp;actie=edit$strExtra\" class=\"linkitem\">Bewerk pagina</a></td>\n";
  		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?oid=".$objPagina->getOnderdeelID()."&amp;actie=view$strExtra\" class=\"linkitem\">Bekijk onderdeel</a></td>\n";
	  	echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
		echo "</table>\n";
		echo "</form>\n";	
  	}
  	else {
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Pagina niet gevonden</td></tr>\n";
  		echo "<tr><td class=\"formvak\">De pagina met id-nummer '$intPaginaID' is niet gevonden.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
	  	echo "</table>\n";  		
  	}

  }
  function checkPaginaRechten( $objGebRechten ) {
  	if($objGebRechten == false || $objGebRechten == null) 
  		return false;
  	elseif($objGebRechten == "ja")
  		return true;
  	elseif($objGebRechten->getPaginaRecht() == "ja")
  		return true;
  	else
  		return false;
  }
 
?>