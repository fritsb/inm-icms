<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Gebruikerfuncties.php
 * Beschrijving: De functies mbt de Gebruiker
 */
 
// Functie om een gebruiker in te voeren
function insertGebruiker( Gebruiker $objGebruiker ) {
	$sql = "INSERT INTO gebruiker (gebruikersnaam, wachtwoord, email, voornaam, tussenvoegsel, achternaam, straat, huisnr, postcode , woonplaats, telnr, faxnr, mobielnr, aanmelddatum, actief, ip, wid)";
	$sql .= "VALUES ('".$objGebruiker->getGebruikersNaam()."', '".md5($objGebruiker->getWachtwoord())."', '".$objGebruiker->getEMail() . "', '".$objGebruiker->getVoornaam()."', '".$objGebruiker->getTussenvoegsel()."', ";
	$sql .= " '".$objGebruiker->getAchterNaam() . "', '".$objGebruiker->getStraat()."','".$objGebruiker->getHuisNr()."', '".$objGebruiker->getPostcode()."', '".$objGebruiker->getWoonplaats()."', '".$objGebruiker->getTelNr()."', ";
	$sql .= " '".$objGebruiker->getFaxNr()."', '".$objGebruiker->getMobielNr()."', '".getDatumTijd()."', 'ja', '".$_SERVER['REMOTE_ADDR']."','".$objGebruiker->getWebsiteID()."' )";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
}
// Functie om de gebruikersrechten in te voeren //  getTekstAfbRecht
function insertGebruikersRechten( GebruikersRechten $objGebRechten ) {
	$sql = "INSERT INTO gebruikersrechten (onderdelen, subonderdelen, contentpagina, afbeelding, contactform, downloads, flash, htmlcode, links, tekstafb, tekst, wysiwyg, uploaden, bekijken, verwijderen, maxsize, extensies, gid ) VALUES  ";
	$sql .= " ('".$objGebRechten->getOnderdeelRecht()."', '".$objGebRechten->getSubOnderdeelRecht()."', '".$objGebRechten->getPaginaRecht()."', '".$objGebRechten->getAfbeeldingRecht()."', ";
	$sql .= "'".$objGebRechten->getContactFormRecht()."', '".$objGebRechten->getDownloadsRecht()."','".$objGebRechten->getFlashRecht()."','".$objGebRechten->getHTMLCodeRecht()."','".$objGebRechten->getLinksRecht()."', ";
	$sql .= " '".$objGebRechten->getTekstAfbRecht()."','".$objGebRechten->getTekstRecht()."','".$objGebRechten->getWYSIWYGRecht()."' ,'".$objGebRechten->getUploadRecht()."',";
	$sql .= " '".$objGebRechten->getBekijkRecht()."', '".$objGebRechten->getVerwijderRecht()."', '".$objGebRechten->getMaxSize()."' , '".$objGebRechten->getExtensies()."' , '".$objGebRechten->getGebruikersID()."')";
	global $dbConnectie;
	return $dbConnectie->setData($sql);
}
// Functie om info van gebruiker up te daten
function updateGebruiker( Gebruiker $objGebruiker ) {
	$sql = "UPDATE gebruiker SET gebruikersnaam = '".$objGebruiker->getGebruikersNaam()."', email = '".$objGebruiker->getEMail()."', voornaam = '".$objGebruiker->getVoornaam()."', tussenvoegsel = '".$objGebruiker->getTussenvoegsel()."', achternaam = '".$objGebruiker->getAchterNaam()."',  ";
	$sql .= "straat = '".$objGebruiker->getStraat()."', huisnr = '".$objGebruiker->getHuisNr()."', postcode = '".$objGebruiker->getPostcode()."', woonplaats = '".$objGebruiker->getWoonplaats()."', telnr = '".$objGebruiker->getTelNr()."', ";
	$sql .= " faxnr = '".$objGebruiker->getFaxNr()."', mobielnr = '".$objGebruiker->getMobielNr()."', wid = '".$objGebruiker->getWebsiteID()."' ";
	if($objGebruiker->getWachtwoord() != "" ) {
		$sql .= ", wachtwoord = '".md5($objGebruiker->getWachtwoord())."' ";
	}
	$sql .= "WHERE id = '".$objGebruiker->getGebruikersID()."'";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
}
// Functie om wachtwoord te veranderen
 function updateGebruikerWachtwoord( $intGebruikersID, $strWachtwoord ) {
 	$sql = "UPDATE gebruiker SET wachtwoord = '".md5($strWachtwoord)."' WHERE id = '$intGebruikersID'";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
 }
