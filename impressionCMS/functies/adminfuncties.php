<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Adminfuncties.php
 * Beschrijving: De functies mbt Admin
 */

 
 // Functie om beheerder in te voeren
 function insertAdmin( Admin $objAdmin ) {
 	$sql = "INSERT INTO admin (loginnaam, wachtwoord, email, voornaam, tussenvoegsel, achternaam, aanmelddatum, actief, superuser, ip ) VALUES ";
 	$sql .= "('".$objAdmin->getLoginNaam()."', '".md5($objAdmin->getWachtwoord())."', '".$objAdmin->getEMail()."', '".$objAdmin->getVoorNaam()."', '".$objAdmin->getTussenvoegsel()."', ";
 	$sql .= "'".$objAdmin->getAchterNaam()."', '".$objAdmin->getAanmeldDatum()."','".$objAdmin->getActief()."', '".$objAdmin->getSuperUser()."', '".$objAdmin->getIP()."' )";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
 }
 // Functie om beheerderinfo uptedaten
 function updateAdmin( Admin $objAdmin ) {
 	$sql = "UPDATE admin SET loginnaam = '".$objAdmin->getLoginNaam()."', email = '".$objAdmin->getEMail()."', ";
 	$sql .= "voornaam = '".$objAdmin->getVoorNaam()."', tussenvoegsel = '".$objAdmin->getTussenvoegsel()."', achternaam = '".$objAdmin->getAchterNaam()."', ";
	$sql .= " superuser = '".$objAdmin->getSuperUser()."' ";
	if($objAdmin->getWachtwoord() != "" ) 
		$sql .= ", wachtwoord = '".md5($objAdmin->getWachtwoord())."' ";
	$sql .= " WHERE id = '".$objAdmin->getAdminID()."'";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql); 	
 }
 // Functie om wachtwoord te veranderen
 function updateAdminWachtwoord( $intAdminID, $strWachtwoord ) {
 	$sql = "UPDATE admin SET wachtwoord = '".md5($strWachtwoord)."' WHERE id = '$intAdminID'";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
 }
 // Functie om beheerder te verwijderen
 function delAdmin( $intAdminID ) {
 	$sql = "DELETE FROM admin WHERE id = '$intAdminID'";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
 }
 // Functie om beheerderinfo op te vragen
 function getAdmin( $intAdminID ) {
 	$sql = "SELECT * FROM admin WHERE id = '$intAdminID'";
 	global $dbConnectie;
 	$arrAdmins = $dbConnectie->getData($sql);
 	if($arrAdmins == false || $arrAdmins == null) {
		return false;
 	}
 	else {
	 	$objAdmin = new Admin();
 		$objAdmin->setValues($arrAdmins[0]);
	 	return $objAdmin;
 	}
 }
 // Functie om beheerderinfo op te vragen, via e-mail
 function getAdminMetMail( $strEmail ) {
 	$sql = "SELECT * FROM admin WHERE email ='$strEmail'";
 	global $dbConnectie;
 	$arrAdmins = $dbConnectie->getData($sql);
 	if($arrAdmins == false || $arrAdmins == null) {
		return false;
 	}
 	else {
	 	$objAdmin = new Admin();
 		$objAdmin->setValues($arrAdmins[0]);
	 	return $objAdmin;
 	}
 } 
 // Functie om alle beheerders op te vragen
 function getAdmins( $intVan = 0, $intAantal = 25) {
 	$sql = "SELECT * FROM admin ";
	if($intVan != -1)	
	 	$sql .= " LIMIT $intVan, $intAantal";
 	global $dbConnectie;
 	$arrAdmins = $dbConnectie->getData($sql);
 	return $arrAdmins;
 }
