<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: websitefuncties.php
 * Beschrijving: De functies mbt de objecten website
 */
 
// Functie om een website in te voeren
function insertWebsite( Website $objWebsite ) {
	$sql = "INSERT INTO website (url, email, titel, omschrijving, aanmelddatum, ftphost, ftpuser, ftppass, sitecode) VALUES";
	$sql .= "('".$objWebsite->getURL()."', '".$objWebsite->getEMail()."', '".$objWebsite->getTitel()."', '";
	$sql .= $objWebsite->getOmschrijving()."', '".$objWebsite->getAanmeldDatum()."', '".$objWebsite->getFTPhost()."',";
	$sql .= " '".$objWebsite->getFTPuser()."' ,'".$objWebsite->getFTPpass()."' ,'" . $objWebsite->getSiteCode() . "')";
	global $dbConnectie;
 	return $dbConnectie->setData($sql);
}
// Functie om info van een website up te daten
function updateWebsite( Website $objWebsite ) {
	$sql = "UPDATE website SET url = '".$objWebsite->getURL()."', email = '".$objWebsite->getEMail()."', titel = '".$objWebsite->getTitel()."', omschrijving = '";
	$sql .= $objWebsite->getOmschrijving()."', ftphost = '".$objWebsite->getFTPhost()."', ftpuser = '".$objWebsite->getFTPuser()."',  ftppass = '".$objWebsite->getFTPpass()."', ";
	$sql .= " sitecode = '".$objWebsite->getSiteCode()."' WHERE id = '".$objWebsite->getWebsiteID()."'";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
}
// Functie om een website te verwijderen
function delWebsite( $intWebsiteID ) {
	if($intWebsiteID == null || $intWebsiteID == 0 || $intWebsiteID == "" || $intWebsiteID == false)
		return false;
	
	
	$arrSQL[0] = "DELETE FROM afbeeldingblok WHERE wid = '$intWebsiteID'";
	$arrSQL[1] = "DELETE FROM contactformblok WHERE wid = '$intWebsiteID'";
	$arrSQL[2] = "DELETE FROM flashblok WHERE wid = '$intWebsiteID'";
	$arrSQL[3] = "DELETE FROM htmlblok WHERE wid = '$intWebsiteID'";
	$arrSQL[4] = "DELETE FROM linksblok WHERE wid = '$intWebsiteID'";
	$arrSQL[5] = "DELETE FROM tekstafbblok WHERE wid = '$intWebsiteID'";
	$arrSQL[6] = "DELETE FROM tekstblok WHERE wid = '$intWebsiteID'";
	$arrSQL[7] = "DELETE FROM blok WHERE wid = '$intWebsiteID'";
 	$arrSQL[8] = "DELETE FROM pagina WHERE wid = '$intWebsiteID'";
	$arrSQL[9] = "DELETE FROM onderdeel WHERE wid = '$intWebsiteID'";
	$arrSQL[10] = "DELETE gr FROM gebruikersrechten AS gr, gebruiker AS g WHERE gr.gid = g.id AND g.wid = '$intWebsiteID'";
	$arrSQL[11] = "DELETE FROM gebruiker WHERE wid = '$intWebsiteID'";
	$arrSQL[12] = "DELETE FROM bestand WHERE wid = '$intWebsiteID'";
	$arrSQL[13] = "DELETE FROM website WHERE id = '$intWebsiteID'";
	$intArraySize = count($arrSQL);
	
  	global $dbConnectie;
  	for($intTeller = 0; $intTeller < $intArraySize; $intTeller++) {
  		if(!$dbConnectie->setData($arrSQL[$intTeller])) {
  			return false;
  		}
  	}
  	return true;
}
// Functie om websiteinfo op te vragen
function getWebsite( $intWebsiteID ) {
	$sql = "SELECT * FROM website WHERE id = '$intWebsiteID'";
 	global $dbConnectie;
 	$arrWebsites = $dbConnectie->getData($sql);
 	if($arrWebsites == null || $arrWebsites == false) {
 		return false;
 	}
 	else {
 	    $objWebsite = new Website();
        $objWebsite->setValues($arrWebsites[0]);
        return $objWebsite; 		
 	}
}
// Functie om de website te laten zien in een formulier
function showWebsite( $objWebsite ) {
       	echo "<h1>Bekijk websiteinformatie</h1>\n";
 	  	if($objWebsite == null || $objWebsite == false) {
    		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
			echo "<tr><td class=\"tabletitle\">Website niet gevonden</td></tr>\n";
			echo "<tr><td class=\"formvak\">De website met het opgegeven ID-nummer is niet in de database gevonden.</td></tr>\n";
			echo "<tr><td class=\"tablelinks\"><a href=\"" . $_SERVER['PHP_SELF'] . "\" class=\"linkitem\">Websitesoverzicht</a></td></tr>\n";
			echo "</table>\n";
 	  	}
		else {
	 	  	$arrAanmeldDatum = convertDatumTijd( $objWebsite->getAanmeldDatum() );
    		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
			echo "<tr><td class=\"tabletitle\" colspan=\"4\">Website: " . fixData($objWebsite->getTitel()) . "</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Website-ID:</td><td colspan=\"3\" class=\"formvak\">".$objWebsite->getWebsiteID()."</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Titel:</td><td colspan=\"3\" class=\"formvak\">".fixData($objWebsite->getTitel())."</td></tr>\n";
			echo "<tr><td class=\"formvakb\">URL:</td><td colspan=\"3\" class=\"formvak\"><a href=\"".$objWebsite->getURL()."\" target=\"_blank\">".$objWebsite->getURL()."</a></td></tr>\n";
			echo "<tr><td class=\"formvakb\">E-mail:</td><td colspan=\"3\" class=\"formvak\"><a href=\"mailto:".$objWebsite->getEMail()."\">".$objWebsite->getEMail()."</a></td></tr>\n";
			echo "<tr><td class=\"formvakb\">Omschrijving:</td><td colspan=\"3\" class=\"formvak\">".fixData($objWebsite->getOmschrijving())."</td></tr>\n";
			//echo "<tr><td class=\"formvakb\">FTP-host:</td><td colspan=\"3\" class=\"formvak\">".$objWebsite->getFTPhost()."</td></tr>\n";
			//echo "<tr><td class=\"formvakb\">FTP-user:</td><td colspan=\"3\" class=\"formvak\">".$objWebsite->getFTPuser()."</td></tr>\n";
			//echo "<tr><td class=\"formvakb\">FTP-pass:</td><td colspan=\"3\" class=\"formvak\">".$objWebsite->getFTPpass()."</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Lid sinds:</td><td colspan=\"3\" class=\"formvak\">".$arrAanmeldDatum['dag']."-".$arrAanmeldDatum['maand']."-".$arrAanmeldDatum['jaar']." om ".$arrAanmeldDatum['uur'].":".$arrAanmeldDatum['minuten']."</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Website-code:</td><td colspan=\"3\" class=\"formvak\">".$objWebsite->getSiteCode()."</td></tr>\n";
			echo "<tr><td class=\"formvakb\" colspan=\"4\">Gebruikers bij deze website:</td></tr>\n";
			echo "<tr><td class=\"formvak\" colspan=\"4\">";
			showGebruikersByWebsite( $objWebsite->getWebsiteID() );
			echo "</td></tr>\n";
			echo "<tr><td class=\"tablelinks\" width=\"100\"><a href=\"inhoudbeheer.php?wid=".$objWebsite->getWebsiteID()."\" class=\"linkitem\">Bewerk inhoud</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"" . $_SERVER['PHP_SELF'] . "?actie=ew&id=".$objWebsite->getWebsiteID()."\" class=\"linkitem\">Bewerk informatie</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"" . $_SERVER['PHP_SELF'] . "?actie=dw&id=".$objWebsite->getWebsiteID()."\" class=\"linkitem\">Verwijder website</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"" . $_SERVER['PHP_SELF'] . "\" class=\"linkitem\">Websitesoverzicht</a></td></tr>\n";
			echo "</table>\n";
 	  	}
}