// Functie om gebruikersrechten bij te werken
function updateGebruikersRechten( GebruikersRechten $objGebRechten ) {
	$sql = "UPDATE gebruikersrechten SET onderdelen = '".$objGebRechten->getOnderdeelRecht()."', subonderdelen = '".$objGebRechten->getSubOnderdeelRecht()."', contentpagina = '".$objGebRechten->getPaginaRecht()."', afbeelding = '".$objGebRechten->getAfbeeldingRecht()."', ";
	$sql .= " contactform = '".$objGebRechten->getContactFormRecht()."', downloads = '".$objGebRechten->getDownloadsRecht()."', flash = '".$objGebRechten->getFlashRecht()."',  htmlcode = '".$objGebRechten->getHTMLCodeRecht()."',  links = '".$objGebRechten->getLinksRecht()."', tekstafb = '".$objGebRechten->getTekstAfbRecht()."',  ";
	$sql .= " tekst = '".$objGebRechten->getTekstRecht()."', wysiwyg = '".$objGebRechten->getWYSIWYGRecht()."', uploaden = '".$objGebRechten->getUploadRecht()."', bekijken = '".$objGebRechten->getBekijkRecht()."', verwijderen = '".$objGebRechten->getVerwijderRecht()."', maxsize = '".$objGebRechten->getMaxSize()."', extensies = ";
	$sql .= " '".$objGebRechten->getExtensies()."' WHERE gid = '".$objGebRechten->getGebruikersID()."' ";
	global $dbConnectie;
	return $dbConnectie->setData($sql);	
}
// Functie om een gebruiker te verwijderen
function delGebruiker( $intGebruikersID ) {
	$sql1 = "DELETE FROM gebruikersrechten WHERE gid = '$intGebruikersID'";
	$sql2 = "DELETE FROM gebruiker WHERE id = '$intGebruikersID'";
 	global $dbConnectie;
 	if(!$dbConnectie->setData($sql1)) {
 		return false;
 	}
 	elseif(!$dbConnectie->setData($sql2)) {
 		return false;
 	}
 	else {
 		return true;
 	}
}
// Functie om gebruikersinfo op te vragen
function getGebruiker( $intGebruikersID ) {
	$sql = "SELECT * FROM gebruiker WHERE id = '$intGebruikersID'";
 	global $dbConnectie;
 	$arrGebruikers = $dbConnectie->getData($sql);
 	if($arrGebruikers == null || $arrGebruikers == false) {
 		return false;
 	}
 	else {
 	    $objGebruiker = new Gebruiker();
        $objGebruiker->setValues($arrGebruikers[0]);
        return $objGebruiker; 		
 	}
}
// Functie om gebruikersinfo op te vragen dmv naam
function getGebruikerMetNaam( $strGebruikersNaam ) {
	$sql = "SELECT * FROM gebruiker WHERE gebruikersnaam = '$strGebruikersNaam'";
	global $dbConnectie;
	$arrGebruikers = $dbConnectie->getData($sql);
 	if($arrGebruikers == null || $arrGebruikers == false) {
 		return false;
 	}
 	else {
 		$objGebruiker = new Gebruiker();
    	$objGebruiker->setValues($arrGebruikers[0]);
    	return $objGebruiker;
    }
}
// Functie om gebruikersinfo op te vragen dmv email
function getGebruikerMetMail( $strEmail ) {
	$sql = "SELECT * FROM gebruiker WHERE email LIKE '%$strEmail%'";
	global $dbConnectie;
	$arrGebruikers = $dbConnectie->getData($sql);
 	if($arrGebruikers == null || $arrGebruikers == false) {
 		return false;
 	}
 	else {
 		$objGebruiker = new Gebruiker();
    	$objGebruiker->setValues($arrGebruikers[0]);
    	return $objGebruiker;
    }
}
// Functie om gebruikersrechten op te vragen
function getGebruikersRechten( $intGebruikersID ) {
	$sql = "SELECT * FROM gebruikersrechten WHERE gid = '$intGebruikersID'";
	global $dbConnectie;
	$arrGebsRechten = $dbConnectie->getData($sql);

	if($arrGebsRechten == null || $arrGebsRechten == false) {
		return false;
	}
	else {
		$objGebRechten = new GebruikersRechten();
		$objGebRechten->setValues( $arrGebsRechten[0]);
		return $objGebRechten;
	}
}
// Functie om alle gebruikers op te vragen
function getGebruikers( $intVan = 0, $intAantal = 25, $intWebsiteID = 0 ) {
	$sql = "SELECT * FROM gebruiker ";
	if($intWebsiteID != 0) 
		$sql .= " WHERE wid = '$intWebsiteID' ";
	if($intVan != -1)
		$sql .= "LIMIT $intVan, $intAantal";
	global $dbConnectie;
	return $dbConnectie->getData($sql);
}
// Functie om het aantal gebruikers op te vragen
function getGebruikersAantal() {
	$sql = "SELECT count(*) AS count FROM gebruiker";	
	global $dbConnectie;
	$arrGebruikers = $dbConnectie->getData($sql);
	if($arrGebruikers != null && $arrGebruikers != false) {
		return $arrGebruikers[0]['count'];
	}
	else {
		return false;
	}
}
// Functie om een gebruiker te laten zien
function showGebruiker( $objGebruiker ) {
//          $objGebruiker = getGebruiker($intGebruikersID);
          $objGebRechten = getGebruikersRechten( $objGebruiker->getGebruikersID() );
          echo "<h1>Bekijk gebruikersinformatie</h1>\n";
          if($objGebruiker == false || $objGebruiker == null || !is_object($objGebruiker)) {
          	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		    echo "<tr><td class=\"tabletitle\"  colspan=\"3\">Gebruiker niet gevonden</td></tr>\n";
		    echo "<tr><td class=\"formvak\" colspan=\"3\">Er is geen informatie beschikbaar over de gebruiker met het opgegeven ID-nummer.</td></tr>\n";
		    echo "<tr><td class=\"tablelinks\" colspan=\"3\"><a href=\"" . $_SERVER['PHP_SELF'] . "\" class=\"linkitem\">Gebruikersoverzicht</a></td></tr>\n";
		    echo "</table>\n";		    
          }
          else {
    		$arrLastLoginData = convertDatumTijd($objGebruiker->getLastLogin());
	    	$arrAanmeldData = convertDatumTijd($objGebruiker->getAanmeldDatum());
            echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		    echo "<tr><td class=\"tabletitle\" colspan=\"3\">Gebruiker: " . $objGebruiker->getGebruikersNaam() . "</td></tr>\n";
		    echo "<tr><td class=\"formvakb\" width=\"200\">Gebruikers-ID:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getGebruikersID()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Gebruikersnaam:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getGebruikersNaam()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">E-mail:</td><td class=\"formvak\" colspan=\"2\"><a href=\"mailto:".$objGebruiker->getEMail()."\">".$objGebruiker->getEMail()."</a></td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Voornaam:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getVoorNaam()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Tussenvoegsel:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getTussenvoegsel()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Achternaam:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getAchterNaam()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Straat:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getStraat()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Huisnummer:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getHuisNr()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Postcode:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getPostcode()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Woonplaats:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getWoonplaats()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Telefoonnummer:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getTelNr()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Faxnummer:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getFaxNr()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Mobiele nummer:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getMobielNr()."</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Toegevoegd op:</td><td class=\"formvak\" colspan=\"2\">".$arrAanmeldData['dag']."-".$arrAanmeldData['maand']."-".$arrAanmeldData['jaar']." om ".$arrAanmeldData['uur'].":".$arrAanmeldData['minuten']."</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Laatst ingelogd:</td><td class=\"formvak\" colspan=\"2\">";
	    	if($objGebruiker->getLastLogin() == "0000-00-00 00:00:00")
    			echo "Nog nooit";
	    	else
				echo $arrLastLoginData['dag']."-".$arrLastLoginData['maand']."-".$arrLastLoginData['jaar']." om ".$arrLastLoginData['uur'].":".$arrLastLoginData['minuten'];
			echo "</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Laatste IP-adres:</td><td class=\"formvak\" colspan=\"2\">";
			if($objGebruiker->getIP() == "")
				echo "Geen";
			else
				echo $objGebruiker->getIP();
			echo "</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Website:</td><td class=\"formvak\" colspan=\"2\"><a href=\"websitebeheer.php?actie=bw&amp;id=".$objGebruiker->getWebsiteID()."\">";
		    showWebsiteNaam($objGebruiker->getWebsiteID());
		    echo "</a></td></tr>\n";
		    echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=eg&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Bewerk gebruiker</a></td>\n";
		    echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=dg&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Verwijder gebruiker</a></td>\n";
		    echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Gebruikersoverzicht</a></td></tr>\n";
		    echo "</table>\n";
		    echo "<br/>";
		    if($objGebRechten != false && $objGebRechten != null) {
            	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
			    echo "<tr><td class=\"tabletitle\" colspan=\"2\">Rechten voor beheer van onderdelen en pagina's</td></tr>\n";
			    echo "<tr><td class=\"formvakb\" width=\"200\">Onderdelen:</td><td class=\"formvak\">".$objGebRechten->getOnderdeelRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Subonderdelen:</td><td class=\"formvak\">".$objGebRechten->getSubOnderdeelRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Pagina's:</td><td class=\"formvak\">".$objGebRechten->getPaginaRecht()."</td></tr>\n";
			    echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=er&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Bewerk gebruikersrechten</a></td>\n";
			    echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Gebruikersoverzicht</a></td></tr>\n";
			    echo "</table>\n";
			    echo "<br/>";
    	        echo "<table class=\"overzicht\" cellspacing=\"0\">\n";   		    
		    	echo "<tr><td class=\"tabletitle\" colspan=\"2\">Rechten voor beheer van de blokken</td></tr>\n";
			    echo "<tr><td class=\"formvakb\" width=\"200\">Afbeelding-blok</td><td class=\"formvak\">".$objGebRechten->getAfbeeldingRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Contactformulier:</td><td class=\"formvak\">".$objGebRechten->getContactFormRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Downloads-blok:</td><td class=\"formvak\">".$objGebRechten->getDownloadsRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Flash-blok:</td><td class=\"formvak\">".$objGebRechten->getFlashRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">HTML-blok:</td><td class=\"formvak\">".$objGebRechten->getHTMLCodeRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Links-blok:</td><td class=\"formvak\">".$objGebRechten->getLinksRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Tekst-blok:</td><td class=\"formvak\">".$objGebRechten->getTekstRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Tekst met afbeeldingen-blok:</td><td class=\"formvak\">".$objGebRechten->getTekstAfbRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">WYSIWYG-editor:</td><td class=\"formvak\">".$objGebRechten->getWYSIWYGRecht()."</td></tr>\n";
			    echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=er&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Bewerk gebruikersrechten</a></td>\n";
			    echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Gebruikersoverzicht</a></td></tr>\n";
			    echo "</table>\n";
		    	echo "<br/>";
    	        echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
			    echo "<tr><td class=\"tabletitle\" colspan=\"2\">Instellingen voor bestanden</td></tr>\n";
			    echo "<tr><td class=\"formvakb\" width=\"200\">Bestanden bekijken:</td><td class=\"formvak\">".$objGebRechten->getBekijkRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Uploaden toegestaan:</td><td class=\"formvak\">".$objGebRechten->getUploadRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Verwijderen toegestaan:</td><td class=\"formvak\">".$objGebRechten->getVerwijderRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Maximale grootte:</td><td class=\"formvak\">".$objGebRechten->getMaxSize()." bytes</td></tr>\n";
			    echo "<tr><td class=\"formvakb\" style=\"vertical-align: top;\">Extensies:</td><td class=\"formvak\">".$objGebRechten->getExtensies()."</td></tr>\n";
			    echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=er&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Bewerk gebruikersrechten</a></td>\n";
			    echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Gebruikersoverzicht</a></td></tr>\n";
			    echo "</table>\n";
		    }
		    else {
            	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
			    echo "<tr><td class=\"tabletitle\"  colspan=\"3\">Gebruikersrechten van ".$objGebruiker->getGebruikersNaam()."</td></tr>\n";
			    echo "<tr><td class=\"formvak\" colspan=\"3\">Er zijn nog geen rechten ingesteld voor deze gebruiker.</td></tr>\n";
			    echo "<tr><td class=\"tablelinks\" width=\"200\"><a href=\"".$_SERVER['PHP_SELF']."?actie=er&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Bewerk gebruikersrechten</a></td>\n";
			    echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Gebruikersoverzicht</a></td></tr>\n";
			    echo "</table>\n";
		    }
		    echo "<br/>";		    
          }	
}
// Functie om gebruikersinformatie te laten zien voor een gebruiker
function showGebruikersInfo($objGebruiker, $objGebRechten) {
          echo "<h1>Bekijk gebruikersinformatie</h1>\n";
          if($objGebruiker == false && $objGebruiker == null) {
          	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		    echo "<tr><td class=\"tabletitle\"  colspan=\"3\">Gebruiker niet gevonden</td></tr>\n";
		    echo "<tr><td class=\"formvak\" colspan=\"3\">Er is geen informatie beschikbaar over deze gebruiker.</td></tr>\n";
		    echo "<tr><td class=\"tablelinks\" colspan=\"3\">&nbsp;</td></tr>\n";
		    echo "</table>\n";		    
          }
          else {
    		$arrLastLoginData = convertDatumTijd($objGebruiker->getLastLogin());
	    	$arrAanmeldData = convertDatumTijd($objGebruiker->getAanmeldDatum());
            echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		    echo "<tr><td class=\"tabletitle\"  colspan=\"3\">Gebruiker: " . $objGebruiker->getGebruikersNaam() . "</td></tr>\n";
		    echo "<tr><td class=\"formvakb\" width=\"150\">Gebruikersnaam:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getGebruikersNaam()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">E-mail:</td><td class=\"formvak\" colspan=\"2\"><a href=\"mailto:".$objGebruiker->getEMail()."\">".$objGebruiker->getEMail()."</a></td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Voornaam:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getVoorNaam()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Tussenvoegsel:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getTussenvoegsel()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Achternaam:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getAchterNaam()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Straat:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getStraat()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Huisnummer:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getHuisNr()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Postcode:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getPostcode()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Woonplaats:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getWoonplaats()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Telefoonnummer:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getTelNr()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Faxnummer:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getFaxNr()."</td></tr>\n";
		    echo "<tr><td class=\"formvakb\">Mobiele nummer:</td><td class=\"formvak\" colspan=\"2\">".$objGebruiker->getMobielNr()."</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Toegevoegd op:</td><td class=\"formvak\" colspan=\"2\">".$arrAanmeldData['dag']."-".$arrAanmeldData['maand']."-".$arrAanmeldData['jaar']." om ".$arrAanmeldData['uur'].":".$arrAanmeldData['minuten']."</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Laatst ingelogd:</td><td class=\"formvak\" colspan=\"2\">";
	    	if($objGebruiker->getLastLogin() == "0000-00-00 00:00:00")
    			echo "Nog nooit";
	    	else
				echo $arrLastLoginData['dag']."-".$arrLastLoginData['maand']."-".$arrLastLoginData['jaar']." om ".$arrLastLoginData['uur'].":".$arrLastLoginData['minuten'];
			echo "</td></tr>\n";
			echo "<tr><td class=\"formvakb\">Laatste IP-adres:</td><td class=\"formvak\" colspan=\"2\">";
			if($objGebruiker->getIP() == "")
				echo "-";
			else
				echo $objGebruiker->getIP();
			echo "</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Website:</td><td class=\"formvak\" colspan=\"2\">";
		    showWebsiteNaam($objGebruiker->getWebsiteID());
		    echo "</td></tr>\n";
		    echo "<tr><td class=\"tablelinks\" colspan=\"3\"><a href=\"".$_SERVER['PHP_SELF']."?actie=eg&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Bewerk informatie</a></td></tr>\n";
		    echo "</table>\n";
		    echo "<br/>";
		    if($objGebRechten != false && $objGebRechten != null && is_object($objGebruiker)) {
            	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
			    echo "<tr><td class=\"tabletitle\" colspan=\"2\">Rechten voor beheer van onderdelen en pagina's</td></tr>\n";
			    echo "<tr><td class=\"formvakb\" width=\"200\">Onderdelen:</td><td class=\"formvak\">".$objGebRechten->getOnderdeelRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Subonderdelen:</td><td class=\"formvak\">".$objGebRechten->getSubOnderdeelRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Pagina's:</td><td class=\"formvak\">".$objGebRechten->getPaginaRecht()."</td></tr>\n";
			    echo "<tr><td class=\"tablelinks\" colspan=\"2\">&nbsp;</td></tr>\n";
			    echo "</table>\n";
			    echo "<br/>";
    	        echo "<table class=\"overzicht\" cellspacing=\"0\">\n";   		    
		    	echo "<tr><td class=\"tabletitle\" colspan=\"2\">Rechten voor beheer van blokken</td></tr>\n";
			    echo "<tr><td class=\"formvakb\" width=\"200\">Afbeelding-blok</td><td class=\"formvak\">".$objGebRechten->getAfbeeldingRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Contactformulier:</td><td class=\"formvak\">".$objGebRechten->getContactFormRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Downloads-blok:</td><td class=\"formvak\">".$objGebRechten->getDownloadsRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Flash-blok:</td><td class=\"formvak\">".$objGebRechten->getFlashRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">HTML-blok:</td><td class=\"formvak\">".$objGebRechten->getHTMLCodeRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Links-blok:</td><td class=\"formvak\">".$objGebRechten->getLinksRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Tekst-blok:</td><td class=\"formvak\">".$objGebRechten->getTekstRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Tekst met afbeeldingen-blok:</td><td class=\"formvak\">".$objGebRechten->getTekstAfbRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">WYSIWYG-editor:</td><td class=\"formvak\">".$objGebRechten->getWYSIWYGRecht()."</td></tr>\n";
			    echo "<tr><td class=\"tablelinks\" colspan=\"2\">&nbsp;</td></tr>\n";
			    echo "</table>\n";
		    	echo "<br/>";
    	        echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
			    echo "<tr><td class=\"tabletitle\" colspan=\"2\">Instellingen voor bestanden</td></tr>\n";
			    echo "<tr><td class=\"formvakb\" width=\"200\">Bestanden bekijken:</td><td class=\"formvak\">".$objGebRechten->getBekijkRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Uploaden toegestaan:</td><td class=\"formvak\">".$objGebRechten->getUploadRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Verwijderen toegestaan:</td><td class=\"formvak\">".$objGebRechten->getVerwijderRecht()."</td></tr>\n";
			    echo "<tr><td class=\"formvakb\">Maximale grootte:</td><td class=\"formvak\">".$objGebRechten->getMaxSize()." bytes</td></tr>\n";
			    echo "<tr><td class=\"formvakb\" style=\"vertical-align: top;\">Extensies:</td><td class=\"formvak\">".$objGebRechten->getExtensies()."</td></tr>\n";
			    echo "<tr><td class=\"tablelinks\" colspan=\"3\">&nbsp;</td></tr>\n";
			    echo "</table>\n";
		    }
		    else {
            	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
			    echo "<tr><td class=\"tabletitle\">Gebruikersrechten van ".$objGebruiker->getGebruikersNaam()."</td></tr>\n";
			    echo "<tr><td class=\"formvak\">Er zijn nog geen rechten ingesteld voor deze gebruiker.</td></tr>\n";
			    echo "<tr><td class=\"tablelinks\">&nbsp;</td></tr>\n";
			    echo "</table>\n";
		    }
		    echo "<br/>";		    
          }	
}

