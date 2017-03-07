<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Bestandsfuncties.php
 * Beschrijving: De functies mbt Bestanden
 */

 // Functie om bestanden te checken
 function checkBestandsNaam( $objBestand, $intWebsiteID ) {
	$sql = "SELECT * FROM bestand WHERE bestandsnaam = '".$objBestand->getBestandsNaam()."' AND wid = '$intWebsiteID'";
	global $dbConnectie;
	$arrBestanden = $dbConnectie->getData($sql);
	if($arrBestanden != null && $arrBestanden != false) return true;
	else {
		if(is_file($objBestand->getLocatieDir()."/".$objBestand->getBestandsNaam())) return true;
		else return false;
	}
 }
 // Functie om bestanden up te loaden
 function uploadBestand( $objBestand ) {
	return move_uploaded_file($_FILES['bestand']['tmp_name'], $objBestand->getLocatieDir()."/".$objBestand->getBestandsNaam() ); }
 
 // Functie om een bestand in te voeren
 function insertBestand( Bestand $objBestand ) {
 	$sql = "INSERT INTO bestand (bestandid, bestandsnaam, locatie, omschrijving, datum, wid) VALUES ";
 	$sql .= "( '".$objBestand->getBestandsID()."', '".$objBestand->getBestandsNaam()."','".$objBestand->getLocatie()."',";
 	$sql .= " '".$objBestand->getOmschrijving()."', '".$objBestand->getDatum()."', '".$objBestand->getWebsiteID()."')";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
 }
 // Functie om een bestand uptedaten
 function updateBestand( Bestand $objBestand ) {
 	$sql = "UPDATE bestand SET omschrijving = '".$objBestand->getOmschrijving()."' WHERE bestandid = '".$objBestand->getBestandsID()."'";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql); 	
 } 
 // Functie om een bestand te verwijderen
 function delBestand( $objBestand ) {
 	if(unlink(getHuidigeDir().$objBestand->getLocatie() ."/". $objBestand->getBestandsNaam() )) {
	 	$sql = "DELETE FROM bestand WHERE bestandid = '".$objBestand->getBestandsID()."' AND wid = '".$objBestand->getWebsiteID()."'";
 		global $dbConnectie;
 		return $dbConnectie->setData($sql);
 	}
 	else { return false; }
 }
 // Functie om een bestand op te vragen
 function getBestand( $intBestandID, $intWebsiteID ) {
 	$sql = "SELECT * FROM bestand WHERE bestandid = '$intBestandID' AND wid = '$intWebsiteID'";
 	global $dbConnectie;
 	$arrBestanden = $dbConnectie->getData($sql);
 	if($arrBestanden != null && $arrBestanden != false) {
	 	$objBestand = new Bestand();
 		$objBestand->setValues($arrBestanden[0]);
	 	return $objBestand;
 	}
 	else { return $arrBestanden; }

 }
 // Functie om alle bestanden op te vragen
 function getBestanden( $intWebsiteID, $intVan = 0, $intLimit = 50 ) {
 	$sql = "SELECT * FROM bestand WHERE wid = '$intWebsiteID' ";
 	if($intVan != "-1" && $intLimit != "-1") $sql .= "LIMIT $intVan, $intLimit ";
 	global $dbConnectie;
 	$arrBestanden = $dbConnectie->getData($sql);
 	return $arrBestanden;
 }
 // Functie om alle afbeeldingen op te vragen
 function getAfbBestanden( $intWebsiteID ) {
 	$sql = "SELECT * FROM bestand WHERE wid = '$intWebsiteID' AND (bestandsnaam LIKE '%.gif' OR bestandsnaam LIKE ";
 	$sql .= " '%.png' OR bestandsnaam LIKE '%.jpg' OR bestandsnaam LIKE '%.jpeg' OR bestandsnaam LIKE '%.bmp' )";
 	global $dbConnectie;
 	$arrBestanden = $dbConnectie->getData($sql);
 	return $arrBestanden;
 }
 // Functie om alle afbeeldingen op te vragen
 function getFlashBestanden( $intWebsiteID ) {
 	$sql = "SELECT * FROM bestand WHERE wid = '$intWebsiteID' AND (bestandsnaam LIKE '%.swf')";
 	global $dbConnectie;
 	$arrBestanden = $dbConnectie->getData($sql);
 	return $arrBestanden;
 }
 // Functie om alle bestanden op te vragen
 function getTotaalBestanden( $intWebsiteID) {
 	$sql = "SELECT * FROM bestand WHERE wid = '$intWebsiteID' ";
 	global $dbConnectie;
 	$arrBestanden = $dbConnectie->getData($sql);
 	return count($arrBestanden);
 }
 // Functie om overzicht te laten zien met aantal bestanden erbij function showWebsiteBestandOverzicht( $intVan = 0, $intAantal = 25) {
	$arrWebsites = getWebsiteOverzicht( $intVan, $intAantal);
    echo "<h1>Bekijk websitesoverzicht voor bestanden</h1>\n";	
   	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
    if($arrWebsites == false || $arrWebsites == null) {
    		echo "<tr><td colspan=\"3\" class=\"tabletitle\">Websitesoverzicht</td></tr>\n";
    		echo "<tr><td colspan=\"3\" class=\"formvak\">Er zijn geen websites (meer) aanwezig.</td></tr>\n";
    		echo "<tr><td colspan=\"3\" class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=aw\" class=\"linkitem\">Voeg een website toe</a></a></td></tr>";    	
    }
    else {
    	$intArraySize = count($arrWebsites);
    	echo "<tr><td colspan=\"4\" class=\"tabletitle\">Websitesoverzicht</td></tr>\n";
    	echo "<tr><td class=\"tableinfo\">ID:</td>\n<td class=\"tableinfo\">Titel:</td>\n<td class=\"tableinfo\" style=\"width: 24%\">Aantal bestanden:</td>\n<td class=\"tableinfo\" style=\"width: 10%\">Opties:</td>\n</tr>\n";
    	for( $i = 0; $i < $intArraySize; $i++ ) {
    		$objWebsite = new Website();
    		$objWebsite->setValues($arrWebsites[$i]);
			$intAantalBestanden = getTotaalBestanden($objWebsite->getWebsiteID());
    		echo "<tr><td class=\"formvak\">".$objWebsite->getWebsiteID()."</td>\n";
    		echo "<td class=\"formvak\"><a href=\"".$_SERVER['PHP_SELF']."?wid=".$objWebsite->getWebsiteID()."\" title=\"Bekijk bestandsoverzicht van deze website\">".fixData($objWebsite->getTitel())."</a></td>\n";
    		echo "<td class=\"formvak\" style=\"text-align: center;\">$intAantalBestanden</td>\n";
    		echo "<td class=\"formvak\">".getWebsitesBestandenAdminMenu($objWebsite->getWebsiteID())."</td></tr>\n";
  
    	}
    	echo "<tr><td colspan=\"4\" class=\"tablelinks\">&nbsp;</td></tr>\n";
    }
    	echo "</table>\n";
}
 // Functie om bestandoverzicht te laten zien
 function showBestandOverzicht( $intWebsiteID, $objGebRechten, $intVan = 0, $intLimit = 20  ) {
 	$arrBestanden = getBestanden( $intWebsiteID, $intVan, $intLimit	);
 	$objWebsite = getWebsite( $intWebsiteID );
  	if($objWebsite == false || $objWebsite == null || $intWebsiteID == null || $intWebsiteID == '') {
  		echo "<h1>Overzicht van bestanden</h1>\n";
	   echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	   echo "<tr><td class=\"tabletitle\">Geen website niet gevonden</td></tr>\n";
     	echo "<tr><td class=\"formvak\">Er is geen website gevonden met het ID-nummer '$intWebsiteID'.</td></tr>\n";
     	echo "<tr><td class=\"tablelinks\">&nbsp;</td></tr>\n";
  		echo "</table>\n";
  	}
  	else {
	 	echo "<h1>Overzicht van bestanden bij '";
 		if($_SESSION['login'] == "admin")
			if($objGebRechten == "ja")
  				echo "<a href=\"websitebeheer.php?id=$intWebsiteID&actie=bw\" title=\"Bekijk websiteinformatie\">";
		  	echo $objWebsite->getTitel();
			if($objGebRechten == "ja")
				echo "</a>";
 		echo "'</h1><br>\n";
		
 		if($arrBestanden == false || $arrBestanden == null) {
 			echo "<table cellspacing=\"0\" class=\"overzicht\">\n";
 			echo "<tr><td class=\"tabletitle\" colspan=\"3\">Bestandenoverzicht</td></tr>\n";
   	  	echo "<tr><td class=\"formvak\">Er zijn geen bestanden (meer) aanwezig.</td></tr>\n";
   	  	echo "<tr><td class=\"tablelinks\">";
   	  	if($objGebRechten == "ja"  || ($objGebRechten->getUploadRecht() == "ja" && $objGebRechten->getExtensies() != "")) {
   	  		echo "<a href=\"".$_SERVER['PHP_SELF']."?actie=new";
   	  		if($objGebRechten == "ja")
   	  			echo "&wid=$intWebsiteID";
   	  		echo "\" class=\"linkitem\">Voeg bestand toe</a>";
   	  	}
   	  	echo "&nbsp;</td></tr>\n";
  			echo "</table>\n";
 		}
 		else {
 			$strExtra = checkBeheerder( $objGebRechten, $intWebsiteID);
 			$intArraySize = count($arrBestanden);
 			$objBestand = new Bestand();
 			$strTotaal = getTotaalBestanden($intWebsiteID);
 			echo "<table cellspacing=\"0\" class=\"overzicht\">\n";
 			echo "<tr><td class=\"tabletitle\" colspan=\"4\">Bestandenoverzicht</td></tr>\n";
 			echo "<tr><td class=\"tableinfo\" style=\"width: 15%;\">ID:</td><td class=\"tableinfo\">Bestandsnaam:</td><td class=\"tableinfo\" style=\"width: 18%;\">Opties:</td></tr>\n";
 			for($i = 0; $i < $intArraySize; $i++) {
 				$objBestand->setValues( $arrBestanden[$i] );
 				echo "<tr><td class=\"formvak\">" . $objBestand->getBestandsID() . "</td>\n";		
 				echo "<td class=\"formvak\"><a href=\"".$_SERVER['PHP_SELF']."?actie=view&bestandid=".$objBestand->getBestandsID().$strExtra;
 				echo "\">".$objBestand->getBestandsNaam()."</a></td>\n";
 				if($objGebRechten == "ja" || $objGebRechten->getVerwijderRecht() == "ja")
	 				echo "<td class=\"formvak\">".getBestandenAdminMenu($objBestand->getBestandsID(), $intWebsiteID)."</td></tr>\n";
	 			else
		 			echo "<td class=\"formvak\"><i>Geen</i></td></tr>\n";
 			}
 			echo "<tr><td class=\"tablelinks\">";
 			if($intVan != 0) 
 				echo "<a href=\"".$_SERVER['PHP_SELF']."?van=".($intVan-$intLimit).$strExtra."\" class=\"linkitem\">&lt;-- Vorige </a>";
 			else
 				echo "&nbsp;";
 			echo "</td>\n<td class=\"tablelinks\">";
 			if($objGebRechten == "ja" || $objGebRechten->getUploadRecht() == "ja" && $objGebRechten->getExtensies() != "") {
	 			echo "<a href=\"".$_SERVER['PHP_SELF']."?actie=new";
  		  		if($objGebRechten == "ja")
  		  			echo "&wid=$intWebsiteID";
  		  		echo "\" class=\"linkitem\">Voeg bestand toe</a>";
  		  	}
 			echo "&nbsp;</td><td class=\"tablelinks\">";
 			if($strTotaal > ($intVan + $intLimit))
 				echo "<a href=\"".$_SERVER['PHP_SELF']."?van=".($intVan+$intLimit).$strExtra."\" class=\"linkitem\">Volgende --&gt;</a>";
 			echo "&nbsp;</td></tr>";
 			echo "</table>\n";
 		}
 	}
 }
 // Functie om informatie te bekijken over een bestand 
 function showBestand( $intBestandID, $intWebsiteID, $objGebRechten ) {
	global $strCMSURL;
	global $strCMSDir;
 	$objWebsite = getWebsite($intWebsiteID);
 	$objBestand = getBestand( $intBestandID, $intWebsiteID);
  	echo "<h1>Bestand bekijken</h1>\n";
   echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	if($objWebsite == null || $objWebsite == false) {
	   echo "<tr><td class=\"tabletitle\">Website niet gevonden</td></tr>\n";
     	echo "<tr><td class=\"formvak\">Er is geen website gevonden met het ID-nummer '$intWebsiteID'.</td></tr>\n";
     	echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
     	if($objGebRechten == "ja")
     		echo "?wid=".$intWebsiteID;
     	echo "\" class=\"linkitem\">Overzicht bestanden</a></td></tr>\n";
 	}
 	elseif($objBestand == null || $objBestand == false) {
	   echo "<tr><td class=\"tabletitle\">Bestand niet gevonden</td></tr>\n";
     	echo "<tr><td class=\"formvak\">Er is geen bestand in de database gevonden met het ID-nummer '$intBestandID'.</td></tr>\n";
     	echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
     	if($objGebRechten == "ja")
     		echo "?wid=".$intWebsiteID;
     	echo "\" class=\"linkitem\">Overzicht bestanden</a></td></tr>\n";
 	}
 	else {
 		$objBestand->setLocatieURL( $strCMSURL.$strCMSDir.$objBestand->getLocatie()."/".$objBestand->getBestandsNaam());
		$strToevoeging = checkBeheerder( $objGebRechten, $intWebsiteID );
		if(file_exists($objBestand->getLocatie()."/".$objBestand->getBestandsNaam())) {
		   echo "<tr><td class=\"tabletitle\" colspan=\"3\">Bestand: ".fixData($objBestand->getBestandsNaam())."</td></tr>\n";
	     	echo "<tr><td class=\"formvakb\" style=\"width: 25%\">Bestandsnaam:</td><td class=\"formvak\" colspan=\"2\">";
	     	echo "<a href=\"".$objBestand->getLocatieURL()."\" target=\"_blank\">".fixData($objBestand->getBestandsNaam())."</a></td></tr>\n";
			if($objGebRechten == "ja") {
		     	echo "<tr><td class=\"formvakb\">Map:</td><td class=\"formvak\" colspan=\"2\">";
		     	echo "<a href=\"".$strCMSURL.$strCMSDir.$objBestand->getLocatie()."\" target=\"_blank\">/".$objBestand->getLocatie()."</a>";
		     	echo "</td></tr>\n";
	     	}
	     	echo "<tr><td class=\"formvakb\">Toegevoegd op:</td><td class=\"formvak\" colspan=\"2\">";
	     	DisplayConvertedDatumTijd($objBestand->getDatum());
	     	echo "</td></tr>\n";
	     	echo "<tr><td class=\"formvakb\">Grootte:</td><td class=\"formvak\">".fmtsize(filesize($objBestand->getLocatie()."/".$objBestand->getBestandsNaam()), 3)."</td></tr>\n";
	     	echo "<tr><td class=\"formvakb\" colspan=\"3\">Omschrijving:</td></tr>\n";
	     	echo "<tr><td class=\"formvak\" colspan=\"3\">".fixData($objBestand->getOmschrijving())."</td></tr>\n";
	     	echo "<tr><td class=\"tablelinks\">";
			if($objGebRechten == "ja" || $objGebRechten->getVerwijderRecht() == "ja")
		     	echo "<a href=\"".$_SERVER['PHP_SELF']."?actie=edit&amp;bestandid=".$intBestandID.$strToevoeging."\" class=\"linkitem\">Bewerk bestand</a>";
		   echo "&nbsp;</td>\n<td class=\"tablelinks\">";
			if($objGebRechten == "ja" || $objGebRechten->getVerwijderRecht() == "ja")			if($objGebRechten == "ja" || $objGebRechten->getVerwijderRecht() == "ja")
		     	echo "<a href=\"".$_SERVER['PHP_SELF']."?actie=del&amp;bestandid=".$intBestandID.$strToevoeging."\" class=\"linkitem\">Verwijder bestand</a>";
			echo "&nbsp;</td>\n<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
	     	if($objGebRechten == "ja")
	     		echo "?wid=".$intWebsiteID;
	     	echo "\" class=\"linkitem\">Overzicht bestanden</a></td>";
	     	echo "</tr>\n";
	 	}
	 	else {
		   echo "<tr><td class=\"tabletitle\">Bestand niet gevonden op de webserver</td></tr>\n";
   	  	echo "<tr><td class=\"formvak\">Er is geen bestand gevonden met de naam ".$objBestand->getBestandsNaam()." op de webserver.</td></tr>\n";
   	  	echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
   	  	if($objGebRechten == "ja")
   	  		echo "?wid=".$intWebsiteID;
	     	echo "\" class=\"linkitem\">Overzicht bestanden</a></td></tr>\n";
	 	}
	}
	echo "</table>\n";
 } 
 // Functie om het menu aan te maken, wat in het websitesbestandenoverzicht moet staan