// Functie om het aantal beheerders op te vragen
function getAdminAantal() {
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
// Functie om een admin te bekijken
function showAdmin( $objAdmin ) {
	global $objLIAdmin;
    echo "<h1>Bekijk beheerdersinformatie</h1>\n";
    if($objAdmin == false || $objAdmin == null) {
       	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	    echo "<tr><td class=\"tabletitle\"  colspan=\"3\">Beheerder niet gevonden</td></tr>\n";
	    echo "<tr><td class=\"formvak\" colspan=\"3\">Er is geen informatie beschikbaar over de beheerder met het opgegeven ID-nummer.</td></tr>\n";
	    echo "<tr><td class=\"tablelinks\" colspan=\"3\"><a href=\"" . $_SERVER['PHP_SELF'] . "\" class=\"linkitem\">Beheerdersoverzicht</a></td></tr>\n";
	    echo "</table>\n";		    
    }
    else {
    	$arrLastLoginData = convertDatumTijd($objAdmin->getLastLogin());
    	$arrAanmeldData = convertDatumTijd($objAdmin->getAanmeldDatum());
        echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	    echo "<tr><td class=\"tabletitle\" colspan=\"3\">Beheerder: ".$objAdmin->getGebruikersNaam()."</td></tr>\n";
	    echo "<tr><td class=\"formvakb\" width=\"165\">Admin-ID:</td><td class=\"formvak\" colspan=\"2\">".$objAdmin->getAdminID()."</td></tr>\n";
	    echo "<tr><td class=\"formvakb\">Gebruikersnaam:</td><td class=\"formvak\" colspan=\"2\">".$objAdmin->getGebruikersNaam()."</td></tr>\n";
	    echo "<tr><td class=\"formvakb\">E-mail:</td><td class=\"formvak\" colspan=\"2\"><a href=\"mailto:".$objAdmin->getEMail()."\">".$objAdmin->getEMail()."</a></td></tr>\n";
	    echo "<tr><td class=\"formvakb\">Voornaam:</td><td class=\"formvak\" colspan=\"2\">".$objAdmin->getVoorNaam()."</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Tussenvoegsel:</td><td class=\"formvak\" colspan=\"2\">".$objAdmin->getTussenvoegsel()."</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Achternaam:</td><td class=\"formvak\" colspan=\"2\">".$objAdmin->getAchterNaam()."</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Toegevoegd op:</td><td class=\"formvak\" colspan=\"2\">".$arrAanmeldData['dag']."-".$arrAanmeldData['maand']."-".$arrAanmeldData['jaar']." om ".$arrAanmeldData['uur'].":".$arrAanmeldData['minuten']."</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Laatst ingelogd:</td><td class=\"formvak\" colspan=\"2\">";
    	if($objAdmin->getLastLogin() == "0000-00-00 00:00:00")
    		echo "Nog nooit";
    	else
			echo $arrLastLoginData['dag']."-".$arrLastLoginData['maand']."-".$arrLastLoginData['jaar']." om ".$arrLastLoginData['uur'].":".$arrLastLoginData['minuten'];
		echo "</td></tr>\n";
		echo "<tr><td class=\"formvakb\">Laatste IP-adres:</td><td class=\"formvak\" colspan=\"2\">";
		if($objAdmin->getIP() == "")
			echo "Geen";
		else
			echo $objAdmin->getIP();
		echo "</td></tr>\n";

		if($objLIAdmin->getSuperUser() == "ja") {
		echo "<tr><td class=\"formvakb\">Superuser:</td><td class=\"formvak\" colspan=\"2\">".$objAdmin->getSuperUser()."</td></tr>\n";
			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=ea&amp;id=".$objAdmin->getAdminID()."\" class=\"linkitem\">Bewerk beheerder</a></td>\n";
			if($objLIAdmin->getAdminID() == $objAdmin->getAdminID())
				echo "<td class=\"tablelinks\">&nbsp;</td>\n";
			else
				echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=da&amp;id=".$objAdmin->getAdminID()."\" class=\"linkitem\">Verwijder beheerder</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Beheerdersoverzicht</a></td></tr>\n";			
		}
		else {
			echo "<tr><td class=\"tablelinks\" colspan=\"2\">&nbsp;</td>\n";
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=ea&amp;id=".$objAdmin->getAdminID()."\" class=\"linkitem\">Bewerk gegevens</a></td></tr>\n";
			
		}
		echo "</table>\n";
	}
}


 // Functie om alle admins te showen
 function showAdminsOverzicht( $intPaginaNr = 0 ) {
  	echo "<h1>Bekijk beheerdersoverzicht</h1><br>\n";
 	$arrAdmins = getAdmins($intPaginaNr * 25, 25 );
   	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
 	if($arrAdmins == null || $arrAdmins == false) {
		    echo "<tr><td class=\"tabletitle\"  colspan=\"3\">Geen beheerders aanwezig</td></tr>\n";
		    echo "<tr><td class=\"formvak\" colspan=\"3\">Er zijn geen beheerders gevonden in de database. Aangezien dit nu wel wordt bekeken, is dat technisch onmogelijk.</td></tr>\n";
		    echo "<tr><td class=\"tablelinks\" colspan=\"3\">&nbsp;</td></tr>\n";
		    echo "</table>\n";	
 	}
 	else {
 	   	$intArraySize = count($arrAdmins);
	   	echo "<tr><td class=\"tabletitle\"  colspan=\"4\">Beheerdersoverzicht</td></tr>\n";
	   	echo "<tr><td class=\"tableinfo\">ID:</td><td class=\"tableinfo\">Naam:</td><td class=\"tableinfo\">E-mailadres:</td><td class=\"tableinfo\">Opties:</td></tr>\n";
 		for($i = 0; $i < $intArraySize; $i++ ) {
	 		$objAdmin = new Admin();
    		$objAdmin->setValues($arrAdmins[$i]);
     	 
	    	echo "<tr><td class=\"formvak\">".$objAdmin->getAdminID()."</td>\n";
		    echo "<td class=\"formvak\"><a href=\"".$_SERVER['PHP_SELF']."?actie=ba&amp;id=".$objAdmin->getAdminID()."\" title=\"Bekijk informatie van beheerder\">".$objAdmin->getVoornaam()." ".$objAdmin->getTussenvoegsel()." ".$objAdmin->getAchternaam()."</a></td>\n";
		    echo "<td class=\"formvak\"><a href=\"mailto:".$objAdmin->getEmail()."\" title=\"Stuur een e-mail\">".$objAdmin->getEmail()."</a></td>\n";
		    echo "<td class=\"formvak\">".getAdminOptieMenu( $objAdmin->getAdminID() )."</td></tr>\n";
	   	}
    
		echo "<tr><td class=\"tablelinks\">";
      	if($intPaginaNr > 1)
   	   		echo "<a href=\"".$_SERVER['PHP_SELF']."?v=25\" class=\"linksitem\"><- Vorige 25</a>";
      		echo "&nbsp;</td>\n";
      	echo "<td class=\"tablelinks\">";
		if(getAdminAantal() < ($intPaginaNr * 25))
      			echo "<a href=\"\" class=\"linksitem\">Volgende 25 -></a>";
       	echo "&nbsp;</td>\n";
	   	echo "<td class=\"tablelinks\" colspan=\"2\"><a href=\"".$_SERVER['PHP_SELF']."?actie=aa\" class=\"linkitem\">Voeg een beheerder toe</a></td>";
  		echo "</tr>";
	    echo "</table>\n";
    	echo "<br>";
    }
 }
 // Functie om login te checken
 function checkAdminLogin( $strGebrNaam, $strWW ) {
 	if(getAdmins() != null) {
	 	$sql = "SELECT * FROM admin WHERE loginnaam = '$strGebrNaam' AND wachtwoord = '".md5($strWW)."'";
  		global $dbConnectie;
	 	return $dbConnectie->getData($sql);	 		
 	}
 	else {
 		return "leeg";
 	}
 }
 // Functie om te checken of naam + email al eens voorkomt
 function checkAdminGegevens( $objAdmin ) {
 	$sql = "SELECT * FROM admin WHERE (loginnaam = '".$objAdmin->getGebruikersNaam()."' OR email = '".$objAdmin->getEMail()."') ";
 	if($objAdmin->getAdminID() != "")
 		$sql .= " AND id != '".$objAdmin->getAdminID()."'";
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
 // Functie om het registreer formulier te maken voor beheerders
 function maakAdminForm($objAdmin = '', $strActie = false) {
 	if($strActie == "add" || $strActie == "addgw") {
 		if($objAdmin == "")
	 		$objAdmin = new Admin();
 		$strKnopNaam = "addAdmin";
 		$strKnopTitel = "Voeg beheerder toe";
		echo "<h1>Voeg beheerder toe</h1>\n";
 	}
 	elseif($strActie == "new" || $strActie == "newgw") {
		if($objAdmin == "")
	 		$objAdmin = new Admin();
	 	$objAdmin->setIP( $_SERVER['REMOTE_ADDR'] ); 		
 		$strKnopNaam = "registreerFirst";
 		$strKnopTitel = "Registreer als eerste beheerder";
		echo "<h1>Registreer als beheerder</h1>\n";
 	}
 	elseif($strActie == "edit" || $strActie == "editgw") {
 		$strKnopNaam = "editAdmin";
 		$strKnopTitel = "Bewerk beheerder";
	    echo "<h1>Bewerk gegevens</h1>\n";
 	}
    if($objAdmin == false || $objAdmin == null) {
       	echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	    echo "<tr><td class=\"tabletitle\" colspan=\"3\">Beheerder niet gevonden</td></tr>\n";
	    echo "<tr><td class=\"formvak\" colspan=\"3\">De beheerder is niet gevonden.</td></tr>\n";
	    echo "<tr><td class=\"tablelinks\" colspan=\"3\"><a href=\"" . $_SERVER['PHP_SELF'] . "\" class=\"linkitem\">Beheerdersoverzicht</a></td></tr>\n";
	    echo "</table>\n";
    }
 	else {
		echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" id=\"registreerFirstForm\">\n";

		if($objAdmin->getAdminID() != "")
			echo "<input type=\"hidden\" name=\"aid\" value=\"".$objAdmin->getAdminID()."\">\n";
	    echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Beheerdersformulier</td></tr>\n";

		if($strActie == "new" || $strActie == "newgw") {
			echo "<tr><td class=\"formvak\" colspan=\"3\">Aangezien er nog geen beheerders aanwezig zijn in het systeem, is het noodzakelijk dat u zich via het onderstaand formulier registreert. U bent dan de eerste beheerder en ontvangt dan ook alle rechten.<br><br>Alle velden met een rode ster (<span class=\"redStar\">*</span>) erbij vermeld zijn verplicht om in te vullen. </td></tr>\n";
		}
		elseif($strActie == "add" || $strActie == "addgw") {
			echo "<tr><td class=\"formvak\" colspan=\"3\">De velden aangegeven met een rode ster (<span class=\"redStar\">*</span>) moeten worden ingevuld. </td></tr>\n";
		}
		elseif($strActie == "edit" || $strActie == "editgw") {
			echo "<tr><td class=\"formvak\" colspan=\"3\">De velden aangegeven met een rode ster (<span class=\"redStar\">*</span>) moeten worden ingevuld. Laat het wachtwoord-veld leeg als deze niet gewijzigd moet worden.</td></tr>\n";
		}

		echo "<tr><td class=\"formvakb\" width=\"165\">Voornaam: <span class=\"redStar\">*</span></td><td class=\"formvak\" colspan=\"2\"><input type=\"text\" name=\"voornaam\" value=\"".$objAdmin->getVoorNaam()."\" maxlength=\"100\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Tussenvoegsel: </td><td class=\"formvak\" colspan=\"2\"><input type=\"text\" name=\"tussenvoegsel\" value=\"".$objAdmin->getTussenvoegsel()."\" maxlength=\"20\"></td></tr>\n";	
		echo "<tr><td class=\"formvakb\">Achternaam: <span class=\"redStar\">*</span></td><td class=\"formvak\" colspan=\"2\"><input type=\"text\" name=\"achternaam\" value=\"".$objAdmin->getAchterNaam()."\" maxlength=\"100\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">E-mailadres: <span class=\"redStar\">*</span></td><td class=\"formvak\" colspan=\"2\"><input type=\"text\" name=\"email\" value=\"".$objAdmin->getEMail()."\" maxlength=\"100\"></td></tr>\n";
		echo "<tr><td class=\"formvakb\">Gebruikersnaam: <span class=\"redStar\">*</span></td><td class=\"formvak\" colspan=\"2\"><input type=\"text\" name=\"loginnaam\" value=\"".$objAdmin->getLoginNaam()."\" maxlength=\"15\"></td></tr>\n";

		echo "<tr><td class=\"formvakb\">Wachtwoord: ";
		// Verschillende manieren van het laten zien van wachtwoordvelden bij de acties
		if($strActie == "new" || $strActie == "add") {
			echo "<span class=\"redStar\">*</span></td><td class=\"formvak\"><input type=\"text\" name=\"wachtwoord\" value=\"\" maxlength=\"100\">";
		}
		elseif($strActie == "edit") {
			echo "</td><td class=\"formvak\"><input type=\"text\" name=\"wachtwoord\" value=\"\" maxlength=\"100\">";
		}
		elseif($strActie == "editgw") {
			echo "</td><td class=\"formvak\"><input type=\"text\" name=\"wachtwoord\" value=\"".$objAdmin->getWachtwoord()."\" maxlength=\"100\">";
		}
		else {
			echo "<span class=\"redStar\">*</span></td><td class=\"formvak\"><input type=\"text\" name=\"wachtwoord\" value=\"".$objAdmin->getWachtwoord()."\" maxlength=\"100\">";
		}
		echo "</td><td><input type=\"submit\" name=\"getRandomPassKnop\" value=\"Genereer wachtwoord\" class=\"button\"></td></tr>\n";
		global $objLIAdmin;
		if(isset($objLIAdmin) && $objLIAdmin->getSuperUser() == "ja")
			echo "<tr><td class=\"formvakb\">Superuser: <span class=\"redStar\">*</span></td><td class=\"formvak\" colspan=\"2\">".getSelectMenu("superuser", $objAdmin->getSuperUser())."</td></tr>\n";
		
		// Bij de eerste beheerder komt zijn IP-adres erbij te staan.
		if($strActie == "new" || $strActie == "newgw") {
			echo "<tr><td class=\"formvakb\">IP-adres:</td><td class=\"formvak\" colspan=\"2\">".$objAdmin->getIP()."<input type=\"hidden\" name=\"superuser\" value=\"ja\"></td></tr>\n";
		}

		echo "<tr><td class=\"buttonvak\" colspan=\"3\"><input type=\"submit\" name=\"".$strKnopNaam."Knop\" value=\"".$strKnopTitel."\" class=\"button\"></td></tr>\n";
		if(($strActie == "edit" || $strActie == "editgw") && ($objLIAdmin->getAdminID() == $objAdmin->getAdminID()) && $objLIAdmin->getSuperUser() != "ja") {
			echo "<tr><td class=\"tablelinks\" colspan=\"3\"><a href=\"".$_SERVER['PHP_SELF']."?actie=ba&amp;id=".$objAdmin->getAdminID()."\" class=\"linkitem\">Bekijk gegevens</a></td></tr>\n";
		}
		elseif($strActie == "edit" || $strActie == "editgw") {
			echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=ba&amp;id=".$objAdmin->getAdminID()."\" class=\"linkitem\">Bekijk beheerder</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=da&amp;id=".$objAdmin->getAdminID()."\" class=\"linkitem\">Verwijder beheerder</a></td>\n";
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Beheerdersoverzicht</a></td></tr>\n";
		}
		elseif($strActie == "add" || $strActie == "addgw") {
			echo "<tr><td class=\"tablelinks\" colspan=\"2\">&nbsp;</td>";
			echo "<td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Beheerdersoverzicht</a></td></tr>\n";
		}
		echo "</table>\n</form>\n"; 		
 	}

}


 
// Functie om het menu aan te maken, wat in het gebruikersoverzicht moet staan
function getAdminOptieMenu( $intAdminID ) {
	$strMenu = "<a href=\"".$_SERVER['PHP_SELF']."?actie=ea&amp;id=$intAdminID\" title=\"Bewerk beheerder\"><img src=\"images/editpersonicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Bewerk beheerder\"></a> ";
	if($intAdminID != 1)
		$strMenu .= " <a href=\"".$_SERVER['PHP_SELF']."?actie=da&amp;id=$intAdminID\" title=\"Verwijder beheerder\"><img src=\"images/deleteicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Verwijder beheerder\"></a>";
	else
		$strMenu .= " <a href=\"#\" title=\"Verwijderen van beheerder niet mogelijk\"><img src=\"images/deleteicondis.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Verwijder beheerder\"></a>";
	return $strMenu;
}

// Functie om formulier te maken om gebruiker te verwijderen
function maakDelAdminForm( $intAdminID ) {
	global $objLIAdmin;
	$objAdmin = getAdmin($intAdminID);
    echo "<h1>Verwijder beheerder</h1>\n";
	if($intAdminID == false || $intAdminID == 1 || $intAdminID < 0) {
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\">Verwijderen van beheerder niet mogelijk</td></tr>\n";
		echo "<tr><td class=\"formvak\">Het verwijderen van deze beheerder is niet mogelijk.</td></tr>\n";
		echo "<tr><td class=\"tablelinks\">&nbsp;</td></tr>\n";
		echo "</table>\n";
	}
	elseif($objAdmin == false || $objAdmin == null) {
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\">Beheerder niet gevonden</td></tr>\n";
		echo "<tr><td class=\"formvak\">De beheerder met het id-nummer $intAdminID is niet gevonden in de database.</td></tr>\n";
		echo "<tr><td class=\"tablelinks\">&nbsp;</td></tr>\n";
		echo "</table>\n";	
	}
	elseif($intAdminID == $objLIAdmin->getID()) {
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\">Verwijderen van beheerder niet mogelijk</td></tr>\n";
		echo "<tr><td class=\"formvak\">Het is niet mogelijk om jezelf als beheerder te verwijderen.</td></tr>\n";
		echo "<tr><td class=\"tablelinks\">&nbsp;</td></tr>\n";
		echo "</table>\n";
	}
	else {
		echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\" id=\"delAdminForm\">\n";
		echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Beheerder verwijderen</td></tr>\n";
		echo "<tr><td class=\"formvak\" colspan=\"3\">Weet u zeker dat u deze beheerder wilt verwijderen? Als u deze beheerder verwijdert, kan deze niet meer inloggen.</td></tr>\n";
		echo "<tr><td class=\"buttonvak\"><input type=\"hidden\" name=\"id\" value=\"".$intAdminID."\"></td>";
		echo "<td class=\"buttonvak\" colspan=\"2\"><input type=\"reset\" name=\"geenDelAdminKnop\" value=\"Beheerder niet verwijderen\" class=\"button\" onclick=\"history.back()\"> \n<input type=\"submit\" name=\"delAdminKnop\" value=\"Beheerder verwijderen\" class=\"button\"></td></tr>\n";
		echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=ba&amp;id=".$intAdminID."\" class=\"linkitem\">Bekijk beheerder</a></td><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."?actie=ea&amp;id=".$intAdminID."\" class=\"linkitem\">Bewerk beheerder</a></td><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF']."\" class=\"linkitem\">Beheerdersoverzicht</a></td></tr>";
		echo "</td></tr>\n";
		echo "</table>\n";
	}
}
// Functie om een SELECT-lijst te krijgen van beheerdersfunction showBeheerdersList( $intSelected, $strWhiteSpace = false ) {
	$arrBeheerders = getAdmins(-1);
	
	if($arrBeheerders == null || $arrBeheerders == false) {
		return false;
	}
	else {
		$intArraySize = count($arrBeheerders);
		echo "<select name=\"aid\" class=\"groot\">\n";
		if($strWhiteSpace != false) {
			echo "<option value=\"\"";
			if($intSelected == "")
				echo " SELECTED";
			echo ">\n";
		}
		for($i = 0;$i < $intArraySize; $i++) {
			$objBeheerder = new Admin();
			$objBeheerder->setValues($arrBeheerders[$i]);
			echo "<option value=\"" . $objBeheerder->getID() . "\"";
			if($objBeheerder->getID() == $intSelected )
				echo " SELECTED";
			echo ">" . $objBeheerder->getVolledigeNaam()." (ID: " . $objBeheerder->getID() .  ")\n";
		}
		echo "</select>\n";
	}
}
?>