// Funcctie om gebruikersoverzicht op te vragen
function showGebruikerOverzicht( $intPaginaNr = 0 ) {
     $arrGebruikers = getGebruikers( $intPaginaNr * 25, 25 );
     echo "<h1>Bekijk gebruikersoverzicht</h1>\n";     
     echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
     if($arrGebruikers == false || $arrGebruikers == null) {
	    echo "<tr><td class=\"tabletitle\">Geen gebruikers aanwezig</td></tr>\n";
     	echo "<tr><td class=\"formvak\">Er zijn nog geen gebruikers aanwezig in de database.</td></tr>";
     	echo "<tr><td class=\"tablelinks\" colspan=\"2\"><a href=\"".$_SERVER['PHP_SELF']."?actie=ag\" class=\"linkitem\">Voeg een gebruiker toe</a></td></tr>";
     }
     else {
	   $intArraySize = count($arrGebruikers);
	   echo "<tr><td class=\"tabletitle\"  colspan=\"4\">Gebruikersoverzicht</td></tr>\n";
	   echo "<tr><td class=\"tableinfo\">ID:</td><td class=\"tableinfo\">Naam:</td><td class=\"tableinfo\">Website:</td><td class=\"tableinfo\">Opties</td></tr>\n";
       for( $i = 0; $i < $intArraySize; $i++) {
	     $objGebruiker = new Gebruiker();       
     	 $objGebruiker->setValues($arrGebruikers[$i]);
     	 $objWebsite = getWebsite($objGebruiker->getWebsiteID());
   	  	 echo "<tr><td class=\"formvak\">".$objGebruiker->getGebruikersID()."</td>\n";
   	  	 echo "<td class=\"formvak\"><a href=\"".$_SERVER['PHP_SELF']."?actie=bg&amp;id=".$objGebruiker->getGebruikersID()."\">".$objGebruiker->getGebruikersNaam()."</a></td>\n";
   	  	 echo "<td class=\"formvak\"><a href=\"websitebeheer.php?actie=bw&amp;id=".$objWebsite->getWebsiteID()."\">".$objWebsite->getTitel()."</a>  (ID: ".$objWebsite->getWebsiteID().")</td>\n";
   	  	 echo "<td class=\"formvak\">".getGebruikersOptieMenu( $objGebruiker->getGebruikersID() )."</td></tr>\n";

       }
       echo "<tr><td class=\"tablelinks\">";
       if($intPaginaNr > 1)
       		echo "<a href=\"".$_SERVER['PHP_SELF']."?v=25\" class=\"linksitem\"><- Vorige 25</a>";
       echo "&nbsp;</td>\n";
       echo "<td class=\"tablelinks\">";
       if(getGebruikersAantal() < ($intPaginaNr * 25))
       		echo "<a href=\"\" class=\"linksitem\">Volgende 25 -></a>";
       echo "&nbsp;</td>\n";
	   echo "<td class=\"tablelinks\" colspan=\"2\"><a href=\"".$_SERVER['PHP_SELF']."?actie=ag\" class=\"linkitem\">Voeg een gebruiker toe</a></td>";
	   echo "</tr>";
     }
       echo "</table>\n";
       echo "<br>";
}
// Functie om gebruikers bij een website te bekijken
function showGebruikersByWebsite( $intWebsiteID ) {
	$arrGebruikers = getGebruikers( 0, 25 , $intWebsiteID );
	if($arrGebruikers == false || $arrGebruikers == null ) {
		echo "Geen gebruikers aanwezig.";
	}
	else {
		$intArraySize = count($arrGebruikers);
		echo "<ul>";
		for($i = 0; $i < $intArraySize; $i++) {
			$objGebruiker = new Gebruiker();
			$objGebruiker->setValues($arrGebruikers[$i]);
			echo "<li><a href=\"gebruikersbeheer.php?actie=bg&amp;id=".$objGebruiker->getGebruikersID()."\">".$objGebruiker->getGebruikersNaam()."</a>\n";
		}
		echo "</ul>";
	}
}

