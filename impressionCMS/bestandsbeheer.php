<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: bestandsbeheer.inc.php
 * Beschrijving: Het script om bestanden te beheren.
 */

 session_start();
 include("header.php");
 if(!isset($_SESSION['login'])) {
 	echo "<h1>Geen toegang</h1>\n";
 	echo "Om deze pagina te gebruiken, moet je eerst inloggen.<br><br>\n";
 	echo "Het is mogelijk dat u te lang bent ingelogd, dan moet u opnieuw inloggen. U wordt na het inloggen ";
 	echo "vanzelf teruggestuurd naar de pagina waar u naar toe wou.\n ";
	$strTekst = "Persoon met het IP-adres ".$_SERVER['REMOTE_ADDR']." heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen.";
	verwerkLogRegel( $strTekst, '','','', "Geen toegang" );
 }
 elseif($objLIGebRechten != "ja" && $objLIGebRechten->getBekijkRecht() != "ja") {
 	echo "<h1>Geen toegang</h1>\n";
 	echo "U heeft geen rechten om deze pagina te bezoeken. \n";
	$strTekst = maakLogTekst( "De gebruiker", $objLIGebruiker, "heeft zonder daarvoor rechten te hebben de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen.");
	verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $objLIGebruiker->getWebsiteID(), "Geen toegang" );
 }
 elseif($_SESSION['login'] == "admin" && (!isset($_GET['wid']) && !isset($_POST['wid']))) {
 	showWebsiteBestandOverzicht();
 }
 else {
	// $intWebsiteID & $intGebruikersID definieren
	if($_SESSION['login'] == "gebruiker") {
		$intWebsiteID = $objLIGebruiker->getWebsiteID();
		$intGebruikersID =  $objLIGebruiker->getGebruikersID();
		$strType = "De gebruiker";
		$objPersoon = $objLIGebruiker;
	}
	elseif($_SESSION['login'] == "admin" && isset($_GET['wid'])) {
		$intWebsiteID = checkData($_GET['wid'], "integer");
		$intGebruikersID = -42;
		$strType = "De beheerder";
		$objPersoon = $objLIAdmin;
	}
	elseif($_SESSION['login'] == "admin" && isset($_POST['wid'])) {
		$intWebsiteID = checkData($_POST['wid'], "integer");
		$intGebruikersID = -42;
		$strType = "De beheerder";
		$objPersoon = $objLIAdmin;
	}
	//  Acties: 
	if(isset($_GET['actie']) && isset($_GET['bestandid'])) {
		$intBestandID = checkData($_GET['bestandid'], "integer");
		$strActie = checkData($_GET['actie']);
		
		if($strActie == "view") {
			showBestand( $intBestandID, $intWebsiteID, $objLIGebRechten );
			
			$objBestand = getBestand($intBestandID, $intWebsiteID );
			if(is_object($objBestand)) {
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft het bestand met de naam '".$objBestand->getBestandsNaam()."' (ID: ".
				$intBestandID.") bekeken.");
				$strSoort = "Bekijken";
			}
			else {
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het bestand met ID-nummer $intBestandID te bekijken.");
				$strSoort = "Fout";
			}
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
		}
		elseif($strActie == "edit") {
			editBestandForm($intBestandID, $intWebsiteID, $objLIGebRechten );
		}
		elseif($strActie == "del") {
			delBestandForm( $intBestandID, $intWebsiteID, $objLIGebRechten );
		}
	}
	elseif(isset($_GET['actie']) && $_GET['actie'] == "new") {
		addBestandForm( $intWebsiteID, $objLIGebRechten );
	}
	elseif(isset($_POST['addBestandKnop'])) {
		echo "<h1>Bestand toevoegen</h1>";
		$objBestand = new Bestand();
		$objBestand->setOmschrijving( checkData($_POST['omschrijving'], "tekst" ));
		$objBestand->setBestandsID( getHighestIDNummer("bestand",$intWebsiteID) );
		$objBestand->setWebsiteID( $intWebsiteID );
		$objBestand->setOrgBestandsNaam( $_FILES['bestand']['name'] );
		$objBestand->setBestandsType( $_FILES['bestand']['type'] );
		$objBestand->setBestandsGrootte( $_FILES['bestand']['size'] );
		$objBestand->setBestandsError( $_FILES['bestand']['error'] );
		// De bestemming van het bestand 
		$strBestemming = getHuidigeDir().$strUploadMap.$intWebsiteID;
		$objBestand->setLocatieDir($strBestemming );
		$objBestand->setLocatie($strUploadMap.$intWebsiteID );
		// Extensie opvragen 
		$arrBestand = explode(".",$objBestand->getOrgBestandsNaam());
		$intArraySize = count($arrBestand);
		$strExtensie = $arrBestand[$intArraySize -1];
		if(strlen($arrBestand[0]) > 20)
			$arrBestand[0] = substr($arrBestand[0], 0, 20);

		// Het hernoemen van het bestand, als het bestand bijvoorbeeld twee extensies heeft. 
		if($intArraySize > 2)
			$objBestand->setBestandsNaam( $arrBestand[0].".".$arrBestand[ $intArraySize - 1] );
		else 
			$objBestand->setBestandsNaam( $arrBestand[0].".".$arrBestand[1] ); 

	   echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
		if($objLIGebRechten != "ja" && !eregi($strExtensie, $objLIGebRechten->getExtensies())) {
		   echo "<tr><td class=\"tabletitle\">Bestand kon niet worden upgeload</td></tr>\n";
   	  	echo "<tr><td class=\"formvak\">Het was niet mogelijk om het bestand op internet te zetten.<br><br>\n";
   	  	echo " <b>Foutmelding:</b><br>Dit heeft te maken met dat het bestand een extensie heeft, waarvoor u de rechten niet heeft om ";
   	  	echo " zo'n soort bestand op internet te zetten. ";
   	  	echo "<br><br><b>De extensie was:</b> .$strExtensie<br>\n ";
   	  	echo "<b>Extensie die zijn toegestaan zijn:</b><br> ".$objLIGebRechten->getExtensies()."<br>\n ";
   	  	echo "</td></tr>\n";
			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het bestand met de naam '".$objBestand->getBestandsNaam().
			"' toe te voegen. Maar de gebruiker heeft geen rechten voor de gebruikte extensie ($strExtensie). ");
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, "Fout" );
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, "Fout" );
   	}
		elseif($objBestand->getBestandsError() != "0") {
		   echo "<tr><td class=\"tabletitle\">Bestand kon niet worden upgeload</td></tr>\n";
   	  	echo "<tr><td class=\"formvak\">Het was niet mogelijk om het bestand op internet te zetten.<br><br>\n";
   	  	if($objBestand->getBestandsError() == "1")
	   	  	$strFoutMelding = "<b>Foutmelding:</b><br> Het bestand is groter dan de ingestelde maximumwaarde in de configuratiebestanden. Het bestand mag namelijk niet groter zijn dan ".ini_get('post_max_size').".\n";
   	  	elseif($objBestand->getBestandsError() == "2")
	   	  	$strFoutMelding = "<b>Foutmelding:</b><br> Het bestand is groter dan de ingestelde maximumwaarde. Het bestand mag namelijk niet groter zijn dan ".$objLIGebRechten->getMaxSize()." bytes\n";
   	  	elseif($objBestand->getBestandsError() == "3")
	   	  	$strFoutMelding = "<b>Foutmelding:</b><br> Het bestand is niet helemaal goed aangekomen. <a href=\"javascript:history.go(-1);\">Probeer het nogmaals.</a>\n";
   	  	elseif($objBestand->getBestandsError() == "4")
	   	  	$strFoutMelding = "<b>Foutmelding:</b><br> Er is geen bestand geselecteerd. <a href=\"javascript:history.go(-1);\">Probeer het nogmaals.</a>\n";
   	  	elseif($objBestand->getBestandsError() == "6")
	   	  	$strFoutMelding = "<b>Foutmelding:</b><br> De instellingen op de server zijn niet goed.\n";
	   	echo $strFoutMelding;
   	  	echo "</td></tr>\n";
			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het bestand met de naam '".$objBestand->getBestandsNaam().
			"' toe te voegen. <br>$strFoutMelding ");
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, "Fout" );
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, "Fout" );
		}
		elseif(checkBestandsNaam( $objBestand, $intWebsiteID )) {
		   echo "<tr><td class=\"tabletitle\">Bestand kon niet worden upgeload</td></tr>\n";
   	  	echo "<tr><td class=\"formvak\">Het was niet mogelijk om het bestand op internet te zetten.<br><br>\n";
   	  	echo "<b>Foutmelding:</b><br>Dit heeft te maken dat dit bestand al met dezelfde naam op de server of in de database aanwezig is.";
   	  	echo "<br><br>Wijzig de naam van het bestand en <a href=\"javascript:history.go(-1);\">probeer het nogmaals.</a>\n";
   	  	echo "</td></tr>\n";
			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het bestand met de naam '".$objBestand->getBestandsNaam().
			"' toe te voegen. Dit is mislukt, omdat het bestand was al aanwezig in de server of in de database.");
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, "Fout" );
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, "Fout" );
		}
		else {
			if(!is_dir($objBestand->getLocatie()))
				mkdir( $objBestand->getLocatie(), 744);
						
			if(uploadBestand( $objBestand )) {
				$objBestand->setDatum( getDatumTijd() );
				if(insertBestand($objBestand)) {
				   echo "<tr><td class=\"tabletitle\">Bestand succesvol upgeload!</td></tr>\n";
		   	  	echo "<tr><td class=\"formvak\">Het bestand staat nu op internet onder de naam '".$objBestand->getBestandsNaam()."'.";
		   	  	echo "Het bestand kan nu worden gebruikt bij andere onderdelen.";
		   	  	echo "</td></tr>\n";
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft succesvol het bestand met de naam '".$objBestand->getBestandsNaam().
					"' toegevoegd. .");
					if(isset($objLIAdmin))
						verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, "Toevoeging" );
					else
						verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, "Toevoeging" );
		  		}
		  		else {
				   echo "<tr><td class=\"tabletitle\">Bestand kon niet worden upgeload</td></tr>\n";
   			  	echo "<tr><td class=\"formvak\">Het was niet mogelijk om de gegevens van het bestand in de database te zetten.";
   			  	echo "</td></tr>\n";
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het bestand met de naam '".$objBestand->getBestandsNaam().
					"' toe te voegen. Dit is mislukt, omdat het niet in de database kon worden gezet.");
					if(isset($objLIAdmin))
						verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, "Fout" );
					else
						verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, "Fout" );
		  		}
			}
			else {
			   echo "<tr><td class=\"tabletitle\">Bestand kon niet worden upgeload</td></tr>\n";
   		  	echo "<tr><td class=\"formvak\">Het was niet mogelijk om het bestand op internet te zetten.";
   		  	echo "</td></tr>\n";
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het bestand met de naam '".$objBestand->getBestandsNaam().
				"' toe te voegen. Dit is mislukt, omdat het niet kon worden upgeload.");
				if(isset($objLIAdmin))
					verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, "Fout" );
				else
					verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, "Fout" );
			}
		}
  	  	echo "<tr><td class=\"tablelinks\"><a href=\"".$_SERVER['PHP_SELF'];
	  	if($objLIGebRechten == "ja")
   	  	echo "?wid=$intWebsiteID";
	  	echo "\" class=\"linkitem\">Bestandenoverzicht</a></td></tr>\n";
		echo "</table>\n";
		
	
	}
	elseif(isset($_POST['editBestandKnop'])) {
		$objBestand = getBestand( checkData($_POST['bestandid'], "integer" ), $intWebsiteID);
		$objBestand->setOmschrijving( checkData($_POST['omschrijving'], "tekst" ));
		
		if(!updateBestand( $objBestand )) {
			showErrMessage( "Het bestand kon niet worden bewerkt!\n" );
			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het bestand met de naam '".$objBestand->getBestandsNaam().
			"' te bewerken. Dit is mislukt.");
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, "Fout" );
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, "Fout" );
		}
		else {
			showMedMessage( "Het bestand is succesvol bewerkt\n" );
			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft succesvol het bestand met de naam '".$objBestand->getBestandsNaam().
			"' bewerkt.");
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, "Bewerking" );
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, "Bewerking" );
		}
		showBestand( $objBestand->getBestandsID(), $intWebsiteID, $objLIGebRechten );
	}
	elseif(isset($_POST['delBestandKnop'])) {
		$intBestandID = checkData($_POST['bestandid'], "integer");
		$objBestand = getBestand( $intBestandID, $intWebsiteID);

		if(!delBestand( $objBestand )) {
			showErrMessage( "Het bestand kon niet worden verwijderd!\n" );
			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het bestand met de naam '".$objBestand->getBestandsNaam().
			"' te verwijderen. Dit is mislukt.");
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, "Fout" );
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, "Fout" );
		}
		else {
			showMedMessage( "Het bestand is succesvol verwijderd\n" );
			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft succesvol het bestand met de naam '".$objBestand->getBestandsNaam().
			"' verwijderd.");
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, "Verwijdering" );
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, "Verwijdering" );
		}
		showBestandOverzicht( $intWebsiteID, $objLIGebRechten );
	}
	else {
		$intVan = 0;
		if(isset($_GET['van']))
			$intVan = checkData($_GET['van'], "integer");
		showBestandOverzicht( $intWebsiteID, $objLIGebRechten, $intVan );
	}

 }

 include("footer.php");

?>