// Functie om alle websites op te vragen
function getWebsiteOverzicht( $intVan = 0, $intAantal = 25) {
	$sql = "SELECT * FROM website";
	if($intVan != "-1") 
		$sql .= " LIMIT $intVan, $intAantal";

	global $dbConnectie;
	return $dbConnectie->getData($sql);
}
// Functie om een SELECT-lijst te krijgen van websites
function showWebsiteList( $intSelected, $strWhiteSpace = false ) {
	$arrWebsites = getWebsiteOverzicht(-1);
	
	if($arrWebsites == null || $arrWebsites == false) {
		return false;
	}
	else {
		$intArraySize = count($arrWebsites);
		echo "<SELECT name=\"wid\" class=\"groot\">\n";
		if($strWhiteSpace != false)
			echo "<OPTION value=\"\"";
			if($intSelected == "")
				echo " SELECTED";
			echo ">\n";
		for($i = 0;$i < $intArraySize; $i++) {
			$objWebsite = new Website();
			$objWebsite->setValues($arrWebsites[$i]);
			echo "<OPTION value=\"" . $objWebsite->getWebsiteID() . "\"";
			if($objWebsite->getWebsiteID() == $intSelected )
				echo " SELECTED";
			echo ">" . $objWebsite->getTitel() . " (ID: " . $objWebsite->getWebsiteID() .  ")\n";
		}
		echo "</SELECT>\n";
	}
}
// Functie om websitenaam op te zoeken
function showWebsiteNaam( $intWebsiteID ) {
	$sql = "SELECT titel FROM website WHERE id = '$intWebsiteID'";
	global $dbConnectie;
	$arrWebsites = $dbConnectie->getData($sql);
	
	if($arrWebsites == null || $arrWebsites == false ) {
		return false;
	}
	else {
		$objWebsite = new Website();
		$objWebsite->setValues($arrWebsites[0]);
		echo $objWebsite->getTitel();
	}
}
// Functie om overzicht te laten zien
function showWebsiteOverzicht( $intVan = 0, $intAantal = 25) {
	$arrWebsites = getWebsiteOverzicht( $intVan, $intAantal);
    echo "<h1>Bekijk websitesoverzicht</h1>\n";	
   	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
    if($arrWebsites == false || $arrWebsites == null) {
    	echo "<tr><td colspan=\"3\" class=\"tabletitle\">Websitesoverzicht</td></tr>\n";
    	echo "<tr><td colspan=\"3\" class=\"formvak\">Er zijn geen websites aanwezig</td></tr>\n";
    	echo "<tr><td colspan=\"3\" class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=aw\" class=\"linkitem\">Voeg een website toe</a></a></td></tr>";    	
    }
    else {
    	$intArraySize = count($arrWebsites);
    	echo "<tr><td colspan=\"4\" class=\"tabletitle\">Websitesoverzicht</td></tr>\n";
    	echo "<tr><td class=\"tableinfo\">ID:</td>\n<td class=\"tableinfo\">Titel:</td>\n<td class=\"tableinfo\">URL:</td>\n<td class=\"tableinfo\">Opties:</td>\n</tr>\n";
    	for( $i = 0; $i < $intArraySize; $i++ ) {
    		$objWebsite = new Website();
    		$objWebsite->setValues($arrWebsites[$i]);
    		echo "<tr><td class=\"formvak\">".$objWebsite->getWebsiteID()."</td>\n";
    		echo "<td class=\"formvak\"><a href=\"".$_SERVER['PHP_SELF']."?actie=bw&id=".$objWebsite->getWebsiteID()."\" title=\"Bekijk informatie over de website\">".fixData($objWebsite->getTitel())."</a></td>\n";
    		echo "<td class=\"formvak\"><a href=\"".$objWebsite->getURL()."\" target=\"_blank\" title=\"Bezoek website (in een nieuw venster)\">".$objWebsite->getURL()."</a></td>\n";
    		echo "<td class=\"formvak\">".getWebsitesAdminMenu($objWebsite->getWebsiteID())."</td></tr>\n";
  
    	}
    	echo "<tr><td colspan=\"4\" class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=aw\" class=\"linkitem\">Voeg website toe</a></td></tr>";
    }
    	echo "</table>";
}
// Functie om het formulier te maken om website toe te voegen of te bewerken
function maakWebsiteForm( $objWebsite = '', $strActie) {
    if($strActie == "add" || $strActie == "addgw") {
		if($objWebsite == "")
			$objWebsite = new Website();
		$objWebsite->setAanmeldDatum( getDatumTijd() );
		$strKnopTitel = "Volgende stap";
		$strKnopNaam = "addWebsiteKnop";
		echo "<h1>Voeg website toe</h1>\n";
    }
    elseif($strActie == "edit" || $strActie == "editgw") {
		$strKnopTitel = "Bewerk gegevens";
		$strKnopNaam = "editWebsiteKnop";
		echo "<h1>Bewerk website-informatie</h1>\n";
    }
    if($objWebsite == null || $objWebsite == false) {
   		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\">Website niet gevonden</td></tr>\n";
		echo "<tr><td class=\"formvak\">De website is niet in de database gevonden.</td></tr>\n";
		echo "<tr><td class=\"tablelinks\"><a href=\"" . $_SERVER['PHP_SELF'] . "\" class=\"linkitem\">Websitesoverzicht</a></td></tr>\n";
		echo "</table>\n";
    }
    else {
	    $arrAanmeldDatum = convertDatumTijd( $objWebsite->getAanmeldDatum() );
		echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\" name=\"" . $strActie . "WebsiteForm\">\n";

		if($objWebsite->getWebsiteID() != "") {
			echo "<input type=\"hidden\" name=\"wid\" value=\"" . $objWebsite->getWebsiteID() . "\">";
		}
		else {
			echo "<input type=\"hidden\" name=\"aanmelddatum\" value=\"".getDatumTijd()."\">\n";
		}
	
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Websiteformulier</td></tr>\n";
		echo "<tr><td class=\"formvak\" colspan=\"3\">Alle velden die zijn aangegeven met een rood sterretje (<span class=\"redStar\">*</span>) zijn verplicht om in te vullen.</td></tr>\n";	
		echo "<tr><td class=\"formvakb\">URL: <span class=\"redStar\">*</span></td><td class=\"formvak\" colspan=\"2\"><input type=\"text\" name=\"url\" value=\"".$objWebsite->getURL()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Email: <span class=\"redStar\">*</span></td><td class=\"formvak\" colspan=\"2\"><input type=\"text\" name=\"email\" value=\"".$objWebsite->getEMail()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Titel: <span class=\"redStar\">*</span></td><td class=\"formvak\" colspan=\"2\"><input type=\"text\" name=\"titel\" value=\"".fixData($objWebsite->getTitel())."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Omschrijving:</td><td class=\"formvak\" colspan=\"2\"><textarea name=\"omschrijving\" rows=6 cols=40>".fixData($objWebsite->getOmschrijving())."</textarea></td></tr>\n";
		echo "<tr><td class=\"formvakb\">FTP-hostname:</td><td class=\"formvak\" colspan=\"2\"><input type=\"text\" name=\"ftphost\" value=\"".$objWebsite->getFTPhost()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">FTP-gebruikersnaam:</td><td class=\"formvak\" colspan=\"2\"><input type=\"text\" name=\"ftpuser\" value=\"".$objWebsite->getFTPuser()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">FTP-wachtwoord:</td><td class=\"formvak\" colspan=\"2\"><input type=\"text\" name=\"ftppass\" value=\"".$objWebsite->getFTPpass()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Websitecode: <span class=\"redStar\">*</span></td><td class=\"formvak\">";
		echo "<input type=\"text\" name=\"sitecode\" value=\"".$objWebsite->getSiteCode()."\" size=\"30\" maxlengt=\"50\"></td>\n";
		echo "<td class=\"buttonvak\"><input type=\"submit\" name=\"genereerSiteCode\" value=\"Genereer sitecode\" class=\"button\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Toegevoegd op:</td><td class=\"formvak\" colspan=\"2\">".$arrAanmeldDatum['dag']."-".$arrAanmeldDatum['maand']."-".$arrAanmeldDatum['jaar']." om ".$arrAanmeldDatum['uur'].":".$arrAanmeldDatum['minuten']."</td></tr>";
		echo "<tr><td colspan=\"3\" class=\"buttonvak\"><input type=\"submit\" name=\"".$strKnopNaam."\" value=\"".$strKnopTitel."\" class=\"button\"></td></tr>\n";

		if($objWebsite->getWebsiteID() != "") {
			echo "<tr><td class=\"tablelinks\"><a href=\"" . $_SERVER['PHP_SELF'] . "?actie=bw&id=" . $objWebsite->getWebsiteID()  . "\" class=\"linkitem\">Bekijk website</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"" . $_SERVER['PHP_SELF'] . "?actie=dw&id=" . $objWebsite->getWebsiteID()  . "\" class=\"linkitem\">Verwijder website</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"" . $_SERVER['PHP_SELF'] . "\" class=\"linkitem\">Websitesoverzicht</a></td></tr>\n";
		}
		else {
			echo "<tr><td class=\"tablelinks\" colspan=\"3\"><a href=\"" . $_SERVER['PHP_SELF'] . "\" class=\"linkitem\">Websitesoverzicht</a></td></tr>\n";
		}
		echo "</table>\n</form\n>";
    }		
}
// Functie om het formulier te maken om een website te verwijderen
function maakDelWebsiteForm( $intWebsiteID ) {
   $objWebsite = getWebsite( $intWebsiteID );
   echo "<h1>Verwijder website</h1>\n";
   if($objWebsite == null || $objWebsite == false) {
   	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\">Website niet gevonden</td></tr>\n";
		echo "<tr><td class=\"formvak\">De website met het opgegeven ID-nummer is niet in de database gevonden.</td></tr>\n";
		echo "<tr><td class=\"tablelinks\"><a href=\"" . $_SERVER['PHP_SELF'] . "\" class=\"linkitem\">Websitesoverzicht</a></td></tr>\n";
		echo "</table>\n";
 	}
 	else {
		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" name=\"delWebsiteForm\">\n";
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Website (en bijbehorende gegevens) verwijderen</td></tr>\n";
		echo "<tr><td class=\"formvak\" colspan=\"3\">Weet u zeker dat u deze website wilt verwijderen? Als u deze website verwijderd, worden ook de bijbehorende onderdelen, pagina's, blokken en gebruikers verwijderd.<input type=\"hidden\" name=\"id\" value=\"".$intWebsiteID."\"></td></tr>\n";
		echo "<tr><td class=\"formvak\" colspan=\"3\">De bestanden die bij deze website horen moet u zelf handmatig verwijderen. De bestanden worden wel uit de database verwijderd.</td></tr>\n";
		echo "<tr><td class=\"buttonvak\" colspan=\"2\"><input type=\"reset\" name=\"geenDelWebsiteKnop\" value=\"Website niet verwijderen\" class=\"button\" onclick=\"history.back()\">\n";
		echo "</td><td class=\"buttonvak\"><input type=\"submit\" name=\"delWebsiteKnop\" value=\"Website verwijderen\" class=\"button\"></td></tr>\n";
		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=bw&id=".$intWebsiteID."\" class=\"linkitem\">Bekijk website</a></td><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=ew&id=".$intWebsiteID."\" class=\"linkitem\">Bewerk website</a></td><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Websitesoverzicht</a></td></tr>\n";	
		echo "</table>\n";
	}
}

// Functie om het menu aan te maken, wat in het websitesoverzicht moet staan
function getWebsitesAdminMenu( $intWebsiteID ) {
	$strMenu = "<a href=\"inhoudbeheer.php?	wid=$intWebsiteID\" title=\"Bewerk websiteinhoud\"><img src=\"images/editinhoudicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Bewerk websiteinhoud\"></a> ";
	$strMenu .= "<a href=\"".$_SERVER['PHP_SELF']."?actie=ew&id=$intWebsiteID\" title=\"Bewerk websiteinformatie\"><img src=\"images/editicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Bewerk websiteinformatie\"></a> ";
	$strMenu .= " <a href=\"".$_SERVER['PHP_SELF']."?actie=dw&id=$intWebsiteID\" title=\"Verwijder website\"><img src=\"images/deleteicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Verwijder website\"></a>";
	return $strMenu;
}

?>