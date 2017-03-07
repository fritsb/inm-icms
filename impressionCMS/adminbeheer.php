<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: adminbeheer.inc.php
 * Beschrijving: De beheerpagina voor beheerder
 */

 session_start();
 include("header.php");

 if(!isset($_SESSION['login']) || $_SESSION['login'] == "gebruiker") {
 	echo "<h1>Geen toegang</h1>\n";
 	echo "Om deze pagina te gebruiken, moet je eerst inloggen bij het beheerdersgedeelte.\n";
	// Logboek 
	if(isset($objLIGebruiker)) {
		$strTekst = maakLogTekst( "De gebruiker", $objLIGebruiker, "heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen. ");
		verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $objLIGebruiker->getWebsiteID(), "Geen toegang" );
	}
	else {
		$strTekst = "Persoon met het IP-adres ".$_SERVER['REMOTE_ADDR']." heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen.";
		verwerkLogRegel( $strTekst, '','','', "Geen toegang" );
	}			
 }
 elseif($objLIAdmin->getSuperUser() == "nee" && !isset($_GET['id']) && !isset($_GET['actie']) && !isset($_POST['aid'])) {
 	echo "<h1>Geen toegang</h1>\n";
 	echo "Alleen de hoofdbeheerders hebben toegang tot dit onderdeel.\n"; 	
	// Logboek
	$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft het beheerdersgedeelte proberen aan te roepen zonder toestemming. ");
	verwerkLogRegel( $strTekst, '',$objLIAdmin->getID() , '', "Geen toegang" );
 }
 elseif($_SESSION['login'] == "admin") {
     if(isset($_GET['actie'])) {
	   // Actie om admininfo te bekijken
       if($_GET['actie'] == "ba" && isset($_GET['id'])) {
          $intAdminID = checkData($_GET['id']);
        	 if($objLIAdmin->getSuperUser() == "ja" || $objLIAdmin->getAdminID() == $intAdminID)
				$objAdmin = getAdmin($intAdminID);
			  	 showAdmin( $objAdmin );
			  	 // Logboek
			  	if($objAdmin != null & $objAdmin != false) {
					$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft de informatie van de beheerder met de naam '".$objAdmin->getVolledigeNaam().
						"' (ID: $intAdminID) bekeken.");
					verwerkLogRegel( $strTekst, '',$objLIAdmin->getID() , '', "Bekeken" );
				}
				else {
					$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd de informatie van de beheerder met ID-nummer '$intAdminID' te bekijken. Maar dit is ongeldig ID-nummer.");	
					verwerkLogRegel( $strTekst, '',$objLIAdmin->getID() , '', "Fout" );
				}
     	}
     	// Actie om admininfo toe te voegen
     	if($_GET['actie'] == "aa" && $objLIAdmin->getSuperUser() == "ja") {
     		maakAdminForm('', "add");
     	}
     	// Actie om admininfo te bewerken
     	if($_GET['actie'] == "ea" && isset($_GET['id']) && ($objLIAdmin->getSuperUser() == "ja" || ($_GET['id'] == $objLIAdmin->getAdminID()))) {
     		$intAdminID = checkData($_GET['id'], "nummer");
     		$objAdmin = getAdmin($intAdminID);
     		maakAdminForm($objAdmin, "edit");
     	}
     	// Actie om admininfo te verwijderen
     	if($_GET['actie'] == "da" && isset($_GET['id']) && $objLIAdmin->getSuperUser() == "ja") {
     		$intAdminID = checkData($_GET['id'], "nummer");
     		maakDelAdminForm($intAdminID);
     	}     	     	
     }
     // Actie als men op de toevoeg-knop heeft gedrukt
     elseif(isset($_POST['addAdminKnop']) && $objLIAdmin->getSuperUser() == "ja") {
		// Stop alle gegevens in het object
     	$objAdmin = new Admin();
     	$objAdmin->setGebruikersNaam( checkData($_POST['loginnaam']) );
     	$objAdmin->setWachtwoord( checkData($_POST['wachtwoord']) ); 
     	$objAdmin->setEMail( checkData($_POST['email']) );
     	$objAdmin->setVoorNaam( checkData($_POST['voornaam']) );
     	$objAdmin->setTussenvoegsel( checkData($_POST['tussenvoegsel']) );
     	$objAdmin->setAchterNaam( checkData($_POST['achternaam']) );
     	$objAdmin->setAanmeldDatum( getDatumTijd() );
     	$objAdmin->setSuperUser( checkData( $_POST['superuser']) );

		// Checkt of alles wel is ingevuld
     	if(!checkAdminGegevens($objAdmin))
 			$arrError[0] = true;
	 	if($objAdmin->getVoorNaam() == "")
 			$arrError[1] = true;
	 	if($objAdmin->getAchterNaam() == "")
 			$arrError[2] = true;
	 	if($objAdmin->getEMail() == "" || !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$", $objAdmin->getEMail()) )
 			$arrError[3] = true;
	 	if($objAdmin->getLoginNaam() == "")
 			$arrError[4] = true;
 		if($objAdmin->getWachtwoord() == "")
	 		$arrError[5] = true;
	 	
	 	// Gaat na of er errors zijn en laat dit op het scherm zien
     	if(isset($arrError) && !checkErrors($arrError)) {
		  	$strFoutMelding = "Er zijn error(s) opgetreden tijdens het verwerken van de gegevens. Hieronder staan de melding(en):<br><ul>\n";
			if(isset($arrError[0]))
			    $strFoutMelding .= "<li>Het e-mailadres of gebruikersnaam staat al in de database. Kies een andere gebruikersnaam of e-mailadres. \n ";
			if(isset($arrError[1])) 
			    $strFoutMelding .= "<li>Er is geen voornaam ingevuld.\n ";
			if(isset($arrError[2]))
			    $strFoutMelding .= "<li>Er is geen achternaam ingevuld.\n ";
			if(isset($arrError[3]))
			    $strFoutMelding .= "<li>Er is geen (correct) e-mailadres ingevuld.\n ";
			if(isset($arrError[4])) 
			    $strFoutMelding .= "<li>Er is geen gebruikersnaam ingevuld.\n ";
			if(isset($arrError[5])) 
			    $strFoutMelding .= "<li>Er is geen wachtwoord ingevuld.\n ";

			$strFoutMelding .= "</ul><br>Probeer nogmaals de gegevens in te vullen in het onderstaande formulier.\n"; 
			showErrMessage($strFoutMelding);
    	
     		maakAdminForm($objAdmin, "addgw");
     		$booFout = true;
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd om een beheerder met de naam '".$objAdmin->getVolledigeNaam()."' toe te voegen. Dit is mislukt, omdat niet alle gegevens correct waren ingevuld.");
			verwerkLogRegel( $strTekst, '',$objLIAdmin->getID() , '', "Fout" );
     	}
     	// Probeert de gegevens in de database te inserten, melding hieronder als het niet lukt
     	elseif(!insertAdmin($objAdmin)) {
			$booFout = false;
     		showErrMessage( "Het invoeren van de beheerder is niet goed gelukt.");
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd om een beheerder met de naam '".$objAdmin->getVolledigeNaam()."' toe te voegen, maar dit is mislukt. ");
			verwerkLogRegel( $strTekst, '',$objLIAdmin->getID() , '', "Fout" );
     	}
     	// Melding hieronder als het wel is gelukt
     	else {
			$booFout = false;
     		showMedMessage( "Het invoeren van de beheerder is goed gelukt.");
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft een beheerder met de naam '".$objAdmin->getVolledigeNaam()."' succesvol toegevoegd. ");
			verwerkLogRegel( $strTekst, '',$objLIAdmin->getID() , '', "Toevoeging" );
     	}
     	if($booFout == false)
		    showAdminsOverzicht();
     }
     // Actie als men op de bewerk-knop heeft gedrukt
     elseif(isset($_POST['editAdminKnop']) && ($objLIAdmin->getSuperUser() == "ja" || ($_POST['aid'] == $objLIAdmin->getAdminID()))) {
     	// Alle gegevens in object stoppen
     	$objAdmin = getAdmin(checkData($_POST['aid'], "integer") );
     	$objAdmin->setGebruikersNaam( checkData($_POST['loginnaam']) );
     	$objAdmin->setWachtwoord( checkData($_POST['wachtwoord']) ); 
     	$objAdmin->setEMail( checkData($_POST['email']) );
     	$objAdmin->setVoorNaam( checkData($_POST['voornaam']) );
     	$objAdmin->setTussenvoegsel( checkData($_POST['tussenvoegsel']) );
     	$objAdmin->setAchterNaam( checkData($_POST['achternaam']) );
     	if($objLIAdmin->getSuperUser() == "ja")
	     	$objAdmin->setSuperUser( checkData( $_POST['superuser']) );
	   else
	   	$objAdmin->setSuperUser( "nee" );
		
		// Checken of alles wel is ingevuld
     	if(!checkAdminGegevens($objAdmin))
 			$arrError[0] = true;
	 	if($objAdmin->getVoorNaam() == "")
 			$arrError[1] = true;
	 	if($objAdmin->getAchterNaam() == "")
 			$arrError[2] = true;
	 	if($objAdmin->getEMail() == "" || !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$", $objAdmin->getEMail()) )
 			$arrError[3] = true;
	 	if($objAdmin->getLoginNaam() == "")
 			$arrError[4] = true;

	 	// Nagaan of er errors zijn
	 	// Zo ja, dan komen de errors op het scherm en wordt men terug gestuurd naar het formulier
     	if(isset($arrError) && !checkErrors($arrError)) {
		  	$strFoutMelding = "Er zijn error(s) opgetreden tijdens het verwerken van de gegevens. Hieronder staan de melding(en):<br><ul>\n";
			if(isset($arrError[0]))
			    $strFoutMelding .= "<li>Het e-mailadres of gebruikersnaam staat al in de database. Kies een andere gebruikersnaam of e-mailadres. \n ";
			if(isset($arrError[1])) 
			    $strFoutMelding .= "<li>Er is geen voornaam ingevuld.\n ";
			if(isset($arrError[2])) 
			    $strFoutMelding .= "<li>Er is geen achternaam ingevuld.\n ";
			if(isset($arrError[3])) 
			    $strFoutMelding .= "<li>Er is geen (correct) e-mailadres ingevuld.\n ";
			if(isset($arrError[4])) 
			    $strFoutMelding .= "<li>Er is geen gebruikersnaam ingevuld.\n ";

			$strFoutMelding .= "</ul><br>Probeer nogmaals de gegevens in te vullen in het onderstaande formulier.\n"; 
			showErrMessage($strFoutMelding);
    	
     		maakAdminForm($objAdmin, "editgw");
     		$booFout = true;
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd om de gegevens van de beheerder met de naam '".$objAdmin->getVolledigeNaam()."' (ID: ".$objAdmin->getID().") te bewerken. Dit is mislukt, omdat niet alle gegevens correct waren ingevuld.");
			verwerkLogRegel( $strTekst, '',$objLIAdmin->getID() , '', "Fout" );
     	}
     	// Probeer de gegevens up te daten, melding hieronder als het niet lukt
     	elseif(!updateAdmin($objAdmin)) {
			$booFout = false;
     		showErrMessage("Het bijwerken van de gegevens van de beheerder is niet gelukt.");
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft de gegevens van de beheerder met de naam '".$objAdmin->getVolledigeNaam()."' (ID: ".$objAdmin->getID().") proberen te bewerken. Dit is mislukt.");
			verwerkLogRegel( $strTekst, '',$objLIAdmin->getID() , '', "Fout" );
     	}
     	// Melding hieronder als alles wel lukt
     	else {
			$booFout = false;
     		showMedMessage("Het bijwerken van de gegevens van de beheerder is gelukt.");
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft de gegevens van de beheerder met de naam '".$objAdmin->getVolledigeNaam()."' (ID: ".$objAdmin->getID().") succesvol bewerkt.");
			verwerkLogRegel( $strTekst, '',$objLIAdmin->getID() , '', "Bewerking" );
     	}
     	if($booFout == false) 
		    showAdmin( $objAdmin );
     }
     // Actie als men op de "Genereer wachtwoord"-knop heeft gedrukt
     elseif(isset($_POST['getRandomPassKnop']) && ($objLIAdmin->getSuperUser() == "ja" || ($_POST['aid'] == $objLIAdmin->getAdminID()))) {
		// Stop de gegevens in hetobject
     	$objAdmin = new Admin();
     	if(isset($_POST['aid']))
	     	$objAdmin->setAdminID( checkData($_POST['aid'], "integer") );
     	$objAdmin->setGebruikersNaam( checkData($_POST['loginnaam']) );
     	// De functie getRandomPass wordt aangeroepen, wachtwoord krijgt lengte van 10 karakters
     	$objAdmin->setWachtwoord( getRandomPass(10) );
     	$objAdmin->setEMail( checkData($_POST['email']) );
     	$objAdmin->setVoorNaam( checkData($_POST['voornaam']) );
     	$objAdmin->setTussenvoegsel( checkData($_POST['tussenvoegsel']) );
     	$objAdmin->setAchterNaam( checkData($_POST['achternaam']) );
     	if($objLIAdmin->getSuperUser() == "ja")
	     	$objAdmin->setSuperUser( checkData( $_POST['superuser']) );

		// Het formulier wordt weer aangeroepen met bij de parameter 'strActie' "gw" erbij
		if(isset($_POST['aid'])) {
		    maakAdminForm( $objAdmin, "editgw");
		}
		else {
			maakAdminForm( $objAdmin, "addgw");
		}
     }
     // Actie als men op verwijder knop heeft gedrukt
     elseif(isset($_POST['delAdminKnop']) && $objLIAdmin->getSuperUser() == "ja") {
     	$intAdminID = $_POST['id'];
     	$objAdmin = getAdmin($intAdminID);
      if($objAdmin != null && $objAdmin != false && !delAdmin($intAdminID)) {
     		showErrMessage("Het verwijderen van de gegevens van de beheerder is niet gelukt.");
			// Logboek
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft de gegevens van de beheerder met de naam '".$objAdmin->getVolledigeNaam()."' (ID: ".$intAdminID.") proberen te verwijderen.");
			verwerkLogRegel( $strTekst, '',$objLIAdmin->getID() , '', "Fout" );
     	}
     	elseif($objAdmin != null && $objAdmin != false) {
     		showMedMessage("Het verwijderen van de gegevens van de beheerder is gelukt.");
			// Logboek 			
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft de gegevens van de beheerder met de naam '".$objAdmin->getVolledigeNaam()."' (ID: ".$intAdminID.") succesvol verwijderd.");
			verwerkLogRegel( $strTekst, '',$objLIAdmin->getID() , '', "Verwijdering" );
     	}
		showAdminsOverzicht();
     }
     elseif($objLIAdmin->getSuperUser() == "ja") {
			showAdminsOverzicht();
     }     

 }
 
 include("footer.php");
?>