// Functie om de inlogggegevens te checken van een gebruiker
function checkGebruikerLogin($strGebruikersnaam, $strWachtwoord) {
	$sql = "SELECT g.id, g.gebruikersnaam, g.wachtwoord, g.voornaam, g.tussenvoegsel, g.achternaam, g.email, g.straat, ";
	$sql .= " g.huisnr, g.postcode, g.woonplaats, g.telnr, g.faxnr, g.mobielnr, g.aanmelddatum, g.lastlogin, g.actief, g.ip, g.wid";
	$sql .= " FROM gebruiker AS g, gebruikersrechten AS gr WHERE g.gebruikersnaam = '$strGebruikersnaam' AND ";
	$sql .= " g.wachtwoord = '".md5($strWachtwoord)."' AND gr.gid = (SELECT id FROM gebruiker WHERE gebruikersnaam ";
	$sql .= " = '$strGebruikersnaam' AND wachtwoord = '".md5($strWachtwoord)."')";

 	global $dbConnectie;
 	return $dbConnectie->getData($sql);
}
 // Functie om te checken of naam + email al eens voorkomt
 function checkGebruikerGegevens( $objGebruiker ) {
 	$sql = "SELECT * FROM gebruiker WHERE (gebruikersnaam = '".$objGebruiker->getGebruikersNaam()."' OR email = '".$objGebruiker->getEMail()."') ";
 	if($objGebruiker->getGebruikersID() != "")
 		$sql .= " AND id != '".$objGebruiker->getGebruikersID()."'";
	global $dbConnectie;
 	$arrResults = $dbConnectie->getData($sql);
 	if($arrResults != false) {
 		if(count($arrResults) > 0)
 			return false;
 	}
 	else {
 		return true;
 	}
 }