function getWebsitesBestandenAdminMenu( $intWebsiteID ) {
	$strMenu = "<a href=\"".$_SERVER['PHP_SELF']."?wid=$intWebsiteID\" title=\"Bekijk bestanden\"><img src=\"images/editinhoudicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Bekijk bestanden\"></a> \n";
	$strMenu .= "<a href=\"".$_SERVER['PHP_SELF']."?actie=new&wid=$intWebsiteID\" title=\"Voeg bestand toe\"><img src=\"images/editicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Voeg bestand toe\"></a>\n";
	return $strMenu;
}
 // Functie om het menu aan te maken, wat in het websitesbestandenoverzicht moet staan
function getBestandenAdminMenu( $intBestandID, $intWebsiteID ) {
	global $objLIGebRechten;
	$strExtra = checkBeheerder( $objLIGebRechten, $intWebsiteID);
	$strMenu = "<a href=\"".$_SERVER['PHP_SELF']."?actie=edit&bestandid=$intBestandID$strExtra\" title=\"Bewerk bestand\"><img src=\"images/editicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Bewerk bestand\"></a> \n";
	$strMenu .= "<a href=\"".$_SERVER['PHP_SELF']."?actie=del&bestandid=$intBestandID$strExtra\" title=\"Verwijder bestand\"><img src=\"images/deleteicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Verwijder bestand\"></a>\n";
	return $strMenu;
}
// Formulier om toe te voegen 
function addBestandForm( $intWebsiteID, $objGebRechten ) {
	$objWebsite = getWebsite( $intWebsiteID );
	echo "<h1>Bestand toevoegen</h1>";	
	if($objWebsite == false || $objWebsite == null) {
	   echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	   echo "<tr><td class=\"tabletitle\">Geen website niet gevonden</td></tr>\n";
     	echo "<tr><td class=\"formvak\">Er is geen website gevonden met het ID-nummer '$intWebsiteID'.</td></tr>\n";
     	echo "<tr><td class=\"tablelinks\">&nbsp;</td></tr>";
  		echo "</table>\n";
	}
	elseif($objGebRechten == "ja" || ($objGebRechten->getUploadRecht() == "ja" && $objGebRechten->getExtensies() != "")) {
		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" enctype=\"multipart/form-data\" id=\"addBestandForm\">\n";
	   echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	   echo "<tr><td class=\"tabletitle\" colspan=\"2\">Bestand toevoegen</td></tr>\n";
	   echo "<tr><td class=\"tableinfo\" colspan=\"2\">Bij het uploaden wordt het bestandsnaam ingekort tot 20 tekens, exclusief de punt en de extensie. ";
	   echo "<br>Daarnaast worden dubbele extensies gefilterd, dit is een veiligheidsmaatregel. Voorbeeld: een bestand zoals 'voorbeeld.exe.png' wordt omgezet naar 'voorbeeld.png'.</td></tr>";
     	echo "<tr><td class=\"formvakb\">Bestand:</td><td class=\"formvak\">\n";
		if($objGebRechten != "ja")
     		echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"".$objGebRechten->getMaxSize()."\">\n";
  		echo "<input type=\"file\" name=\"bestand\"></td></tr>\n";
     	echo "<tr><td class=\"formvakb\" colspan=\"2\">Omschrijving:</td></tr>\n";
     	echo "<tr><td class=\"formvakb\" colspan=\"2\"><textarea name=\"omschrijving\" cols=70 rows=4></textarea></td></tr>\n";
     	echo "<tr><td class=\"buttonvak\" colspan=\"2\"><input type=\"submit\" name=\"addBestandKnop\" value=\"Bestand toevoegen\" class=\"button\"></td></tr>\n";
     	echo "<tr><td class=\"tablelinks\" colspan=\"2\"><a href=\"".$_SERVER['PHP_SELF'];
     	if($objGebRechten == "ja")
     		echo "?wid=".$intWebsiteID;
     	echo "\" class=\"linkitem\">Overzicht bestanden</a></td></tr>\n";
  		echo "</table>\n";
  		
  		if($objGebRechten =="ja")
	  		echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID\">\n";
  		echo "</form>\n";
	}
	else {
	   echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	   echo "<tr><td class=\"tabletitle\">Geen rechten om bestand toe te voegen</td></tr>\n";
     	echo "<tr><td class=\"formvak\">U heeft geen rechten om een bestand toe te voegen.</td></tr>\n";
     	echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Bestandoverzicht</a></td></tr>";
  		echo "</table>\n";
	}
}
// Formulier om te bewerken 
function editBestandForm( $intBestandID, $intWebsiteID, $objGebRechten  ) {
	$objWebsite = getWebsite( $intWebsiteID );
	$objBestand = getBestand( $intBestandID, $intWebsiteID);
	echo "<h1>Bestand bewerken</h1>";
	if($objWebsite == false || $objWebsite == null) {
	   echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	   echo "<tr><td class=\"tabletitle\">Geen website niet gevonden</td></tr>\n";
     	echo "<tr><td class=\"formvak\">Er is geen website gevonden met het ID-nummer '$intWebsiteID'.</td></tr>\n";
     	echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
     	if($objGebRechten == "ja")
     		echo "?wid=".$intWebsiteID;
     	echo "\" class=\"linkitem\">Overzicht bestanden</a></td></tr>\n";
  		echo "</table>\n";
	}
 	elseif($objBestand == null || $objBestand == false) {
	   echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	   echo "<tr><td class=\"tabletitle\">Bestand niet gevonden</td></tr>\n";
     	echo "<tr><td class=\"formvak\">Er is geen bestand gevonden met het ID-nummer '$intBestandID'.</td></tr>\n";
     	echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
     	if($objGebRechten == "ja")
     		echo "?wid=".$intWebsiteID;
     	echo "\" class=\"linkitem\">Overzicht bestanden</a></td></tr>\n";
  		echo "</table>\n";
 	}
	elseif($objGebRechten == "ja" || $objGebRechten->getVerwijderRecht() == "ja") {
		$strToevoeging = checkBeheerder( $objGebRechten, $intWebsiteID );
		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" id=\"editBestandForm\">\n";
	   echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	   echo "<tr><td class=\"tabletitle\" colspan=\"3\">Bestand bewerken</td></tr>\n";
     	echo "<tr><td class=\"formvakb\" colspan=\"3\">Omschrijving:</td></tr>\n";
     	echo "<tr><td class=\"formvak\" colspan=\"3\"><textarea name=\"omschrijving\" cols=70 rows=4>".fixData($objBestand->getOmschrijving(), "tekstvak")."</textarea></td></tr>\n";
     	echo "<tr><td class=\"buttonvak\" colspan=\"3\"><input type=\"submit\" name=\"editBestandKnop\" value=\"Bestand bewerken\" class=\"button\">\n</td></tr>\n";
     	echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=view&amp;bestandid=".$intBestandID.$strToevoeging."\" class=\"linkitem\">Bekijk bestand</a></td>\n";
     	echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=del&amp;bestandid=".$intBestandID.$strToevoeging."\" class=\"linkitem\">Verwijder bestand</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
     	if($objGebRechten == "ja")
     		echo "?wid=".$intWebsiteID;
     	echo "\" class=\"linkitem\">Overzicht bestanden</a></td>";
     	echo "</tr>\n";
  		echo "</table>\n";
		if($objGebRechten == "ja")
			echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID\">\n";
		echo "<input type=\"hidden\" name=\"bestandid\" value=\"$intBestandID\">\n";
     	echo "</form>\n";
	}
}
// Formulier om te verwijderen 
function delBestandForm( $intBestandID, $intWebsiteID, $objGebRechten  ) {
	$objWebsite = getWebsite( $intWebsiteID );
	$objBestand = getBestand( $intBestandID, $intWebsiteID );
	echo "<h1>Bestand verwijderen</h1>";
	if($objWebsite == false || $objWebsite == null) {
	   echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	   echo "<tr><td class=\"tabletitle\">Geen website niet gevonden</td></tr>\n";
     	echo "<tr><td class=\"formvak\">Er is geen website gevonden met het ID-nummer '$intWebsiteID'.</td></tr>\n";
     	echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
     	if($objGebRechten == "ja")
     		echo "?wid=".$intWebsiteID;
     	echo "\" class=\"linkitem\">Overzicht bestanden</a></td></tr>\n";
		echo "</table>\n";
	}
 	elseif($objBestand == null || $objBestand == false) {
	   echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	   echo "<tr><td class=\"tabletitle\">Bestand niet gevonden</td></tr>\n";
     	echo "<tr><td class=\"formvak\">Er is geen bestand gevonden met het ID-nummer '$intBestandID'.</td></tr>\n";
     	echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
     	if($objGebRechten == "ja")
     		echo "?wid=".$intWebsiteID;
     	echo "\" class=\"linkitem\">Overzicht bestanden</a></td></tr>\n";
		echo "</table>\n";
 	}
	elseif($objGebRechten == "ja" || $objGebRechten->getVerwijderRecht() == "ja") {
		$strToevoeging = checkBeheerder( $objGebRechten, $intWebsiteID );
		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" id=\"delBestandForm\">\n";
	   echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	   echo "<tr><td class=\"tabletitle\" colspan=\"3\">Bestand verwijderen</td></tr>\n";
     	echo "<tr><td class=\"formvak\" colspan=\"3\">Weet u zeker dat u het bestand met het ID-nummer '$intBestandID' wilt verwijderen?</td></tr>\n";
     	echo "<tr><td class=\"buttonvak\" colspan=\"2\"><input type=\"reset\" name=\"cancelDelBestandKnop\" value=\"Bestand niet verwijderen\" onclick=\"history.back()\" class=\"button\"></td>\n";
     	echo "<td class=\"buttonvak\"><input type=\"submit\" name=\"delBestandKnop\" value=\"Bestand verwijderen\" class=\"button\">\n<br><br>\n</td></tr>\n";
     	echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=view&amp;bestandid=".$intBestandID.$strToevoeging."\" class=\"linkitem\">Bekijk bestand</a></td>\n";
     	echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=edit&amp;bestandid=".$intBestandID.$strToevoeging."\" class=\"linkitem\">Bewerk bestand</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
     	if($objGebRechten == "ja")
     		echo "?wid=".$intWebsiteID;
     	echo "\" class=\"linkitem\">Overzicht bestanden</a></td>";
     	echo "</tr>\n";
		echo "</table>\n";
		if($objGebRechten == "ja")
			echo "<input type=\"hidden\" name=\"wid\" value=\"$intWebsiteID\">\n";
		echo "<input type=\"hidden\" name=\"bestandid\" value=\"$intBestandID\">\n";
		echo "</form>\n";
	}

}
// Functie om de grootte van het bestand af te ronden, gevonden op PHP.net
function fmtsize($size, $prec) {   $size = round(abs($size));   $units = array(0=>" B ", 1=>" kB", 2=>" MB", 3=>" GB", 4=>" TB");   if ($size==0) return str_repeat(" ", $prec)."0$units[0]";   $unit = min(4, floor(log($size)/log(2)/10));   $size = $size*pow(2, -10*$unit);   $digi = $prec-1-floor(log($size)/log(10));   $size = round($size*pow(10, $digi))*pow(10, -$digi);   while (strlen($size)<=$prec) $size = " $size";	return $size.$units[$unit];}// Functie om  een lijst te krijgen van bestanden bij een website 
function showBestandenMenu( $intWebsiteID, $intSelected = '', $strSoortBestanden = '' ) {
	if($strSoortBestanden == "flash")
		$arrBestanden = getFlashBestanden( $intWebsiteID );
	elseif($strSoortBestanden == "afbeeldingen")
		$arrBestanden = getAfbBestanden( $intWebsiteID );
	else
		$arrBestanden = getBestanden( $intWebsiteID, '-1', '-1');
		
	if($arrBestanden != false && $arrBestanden != null) {
		$intArraySize = count($arrBestanden);
		echo "<select name=\"bestandid\" size=\"5\" class=\"groot\">\n";
		echo "<option value=\"\"";
			if($intSelected == "")
				echo " SELECTED";
			echo ">\n";
		for($i = 0;$i < $intArraySize; $i++) {
			$objBestand = new Bestand();
			$objBestand->setValues($arrBestanden[$i]);
			echo "<option value=\"" . $objBestand->getBestandsID() . "\"";
			if($objBestand->getBestandsID() == $intSelected )
				echo " SELECTED";
			echo ">" . $objBestand->getBestandsNaam()."\n";
		}
		echo "</select>\n";
	}
	else {
		echo "<i>Geen bestanden aanwezig</i>";
	}
}

?>