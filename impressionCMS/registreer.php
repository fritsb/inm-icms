<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: registreer.php
 * Beschrijving: De pagina waar men opkomt als er geen administrators zijn
 */
 session_start();
 include("header.php");
 
 
 if(getAdmins() != null) {
 	echo "<h1>Geen toegang</h1>\n";
 	echo "Deze pagina is alleen beschikbaar als er nog geen beheerders zijn.\n";
	if(isset($objLIGebruiker)) {
		$strTekst = maakLogTekst( "De gebruiker", $objLIGebruiker, "heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen. ");
		verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $objLIGebruiker->getWebsiteID(), "Geen toegang" );
	}
	if(isset($objLIAdmin)) {
		$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen. ");
		verwerkLogRegel( $strTekst, '', $objLIAdmin->getAdminID(), '', "Geen toegang" );
	}
	else {
		$strTekst = "Persoon met het IP-adres ".$_SERVER['REMOTE_ADDR']." heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen.";
		verwerkLogRegel( $strTekst, '','','', "Geen toegang" );
	}	
 }
 elseif(isset($_SESSION['login'])) {
 	echo "<h1>Geen toegang</h1>\n";
 	echo "Deze pagina is niet voor geregistreerde beheerders of gebruikers.\n";
	if(isset($objLIGebruiker)) {
		$strTekst = maakLogTekst( "De gebruiker", $objLIGebruiker, "heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen. ");
		verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $objLIGebruiker->getWebsiteID(), "Geen toegang" );
	}
	if(isset($objLIAdmin)) {
		$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen. ");
		verwerkLogRegel( $strTekst, '', $objLIAdmin->getAdminID(), '', "Geen toegang" );
	}
	else {
		$strTekst = "Persoon met het IP-adres ".$_SERVER['REMOTE_ADDR']." heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen.";
		verwerkLogRegel( $strTekst, '','','', "Geen toegang" );
	}	
 }
 elseif(isset($_POST['registreerFirstKnop'])) {
 	$objAdmin = new Admin();
 	$objAdmin->setVoorNaam( checkData($_POST['voornaam']) );
  	$objAdmin->setTussenvoegsel( checkData($_POST['tussenvoegsel']) );
 	$objAdmin->setAchterNaam( checkData($_POST['achternaam']) );
 	$objAdmin->setEMail( checkData($_POST['email']) );
 	$objAdmin->setLoginNaam( checkData($_POST['loginnaam']) );
 	$objAdmin->setWachtwoord( checkData($_POST['wachtwoord']) );
 	$objAdmin->setAanmeldDatum( getDatumTijd() ); 
  	$objAdmin->setActief( "ja" );
  	$objAdmin->setSuperUser( "ja" );
 	$objAdmin->setIP( $_SERVER['REMOTE_ADDR'] );
 	
 	if($objAdmin->getVoorNaam() == "")
 		$arrError[1] == true;
 	if($objAdmin->getAchterNaam() == "")
 		$arrError[2] == true; 		
 	if($objAdmin->getEMail() == "" || !eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$", $objAdmin->getEMail()) )
 		$arrError[3] == true;
 	if($objAdmin->getLoginNaam() == "")
 		$arrError[4] == true;
 	if($objAdmin->getWachtwoord() == "")
 		$arrError[5] == true;
 	
     	if(isset($arrError) && !checkErrors($arrError)) {
		  	$strFoutMelding = "Er zijn error(s) opgetreden tijdens het verwerken van de gegevens. Hieronder staan de melding(en):<br><br>\n";
			if(isset($arrError[0])) {
			    $strFoutMelding .= "<li>Het e-mailadres of gebruikersnaam staat al in de database. Kies een andere gebruikersnaam of e-mailadres. \n ";
			}
			if(isset($arrError[1])) {
			    $strFoutMelding .= "<li>Er is geen voornaam ingevuld.\n ";
			}
			if(isset($arrError[2])) {
			    $strFoutMelding .= "<li>Er is geen achternaam ingevuld.\n ";
			}
			if(isset($arrError[3])) {
			    $strFoutMelding .= "<li>Er is geen e-mailadres ingevuld.\n ";
			}
			if(isset($arrError[4])) {
			    $strFoutMelding .= "<li>Er is geen gebruikersnaam ingevuld.\n ";
			}
			if(isset($arrError[5])) {
			    $strFoutMelding .= "<li>Er is geen wachtwoord ingevuld.\n ";
			}

			$strFoutMelding .= "<br><br>Probeer nogmaals de gegevens in te vullen in het onderstaande formulier.\n"; 
			showErrMessage($strFoutMelding);
	   	 	maakAdminForm($objAdmin, "new");
	   	 }
		else {
		if(!checkDBTables()) {
		 	echo "<h1>Database niet goed aangemaakt</h1>\n";
		 	echo "De database is niet goed aangemaakt. Controleer de instellingen, met name de $arrTables-variabele. Controleer daarna de database of alle namen uit de array in de database staan. Zo niet, verwijder de database en draai het start_up.sql script nog een keer.\n";
		}
		elseif(!insertAdmin($objAdmin)) {
		 	echo "<h1>Beheerder kon niet worden aangemaakt</h1>\n";
		 	echo "De gegevens konden niet worden ingevoerd in de database. Controleer de database-settings.\n";
			$strTekst = "Het toevoegen van de eerste beheerder met de naam '".$objAdmin->getVolledigeNaam()."' is mislukt.";
			verwerkLogRegel( $strTekst, '','','', "Fout" );
		}
		else {
		 	echo "<h1>Beheerder succesvol aangemaakt</h1>\n";
		 	echo "De gegevens zijn succesvol ingevoerd in de database. Het is vanaf nu mogelijk om <a href=\"".$strAdmIndex."\">in te loggen</a>.\n";
			$strTekst = "De eerste beheerder met de naam '".$objAdmin->getVolledigeNaam()."' is succesvol toegevoegd.";
			verwerkLogRegel( $strTekst, '','','', "Toevoeging" );
		}
	}
 }
// Actie als men op de "Genereer wachtwoord"-knop heeft gedrukt
elseif(isset($_POST['getRandomPassKnop'])) {
		// Stop de gegevens in hetobject
     	$objAdmin = new Admin();
     	$objAdmin->setGebruikersNaam( checkData($_POST['loginnaam']) );
     	// De functie getRandomPass wordt aangeroepen, wachtwoord krijgt lengte van 10 karakters
     	$objAdmin->setWachtwoord( getRandomPass(10) );
     	$objAdmin->setEMail( checkData($_POST['email']) );
     	$objAdmin->setVoorNaam( checkData($_POST['voornaam']) );
     	$objAdmin->setTussenvoegsel( checkData($_POST['tussenvoegsel']) );
     	$objAdmin->setAchterNaam( checkData($_POST['achternaam']) );
		// Het formulier wordt weer aangeroepen met bij de parameter "newgw" erbij
	    maakAdminForm( $objAdmin, "newgw");
}
 else {
 	maakAdminForm( '', "new");
 }
 

 include("footer.php");
 
?>