// Functie om het formulier te maken om gebruikers toe te voegen of te bewerken
function maakGebruikerForm( $objGebruiker = '', $strActie, $objWebsite = '') {
	// Als er een gebruiker wordt toegevoegd en objGebruiker bestaat niet
    if($strActie == "add" && $objGebruiker == "") {
		$objGebruiker = new Gebruiker();
		$intPostcode1 = "";
		$intPostcode2 = "";
		$strKnopTitel = "Voeg gebruiker toe";
		$strKnopName = "addGebruikerKnop";
		echo "<h1>Voeg gebruiker toe</h1>\n";
    }
    // Als er een gebruiker wordt toegevoegd en object bestaat al
    elseif($strActie == "add" || $strActie == "addgw") {
    	$intPostcode1 = substr($objGebruiker->getPostcode(), 0, 4);
	    $intPostcode2 = substr($objGebruiker->getPostcode(), 4, 2);
		$strKnopTitel = "Voeg gebruiker toe";
		$strKnopName = "addGebruikerKnop";
		echo "<h1>Voeg gebruiker toe</h1>\n";
    }
    // Als gebruiker wordt bewerkt
    elseif(($strActie == "edit" || $strActie == "editgw") && isset($objGebruiker) && is_object($objGebruiker)) {
		$intPostcode1 = substr($objGebruiker->getPostcode(), 0, 4);
		$intPostcode2 = substr($objGebruiker->getPostcode(), 4, 2);
		$strKnopTitel = "Bewerk gebruiker";
		$strKnopName = "editGebruikerKnop";
		echo "<h1>Bewerk gebruikersinformatie</h1>\n";
    }

	// Als de gebruiker niet bestaat, nog een foutmelding
  	if($objGebruiker == false || $objGebruiker == null) {
       	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	    echo "<tr><td class=\"tabletitle\" colspan=\"3\">Gebruiker niet gevonden</td></tr>\n";
	    echo "<tr><td class=\"formvak\" colspan=\"3\">De gebruiker is niet gevonden.</td></tr>\n";
	    echo "<tr><td class=\"tablelinks\" colspan=\"3\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Gebruikersoverzicht</a></td></tr>\n";
	    echo "</table>\n";
	}
	else {
		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" id=\"".$strActie."GebruikerForm\">\n";
		// De GebruikersID wordt meegegeven bij het bewerken
		if($objGebruiker->getGebruikersID() != "") {
			echo "<input type=\"hidden\" name=\"gid\" value=\"".$objGebruiker->getGebruikersID()."\">";
		}
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Gebruikersformulier</td></tr>\n";
	    echo "<tr><td class=\"formvak\" colspan=\"3\">De velden waar een rode ster (<span class=\"redStar\">*</span>) bij staat vermeld, zijn verplicht in te vullen.</td></tr>\n";
		echo "<tr><td class=\"formvakb\" width=\"140\">Voornaam: <span class=\"redStar\">*</span></td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"voornaam\" value=\"".$objGebruiker->getVoorNaam()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Tussenvoegsel:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"tussenvoegsel\" value=\"".$objGebruiker->getTussenvoegsel()."\"></td></tr>\n";	
		echo "<tr><td class=\"formvakb\">Achternaam: <span class=\"redStar\">*</span></td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"achternaam\" value=\"" . $objGebruiker->getAchterNaam()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">E-mailadres: <span class=\"redStar\">*</span></td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"email\" value=\"".$objGebruiker->getEMail()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Straat:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"straat\" value=\"".$objGebruiker->getStraat()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Huisnummer:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"huisnr\" value=\"".$objGebruiker->getHuisNr()."\" maxlength=\"5\" size=\"3\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Postcode:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"postcode1\" value=\"".$intPostcode1."\" size=\"4\" maxlength=\"4\">\n";
		echo "<input type=\"text\" name=\"postcode2\" value=\"".$intPostcode2."\" size=\"2\" maxlength=\"2\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Woonplaats:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"woonplaats\" value=\"".$objGebruiker->getWoonplaats()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Telefoonnummer:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"telnr\" value=\"".$objGebruiker->getTelNr()."\" maxlength=\"15\" size=\"12\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Faxnummer:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"faxnr\" value=\"".$objGebruiker->getFaxNr()."\" maxlength=\"15\" size=\"12\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Mobielnummer:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"mobielnr\" value=\"".$objGebruiker->getMobielNr()."\" maxlength=\"15\" size=\"12\"></td></tr>\n";
		// Na het aanmaken van een website wordt dit formulier ook aangeroepen met het objWebsite meegegeven
		if($objWebsite != "") {
		  echo "<tr><td class=\"formvakb\">Website: <span class=\"redStar\">*</span></td><td colspan=\"2\" class=\"formvak\"><a href=\"websitebeheer.php?actie=bw&amp;id=" . $objWebsite->getWebsiteID() . "\">"; 
		  echo $objWebsite->getTitel();
		  echo "</a><input type=\"hidden\" name=\"wid\" value=\"" . $objWebsite->getWebsiteID() . "\"></td></tr>\n";
		}
		// Zo niet, dan gewoon een website-lijst
		else {
	      echo "<tr><td class=\"formvakb\">Website: <span class=\"redStar\">*</span></td><td class=\"formvak\">";
    	  showWebsiteList( $objGebruiker->getWebsiteID() );
	      echo "</td></tr>\n";		
		}
		echo "<tr><td class=\"formvakb\">Gebruikersnaam: <span class=\"redStar\">*</span></td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"gebruikersnaam\" value=\"".$objGebruiker->getGebruikersNaam()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Wachtwoord: ";
		// Als de gebruiker wordt aangemaakt, dan is het veld verplicht, dus een rode ster
		if($strActie == "add" || $strActie == "addgw")
			echo "<span class=\"redStar\">*</span>";
		// Anders gewoon een opmerking
		else 
			echo "&#185;";
		// Als er op genereer wachtwoord is gedrukt, dan wordt die getoond
		if($strActie == "addgw" || $strActie == "editgw")
			echo "</td><td class=\"formvak\"><input type=\"text\" name=\"wachtwoord\" value=\"".$objGebruiker->getWachtwoord()."\"></td>\n";
		// Anders wordt er geen wachtwoord getoond
		else
			echo "</td><td class=\"formvak\"><input type=\"text\" name=\"wachtwoord\"></td>\n";
		echo "<td class=\"buttonvak\"><input type=\"submit\" name=\"getRandomPassKnop\" value=\"Genereer Wachtwoord\" class=\"button\"></td></tr>\n";
		
		// Als de gebruiker wordt bewerkt een opmerking over dat wachtwoordveld leeggelaten moet worden als die niet moet worden veranderd
		if($strActie == "edit" || $strActie == "editgw")
				echo "<tr><td class=\"formvakb\">&nbsp;</td><td class=\"formvak\" colspan=\"2\">&#185;) Als u uw wachtwoord niet wilt aanpassen, dan kunt u het veld leeglaten.</td></tr>\n";

		echo "<tr><td colspan=\"3\" class=\"buttonvak\"><input type=\"submit\" name=\"".$strKnopName."\" value=\"".$strKnopTitel."\" class=\"button\"></td></tr>\n";
		// Als de gebruiker wordt aangemaakt, dan kunnen de links onderin niet allemaal getoond worden (geen bewerk + verwijder)
		if($strActie == "add" || $strActie == "addgw") {
			echo "<tr><td class=\"tablelinks\" colspan=\"3\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Terug naar het overzicht</a></td></tr>\n";
		}
		// Als de gebruiker wordt bewerkt, kan dat wel..
		else {
			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=bg&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Bekijk gebruiker</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=er&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Bewerk rechten</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Terug naar het overzicht</a></td></tr>\n";			
		}

		echo "</table>\n</form>\n";		
	}
}
// Functie om formulier te maken om persoonlijke info te bewerken
function maakPersoonlijkInfoForm( $objGebruiker, $booGenereerPass = false) {
	$intPostcode1 = substr($objGebruiker->getPostcode(), 0, 4);
	$intPostcode2 = substr($objGebruiker->getPostcode(), 4, 2);
	$strKnopTitel = "Bewerk gebruiker";
	echo "<h1>Bewerk gebruikersinformatie</h1>\n";
	
	// Als de gebruiker niet bestaat oid, een foutmelding
   	if($objGebruiker == false || $objGebruiker == null || !is_object($objGebruiker)) {
       	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	    echo "<tr><td class=\"tabletitle\" colspan=\"3\">Gegevens niet gevonden</td></tr>\n";
	    echo "<tr><td class=\"formvak\" colspan=\"3\">De gegevens van de gebruiker zijn niet gevonden.</td></tr>\n";
	    echo "<tr><td class=\"tablelinks\" colspan=\"3\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Gebruikersoverzicht</a></td></tr>\n";
	    echo "</table>\n";
	}
	else {
		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\" id=\"bewerkGebruikerForm\">\n";
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Gebruikersformulier</td></tr>\n";
	    echo "<tr><td class=\"formvak\" colspan=\"3\">De velden waar een rode ster (<span class=\"redStar\">*</span>) bij staat vermeld, zijn verplicht in te vullen.</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Voornaam: <span class=\"redStar\">*</span></td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"voornaam\" value=\"".$objGebruiker->getVoorNaam()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Tussenvoegsel:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"tussenvoegsel\" value=\"".$objGebruiker->getTussenvoegsel()."\"></td></tr>\n";	
		echo "<tr><td class=\"formvakb\">Achternaam: <span class=\"redStar\">*</span></td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"achternaam\" value=\"" . $objGebruiker->getAchterNaam()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">E-mailadres: <span class=\"redStar\">*</span></td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"email\" value=\"".$objGebruiker->getEMail()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Straat:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"straat\" value=\"".$objGebruiker->getStraat()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Huisnummer:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"huisnr\" value=\"".$objGebruiker->getHuisNr()."\" maxlength=\"5\" size=\"3\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Postcode:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"postcode1\" value=\"".$intPostcode1."\" size=\"4\" maxlength=\"4\">\n";
		echo "<input type=\"text\" name=\"postcode2\" value=\"".$intPostcode2."\" size=\"2\" maxlength=\"2\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Woonplaats:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"woonplaats\" value=\"".$objGebruiker->getWoonplaats()."\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Telefoonnummer:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"telnr\" value=\"".$objGebruiker->getTelNr()."\" maxlength=\"15\" size=\"12\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Faxnummer:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"faxnr\" value=\"".$objGebruiker->getFaxNr()."\" maxlength=\"15\" size=\"12\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Mobielnummer:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"mobielnr\" value=\"".$objGebruiker->getMobielNr()."\" maxlength=\"15\" size=\"12\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Wachtwoord: &#185;</td><td class=\"formvak\"><input type=\"text\" name=\"wachtwoord\"";
		if($booGenereerPass == true)
			echo "value=\"".$objGebruiker->getWachtwoord()."\"";
		echo "></td><td class=\"buttonvak\"><input type=\"submit\" name=\"getRandomPassKnop\" value=\"Genereer Wachtwoord\" class=\"button\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">&nbsp;</td><td class=\"formvak\" colspan=\"2\">&#185;) Als u uw wachtwoord niet wilt aanpassen, dan kunt u het veld leeglaten.</td></tr>\n";
		echo "<tr><td colspan=\"3\" class=\"buttonvak\"><input type=\"submit\" name=\"bewerkGebruikerInfoKnop\" value=\"Bewerk persoonlijke informatie\" class=\"button\"></td></tr>\n";
		echo "<tr><td class=\"tablelinks\" colspan=\"3\"><a href=\"".$_SERVER['PHP_SELF']."?actie=bg&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Bekijk informatie</a></td></tr>\n";
		echo "</table>\n</form>\n";		
	}
}

