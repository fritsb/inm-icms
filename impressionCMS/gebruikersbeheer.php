<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: gebruikersbeheer.php
 * Beschrijving: De beheerpagina van gebruikers
 */
 session_start();
 include("header.php");
 
 if(isset($_SESSION['login']) && $_SESSION['login'] == "gebruiker" && isset($_GET['actie'])) {
      if($_GET['actie'] == "bg") {
		  showGebruikersInfo( $objLIGebruiker, $objLIGebRechten );
     	}
     	elseif($_GET['actie'] == "eg") {
		  maakPersoonlijkInfoForm( $objLIGebruiker );
     	}
     	else {
     		echo "<h1>Geen toegang</h1>";
		 	echo "Er is geen juiste actie opgegeven, dus kan de pagina niet worden getoond.";
			// Logboek 
			$strTekst = maakLogTekst( "De gebruiker", $objLIGebruiker, "heeft zonder toestemming '".$_SERVER['PHP_SELF']."' proberen aan te roepen.");
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $objLIGebruiker->getWebsiteID(), "Geen toegang" );
     	}
 }
 elseif(isset($_SESSION['login']) && $_SESSION['login'] == "gebruiker" && isset($_POST['getRandomPassKnop'])) {
		// Stop de gegevens in het object
     	$objGebruiker = new Gebruiker();
     	$objGebruiker->setGebruikersID( $objLIGebruiker->getGebruikersID() );
     	// De functie getRandomPass wordt aangeroepen, wachtwoord krijgt lengte van 10 karakters
     	$objGebruiker->setWachtwoord( getRandomPass(10) );
     	$objGebruiker->setEMail( checkData($_POST['email']) );
     	$objGebruiker->setVoorNaam( checkData($_POST['voornaam']) );
     	$objGebruiker->setTussenvoegsel( checkData($_POST['tussenvoegsel']) );
     	$objGebruiker->setAchterNaam( checkData($_POST['achternaam']) );
     	$objGebruiker->setWoonplaats( checkData($_POST['woonplaats']) );
     	$objGebruiker->setStraat( checkData($_POST['straat']) );
     	$objGebruiker->setHuisNr( checkData($_POST['huisnr']) );
     	$objGebruiker->setPostcode( checkData($_POST['postcode1']) . checkData($_POST['postcode2']) );
     	$objGebruiker->setTelNr( checkData($_POST['telnr']) );
     	$objGebruiker->setFaxNr( checkData($_POST['faxnr']) );
     	$objGebruiker->setMobielNr( checkData($_POST['mobielnr']) );     	

		// Het formulier wordt weer aangeroepen met bij de parameter 'strActie' "gw" erbij
	    maakPersoonlijkInfoForm( $objGebruiker, true);
}
elseif(isset($_SESSION['login']) && $_SESSION['login'] == "gebruiker" && isset($_POST['bewerkGebruikerInfoKnop'])) {
		$objGebruiker = new Gebruiker();
		$objGebruiker->setGebruikersID( $objLIGebruiker->getGebruikersID() );
		$objGebruiker->setGebruikersNaam($objLIGebruiker->getGebruikersNaam() );
     	$objGebruiker->setWebsiteID( $objLIGebruiker->getWebsiteID() );
    	$objGebruiker->setWachtwoord( checkData($_POST['wachtwoord']) );
     	$objGebruiker->setEMail( checkData($_POST['email']) );
     	$objGebruiker->setVoorNaam( checkData($_POST['voornaam']) );
     	$objGebruiker->setTussenvoegsel( checkData($_POST['tussenvoegsel']) );
     	$objGebruiker->setAchterNaam( checkData($_POST['achternaam']) );
     	$objGebruiker->setWoonplaats( checkData($_POST['woonplaats']) );
     	$objGebruiker->setStraat( checkData($_POST['straat']) );
     	$objGebruiker->setHuisNr( checkData($_POST['huisnr']) );
     	$objGebruiker->setPostcode( checkData($_POST['postcode1']) . checkData($_POST['postcode2']) );
     	$objGebruiker->setTelNr( checkData($_POST['telnr']) );
     	$objGebruiker->setFaxNr( checkData($_POST['faxnr']) );
     	$objGebruiker->setMobielNr( checkData($_POST['mobielnr']) );

		// Checkt of alles wel is ingevuld
     	if(!checkGebruikerGegevens($objGebruiker))
 			$arrError[0] = true;
	 	if($objGebruiker->getVoorNaam() == "")
 			$arrError[1] = true;
	 	if($objGebruiker->getAchterNaam() == "")
 			$arrError[2] = true;
	 	if($objGebruiker->getEMail() == "" || !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$", $objGebruiker->getEMail()) )
 			$arrError[3] = true;
 		if($objGebruiker->getWebsiteID() == "")
	 		$arrError[6] = true;
     	
     	// Laat de errors zien
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
			if(isset($arrError[6])) 
			    $strFoutMelding .= "<li>Er is geen website geselecteerd.\n ";

			$strFoutMelding .= "</ul><br>Probeer nogmaals de gegevens in te vullen in het onderstaande formulier.\n"; 
			showErrMessage($strFoutMelding);
			// Logboek 
			$strTekst = maakLogTekst( "De gebruiker", $objLIGebruiker, "heeft geprobeerd om zijn/haar eigen gegevens te bewerken. Dit is niet gelukt, omdat  sommige verplichte gegevens niet juist waren.");
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $objLIGebruiker->getWebsiteID(), "Fout" );
			// Roept nogmaals het formulier aan
     		maakPersoonlijkInfoForm($objGebruiker, true	);
     		$booFout = true;
		}
		// Probeert de gegevens in de database te zetten, als het niet lukt een melding
     	elseif(!updateGebruiker($objGebruiker)) {
     		$booFout = false;
     		showErrMessage("Het bijwerken van de gegevens van de gebruiker is niet gelukt.");
     		// Logboek 
			$strTekst = maakLogTekst( "De gebruiker", $objLIGebruiker, "heeft geprobeerd om zijn/haar eigen gegevens te bewerken. Dit is niet gelukt.");
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $objLIGebruiker->getWebsiteID(), "Fout" );
     	}
     	// Het is wel gelukt
     	else {
     		$booFout = false;
     		// Logboek 
			$strTekst = maakLogTekst( "De gebruiker", $objLIGebruiker, "heeft succesvol zijn/haar eigen gegevens bewerkt.");
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $objLIGebruiker->getWebsiteID(), "Bewerking" );
     		showMedMessage("Het bijwerken van de gegevens van de gebruiker is gelukt.");
     	}
    	// Als er geen errors zijn, dan wordt de gebruikerinfo nog geshowed
    	if($booFout == false) {
    		$objLIGebruiker = getGebruiker($objGebruiker->getGebruikersID());
    		$_SESSION['geb'] = serialize($objLIGebruiker);
	     	showGebruikersInfo( $objLIGebruiker, $objLIGebRechten );
    	}
 }
 elseif(!isset($_SESSION['login']) || $_SESSION['login'] == "gebruiker") {
 	echo "<h1>Geen toegang</h1>\n";
 	echo "Om deze pagina te gebruiken, moet je eerst inloggen bij het beheerdersgedeelte.\n";
	// Logboek 
	if(isset($objLIGebruiker)) {
		$strTekst = maakLogTekst( "De gebruiker", $objLIGebruiker, "heeft zonder toestemming '".$_SERVER['PHP_SELF']."' proberen aan te roepen.");
		verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $objLIGebruiker->getWebsiteID(), "Geen toegang" );
	}
	else {
		$strTekst = "Persoon met het IP-adres ".$_SERVER['REMOTE_ADDR']." heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen.";
		verwerkLogRegel( $strTekst, '','','', "Geen toegang" );
	}
}
 elseif($_SESSION['login'] == "admin") {
     if(isset($_GET['actie'])) {
       // Om gebruiker te bekijken
       if($_GET['actie'] == "bg" && isset($_GET['id'])) {
         $intGebruikersID = checkData($_GET['id']);
         $objGebruiker = getGebruiker( $intGebruikersID );
		  	showGebruiker( $objGebruiker );	
			// Logboek 
			if($objGebruiker != false || $objGebruiker != null) {
				$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft de informatie van de gebruiker met de naam '".$objGebruiker->getVolledigeNaam()."' (ID: ".$objGebruiker->getGebruikersID().") bekeken.");
				verwerkLogRegel( $strTekst, $intGebruikersID, $objLIAdmin->getID(), '', "Bekijken");
			}
			else {
				$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd de informatie van de gebruiker met het ID-nummer $intGebruikersID te bekijken.");
				verwerkLogRegel( $strTekst, $intGebruikersID, $objLIAdmin->getID(), '', "Fout");
			}
	  	}
     	// Om gebruiker toe te voegen (alleen als er al websites aanwezig zijn)
     	if($_GET['actie'] == "ag") {
     		if(getWebsiteOverzicht() == null)  {
    			echo "<h1>Er zijn geen websites aanwezig</h1>\n";
    			echo "Om gebruikers aan te maken, is het noodzakelijk dat er al websites zijn aangemaakt. <br><br>\n";
    			echo "<a href=\"".$strCMSURL.$strCMSDir."websitebeheer.php?actie=aw\">Klik hier om een website aan te maken.</a>";
     		}
     		else
	     		maakGebruikerForm('', "add");
     	}
     	// Om gebruikers te bewerken
     	if($_GET['actie'] == "eg" && isset($_GET['id'])) {
     		$intGebruikersID = checkData($_GET['id'], "nummer");
     		$objGebruiker = getGebruiker($intGebruikersID);
     		maakGebruikerForm($objGebruiker, "edit");
     	}
     	// Om gebruikers te verwijderen
     	if($_GET['actie'] == "dg" && isset($_GET['id'])) {
     		$intGebruikersID = checkData($_GET['id'], "nummer");
     		maakDelGebruikerForm($intGebruikersID);
     	}
     	// Om gebruikersrechten te bewerken
     	if($_GET['actie'] == "er" && isset($_GET['id'])) {
     		$intGebruikersID = checkData($_GET['id'], "nummer");
     		maakGebruikersRechtenForm("edit", $intGebruikersID);
     	}
     }
     // Handeling(en) wanneer er op de knop is gedrukt om gebruikers toe te voegen
     elseif(isset($_POST['addGebruikerKnop'])) {
     	// Alle gegevens in een object
     	$objGebruiker = new Gebruiker();
     	$objGebruiker->setGebruikersNaam( checkData($_POST['gebruikersnaam']) );
     	$objGebruiker->setWachtwoord( checkData($_POST['wachtwoord']) ); 
     	$objGebruiker->setEMail( checkData($_POST['email']) );
     	$objGebruiker->setVoorNaam( checkData($_POST['voornaam']) );
     	$objGebruiker->setTussenvoegsel( checkData($_POST['tussenvoegsel']) );
     	$objGebruiker->setAchterNaam( checkData($_POST['achternaam']) );
     	$objGebruiker->setWoonplaats( checkData($_POST['woonplaats']) );
     	$objGebruiker->setStraat( checkData($_POST['straat']) );
     	$objGebruiker->setHuisNr( checkData($_POST['huisnr']) );
     	$objGebruiker->setPostcode( checkData($_POST['postcode1']) . checkData($_POST['postcode2']) );
     	$objGebruiker->setTelNr( checkData($_POST['telnr']) );
     	$objGebruiker->setFaxNr( checkData($_POST['faxnr']) );
     	$objGebruiker->setMobielNr( checkData($_POST['mobielnr']) );  
     	$objGebruiker->setWebsiteID( checkData( $_POST['wid'] ));
     	
		// Checkt of alles wel is ingevuld en of email en gebruikersnaam al niet bestaan in database
     	if(!checkGebruikerGegevens($objGebruiker))
 			$arrError[0] = true;
	 	if($objGebruiker->getVoorNaam() == "")
 			$arrError[1] = true;
	 	if($objGebruiker->getAchterNaam() == "")
 			$arrError[2] = true;
	 	if($objGebruiker->getEMail() == "" || !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$", $objGebruiker->getEMail()) )
 			$arrError[3] = true;
	 	if($objGebruiker->getGebruikersNaam() == "")
 			$arrError[4] = true;
 		if($objGebruiker->getWachtwoord() == "")
	 		$arrError[5] = true;
 		if($objGebruiker->getWebsiteID() == "")
	 		$arrError[6] = true;
     	
     	// Laat de errors zien
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
			if(isset($arrError[6])) 
			    $strFoutMelding .= "<li>Er is geen website geselecteerd.\n ";

			$strFoutMelding .= "</ul><br>Probeer nogmaals de gegevens in te vullen in het onderstaande formulier.\n"; 
			showErrMessage($strFoutMelding);
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd om een gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
			"' toe te voegen. Dit is niet gelukt, omdat een aantal verplichte gegevens niet correct zijn ingevuld.");
			verwerkLogRegel( $strTekst, $objGebruiker->getID(), $objLIAdmin->getID(), '', "Fout");
    		// Roept nogmaals het formulier aan
     		maakGebruikerForm($objGebruiker, "addgw");
     	}
     	// Probeert de gegevens in de database te zetten, als het niet lukt een melding
     	elseif(!insertGebruiker($objGebruiker)) {
     		showErrMessage( "Het toevoegen van de gebruiker is niet goed gelukt." );
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd om een nieuwe gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
			 "' toe te voegen. Dit is niet gelukt.");
			verwerkLogRegel( $strTekst, $objGebruiker->getID(), $objLIAdmin->getID(), '', "Fout");
     		showGebruikerOverzicht();
     	}
     	// Het is wel gelukt:
     	else {
     		showMedMessage( "Het toevoegen van de gebruiker is goed gelukt." );
	     	maakGebruikersRechtenForm("add", getLastID());
	     	$objGebruiker->setGebruikersID( getLastID());
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft succesvol een nieuwe gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
			 "' (ID: ".$objGebruiker->getID().")  toegevoegd.");
			verwerkLogRegel( $strTekst, $objGebruiker->getID(), $objLIAdmin->getID(), '', "Toevoeging");
     	}
     }
     // Handeling(en) wanneer men op bewerk-knop heeft gedrukt
     elseif(isset($_POST['editGebruikerKnop'])) {
        // Alle gegevens in het object
     	$objGebruiker = getGebruiker( checkData($_POST['gid']) );
     	$objGebruiker->setGebruikersNaam( checkData($_POST['gebruikersnaam']) );
     	$objGebruiker->setWachtwoord( checkData($_POST['wachtwoord']) );     	
     	$objGebruiker->setEMail( checkData($_POST['email']) );
     	$objGebruiker->setVoorNaam( checkData($_POST['voornaam']) );
     	$objGebruiker->setTussenvoegsel( checkData($_POST['tussenvoegsel']) );
     	$objGebruiker->setAchterNaam( checkData($_POST['achternaam']) );
     	$objGebruiker->setWoonplaats( checkData($_POST['woonplaats']) );
     	$objGebruiker->setStraat( checkData($_POST['straat']) );
     	$objGebruiker->setHuisNr( checkData($_POST['huisnr']) );
     	$objGebruiker->setPostcode( checkData($_POST['postcode1']) . checkData($_POST['postcode2']) );
     	$objGebruiker->setTelNr( checkData($_POST['telnr']) );
     	$objGebruiker->setFaxNr( checkData($_POST['faxnr']) );
     	$objGebruiker->setMobielNr( checkData($_POST['mobielnr']) );     	
     	$objGebruiker->setWebsiteID( checkData( $_POST['wid'] ));

		// Checkt of alles wel is ingevuld
     	if(!checkGebruikerGegevens($objGebruiker))
 			$arrError[0] = true;
	 	if($objGebruiker->getVoorNaam() == "")
 			$arrError[1] = true;
	 	if($objGebruiker->getAchterNaam() == "")
 			$arrError[2] = true;
	 	if($objGebruiker->getEMail() == "" || !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$", $objGebruiker->getEMail()) )
 			$arrError[3] = true;
	 	if($objGebruiker->getGebruikersNaam() == "")
 			$arrError[4] = true;
 		if($objGebruiker->getWebsiteID() == "")
	 		$arrError[6] = true;
     	
     	// Laat de errors zien
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
			if(isset($arrError[6])) 
			    $strFoutMelding .= "<li>Er is geen website geselecteerd.\n ";

			$strFoutMelding .= "</ul><br>Probeer nogmaals de gegevens in te vullen in het onderstaande formulier.\n"; 
			showErrMessage($strFoutMelding);
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd om de gegevens van de gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
			 "' (ID: ".$objGebruiker->getID().") te bewerken. Dit is niet gelukt, omdat een aantal verplichte gegevens niet correct zijn ingevuld.");
			verwerkLogRegel( $strTekst, $objGebruiker->getID(), $objLIAdmin->getID(), '', "Fout");
			// Roept nogmaals het formulier aan
     		maakGebruikerForm($objGebruiker, "editgw");
     		$booFout = true;
		}
		// Probeert de gegevens in de database te zetten, als het niet lukt een melding
     	elseif(!updateGebruiker($objGebruiker)) {
     		$booFout = false;
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd om de gegevens van de gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
			 "' (ID: ".$objGebruiker->getID().") te bewerken. Dit is niet gelukt.");
			verwerkLogRegel( $strTekst, $objGebruiker->getID(), $objLIAdmin->getID(), '', "Fout");
     		showErrMessage("Het bijwerken van de gegevens van de gebruiker is niet gelukt.");
     	}
     	// Het is wel gelukt
     	else {
     		$booFout = false;
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft succesvol de gegevens van de gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
			 "' (ID: ".$objGebruiker->getID().") bewerkt.");
			verwerkLogRegel( $strTekst, $objGebruiker->getID(), $objLIAdmin->getID(), '', "Bewerking");
     		showMedMessage("Het bijwerken van de gegevens van de gebruiker is gelukt.");
     	}
    	// Als er geen errors zijn, dan wordt de gebruikerinfo nog geshowed
    	if($booFout == false)
	     	showGebruiker( $objGebruiker );	
     }
     // Actie als men op de "Genereer wachtwoord"-knop heeft gedrukt
     elseif(isset($_POST['getRandomPassKnop'])) {
		// Stop de gegevens in het object
     	$objGebruiker = new Gebruiker();
     	if(isset($_POST['gid']))
	     	$objGebruiker->setGebruikersID( checkData($_POST['gid']) );
     	$objGebruiker->setGebruikersNaam( checkData($_POST['gebruikersnaam']) );
     	// De functie getRandomPass wordt aangeroepen, wachtwoord krijgt lengte van 10 karakters
     	$objGebruiker->setWachtwoord( getRandomPass(10) );
     	$objGebruiker->setEMail( checkData($_POST['email']) );
     	$objGebruiker->setVoorNaam( checkData($_POST['voornaam']) );
     	$objGebruiker->setTussenvoegsel( checkData($_POST['tussenvoegsel']) );
     	$objGebruiker->setAchterNaam( checkData($_POST['achternaam']) );
     	$objGebruiker->setWoonplaats( checkData($_POST['woonplaats']) );
     	$objGebruiker->setStraat( checkData($_POST['straat']) );
     	$objGebruiker->setHuisNr( checkData($_POST['huisnr']) );
     	$objGebruiker->setPostcode( checkData($_POST['postcode1']) . checkData($_POST['postcode2']) );
     	$objGebruiker->setTelNr( checkData($_POST['telnr']) );
     	$objGebruiker->setFaxNr( checkData($_POST['faxnr']) );
     	$objGebruiker->setMobielNr( checkData($_POST['mobielnr']) );     	
     	$objGebruiker->setWebsiteID( checkData( $_POST['wid'] ));

		// Het formulier wordt weer aangeroepen met bij de parameter 'strActie' "gw" erbij
		if(isset($_POST['gid']))
		    maakGebruikerForm( $objGebruiker, "editgw");
		else
			maakGebruikerForm( $objGebruiker, "addgw");
     }
     // Handeling(en) wanneer men op de verwijder knop heeft gedrukt
     elseif(isset($_POST['delGebruikerKnop'])) {
     	$intGebruikersID = $_POST['id'];
     	$objGebruiker = getGebruiker( $intGebruikersID );
      if($objGebruiker != null && !delGebruiker($intGebruikersID)) {
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd de gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
			 "' (ID: ".$objGebruiker->getID().") te verwijderen.");
			verwerkLogRegel( $strTekst, $objGebruiker->getID(), $objLIAdmin->getID(), $objGebruiker->getWebsiteID(), "Fout");
     		showErrMessage( "Het verwijderen van de gebruiker is niet gelukt!");
     	}
     	elseif($objGebruiker != null) {
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft succesvol de gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
			 "' (ID: ".$objGebruiker->getID().") verwijderd.");
			verwerkLogRegel( $strTekst, $objGebruiker->getID(), $objLIAdmin->getID(), $objGebruiker->getWebsiteID(), "Verwijdering");
     		showMedMessage(  "Het verwijderen van de gebruiker is gelukt!");
     	}
  		showGebruikerOverzicht();     	
     }
     // Handeling(en) wanneer men op toevoeg knop van rechten heeft gedrukt
     elseif(isset($_POST['addGebruikersRechtenKnop'])) {
     	// Alle gegevens in een object
     	$objGebRechten = new GebruikersRechten();
     	$objGebRechten->setGebruikersID( checkData($_POST['gid']) );
     	$objGebRechten->setOnderdeelRecht( checkData($_POST['onderdeel']) );
     	$objGebRechten->setSubOnderdeelRecht( checkData($_POST['subonderdeel']) );
     	$objGebRechten->setPaginaRecht( checkData($_POST['pagina']) );
     	$objGebRechten->setAfbeeldingRecht( checkData($_POST['afbeelding']) );
     	$objGebRechten->setContactFormRecht( checkData($_POST['contactform']) );
     	$objGebRechten->setDownloadsRecht( checkData($_POST['downloads']) );
     	$objGebRechten->setFlashRecht( checkData($_POST['flash']) );
     	$objGebRechten->setHTMLCodeRecht( checkData($_POST['htmlcode']) );
     	$objGebRechten->setLinksRecht( checkData($_POST['links']) );
     	$objGebRechten->setTekstAfbRecht( checkData($_POST['tekstafb']) );
     	$objGebRechten->setTekstRecht( checkData($_POST['tekst']) );
     	$objGebRechten->setWYSIWYGRecht( checkData($_POST['wysiwyg']) );
     	$objGebRechten->setUploadRecht( checkData($_POST['uploaden']) );
     	$objGebRechten->setBekijkRecht( checkData($_POST['bekijken']) );
     	$objGebRechten->setVerwijderRecht( checkData($_POST['verwijderen']) );
     	$objGebRechten->setMaxSize( checkData( $_POST['maxsize'] ));
     	$objGebRechten->setExtensies( checkData( $_POST['extensies'] ));
		$objGebruiker = getGebruiker( $objGebRechten->getGebruikersID() );
		// Het toevoegen van gebruikersrechten
     	if($objGebruiker != null && insertGebruikersRechten($objGebRechten)) {
     		showMedMessage( "Het invoeren van de gebruikersrechten is goed gelukt." );
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft succesvol de rechten van de gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
			 "' (ID: ".$objGebRechten->getGebruikersID().") toegevoegd.");
			verwerkLogRegel( $strTekst, $objGebRechten->getGebruikersID(), $objLIAdmin->getID(), '', "Toevoeging");
     	}	
     	else {
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd de rechten van de gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
			 "' (ID: ".$objGebRechten->getGebruikersID().") toe te voegen. Dit is niet gelukt.");
			verwerkLogRegel( $strTekst, $objGebRechten->getGebruikersID(), $objLIAdmin->getID(), '', "Fout");
     		showErrMessage( "Het invoeren van de gebruikersrechten is niet gelukt." );
     	}
     		showGebruikerOverzicht();     	
     }
     // Handeling(en) wanneer men op bewerk knop van rechten heeft gedrukt
     elseif(isset($_POST['editGebruikersRechtenKnop'])) {
     	// Alle gegevens in object
     	$objGebRechten = new GebruikersRechten();
     	$objGebRechten->setGebruikersID( checkData($_POST['gid']) );
     	$objGebRechten->setOnderdeelRecht( checkData($_POST['onderdeel']) );
     	$objGebRechten->setSubOnderdeelRecht( checkData($_POST['subonderdeel']) );
     	$objGebRechten->setPaginaRecht( checkData($_POST['pagina']) );
     	$objGebRechten->setAfbeeldingRecht( checkData($_POST['afbeelding']) );
     	$objGebRechten->setContactFormRecht( checkData($_POST['contactform']) );
     	$objGebRechten->setDownloadsRecht( checkData($_POST['downloads']) );
     	$objGebRechten->setFlashRecht( checkData($_POST['flash']) );
     	$objGebRechten->setHTMLCodeRecht( checkData($_POST['htmlcode']) );
     	$objGebRechten->setLinksRecht( checkData($_POST['links']) );
     	$objGebRechten->setTekstAfbRecht( checkData($_POST['tekstafb']) );
     	$objGebRechten->setTekstRecht( checkData($_POST['tekst']) );
     	$objGebRechten->setWYSIWYGRecht( checkData($_POST['wysiwyg']) );
     	$objGebRechten->setUploadRecht( checkData($_POST['uploaden']) );
     	$objGebRechten->setBekijkRecht( checkData($_POST['bekijken']) );
     	$objGebRechten->setVerwijderRecht( checkData($_POST['verwijderen']) );
     	$objGebRechten->setMaxSize( checkData( $_POST['maxsize'] ));
     	$objGebRechten->setExtensies( checkData( $_POST['extensies'] ));
	
		$objGebruiker = getGebruiker( $objGebRechten->getGebruikersID() );
		// Checkt of de gebruiker al rechten heeft, zo nee: inserten
		if(getGebruikersRechten($objGebRechten->getGebruikersID()) == null) {
	     	if(is_object($objGebruiker) && insertGebruikersRechten($objGebRechten)) {
    	 		showMedMessage("Het invoeren van de gegevens is goed gelukt.");
				// Logboek 
				$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft succesvol de rechten van de gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
				 "' (ID: ".$objGebRechten->getGebruikersID().") toegevoegd.");
				verwerkLogRegel( $strTekst, $objGebRechten->getGebruikersID(), $objLIAdmin->getID(), '', "Toevoeging");
	     	}	
     		else {
				// Logboek 
				$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd de rechten van de gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
				 "' (ID: ".$objGebRechten->getGebruikersID().") toe te voegen. Dit is niet gelukt.");
				verwerkLogRegel( $strTekst, $objGebRechten->getGebruikersID(), $objLIAdmin->getID(), '', "Fout");
    	 		showErrMessage("Het invoeren van gegevens is niet gelukt.");
	     	}			
		}
		// Zo ja: updaten
		else {
     		if(is_object($objGebruiker) && updateGebruikersRechten($objGebRechten)) {
    	 		showMedMessage("Het bijwerken van de gegevens is goed gelukt.");
				// Logboek 
				$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft succesvol de rechten van de gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
				 "' (ID: ".$objGebRechten->getGebruikersID().") bewerkt.");
				verwerkLogRegel( $strTekst, $objGebRechten->getGebruikersID(), $objLIAdmin->getID(), '', "Bewerking");
	     	}	
     		else {
				// Logboek 
				$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd de rechten van de gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
				 "' (ID: ".$objGebRechten->getGebruikersID().") te bewerken. Dit is niet gelukt.");
				verwerkLogRegel( $strTekst, $objGebRechten->getGebruikersID(), $objLIAdmin->getID(), '', "Fout");
     			showErrMessage("Het bijwerken van de gegevens is niet gelukt.");
	     	}			
		}
     	showGebruiker( $objGebruiker );
     }
     else {
			showGebruikerOverzicht();
     }     
     
 }
 
 include("footer.php");
 ?>