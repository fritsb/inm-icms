<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: websitesbeheer.php
 * Beschrijving: De beheerpagina van websites
 */
 session_start();
 include("header.php");
 
 if(!isset($_SESSION['login']) || $_SESSION['login'] == "gebruiker") {
 	echo "<h1>Geen toegang</h1>\n";
 	echo "Om deze pagina te gebruiken, moet je eerst inloggen bij het administratiegedeelte.\n";
	// Logboek 
	if(isset($objLIGebruiker)) {
		$strTekst = maakLogTekst( "De gebruiker", $objLIGebruiker, "heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen.");
		verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $objLIGebruiker->getWebsiteID(), "Geen toegang" );
	}
	else {
		$strTekst = "Persoon met het IP-adres ".$_SERVER['REMOTE_ADDR']." heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen.";
		verwerkLogRegel( $strTekst, '','','', "Geen toegang" );
	}

 }
 elseif($_SESSION['login'] == "admin") {
 	if(isset($_GET['actie'])) {
 	  // Handeling(en) om een website te bekijken (informatie dan)
 	  if($_GET['actie'] == "bw" && isset($_GET['id'])) {
 	  	$intWebsiteID = checkData($_GET['id'], "nummer");
 	  	$objWebsite = getWebsite( $intWebsiteID );
		showWebsite($objWebsite);
		// Logboek 
		if(is_object($objWebsite)) {
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft de informatie van de website met de titel '".$objWebsite->getTitel().
			"' (ID: $intWebsiteID) bekeken.");
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, "Bekijken" );
		}
		else {
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, 	"heeft geprobeerd de informatie van de website met
			 ID-nummer $intWebsiteID te bekijken. Dit is mislukt, omdat er geen website bestaat met dat ID-nummer. ");
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, "Fout" );
		}
 	  }
 	  // Handeling(en) om een website aan te maken
 	  elseif($_GET['actie'] == "aw") {
		echo "<h1>Stap 1: Website aanmaken</h1>\n"; 	  
 	  	maakWebsiteForm('', "add");
 	  }
 	  // Handeling(en) om een website te bewerken
 	  elseif($_GET['actie'] == "ew" && isset($_GET['id'])) {
 	  	$intWebsiteID = checkData($_GET['id'], "nummer");
 	  	$objWebsite = getWebsite($intWebsiteID);
 	  	maakWebsiteForm($objWebsite, "edit");
 	  }
 	  // Handeling(en) om een website te verwijderen
 	  elseif($_GET['actie'] == "dw" && isset($_GET['id'])) {
 	  	$intWebsiteID = checkData($_GET['id'], "nummer");
 	  	maakDelWebsiteForm($intWebsiteID);
 	  }	
 	}
 	// Handeling(en) om  een website toe te voegen
 	elseif(isset($_POST['addWebsiteKnop'])) {
 		// Gegevens in een object
 		$objWebsite = new Website();
 		$objWebsite->setAanmeldDatum( getDatumTijd() );
 		$objWebsite->setURL( checkData( $_POST['url'] ));
 		$objWebsite->setEMail( checkData( $_POST['email'] ));
 		$objWebsite->setTitel( checkData( $_POST['titel'] ));
 		$objWebsite->setOmschrijving( checkData( $_POST['omschrijving'] ));
 		$objWebsite->setFTPhost( checkData( $_POST['ftphost'] ));
 		$objWebsite->setFTPuser( checkData( $_POST['ftpuser'] ));
 		$objWebsite->setFTPpass( checkData( $_POST['ftppass'] ));
 		$objWebsite->setSiteCode( checkData( $_POST['sitecode'] ));

 		// Gegevens worden gecontroleerd
 		if($objWebsite->getURL() == "")
 			$arrError[1] = true;
 		if($objWebsite->getEMail() == "" || !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$", $objWebsite->getEMail()))
 			$arrError[2] = true;
 		if($objWebsite->getTitel() == "")
 			$arrError[3] = true;
 		if($objWebsite->getSiteCode() == "")
 			$arrError[4] = true;
 			
     	// Laat de errors zien
     	if(isset($arrError) && !checkErrors($arrError)) {
		  	$strFoutMelding = "Er zijn error(s) opgetreden tijdens het verwerken van de gegevens. Hieronder staan de melding(en):<br><ul>\n";
			if(isset($arrError[1])) 
			    $strFoutMelding .= "<li>Er is geen URL ingevuld.\n ";
			if(isset($arrError[2])) 
			    $strFoutMelding .= "<li>Er is geen (correct) e-mailadres ingevuld.\n ";
			if(isset($arrError[3])) 
			    $strFoutMelding .= "<li>Er is geen titel ingevuld.\n ";
			if(isset($arrError[4])) 
			    $strFoutMelding .= "<li>Er is geen websitecode ingevuld.\n ";

			$strFoutMelding .= "</ul><br>Probeer nogmaals de gegevens in te vullen in het onderstaande formulier.\n"; 
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd een nieuwe website met de naam '".$objWebsite->getTitel().
				"' toe te voegen. Dit is mislukt, omdat niet alle verplichte gegevens correct zijn ingevuld.");
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), '', "Fout" );

			showErrMessage($strFoutMelding);
    		// Roept nogmaals het formulier aan
     		maakWebsiteForm($objWebsite, "add");
     	}
		// Website wordt toegevoegd, als het niet lukt dan krijg je onderstaande melding
		elseif(!insertWebsite($objWebsite)) {
			echo "<h1>Stap 1 mislukt</h1>\n";
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd een nieuwe website met de naam '".$objWebsite->getTitel().
				"' toe te voegen. Dit is mislukt.");
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), '', "Fout" );
			showErrMessage ("De website kon niet worden aangemaakt.");
		}
		// Als het wel is gelukt, onderstaande handelingen
		else {
			echo "<h1>Stap 2: Gebruiker toevoegen</h1>\n";
			showMedMessage( "De website is succesvol aangemaakt, nu is het mogelijk om een gebruiker aan deze website te koppelen.");
			$objWebsite->setWebsiteID( getLastID() );
			maakGebruikerForm('', "add", $objWebsite);
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft succesvol een nieuwe website met de naam '".$objWebsite->getTitel().
				"' (ID: ".$objWebsite->getWebsiteID().") toegevoegd. ");
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $objWebsite->getWebsiteID(), "Toevoeging" );
		} 		
 	}
 	// Handeling(en) als er op een knop is gedrukt om een gebruiker toe te voegen
     elseif(isset($_POST['addGebruikerKnop'])) {
     	// Stopt alle gegevens in een object
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
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd een nieuwe gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
				"' toe te voegen. Dit is mislukt, omdat niet alle verplichte gegevens correct zijn ingevuld. ");
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), '', "Fout" );
			showErrMessage($strFoutMelding);
    		// Maakt nogmaals het formulier aan
     		maakGebruikerForm($objGebruiker, "add");
     		$booFout = true;
		}
		// Probeert de gebruiker te inserten, als het niet lukt..melding hieronder
     	elseif(!insertGebruiker($objGebruiker)) {
			echo "<h1>Stap 2 mislukt</h1>\n";
			showErrMessage("Het is niet gelukt om een gebruiker te koppelen aan de website, dit kan later ook nog via het gebruikersoverzicht.");
			showWebsiteOverzicht();
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd een nieuwe gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
				"' toe te voegen. Dit is mislukt. ");
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), '', "Fout" );
     	}
     	// Als het wel lukt:
     	else {
			echo "<h1>Stap 3: Gebruikersrechten aanmaken</h1>\n";
			showMedMessage("De gebruiker is succesvol aangemaakt, nu is het mogelijk om de rechten en opties van de gebruiker in te stellen.");
			$objGebruiker->setGebruikersID( getLastID() );
			maakGebruikersRechtenForm("add", $objGebruiker->getGebruikersID());
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft succesvol een nieuwe gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
				"' (ID: ".$objGebruiker->getGebruikersID().") toegevoegd. ");
			verwerkLogRegel( $strTekst, $objGebruiker->getGebruikersID(), $objLIAdmin->getID(), $objGebruiker->getWebsiteID(), "Toevoeging" );
     	}
     }
     // Actie als men op de "Genereer wachtwoord"-knop heeft gedrukt
     elseif(isset($_POST['getRandomPassKnop'])) {
		// Stop de gegevens in het object
     	$objGebruiker = new Gebruiker();
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
		maakGebruikerForm( $objGebruiker, "addgw");
     }

     // Handeling(en) als de gebruikersrechten worden toegevoegd.
     elseif(isset($_POST['addGebruikersRechtenKnop'])) {
     	// Gegevens in een object
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
		// Gegevens worden toegevoegd
		$objGebruiker = getGebruiker( $objGebRechten->getGebruikersID() );
     	if($objGebruiker != false && insertGebruikersRechten($objGebRechten)) {
     		showMedMessage( "Het invoeren van de gebruikersrechten is goed gelukt." );
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft succesvol rechten aan de gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
				"' (ID: ".$objGebruiker->getGebruikersID().") toegevoegd.");
			verwerkLogRegel( $strTekst, $objGebRechten->getGebruikersID(), $objLIAdmin->getID(), '', "Toevoeging" );
     	}	
     	else {
     		showErrMessage( "Het invoeren van de gebruikersrechten is niet gelukt." );
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd rechten aan de gebruiker met de naam '".$objGebruiker->getVolledigeNaam().
				"' (ID: ".$objGebruiker->getGebruikersID().") toe te voegen. Dit is mislukt. ");
			verwerkLogRegel( $strTekst, $objGebRechten->getGebruikersID(), $objLIAdmin->getID(), '', "Fout" );
     	}
		showWebsiteOverzicht();
     }
     // Handeling(en) als er op een knop is gedrukt om een website te bewerken
 	 elseif(isset($_POST['editWebsiteKnop'])) {
 	 	// Gegevens in een object
 		$objWebsite = new Website();
		$objWebsite->setWebsiteID(checkData($_POST['wid'], "integer"));
 		$objWebsite->setURL( checkData( $_POST['url'] ));
 		$objWebsite->setEMail( checkData( $_POST['email'] ));
 		$objWebsite->setTitel( checkData( $_POST['titel'] ));
 		$objWebsite->setOmschrijving( checkData( $_POST['omschrijving'] ));
 		$objWebsite->setFTPhost( checkData( $_POST['ftphost'] ));
 		$objWebsite->setFTPuser( checkData( $_POST['ftpuser'] ));
 		$objWebsite->setFTPpass( checkData( $_POST['ftppass'] ));
 		$objWebsite->setSiteCode( checkData( $_POST['sitecode'] ));

 		// Gegevens worden gecontroleerd
 		if($objWebsite->getURL() == "")
 			$arrError[1] = true;
 		if($objWebsite->getEMail() == "" || !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$", $objWebsite->getEMail()))
 			$arrError[2] = true;
 		if($objWebsite->getTitel() == "")
 			$arrError[3] = true;
 		if($objWebsite->getSiteCode() == "")
 			$arrError[4] = true;
 			
     	// Laat de errors zien
     	if(isset($arrError) && !checkErrors($arrError)) {
		  	$strFoutMelding = "Er zijn error(s) opgetreden tijdens het verwerken van de gegevens. Hieronder staan de melding(en):<br><ul>\n";
			if(isset($arrError[1])) 
			    $strFoutMelding .= "<li>Er is geen URL ingevuld.\n ";
			if(isset($arrError[2])) 
			    $strFoutMelding .= "<li>Er is geen (correct) e-mailadres ingevuld.\n ";
			if(isset($arrError[3])) 
			    $strFoutMelding .= "<li>Er is geen titel ingevuld.\n ";
			if(isset($arrError[4])) 
			    $strFoutMelding .= "<li>Er is geen websitecode ingevuld.\n ";

			$strFoutMelding .= "</ul><br>Probeer nogmaals de gegevens in te vullen in het onderstaande formulier.\n"; 
			showErrMessage($strFoutMelding);
    		// Roept nogmaals het formulier aan
     		maakWebsiteForm($objWebsite, "edit");
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd de gegevens van de website met de naam '".$objWebsite->getTitel().
				"' te bewerken. Dit is mislukt, omdat niet alle verplichte gegevens correct zijn ingevuld. ");
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $objWebsite->getWebsiteID(), "Fout" );
     	}
		// Gegevens worden bijgewerkt
		elseif(updateWebsite($objWebsite)) {
			showMedMessage( "De website is succesvol bijgewerkt.");
			showWebsiteOverzicht();
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft succesvol de website met de naam '".$objWebsite->getTitel().
				"' (ID: ".$objWebsite->getWebsiteID().") bewerkt. ");
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $objWebsite->getWebsiteID(), "Bewerking" );
		}
		else {
			showErrMessage( "De website kon niet worden bijgewerkt." );
			showWebsiteOverzicht();
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd de gegevens van de website met de naam '".$objWebsite->getTitel().
				"' (ID: ".$objWebsite->getWebsiteID().") te bewerken. Dit is mislukt. ");
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $objWebsite->getWebsiteID(), "Fout" );
		}
 	}
 	elseif(isset($_POST['genereerSiteCode'])) {
		$objWebsite = new Website();
 		if(isset($_POST['wid'])) {
			$objWebsite->setWebsiteID(checkData($_POST['wid'], "integer"));
 		}
 		$objWebsite->setAanmeldDatum( getDatumTijd() );
 		$objWebsite->setURL( checkData( $_POST['url'] ));
 		$objWebsite->setEMail( checkData( $_POST['email'] ));
 		$objWebsite->setTitel( checkData( $_POST['titel'] ));
 		$objWebsite->setOmschrijving( checkData( $_POST['omschrijving'] ));
 		$objWebsite->setFTPhost( checkData( $_POST['ftphost'] ));
 		$objWebsite->setFTPuser( checkData( $_POST['ftpuser'] ));
 		$objWebsite->setFTPpass( checkData( $_POST['ftppass'] ));
 		$objWebsite->setSiteCode( getRandomPass() );
 		
 		if($objWebsite->getWebsiteID() != "") {
 			maakWebsiteForm($objWebsite, "editgw");
 		}
 		else {
 			maakWebsiteForm($objWebsite, "addgw");
 		}
 	}
 	// Handeling(en) als er op een knop is gedrukt om een website te verwijderen
 	elseif(isset($_POST['delWebsiteKnop'])) {
		$intWebsiteID = checkData($_POST['id']);
		$objWebsite = getWebsite( $intWebsiteID );
		// Gegevens worden verwijderd
		if($objWebsite != null && delWebsite($intWebsiteID)) {
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft succesvol de website met de naam '".$objWebsite->getTitel().
				"' (ID: ".$objWebsite->getWebsiteID().") verwijderd. ");
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $objWebsite->getWebsiteID(), "Verwijdering" );
			showMedMessage("De website is succesvol verwijderd.");
		}
		elseif($objWebsite != null) {
			// Logboek 
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft geprobeerd de website met de naam '".$objWebsite->getTitel().
				"' (ID: ".$objWebsite->getWebsiteID().") te verwijderen, maar dit is mislukt. ");
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $objWebsite->getWebsiteID(), "Fout" );
			showErrMessage("Het verwijderen van de website is niet gelukt, probeer het later nogmaals.");
		}
		showWebsiteOverzicht();
 	}
    else {
		showWebsiteOverzicht();
    }
 }
 include("footer.php");
?>