// Functie om het formulier te maken om de rechten van gebruikers toe te voegen of te bewerken
function maakGebruikersRechtenForm( $strActie, $intID = '' ) {
    $objGebruiker = getGebruiker( $intID );
    $objGebRechten = getGebruikersRechten( $intID );
    if($objGebRechten == false || $objGebRechten == null)
    	$objGebRechten = new GebruikersRechten();
    
    echo "<h1>Rechten van gebruikers</h1>\n";
	if($objGebruiker != false && $objGebruiker != null && is_object($objGebruiker) && $objGebRechten != false && $objGebRechten != null) {
		echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\" id=\"" . $strActie . "GebruikersRechtenForm\">\n";
		echo "<input type=\"hidden\" name=\"gid\" value=\"".$objGebruiker->getGebruikersID(). "\">\n";
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Rechten voor onderdeel- en paginabeheer:</td></tr>\n";
		echo "<tr><td class=\"tableinfo\" colspan=\"3\">Selecteer 'ja' als de gebruiker onderdelen, subonderdelen of pagina's mag aanmaken, bewerken en verwijderen.</td></tr>\n";
		echo "<tr><td class=\"formvakb\" width=\"160\">Onderdelen:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu( "onderdeel", $objGebRechten->getOnderdeelRecht() )."</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Subonderdelen:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu( "subonderdeel", $objGebRechten->getSubOnderdeelRecht() )."</td></tr>\n";
		echo "<tr><td class=\"formvakb\" width=\"160\">Pagina's:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu( "pagina", $objGebRechten->getPaginaRecht() )."</td></tr>\n";
		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=bg&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Bekijk gebruiker</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=eg&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Bewerk gebruiker</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Gebruikersoverzicht</a></td></tr>";
		echo "</table>\n";
		echo "<br>\n";
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Rechten voor beheer van blokken:</td></tr>\n";
		echo "<tr><td class=\"tableinfo\" colspan=\"3\">Selecteer 'ja' als de gebruiker het betreffende soort blok mag aanmaken, bewerken en verwijderen.</td></tr>\n";
		echo "<tr><td class=\"formvakb\" width=\"160\">Afbeelding:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu( "afbeelding", $objGebRechten->getAfbeeldingRecht() )."</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Contactformulier:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu( "contactform", $objGebRechten->getContactFormRecht() )."</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Downloads:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu( "downloads", $objGebRechten->getDownloadsRecht() )."</td></tr>\n";	
		echo "<tr><td class=\"formvakb\">Flash-bestand:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu( "flash", $objGebRechten->getFlashRecht())."</td></tr>\n";
		echo "<tr><td class=\"formvakb\">HTMLcode:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu( "htmlcode", $objGebRechten->getHTMLCodeRecht() )."</td></tr>\n";	
		echo "<tr><td class=\"formvakb\">Links:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu( "links", $objGebRechten->getLinksRecht() )."</td></tr>\n";	
		echo "<tr><td class=\"formvakb\">Tekst met afbeelding:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu( "tekstafb", $objGebRechten->getTekstAfbRecht() )."</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Tekst:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu( "tekst", $objGebRechten->getTekstRecht() )."</tr>\n";	
		echo "<tr><td class=\"formvakb\">WYSIWYG-editor:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu( "wysiwyg", $objGebRechten->getWYSIWYGRecht() )."</tr>\n";	
		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=bg&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Bekijk gebruiker</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=eg&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Bewerk gebruiker</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Gebruikersoverzicht</a></td></tr>\n";
		echo "</table>\n";
		echo "<br>\n";
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Instellingen voor bestanden</td></tr>\n";
		echo "<tr><td class=\"tableinfo\" colspan=\"3\">Als een gebruiker bestanden moet kunnen uploaden of verwijderen, dan is het noodzakelijk dat de gebruiker ook bestanden kan bekijken.</td></tr>\n";
		echo "<tr><td class=\"formvakb\" width=\"160\">Bestanden bekijken:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu('bekijken', $objGebRechten->getBekijkRecht())."</td>\n";
		echo "<tr><td class=\"formvakb\">Uploaden toegestaan:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu('uploaden', $objGebRechten->getUploadRecht())."</td>\n";
		echo "<tr><td class=\"formvakb\">Verwijderen toegestaan:</td><td colspan=\"2\" class=\"formvak\">".getSelectMenu('verwijderen', $objGebRechten->getVerwijderRecht())."</td>\n";
		echo "<tr><td class=\"formvakb\">Maximaal grootte:</td><td colspan=\"2\" class=\"formvak\"><input type=\"text\" name=\"maxsize\" value=\"".$objGebRechten->getMaxSize()."\"> bytes</td>\n";		
		echo "<tr><td class=\"formvak\"><b>Typen bestanden:</b><br>\n";
		echo "<input type=\"checkbox\" name=\"plaatjes\" onClick=\"updateExtensieArea()\"> <span class=\"linkCursor\" onClick=\"changeCheckBox('document.forms[0].plaatjes')\">Grafische bestanden</span><br>\n";
		echo "<input type=\"checkbox\" name=\"website\" onClick=\"updateExtensieArea()\"> <span class=\"linkCursor\" onClick=\"changeCheckBox('document.forms[0].website')\">Website-bestanden</span><br>\n";
		echo "<input type=\"checkbox\" name=\"video\" onClick=\"updateExtensieArea()\"> <span class=\"linkCursor\" onClick=\"changeCheckBox('document.forms[0].video')\">Video-bestanden</span><br>\n";
		echo "<input type=\"checkbox\" name=\"muziek\" onClick=\"updateExtensieArea()\"> <span class=\"linkCursor\" onClick=\"changeCheckBox('document.forms[0].muziek')\">Muziek-bestanden</span><br>\n";
		echo "<input type=\"checkbox\" name=\"documenten\" onClick=\"updateExtensieArea()\"> <span class=\"linkCursor\" onClick=\"changeCheckBox('document.forms[0].documenten')\">Documenten</span><br>\n";
		echo "<input type=\"checkbox\" name=\"ingepakt\" onClick=\"updateExtensieArea()\"> <span class=\"linkCursor\" onClick=\"changeCheckBox('document.forms[0].ingepakt')\">Ingepakte bestanden</span><br>\n";
		echo "</td><td colspan=\"2\" class=\"formvak\"><b>Extensies:</b><br>\n";
		echo "<textarea name=\"extensies\" cols=40 rows=6 onFocus=\"\">".$objGebRechten->getExtensies()."</textarea></td></tr>";
		echo "<tr><td colspan=\"3\" class=\"buttonvak\"><input type=\"submit\" name=\"" . $strActie . "GebruikersRechtenKnop\" value=\"Verwerk gebruikergegevens\" class=\"button\"></td></tr>\n";
		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=bg&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Bekijk gebruiker</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=eg&amp;id=".$objGebruiker->getGebruikersID()."\" class=\"linkitem\">Bewerk gebruiker</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Gebruikersoverzicht</a></td></tr>\n";
		echo "</table>\n</form>\n";	
	}
}
// Functie om formulier te maken om gebruiker te verwijderen
function maakDelGebruikerForm( $intGebruikersID ) {
	$objGebruiker = getGebruiker( $intGebruikersID );	
	echo "<h1>Verwijder gebruiker</h1>\n";
	if($objGebruiker == false || $objGebruiker == null || !is_object($objGebruiker)) {
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Gebruiker verwijderen</td></tr>\n";
    	echo "<tr><td class=\"tabletitle\" colspan=\"3\">Gegevens niet gevonden</td></tr>\n";
	   echo "<tr><td class=\"formvak\" colspan=\"3\">De gegevens van de gebruiker zijn niet gevonden.</td></tr>\n";
	   echo "<tr><td class=\"tablelinks\" colspan=\"3\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Gebruikersoverzicht</a></td></tr>\n";
	   echo "</table>\n";
	}
	else {
		echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\" id=\"delGebruikerForm\">\n";
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Gebruiker verwijderen</td></tr>\n";
		echo "<tr><td class=\"formvak\" colspan=\"3\">Weet u zeker dat u deze gebruiker wilt verwijderen? Als u deze gebruiker verwijdert, kan deze niet meer inloggen.<br/>\n";
		echo "<input type=\"hidden\" name=\"id\" value=\"".$intGebruikersID."\"></td></tr>";
		echo "<tr><td class=\"buttonvak\" colspan=\"2\"><input type=\"reset\" name=\"geenDelGebruikerKnop\" value=\"Gebruiker niet verwijderen\" class=\"button\" onclick=\"history.back()\"></td>\n";
		echo "<td class=\"buttonvak\"><input type=\"submit\" name=\"delGebruikerKnop\" value=\"Gebruiker verwijderen\" class=\"button\"></td></tr>\n";
		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=bg&amp;id=".$intGebruikersID."\" class=\"linkitem\">Bekijk gebruiker</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=eg&amp;id=".$intGebruikersID."\" class=\"linkitem\">Bewerk gebruiker</a></td>\n";
		echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Gebruikersoverzicht</a></td></tr>\n";
		echo "</td></tr>\n";
		echo "</table>";
	}
}

