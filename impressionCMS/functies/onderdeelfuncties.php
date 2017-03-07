<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: onderdeelfuncties.php
 * Beschrijving: De functies mbt onderdelen
 */
 
  // Functie om onderdeel in te voeren 
  function insertOnderdeel( Onderdeel $objOnderdeel) {  
 	$sql = "INSERT INTO onderdeel (onderdeelid, titel, omschrijving, positie, zichtbaar, bewerkbaar, parent_id, wid )";
 	$sql .= " VALUES ('".getHighestIDNummer( "onderdeel", $objOnderdeel->getWebsiteID())."', '" . $objOnderdeel->getTitel() . "', '" . $objOnderdeel->getOmschrijving() . "', ";
 	$sql .= "'".$objOnderdeel->getPositie()."', '" . $objOnderdeel->getZichtbaar() . "',";
 	$sql .= " '" . $objOnderdeel->getBewerkbaar() . "','" . $objOnderdeel->getParentID() . "', '" . $objOnderdeel->getWebsiteID() ."')";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
  }
  // Functie om onderdeel uptedaten
  function updateOnderdeel( Onderdeel $objOnderdeel ) {
 	$sql = "UPDATE onderdeel SET titel = '".$objOnderdeel->getTitel()."', omschrijving = '".$objOnderdeel->getOmschrijving(). "', ";
 	$sql .= "zichtbaar = '".$objOnderdeel->getZichtbaar()."', bewerkbaar = '".$objOnderdeel->getBewerkbaar()."' ";
 	$sql .= "WHERE onderdeelid = '".$objOnderdeel->getOnderdeelID()."' AND wid = '".$objOnderdeel->getWebsiteID()."'";
 	global $dbConnectie;    
    return $dbConnectie->setData($sql);
  }
  // Functie om een onderdeel te moven
  function moveOnderdeel( $intPositieID, $intParentID, $intOnderdeelID, $intWebsiteID, $strVerplaatsing ) {
 	$sql = "UPDATE onderdeel SET ";
	if($strVerplaatsing == "up") {
		$sql1 = $sql . " positie = (positie + 1) WHERE positie = ($intPositieID-1)";
		$sql .= " positie = (positie - 1) ";
	}
	elseif($strVerplaatsing == "down") {
		$sql1 = $sql . " positie = (positie - 1) WHERE positie = ($intPositieID+1)";
		$sql .= " positie = (positie + 1) ";
	}
	$sql .= " WHERE positie = '$intPositieID' AND parent_id = '$intParentID' AND wid = '$intWebsiteID' AND onderdeelid = '$intOnderdeelID'";
	$sql1 .= " AND parent_id = '$intParentID' AND wid = '$intWebsiteID' AND onderdeelid != '$intOnderdeelID'";

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
  // Functie om de zichtbaarheid van de onderdeel te veranderen
  function changeOnderdeelVisibility( $intOnderdeelID, $intWebsiteID, $strVisibility ) {
   $objOnderdeel = getOnderdeel( $intOnderdeelID, $intWebsiteID );
	if($objOnderdeel != false && $objOnderdeel != null) {
		$sql = "UPDATE onderdeel SET zichtbaar = '$strVisibility'";
		$sql .= " WHERE onderdeelid = '$intOnderdeelID' AND wid = '$intWebsiteID'";
		global $dbConnectie;    
    	return $dbConnectie->setData($sql);
   }
   else return false;
  }
  // Functie om onderdeel te verwijderen
  function deleteOnderdeel( $intOnderdeelID, $intWebsiteID) {
  	$objOnderdeel = getOnderdeel( $intOnderdeelID, $intWebsiteID);
  	if($objOnderdeel != false && $objOnderdeel != null) {
		$intParentID = $objOnderdeel->getParentID();
	  	$intPositie = $objOnderdeel->getPositie();
		veranderOnderdeelPositie( $intOnderdeelID, $intParentID, $intPositie, $intWebsiteID);
		deletePaginasByOID( $intOnderdeelID, $intWebsiteID );
		deleteSubOnderdelen( $intOnderdeelID, $intWebsiteID );
	 	$sql = "DELETE FROM onderdeel WHERE onderdeelid = '$intOnderdeelID' AND wid = '$intWebsiteID'";
  		global $dbConnectie;
  		if(!$dbConnectie->setData($sql)) {
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
  // Functie om subonderdeel te verwijderen
  function deleteSubOnderdelen( $intOnderdeelID, $intWebsiteID, $intDiepte = 0) {
	  if($intDiepte > 2) {
  		return false;	  
	  }
	  else {
	  	global $dbConnectie;
	  	$arrSubOnderdelen = getSubOnderdelen($intOnderdeelID, $intWebsiteID	);
	  	
	  	if($arrSubOnderdelen != false && $arrSubOnderdelen != null) {
	  		$intArraySize = count($arrSubOnderdelen);
	  		for($intTeller = 0; $intTeller < $intArraySize; $intTeller++) { 
	  			$objOnderdeel = new Onderdeel();
	  			$objOnderdeel->setValues( $arrSubOnderdelen[$intTeller]);
	  			deletePaginasByOID( $objOnderdeel->getOnderdeelID(), $intWebsiteID);
	  			deleteSubOnderdelen( $objOnderdeel->getOnderdeelID(), $intWebsiteID, $intDiepte);
		  		$sql = "DELETE FROM onderdeel WHERE parent_id = '$intOnderdeelID' and wid = '$intWebsiteID'";
		  		$dbConnectie->setData($sql);
	  		}
	  	
	  	}
		$intDiepte++;
  	
  	  }
  }
  
  // Functie om de positie te veranderen als er nog contentblokken zijn met een hogere positie
  // Deze functie wordt aangeroepen voordat een andere contentblok is verwijderd
  // Dit zodat de volgorde blijft kloppen
  function veranderOnderdeelPositie( $intOnderdeelID, $intParentID = 0, $intPositie, $intWebsiteID ) {
  	$sql = "SELECT onderdeelid FROM onderdeel WHERE parent_id = '$intParentID' AND positie > '$intPositie' AND wid = '$intWebsiteID'";
  	global $dbConnectie;
  	$arrOnderdelen = $dbConnectie->getData($sql);
  	if($arrOnderdelen != null && $arrOnderdelen != false) {
		$sql2 = "UPDATE onderdeel SET positie = positie - 1 WHERE parent_id = '$intParentID' AND positie > '$intPositie' AND wid = '$intWebsiteID'";
		return $dbConnectie->setData($sql2);
  	}
  }    
  // Functie om onderdeelitem op te vragen
  function getOnderdeel( $intOnderdeelID, $intWebsiteID) {
 	$sql = "SELECT id, onderdeelid, titel, omschrijving, positie, bewerkbaar, zichtbaar, parent_id, wid FROM onderdeel WHERE wid = '$intWebsiteID' AND onderdeelid = '$intOnderdeelID'";
  	global $dbConnectie;	
 	$arrOnderdelen  = $dbConnectie->getData($sql);
 	if($arrOnderdelen != false && $arrOnderdelen != null) {
 	    $objOnderdeel = new Onderdeel();
    	$objOnderdeel->setValues($arrOnderdelen[0]);
    	return $objOnderdeel;
 	}
 	else {
 		return false;
 	}
  }
  // Functie om onderdeelitem op te vragen
  function getOnderdeelByPagina( $intOnderdeelID, $intWebsiteID ) {
 	$sql = "SELECT id, onderdeelid, titel, omschrijving, positie, bewerkbaar, zichtbaar, parent_id, wid FROM onderdeel WHERE id = '$intOnderdeelID' AND wid = '$intWebsiteID'";	
  	global $dbConnectie;	
 	$arrOnderdelen  = $dbConnectie->getData($sql);
 	if($arrOnderdelen != false && $arrOnderdelen != null) {
 	    $objOnderdeel = new Onderdeel();
    	$objOnderdeel->setValues($arrOnderdelen[0]);
    	return $objOnderdeel;
 	}
 	else {
 		return false;
 	}
  }

  // Functie om een onderdeelitem te laten zien
  function showOnderdeel( $intOnderdeelID, $intWebsiteID, $objGebRechten ) {
	$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
  	$objOnderdeel = getOnderdeel( $intOnderdeelID, $intWebsiteID );
  	echo "<h1>Onderdeel bekijken</h1><br>\n";
  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  	if($objOnderdeel != false && $objOnderdeel != null) {
  		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Onderdeel: " . $objOnderdeel->getTitel() . " (" . $objOnderdeel->getOnderdeelID() . ")</td></tr>\n";
	  	echo "<tr><td colspan=\"3\" class=\"formvakb\">Omschrijving:</td></tr>\n";
		echo "<tr><td colspan=\"3\" class=\"formvak\">".$objOnderdeel->getOmschrijving() . "<br><br></td></tr>\n";
  		echo "<tr><td class=\"formvakb\" width=\"120\">Zichtbaar:</td><td class=\"formvak\" colspan=\"2\">" . $objOnderdeel->getZichtbaar()."</td></tr>\n";
  		echo "<tr><td class=\"formvakb\">Bewerkbaar:</td><td class=\"formvak\" colspan=\"2\"> " . $objOnderdeel->getBewerkbaar() . "</td></tr>\n";
  		if($objOnderdeel->getParentID() != 0) {
  			echo "<tr><td class=\"formvakb\">Onderdeel van:</td><td class=\"formvak\" colspan=\"2\">";
	  		showHoofdOnderdelen($objOnderdeel->getParentID(), $objOnderdeel->getWebsiteID(), $objGebRechten);  			
	  		echo "</td></tr>\n";
  		}
		// checkOnderdeel als er geen parent id is of anders checkSubOnderdeel-functie wordt aangeroepen als er wel een parentid is
		$strFunctie = "check";
		if($objOnderdeel->getParentID() != 0)
			$strFunctie .= "Sub";
		$strFunctie .= "OnderdeelRechten";
				// Het onderste menu aanmaken
  		if($objGebRechten == "ja" || ($objOnderdeel->getBewerkbaar() == "ja" && $strFunctie($objGebRechten))) {
  			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?oid=".$objOnderdeel->getOnderdeelID()."&amp;actie=edit$strExtra\" class=\"linkitem\">Bewerk onderdeel</a></td>";
	  		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?oid=".$objOnderdeel->getOnderdeelID()."&amp;actie=del$strExtra\" class=\"linkitem\">Verwijder onderdeel</a></td>";
		}
		else {
			echo "<tr><td class=\"tablelinks\" colspan=\"2\">&nbsp;</td>\n";
		}
		
  		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
	  	echo "</table>\n<br><br>\n";
	  	if(getAantalHoofdOnderdelen($objOnderdeel->getParentID(), $objOnderdeel->getWebsiteID(), $objGebRechten) < 3 ) {
	  		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  			echo "<tr><td class=\"tabletitle\" colspan=\"3\">Onderliggende onderdelen</td></tr>\n";
  			showSubOnderdelen( $intOnderdeelID, $intWebsiteID, $objGebRechten, 0, "ja" );
	  		if($objGebRechten == "ja" || ($objOnderdeel->getBewerkbaar() == "ja" && checkSubOnderdeelRechten($objGebRechten))) {
	  			echo "<tr><td colspan=\"3\" class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?ido=".$objOnderdeel->getOnderdeelID()."&amp;actie=newSO$strExtra\" class=\"linkitem\">Voeg subonderdeel toe</a></td></tr>";
		  	}
		  	else {
	  			echo "<tr><td colspan=\"3\" class=\"tablelinks\">&nbsp;</td></tr>";	  		
	  		}
  			echo "</table>\n";
	  		echo "<br>\n";
	  	}
  		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Onderliggende pagina's</td></tr>\n";
  		showPaginasByOID( $intOnderdeelID, $intWebsiteID,$objGebRechten, "ja" );
  		if($objGebRechten == "ja" || ($objOnderdeel->getBewerkbaar() == "ja" && checkPaginaRechten($objGebRechten))) {
  			echo "<tr><td colspan=\"3\" class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?ido=".$objOnderdeel->getOnderdeelID()."&amp;actie=newP$strExtra\" class=\"linkitem\">Voeg pagina toe</a></tr>";
  		}
  		else {
	  		echo "<tr><td colspan=\"3\" class=\"tablelinks\">&nbsp;</td></tr>";
  		}
 	}
 	else {
  		echo "<tr><td class=\"tabletitle\">Onderdeel niet gevonden</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Het onderdeel met id-nummer '$intOnderdeelID' is niet gevonden.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
 	}
	echo "</table>\n";

  } 
  // Functie om alle Onderdelen op te vragen
  function getOnderdelen( $intWebsiteID , $strBewerkbaar = '') {
 	$sql = "SELECT id, onderdeelid, titel, omschrijving, positie, bewerkbaar, zichtbaar, parent_id, wid FROM onderdeel WHERE wid = '$intWebsiteID' AND parent_id = '0'";
 	if($strBewerkbaar != "")
 		$sql .= " AND bewerkbaar = '$strBewerkbaar' ";
 	$sql .= " ORDER BY positie";
 	
  	global $dbConnectie;	
 	return $dbConnectie->getData($sql);
  }
  // Functie om subOnderdelen op te vragen
  function getSubOnderdelen( $intParentID, $intWebsiteID, $strBewerkbaar = '' ) {
 	$sql = "SELECT id, onderdeelid, titel, omschrijving, positie, bewerkbaar, zichtbaar, parent_id, wid FROM onderdeel WHERE parent_id = '$intParentID' AND wid = '$intWebsiteID'";
	if($strBewerkbaar != "")
		$sql .= " AND bewerkbaar = '$strBewerkbaar'";
 	$sql .= " ORDER BY positie";	
  	global $dbConnectie;	
 	return $dbConnectie->getData($sql);
  }
  // Functie om subonderdelen op te vragen
  function showSubOnderdelen( $intParentID, $intWebsiteID, $objGebRechten, $intDiepte = 0, $strMessage = 'nee' ) {
	$arrSubOnderdelen = getSubOnderdelen( $intParentID, $intWebsiteID );
	$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
 	if($arrSubOnderdelen != false && $arrSubOnderdelen != null) {
 	    $intArraySize = count($arrSubOnderdelen);
   		for($i = 0; $i < $intArraySize; $i++ ) {
	 	    $objSubOnderdeel = new Onderdeel();   		
   			$objSubOnderdeel->setValues( $arrSubOnderdelen[$i] );
  			echo "<tr><td class=\"inhoudSubOnderdeel".$intDiepte."\" colspan=\"2\"><b>O:</b> <a href=\"".$_SERVER['PHP_SELF']."?oid=" . $objSubOnderdeel->getOnderdeelID() . "&amp;actie=view$strExtra\" title=\"Bekijk informatie over dit subonderdeel\">" . $objSubOnderdeel->getTitel() . "</a></td>\n";
			if($objGebRechten == "ja" || ($objSubOnderdeel->getBewerkbaar() == "ja" && checkSubOnderdeelRechten($objGebRechten))) {
				showInhoudMenu("oid", $objSubOnderdeel->getOnderdeelID(), '0', $intWebsiteID);
  				showZichtbaarKeuze("oid", $objSubOnderdeel->getOnderdeelID(), $objSubOnderdeel->getParentID() ,$objSubOnderdeel->getZichtbaar(), $intWebsiteID);
				if($i == 0 && ($i +1) == $intArraySize) {
					showUpAndDownMenu("oid", $objSubOnderdeel->getOnderdeelID(), $objSubOnderdeel->getPositie(), $objSubOnderdeel->getParentID(), "beide" , $intWebsiteID);
				}		
				elseif($i == 0) {
					showUpAndDownMenu("oid", $objSubOnderdeel->getOnderdeelID(), $objSubOnderdeel->getPositie(), $objSubOnderdeel->getParentID(), "eerste", $intWebsiteID );
				}
	  			elseif(($i +1) == $intArraySize) {
					showUpAndDownMenu("oid", $objSubOnderdeel->getOnderdeelID(), $objSubOnderdeel->getPositie(), $objSubOnderdeel->getParentID(), "laatste", $intWebsiteID);
				}
				else {
					showUpAndDownMenu("oid", $objSubOnderdeel->getOnderdeelID(), $objSubOnderdeel->getPositie(), $objSubOnderdeel->getParentID(), 'nvt', $intWebsiteID);
				}  	
  			}
 			echo "</tr>\n";

			showPaginasByOID( $objSubOnderdeel->getOnderdeelID(), $intWebsiteID, $objGebRechten );
			if($intDiepte < 2)
				showSubOnderdelen( $objSubOnderdeel->getOnderdeelID() , $intWebsiteID, $objGebRechten, $intDiepte + 1 );
  		}	    
 	}
 	elseif($strMessage == "ja") {
 		echo "<tr><td class=\"formvak\" colspan=\"2\">Er zijn geen subonderdelen aanwezig</td></tr>\n";
 	}
  }

  
  // Functie om onderdelen, subonderdelen pagina's te showen
  function showWebsiteInhoud( $intWebsiteID, $objGebRechten ) {
  	$objWebsite = getWebsite($intWebsiteID);
  	if($objWebsite == false || $objWebsite == null ) {
  		echo "<h1>Website niet gevonden</h1>";
	   echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	   echo "<tr><td class=\"tabletitle\">Geen website niet gevonden</td></tr>\n";
     	echo "<tr><td class=\"formvak\">Er is geen website gevonden met het ID-nummer '$intWebsiteID'.</td></tr>";
     	echo "<tr><td class=\"tablelinks\">&nbsp;</td></tr>";
  		echo "</table>\n";
  		echo "<br><br>"; 	
  	}
  	else {
	  	echo "<h1>Overzicht van de website '";
		if($objGebRechten == "ja")
  			echo "<a href=\"websitebeheer.php?id=$intWebsiteID&amp;actie=bw\" title=\"Ga terug naar de website-omschrijving\">";
	  	echo $objWebsite->getTitel();
		if($objGebRechten == "ja")
			echo "</a>";
  		echo "'</h1><br>\n";
	  	$arrOnderdelen = getOnderdelen( $intWebsiteID );
   	$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
	  	if($arrOnderdelen != false && $arrOnderdelen != null) {
  			$intArraySize = count($arrOnderdelen);
  			echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  			echo "<tr><td class=\"tabletitle\" colspan=\"3\">Aanwezige onderdelen en pagina's</td></tr>\n";
  			for($i = 0; $i < $intArraySize; $i++) {
	  			$objOnderdeel = new Onderdeel();  		
  				$objOnderdeel->setValues($arrOnderdelen[$i]);
	      	if($objOnderdeel->getTitel() == "")
	      		$objOnderdeel->getTitel("<i>Geen titel</i>");
  				echo "<tr><td class=\"inhoudOnderdeel\" colspan=\"2\"><b>O:</b> <a href=\"".$_SERVER['PHP_SELF']."?oid=" . $objOnderdeel->getOnderdeelID() . "&amp;actie=view$strExtra\" title=\"Bekijk informatie over dit onderdeel\">" . $objOnderdeel->getTitel() . "</a></td>\n";
				// Wordt gecheckt of men wel rechten heeft om te bewerken
				if($objGebRechten == "ja" || ($objOnderdeel->getBewerkbaar() == "ja" && checkOnderdeelRechten($objGebRechten))) {
	  				showInhoudMenu("oid", $objOnderdeel->getOnderdeelID(), '0', $intWebsiteID );
  					showZichtbaarKeuze("oid", $objOnderdeel->getOnderdeelID(), $objOnderdeel->getParentID() ,$objOnderdeel->getZichtbaar(), $intWebsiteID);
					if($i == 0 && ($i + 1) == $intArraySize) {
						showUpAndDownMenu("oid", $objOnderdeel->getOnderdeelID(), $objOnderdeel->getPositie(), $objOnderdeel->getParentID(), "beide", $intWebsiteID);
  					}
	  				elseif(($i +1) == $intArraySize) {
  						showUpAndDownMenu("oid", $objOnderdeel->getOnderdeelID(), $objOnderdeel->getPositie(), $objOnderdeel->getParentID(), "laatste", $intWebsiteID);
  					}
	  				elseif($i == 0) {
  						showUpAndDownMenu("oid", $objOnderdeel->getOnderdeelID(), $objOnderdeel->getPositie(), $objOnderdeel->getParentID(), "eerste", $intWebsiteID);
  					}
  					else {
  						showUpAndDownMenu("oid", $objOnderdeel->getOnderdeelID(), $objOnderdeel->getPositie(), $objOnderdeel->getParentID(), 'nvt', $intWebsiteID);	
	  				}				
				}
 				echo "</tr>\n";
  				showPaginasByOID( $objOnderdeel->getOnderdeelID(), $intWebsiteID, $objGebRechten );
  				showSubOnderdelen( $objOnderdeel->getOnderdeelID() , $intWebsiteID, $objGebRechten );
  			}
  		// Wordt gecheckt of men wel rechten heeft om nieuwe onderdelen toe te voegen
  			if(checkOnderdeelRechten($objGebRechten)) {
	  			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=newO".$strExtra;
	  			echo "\" class=\"linkitem\">Nieuw onderdeel</a></td>";
  			}
	  		else
	  			echo "<tr><td class=\"tablelinks\">&nbsp;</td>";
			// Wordt gecheckt of men wel rechten heeft om nieuwe subonderdelen toe te voegen
	  		if(checkSubOnderdeelRechten($objGebRechten)) {
	  			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=newSO".$strExtra;
	  			echo "\" class=\"linkitem\">Nieuw subonderdeel</a></td>";	  		
	  		}
	  		else
	  			echo "<td class=\"tablelinks\">&nbsp;</td>";
			// Wordt gecheckt of men wel rechten heeft om nieuwe pagina's toe te voegen
  			if(checkPaginaRechten( $objGebRechten )) {
				echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=newP".$strExtra;
	  			echo "\" class=\"linkitem\">Nieuwe pagina</a></td></tr>";	
  			}
	  		else
	  			echo "<td class=\"tablelinks\">&nbsp;</td></tr>";
  			echo "</table>\n";
  		} 		
	  	else {
	   	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	    	echo "<tr><td class=\"tabletitle\">Onderdelen en pagina's niet aanwezig</td></tr>\n";
     		echo "<tr><td class=\"formvak\">Er zijn geen onderdelen aanwezig</td></tr>";
     		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=newO".$strExtra;
     		echo "\" class=\"linkitem\">Voeg een onderdeel toe</a></td></tr>";
  			echo "</table>\n";
  			echo "<br><br>";     	
  		}
  	 }
  }
  // Functie om onderdelen in een select-menu te laten zien
  function showOnderdelenSelectMenu( $intWebsiteID, $objGebRechten, $booSub = false, $intSelected = '' ) {
	$arrOnderdelen = getOnderdelen( $intWebsiteID );
	if($arrOnderdelen != false && $arrOnderdelen != null) {
		$intArraySize = count($arrOnderdelen);
		echo "<select name=\"parent_id\" class=\"groot\">\n";
		for($i = 0; $i < $intArraySize; $i++ ) {
			$objOnderdeel = new Onderdeel();		
			$objOnderdeel->setValues($arrOnderdelen[$i]);
			if($objOnderdeel->getBewerkbaar() != "ja" && $objGebRechten != "ja") {
				echo "<optgroup label=\"".$objOnderdeel->getTitel()." (Niet mogelijk)\">\n";
				$booOptGroup = true;
			}
			else {
				echo "<option value=\"".$objOnderdeel->getOnderdeelID()."\"";
				if($intSelected == $objOnderdeel->getOnderdeelID() && $intSelected != '') {
					echo " SELECTED";
				}
				echo ">".$objOnderdeel->getTitel()."\n";
			}
			showSubOnderdelenSelectMenu( $objOnderdeel->getOnderdeelID(), $intWebsiteID, 0 , $booSub, $intSelected );
			if(isset($booOptGroup) && $booOptGroup == true) {
				echo "</optgroup>\n";
				$booOptGroup = false;
			}
		}
		echo "</select>";
	}
  }
  // Functie om subonderdelen te laten zien
  function showSubOnderdelenSelectMenu( $intParentID, $intWebsiteID, $intDiepte, $booSub, $intSelected = '') {
	$intMax = 2;
	if($booSub == true)
		$intMax = 1;
	if($intDiepte >= $intMax) {
		return false;
	}
	$arrSubOnderdelen = getSubOnderdelen( $intParentID, $intWebsiteID, "ja" );
	if($arrSubOnderdelen != false && $arrSubOnderdelen != null) {
		$intArraySize = count($arrSubOnderdelen);
		for($i = 0; $i < $intArraySize; $i++ ) {
			$objOnderdeel = new Onderdeel();		
			$objOnderdeel->setValues($arrSubOnderdelen[$i]);
			echo "<option class=\"subOnderdeelSelect".$intDiepte."\" value=\"".$objOnderdeel->getOnderdeelID()."\"";
			if($intSelected == $objOnderdeel->getOnderdeelID() && $intSelected != '') {
				echo " SELECTED";
			}
			echo ">".$objOnderdeel->getTitel()."\n";
			if( $intDiepte < 2)
				showSubOnderdelenSelectMenu($objOnderdeel->getOnderdeelID(),  $intWebsiteID, $intDiepte + 1, $booSub, $intSelected );
		}
	}
  }
 // Functie om formulier te maken voor Onderdeel toevoegen
 function addOnderdeelForm( $intWebsiteID, $objGebRechten, $strSubOnderdeel = 'nee', $intSelectedOID = 0) {
	echo "<h1>Onderdeel toevoegen</h1>\n";
 	if($intWebsiteID == "" || !isset($intWebsiteID)) {
	  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Geen website opgegeven</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Er is geen website opgegeven.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\">&nbsp;</td></tr>";
	  	echo "</table>\n";
  	}
  	else {
  		$strExtra = checkBeheerder( $objGebRechten, $intWebsiteID );
  		if($strSubOnderdeel == "ja") {
  			$strTitel = "Subonderdeel toevoegen";
  			$strTekst = "Via het onderstaand formulier is het mogelijk om een subonderdeel aan uw website toe te voegen. ";
  			$strFunctie = "checkSubOnderdeelRechten";
  		}
  		else {
  			$strTitel = "Onderdeel toevoegen";
  			$strTekst = "Via het onderstaand formulier is het mogelijk om een onderdeel aan uw website toe te voegen. ";
  			$strFunctie = "checkOnderdeelRechten";
  		}
	  	$arrOnderdelen = getOnderdelen( $intWebsiteID );
		if(($arrOnderdelen == null || $arrOnderdelen == false) && $strSubOnderdeel == "ja") {
		  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	  		echo "<tr><td class=\"tabletitle\">Subonderdeel toevoegen onmogelijk</td></tr>\n";
  			echo "<tr><td class=\"formvak\">Het is niet mogelijk om subonderdelen aan te maken, omdat er nog geen onderdelen aanwezig zijn.</td></tr>\n";
  			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=newO".$strExtra;
  			echo "\" class=\"linkitem\">Voeg onderdeel toe</a></td></tr>";
		  	echo "</table>\n";
  		}
		elseif($strFunctie($objGebRechten)) {
	 		echo $strTekst."<br><br>\n";
  			echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" name=\"addOnderdeelForm\">\n";
	  		if($objGebRechten == "ja")
	  			echo "<input type=\"hidden\" name=\"wid\" value=\"".$intWebsiteID."\">\n";
  			echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		  	echo "<tr><td class=\"tabletitle\" colspan=\"2\">".$strTitel."</td></tr>\n";
		  	echo "<tr><td class=\"formvakb\">Titel:</td><td class=\"formvak\"><input type=\"text\" name=\"titel\"></td></tr>\n";
	  		if($strSubOnderdeel == 'ja') {
  				echo "<tr><td class=\"formvakb\">Onderdeel van:</td><td class=\"formvak\">";
			  	if($intSelectedOID != 0) {
	  				showOnderdelenSelectMenu( $intWebsiteID, $objGebRechten, true, $intSelectedOID );
			  	}
			  	else {
				  	showOnderdelenSelectMenu( $intWebsiteID, $objGebRechten, true);
		  		}
			  	echo "</td></tr>\n";
			}
		  	echo "<tr><td class=\"formvakb\">Omschrijving:</td><td class=\"formvak\"><textarea name=\"omschrijving\" cols=30 rows=6></textarea></td></tr>\n";
	  		echo "<tr><td class=\"formvakb\">Zichtbaar:</td><td class=\"formvak\">".getSelectMenu("zichtbaar","nee")."</td></tr>\n";
  			if($objGebRechten == "ja")
		  		echo "<tr><td class=\"formvakb\">Bewerkbaar:</td><td class=\"formvak\">".getSelectMenu("bewerkbaar","nee")."</td></tr>\n";
	  		echo "<tr><td class=\"buttonvak\" colspan=\"2\"><input type=\"submit\" name=\"addOnderdeelKnop\" value=\"".$strTitel."\" class=\"button\"></td></tr>\n";
  			echo "<tr>";
		  	if($intSelectedOID != 0) {
				echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		  		if($objGebRechten == "ja")
		  			echo "?wid=".$intWebsiteID;
				echo "&amp;actie=view&oid=$intSelectedOID\" class=\"linkitem\">Bekijk (sub)onderdeel</a></td>";
		  	}
	  	  	else {
  		  		echo "<td class=\"tablelinks\">&nbsp;</td>";
	  	  	}
  			echo "<td class=\"tablelinks\" colspan=\"2\"><a href=\"".$_SERVER['PHP_SELF'];
	  		if($objGebRechten == "ja")
	  			echo "?wid=".$intWebsiteID;
  			echo "\" class=\"linkitem\">Website overzicht</a></td></tr>";
		    echo "</table>\n";
		}
		else {
		  	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	  		echo "<tr><td class=\"tabletitle\">Geen toegang</td></tr>\n";
  			echo "<tr><td class=\"formvak\">Je hebt geen toegang tot dit gedeelte.</td></tr>\n";
  			echo "<tr><td class=\"tablelinks\">&nbsp;</td></tr>";
		  	echo "</table>\n";
		}
     }
 }   
 // Functie om de pagina op te bouwen om onderdelen te bewerken
 function editOnderdeelForm( $intOnderdeelID, $intWebsiteID, $objGebRechten ) {
  	echo "<h1>Bewerk onderdeelinformatie</h1><br>\n";
  	$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
  	$objOnderdeel = getOnderdeel($intOnderdeelID, $intWebsiteID);
	if($objOnderdeel != false || $objOnderdeel != null) {
	  	$intParentID = $objOnderdeel->getParentID();
  		$strFunctie = "check";
	  	if($intParentID != 0)
  			$strFunctie .= "Sub";
	  	$strFunctie .= "OnderdeelRechten";		
	}
	else {
		$strFunctie = "checkOnderdeelRechten";
	}

  	
	if($objGebRechten != "ja" && ($objOnderdeel != false && $objOnderdeel != null) && ($objOnderdeel->getBewerkbaar() == "nee" || !$strFunctie($objGebRechten))) {
  		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Geen toegang</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Je hebt geen rechten om dit onderdeel te bewerken.</td></tr>\n";
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
  	elseif($objOnderdeel != false && $objOnderdeel != null) {
  		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" name=\"editOnderdeelForm\">\n";
  		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Onderdeel: ".fixData($objOnderdeel->getTitel())."</td></tr>\n";
  		echo "<tr><td class=\"formvakb\">Titel:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"titel\" value=\"".fixData($objOnderdeel->getTitel())."\"></td></tr>\n";
  		echo "<tr><td class=\"formvakb\">Omschrijving:</td><td colspan=\"2\" class=\"formvak\"><textarea name=\"omschrijving\" cols=30 rows=6>".fixData($objOnderdeel->getOmschrijving(), "tekstvak")."</textarea></td></tr>\n";
  		echo "<tr><td class=\"formvakb\">Zichtbaar:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu("zichtbaar",$objOnderdeel->getZichtbaar())."</td></tr>\n";
	 	if($objGebRechten == "ja")
 	 		echo "<tr><td class=\"formvakb\">Bewerkbaar:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu("bewerkbaar",$objOnderdeel->getBewerkbaar())."</td></tr>\n";
  		echo "<tr><td class=\"buttonvak\" colspan=\"3\"><input type=\"submit\" name=\"editOnderdeelKnop\" value=\"Onderdeel bewerken\" class=\"button\"></td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?oid=".$objOnderdeel->getOnderdeelID()."&amp;actie=view$strExtra\" class=\"linkitem\">Bekijk onderdeel</a></td>";
  		echo "\n<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?oid=".$objOnderdeel->getOnderdeelID()."&amp;actie=del$strExtra\" class=\"linkitem\">Verwijder onderdeel</a></td>\n";
  		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
  		echo "</table>\n";
	 	if($objGebRechten == "ja")
	 		echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID\">\n";
  		echo "<input type=\"hidden\" name=\"oid\" value=\"$intOnderdeelID\">\n</form>\n";
  	}
  	else {
  		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Onderdeel niet gevonden</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Het onderdeel met id-nummer '$intOnderdeelID' is niet gevonden.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
  		echo "</table>\n";
  	}
 }
  // Functie om formulier te maken om onderdeel te verwijderen
  function delOnderdeelForm( $intOnderdeelID, $intWebsiteID, $objGebRechten ) {
  	$objOnderdeel = getOnderdeel($intOnderdeelID, $intWebsiteID);
  	$strExtra = checkBeheerder($objGebRechten, $intWebsiteID);
	if($objOnderdeel != false || $objOnderdeel != null) {
	  	$intParentID = $objOnderdeel->getParentID();
  		$strFunctie = "check";
	  	if($intParentID != 0)
  			$strFunctie .= "Sub";
	  	$strFunctie .= "OnderdeelRechten";		
	}
	else {
		$strFunctie = "checkOnderdeelRechten";
	}
	echo "<h1>Onderdeel verwijderen</h1><br>\n";
	if($objGebRechten != "ja" && ($objOnderdeel != false && $objOnderdeel != null) && (!$strFunctie($objGebRechten) || $objOnderdeel->getBewerkbaar() == "nee")) {
  		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Geen toegang</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Je hebt geen rechten om dit onderdeel te verwijderen.</td></tr>\n";
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
	elseif($objOnderdeel != false && $objOnderdeel != null) {
		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" name=\"delOnderdeelForm\">\n";
		echo "<input type=\"hidden\" name=\"oid\" value=\"$intOnderdeelID\">\n";
	 	if($objGebRechten == "ja")
	 		echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID\">\n";
  		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Onderdeel verwijderen</td></tr>\n";
		echo "<tr><td colspan=\"3\" class=\"formvak\">Hieronder wordt om een bevestiging gevraagd om het onderdeel met het nummer '$intOnderdeelID', en de eventuele bijbehorende pagina's en subonderdelen, te verwijderen.</td></tr>\n";
		echo "<tr><td  class=\"buttonvak\" colspan=\"2\"><input type=\"reset\" name=\"cancelDelOnderdeelKnop\" value=\"Onderdeel niet verwijderen\" onclick=\"history.back()\" class=\"button\"></td><td class=\"buttonvak\"><input type=\"submit\" name=\"delOnderdeelKnop\" value=\"Onderdeel verwijderen\" class=\"button\">\n<br><br>\n";
		echo "</td></tr>\n";
		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?oid=".$intOnderdeelID."&amp;actie=view$strExtra\" class=\"linkitem\">Bekijk onderdeel</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?oid=".$intOnderdeelID."&amp;actie=edit$strExtra\" class=\"linkitem\">Bewerk onderdeel</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
		echo "</table>\n";
		echo "</form>\n";
	}
  	else {
  		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
  		echo "<tr><td class=\"tabletitle\">Onderdeel niet gevonden</td></tr>\n";
  		echo "<tr><td class=\"formvak\">Het onderdeel met id-nummer '$intOnderdeelID' is niet gevonden.</td></tr>\n";
  		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
		if($objGebRechten == "ja")
	  		echo "?wid=$intWebsiteID";
  		echo "\" class=\"linkitem\">Overzicht website</a></td></tr>";
  		echo "</table>\n";
  	}
  }
  // Functie om te checken of er wel rechten voor onderdelen zijn
  function checkOnderdeelRechten( $objGebRechten ) {
	if($objGebRechten == false || $objGebRechten == null)
		return false;
	elseif($objGebRechten == "ja")
		return true;
  	elseif($objGebRechten->getOnderdeelRecht() == "ja")
		return true;
	else
		return false;
  }
  // Functie om te checken of er wel rechten voor onderdelen zijn
  function checkSubOnderdeelRechten( $objGebRechten ) {
	if($objGebRechten == false || $objGebRechten == null)
		return false;
	elseif($objGebRechten == "ja")
		return true;
  	elseif($objGebRechten->getSubOnderdeelRecht() == "ja")
		return true;
	else
		return false;
  }
  // Functie om te checken of er parentID's zijn
  // Input is de parentID van een onderdeel
  function showHoofdOnderdelen( $intParentID, $intWebsiteID, $objGebRechten ) {
   $strExtra = checkBeheerder( $objGebRechten, $intWebsiteID);
	// Controleert de parent_id's
	for($intTeller = 0; $intParentID != 0; $intTeller++) {
		$objOnderdeel = getOnderdeel($intParentID, $intWebsiteID);
		$intArray[$intTeller] = $intParentID;
		$intParentID = getHoofdOnderdeelID($intParentID, $intWebsiteID);
	}
	// Als er een array bestaat, dan wordt totaalwaarde geteld
	// Anders false gereturned
	if(isset($intArray)) {
		$intArraySize = count($intArray);
	}
	else {
		return false;
	}
	// Teller om alles te laten zien op het scherm
	for($intTeller = 1; $intTeller <= $intArraySize; $intTeller++ ) {
		$objOnderdeel = getOnderdeel( $intArray[$intArraySize - $intTeller], $intWebsiteID);
		if($objOnderdeel != false && $objOnderdeel != null) {
			echo "<a href=\"inhoudbeheer.php?oid=".$objOnderdeel->getOnderdeelID()."&amp;actie=view".$strExtra;
			echo "\">".$objOnderdeel->getTitel()."</a>\n";			

			if($intArraySize != $intTeller)
				echo "-->";
		}
	}
  }
  // Functie om parentID op te vragen
  function getHoofdOnderdeelID( $intOnderdeelID, $intWebsiteID ) {
  	 $sql = "SELECT parent_id FROM onderdeel WHERE onderdeelid = '$intOnderdeelID' AND wid = '$intWebsiteID'";
  	 global $dbConnectie;
  	 $arrResult = $dbConnectie->getData($sql);
  	 if($arrResult == false || $arrResult == null) {
  	 	return false;
  	 }
  	 else {
  	 	$objOnderdeel = new Onderdeel();
  	 	$objOnderdeel->setValues($arrResult[0]);
  	 	return $objOnderdeel->getParentID();
  	 }
  }
 // Functie om het aantal bovenliggende onderdelen te checken  
 function getAantalHoofdOnderdelen( $intParentID, $intWebsiteID ) {
	for($intTeller = 0; $intParentID != 0; $intTeller++) {
		$objOnderdeel = getOnderdeel($intParentID, $intWebsiteID);
		$intArray[$intTeller] = $intParentID;
		$intParentID = getHoofdOnderdeelID($intParentID, $intWebsiteID);
	}
	// Als er een array bestaat, dan wordt totaalwaarde geteld en gereturned
	// Anders false gereturned
	if(isset($intArray)) {
		$intArraySize = count($intArray);
		return $intArraySize;
	}
	else {
		return false;
	}
 	
 }
?> 