// Functie om een SELECT-lijst te krijgen van gebruikers
function showGebruikersList( $intSelected, $strWhiteSpace = false ) {
	$arrGebruikers = getGebruikers(-1);
	
	if($arrGebruikers == null || $arrGebruikers == false) {
		return false;
	}
	else {
		$intArraySize = count($arrGebruikers);
		echo "<select name=\"gid\" class=\"groot\">\n";
		if($strWhiteSpace != false)
			echo "<option value=\"\"";
			if($intSelected == "")
				echo " SELECTED";
			echo ">\n";
		for($i = 0;$i < $intArraySize; $i++) {
			$objGebruiker = new Gebruiker();
			$objGebruiker->setValues($arrGebruikers[$i]);
			echo "<option value=\"" . $objGebruiker->getID() . "\"";
			if($objGebruiker->getID() == $intSelected )
				echo " SELECTED";
			echo ">" . $objGebruiker->getVoorNaam()." ".$objGebruiker->getAchterNaam()." (ID: " . $objGebruiker->getID() .  ")\n";
		}
		echo "</select>\n";
	}
}

// Functie om het menu aan te maken, wat in het gebruikersoverzicht moet staan
function getGebruikersOptieMenu( $intGebruikersID ) {
	$strMenu = "<a href=\"".$_SERVER['PHP_SELF']."?actie=eg&amp;id=$intGebruikersID\" title=\"Bewerk gebruiker\"><img src=\"images/editpersonicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Bewerk gebruiker\"></a> ";
	$strMenu .= " <a href=\"".$_SERVER['PHP_SELF']."?actie=er&amp;id=$intGebruikersID\" title=\"Bewerk gebruikersrechten\"><img src=\"images/editicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Bewerk gebruikerinstellingen\"></a> ";
	$strMenu .= " <a href=\"".$_SERVER['PHP_SELF']."?actie=dg&amp;id=$intGebruikersID\" title=\"Verwijder gebruiker\"><img src=\"images/deleteicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Verwijder gebruiker\"></a>";
	return $strMenu;
}



?>