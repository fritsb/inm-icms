<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: inhoudbeheer.php
 * Beschrijving: De afhandeling van het beheren van de inhoud
 */
 session_start();
 include("header.php");
 
 if(!isset($_SESSION['login'])) {
 	echo "<h1>Geen toegang</h1>\n";
 	echo "Om deze pagina te gebruiken, moet je eerst inloggen bij het gebruikersgedeelte.<br><br>\n";
 	echo "Het is mogelijk dat u te lang bent ingelogd, dan moet u opnieuw inloggen. U wordt vanzelf teruggestuurd naar";
 	echo " de pagina waar u naar toe wou.\n ";
	$strTekst = "Persoon met het IP-adres ".$_SERVER['REMOTE_ADDR']." heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen.";
	verwerkLogRegel( $strTekst, '','','', "Geen toegang" );

 }
 elseif($_SESSION['login'] == "gebruiker" || $_SESSION['login'] == "admin") {
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
	$objWebsite = getWebsite( $intWebsiteID );
	// Onderdeel
	if(isset($_GET['oid']) && isset($_GET['actie'])) {
		$intOID = checkData($_GET['oid'], "integer");
		$objOnderdeel = getOnderdeel($intOID, $intWebsiteID );
		$strActie = checkData($_GET['actie']);
		if($strActie == "view") {
			showOnderdeel($intOID, $intWebsiteID, $objLIGebRechten);

			if(is_object($objOnderdeel) && is_object($objWebsite)) {
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft het onderdeel met de naam '".$objOnderdeel->getTitel()."' (ID: ".
				$intOID.") van de website met de titel '".$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") bekeken.");
				$strSoort = "Bekijken";
			}
			else {
				if(is_object($objWebsite))
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het onderdeel met ID-nummer '$intOID' van de website met de titel '".
						$objWebsite->getTitel()."' te bekijken. Dit is mislukt.");
				else 
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het onderdeel met ID-nummer '$intOID' van de website met ID-nummer ".
						" '$intWebsiteID' te bekijken. Dit is mislukt.");
				$strSoort = "Fout";
			}
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort);
		}
		elseif($strActie == "edit") {
			editOnderdeelForm($intOID, $intWebsiteID, $objLIGebRechten );
		}
		elseif($strActie == "del") {
			delOnderdeelForm($intOID, $intWebsiteID, $objLIGebRechten);
		}
		elseif($strActie == "moveup") {
			$intParentID = checkData($_GET['par'], "integer");
			$intPositie = checkData( $_GET['pos'], "integer");
			if(moveOnderdeel($intPositie, $intParentID, $intOID, $intWebsiteID, "up")) {
				showMedMessage("Onderdeel met het ID-nummer '$intOID' succesvol verplaatst!");
				$strSoort = "Verplaatsing";
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft het onderdeel met de naam '".$objOnderdeel->getTitel()."' (ID: ".
					$intOID.") van de website met de titel '".$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") verplaatst naar boven.");
			}
			else {
				showErrMessage("Onderdeel met het ID-nummer '$intOID' kon niet worden verplaatst!");
				$strSoort = "Fout";
				if(is_object($objWebsite))
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het onderdeel met ID-nummer '$intOID' van de website met de titel '".
						$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") te verplaatsen naar boven. Dit is mislukt.");
				else 
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het onderdeel met ID-nummer '$intOID' van de website met ID-nummer ".
					" '$intWebsiteID' te verplaatsen naar boven. Dit is mislukt.");
			}

			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
			showWebsiteInhoud( $intWebsiteID, $objLIGebRechten );
		}
		elseif($strActie == "movedown") {
			$intParentID = checkData($_GET['par'], "integer");
			$intPositie = checkData( $_GET['pos'], "integer");
			if(moveOnderdeel( $intPositie, $intParentID, $intOID, $intWebsiteID, "down")) {
				showMedMessage("Onderdeel met het ID-nummer '$intOID' succesvol verplaatst!");
				$strSoort = "Verplaatsing";
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft het onderdeel met de naam '".$objOnderdeel->getTitel()."' (ID: ".
					$intOID.") van de website met de titel '".$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") verplaatst naar onder.");
			}
			else {
				showErrMessage("Onderdeel met het ID-nummer '$intOID' kon niet worden verplaatst!");
				$strSoort = "Fout";
				if(is_object($objWebsite))
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het onderdeel met ID-nummer '$intOID' van de website met de titel '".
						$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") te verplaatsen naar onder. Dit is mislukt.");
				else 
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het onderdeel met ID-nummer '$intOID' van de website met ID-nummer ".
					"'$intWebsiteID' te verplaatsen naar onder. Dit is mislukt.");
			}
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
			showWebsiteInhoud( $intWebsiteID, $objLIGebRechten );
		}		
		elseif($strActie == "visibileon") {
			$intParentID = checkData($_GET['par'], "integer");
			if(changeOnderdeelVisibility($intOID, $intWebsiteID, "ja")) {
				showMedMessage("Onderdeel met het ID-nummer '$intOID' succesvol zichtbaar gemaakt!");
				$strSoort = "Zichtbaarheid veranderd";
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft de zichtbaarheid van het onderdeel met de naam '".$objOnderdeel->getTitel()."' (ID: ".
					$intOID.") van de website met de titel '".$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") op 'aan' gezet.");
			}
			else {
				showErrMessage("Onderdeel met het ID-nummer '$intOID' kon niet zichtbaar worden gemaakt!");
				$strSoort = "Fout";
				if(is_object($objWebsite))
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het onderdeel met ID-nummer '$intOID' van de website met de titel '".
						$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") zichtbaar te maken. Dit is mislukt.");
				else 
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het onderdeel met ID-nummer '$intOID' van de website met ID-nummer ".
					" '$intWebsiteID' zichtbaar te maken. Dit is mislukt.");
			}	
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
			showWebsiteInhoud( $intWebsiteID, $objLIGebRechten );
		}
		elseif($strActie == "visibileoff") {
			$intParentID = checkData($_GET['par'], "integer");		
			if(changeOnderdeelVisibility($intOID, $intWebsiteID,  "nee")) {
				showMedMessage("Onderdeel met het ID-nummer '$intOID' succesvol onzichtbaar gemaakt!");
				$strSoort = "Zichtbaarheid veranderd";
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft de zichtbaarheid van het onderdeel met de naam '".$objOnderdeel->getTitel()."' (ID: ".
					$intOID.") van de website met de titel '".$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") op 'uit' gezet.");
			}
			else {
				showErrMessage("Onderdeel met het ID-nummer '$intOID' kon niet onzichtbaar worden gemaakt!");
				$strSoort = "Fout";
				if(is_object($objWebsite))
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het onderdeel met ID-nummer '$intOID' van de website met de titel '".
						$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") onzichtbaar te maken. Dit is mislukt.");
				else 
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het onderdeel met ID-nummer '$intOID' van de website met ID-nummer ".
					" '$intWebsiteID' onzichtbaar te maken. Dit is mislukt.");
			}
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
			showWebsiteInhoud( $intWebsiteID, $objLIGebRechten );
		}
	}
	// Pagina
	elseif(isset($_GET['pid']) && isset($_GET['actie'])) {
		$intPID = checkData($_GET['pid'], "integer");
		$objPagina = getPagina( $intPID, $intWebsiteID );
		$strActie = checkData($_GET['actie']);
		if($strActie == "view") {
			showPagina( $intPID, $intWebsiteID, $objLIGebRechten );

			if(is_object($objPagina) && is_object($objWebsite)) {
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft de pagina met de naam '".$objPagina->getTitel()."' (ID: ".
				$intPID.") van de website met de titel '".$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") bekeken.");
				$strSoort = "Bekijken";
			}
			else {
				if(is_object($objWebsite))
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd de pagina met ID-nummer '$intPID' van de website met de titel '".
						$objWebsite->getTitel()."' te bekijken. Dit is mislukt.");
				else 
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd de pagina met ID-nummer '$intPID' van de website met ID-nummer ".
					" '$intWebsiteID' te bekijken. Dit is mislukt.");
				$strSoort = "Fout";
			}

			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
		}
		elseif($strActie == "edit") {
			editPaginaForm($intPID, $intWebsiteID, $objLIGebRechten );
		}
		elseif($strActie == "del") {
			delPaginaForm($intPID, $intWebsiteID, $objLIGebRechten);
		}
		elseif($strActie == "moveup") {
			$intOnderdeelID = checkData($_GET['par'], "integer");
			$intPositie = checkData( $_GET['pos'], "integer");
			if(movePagina( $intPositie, $intOnderdeelID, $intPID, $intWebsiteID, "up")) {
				showMedMessage("Pagina met het ID-nummer '$intPID' succesvol verplaatst!");
				$strSoort = "Verplaatsing";
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft de pagina met de naam '".$objPagina->getTitel()."' (ID: ".
					$intPID.") van de website met de titel '".$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") verplaatst naar boven.");				
			}
			else {
				showErrMessage("Pagina met het ID-nummer '$intPID' kon niet worden verplaatst!");
				$strSoort = "Fout";
				if(is_object($objWebsite))
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd de pagina met ID-nummer '$intPID' van de website met de titel '".
						$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") te verplaatsen naar boven. Dit is mislukt.");
				else 
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd de pagina met ID-nummer '$intPID' van de website met ID-nummer ".
					" '$intWebsiteID' te verplaatsen naar boven. Dit is mislukt.");
			}
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
			showOnderdeel($intOnderdeelID, $intWebsiteID, $objLIGebRechten);
		}		
		elseif($strActie == "movedown") {
			$intOnderdeelID = checkData($_GET['par'], "integer");
			$intPositie = checkData( $_GET['pos'], "integer");
			if(movePagina($intPositie, $intOnderdeelID, $intPID, $intWebsiteID, "down")) {
				showMedMessage("Pagina met het ID-nummer '$intPID' succesvol verplaatst!");
				$strSoort = "Verplaatsing";
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft de pagina met de naam '".$objPagina->getTitel()."' (ID: ".
					$intPID.") van de website met de titel '".$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") verplaatst naar onder.");
			}
			else {
				showErrMessage("Pagina met het ID-nummer '$intPID' kon niet worden verplaatst!");
				$strSoort = "Fout";
				if(is_object($objWebsite))
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd de pagina met ID-nummer '$intPID' van de website met de titel '".
						$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") te verplaatsen naar onder. Dit is mislukt.");
				else 
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd de pagina met ID-nummer '$intPID' van de website met ID-nummer ".
					" '$intWebsiteID' te verplaatsen naar onder. Dit is mislukt.");

			}
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
			showOnderdeel($intOnderdeelID, $intWebsiteID, $objLIGebRechten);
		}		
		elseif($strActie == "visibileon") {
			$intOnderdeelID = checkData($_GET['par'], "integer");
			if(changePaginaVisibility($intPID, $intWebsiteID, "ja")) {
				showMedMessage("Pagina met het ID-nummer '$intPID' succesvol zichtbaar gemaakt!");
				$strSoort = "Zichtbaarheid veranderd";
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft de zichtbaarheid van de pagina met de naam '".$objPagina->getTitel()."' (ID: ".
					$intPID.") van de website met de titel '".$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") op 'aan' gezet.");
			}
			else {
				showErrMessage("Pagina met het ID-nummer '$intPID' kon niet zichtbaar worden gemaakt!");
				$strSoort = "Fout";
				if(is_object($objWebsite))
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd de pagina met ID-nummer '$intPID' van de website met de titel '".
						$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") zichtbaar te maken. Dit is mislukt.");
				else 
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd de pagina met ID-nummer '$intPID' van de website met ID-nummer ".
					" '$intWebsiteID' zichtbaar te maken. Dit is mislukt.");

			}
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
			showOnderdeel($intOnderdeelID, $intWebsiteID, $objLIGebRechten);
		}
		elseif($strActie == "visibileoff") {
			$intOnderdeelID = checkData($_GET['par'], "integer");		
			if(changePaginaVisibility($intPID, $intWebsiteID, "nee")) {
				showMedMessage("Pagina met het ID-nummer '$intPID' succesvol onzichtbaar gemaakt!");
				$strSoort = "Zichtbaarheid veranderd";
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft de zichtbaarheid van de pagina met de naam '".$objPagina->getTitel()."' (ID: ".
					$intPID.") van de website met de titel '".$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") op 'uit' gezet.");
			}
			else {
				showErrMessage("Pagina met het ID-nummer '$intPID' kon niet onzichbtaar worden gemaakt!");
				$strSoort = "Fout";
				if(is_object($objWebsite))
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd de pagina met ID-nummer '$intOID' van de website met de titel '".
						$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") onzichtbaar te maken. Dit is mislukt.");
				else 
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd de pagina met ID-nummer '$intOID' van de website met ID-nummer ".
					" '$intWebsiteID' onzichtbaar te maken. Dit is mislukt.");
			}
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
			showOnderdeel($intOnderdeelID, $intWebsiteID, $objLIGebRechten);
		}
		elseif($strActie == "newB") {
			addBlokForm( $intPID, $intWebsiteID, $objLIGebRechten);
		}
	}
	// Blokken
	elseif(isset($_GET['bid']) && isset($_GET['actie'])) {
		$intBID = checkData($_GET['bid'], "integer");
		$objBlok = getBlok( $intBID, $intWebsiteID );
		$strActie = checkData($_GET['actie']);
		if($strActie == "view") {
			showBlok( $intBID, $intWebsiteID, $objLIGebRechten );

			if(is_object($objBlok) && is_object($objWebsite)) {
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft het blok met de naam '".$objBlok->getTitel()."' (ID: ".
				$intBID.") van de website met de titel '".$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") bekeken.");
				$strSoort = "Bekijken";
			}
			else {
				if(is_object($objWebsite))
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het blok met ID-nummer '$intBID' van de website met de titel '".
						$objWebsite->getTitel()."' te bekijken.");
				else 
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het blok met ID-nummer '$intBID' van de website met ID-nummer ".
					" '$intWebsiteID' te bekijken. Dit is mislukt.");
				$strSoort = "Fout";
			}			
			
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
		}
		elseif($strActie == "edit") {
			editBlokForm($intBID, $intWebsiteID, $objLIGebRechten );
		}
		elseif($strActie == "del") {
			$intPID = checkData($_GET['pagid'], "integer");
			delBlokForm($intBID, $intPID, $intWebsiteID, $objLIGebRechten);
		}
		elseif($strActie == "moveup") {
			$intPaginaID = checkData( $_GET['par'], "integer" );
			$intPositie = checkData($_GET['pos'], "integer");
			if(moveBlok($intPositie, $intPaginaID, $intBID, $intWebsiteID, "up")) {
				showMedMessage("Blok met het ID-nummer '$intBID' succesvol verplaatst!");
				$strSoort = "Verplaatsing";
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft het blok met de naam '".$objBlok->getTitel()."' (ID: ".
					$intBID.") van de website met de titel '".$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") verplaatst naar boven.");
			}
			else {
				showErrMessage("Blok met het ID-nummer '$intBID' kon niet worden verplaatst!");
				$strSoort = "Fout";
				if(is_object($objWebsite))
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het blok met ID-nummer '$intBID' van de website met de titel '".
						$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") te verplaatsen naar boven. Dit is mislukt.");
				else 
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het blok met ID-nummer '$intBID' van de website met ID-nummer ".
					" '$intWebsiteID' te verplaatsen naar boven. Dit is mislukt.");
			}
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
			showPagina( $intPaginaID, $intWebsiteID, $objLIGebRechten );
		}		
		elseif($strActie == "movedown") {
			$intPaginaID = checkData( $_GET['par'], "integer" );
			$intPositie = checkData($_GET['pos'], "integer");
			if(moveBlok($intPositie, $intPaginaID, $intBID, $intWebsiteID, "down")) {
				showMedMessage("Blok met het ID-nummer '$intBID' succesvol verplaatst!");
				$strSoort = "Verplaatsing";
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft het blok met de naam '".$objBlok->getTitel()."' (ID: ".
					$intBID.") van de website met de titel '".$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") verplaatst naar onder.");
			}
			else {
				$strError = "Blok met het ID-nummer '$intBID' kon niet worden verplaatst!";
				showErrMessage( $strError );
				$strSoort = "Fout";
				if(is_object($objWebsite))
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het blok met ID-nummer '$intBID' van de website met de titel '".
						$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") te verplaatsen naar onder. Dit is mislukt.");
				else 
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het blok met ID-nummer '$intBID' van de website met ID-nummer ".
					" '$intWebsiteID' te verplaatsen naar onder. Dit is mislukt.");

			}
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
			showPagina( $intPaginaID, $intWebsiteID, $objLIGebRechten );
		}		
		elseif($strActie == "visibileon") {
			$intPaginaID = checkData( $_GET['par'], "integer" );
			if(changeBlokVisibility($intBID, $intWebsiteID, "ja")) {
				showMedMessage("Blok met het ID-nummer '$intBID' succesvol zichtbaar gemaakt!");
				$strSoort = "Zichtbaarheid veranderd";
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft de zichtbaarheid van het blok met de naam '".$objBlok->getTitel()."' (ID: ".
					$intBID.") van de website met de titel '".$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") op 'aan' gezet.");
			}
			else {
				showErrMessage("Blok met het ID-nummer '$intBID' kon niet zichbtaar worden gemaakt!");
				$strSoort = "Fout";
				if(is_object($objWebsite))
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het blok met ID-nummer '$intBID' van de website met de titel '".
						$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") zichtbaar te maken. Dit is mislukt.");
				else 
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het blok met ID-nummer '$intBID' van de website met ID-nummer ".
					" '$intWebsiteID' zichtbaar te maken. Dit is mislukt.");
			}
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
			showPagina( $intPaginaID, $intWebsiteID, $objLIGebRechten );
		}
		elseif($strActie == "visibileoff") {
			$intPaginaID = checkData( $_GET['par'], "integer" );		
			if(changeBlokVisibility($intBID, $intWebsiteID, "nee")) {
				showMedMessage("Blok met het ID-nummer '$intBID' succesvol onzichtbaar gemaakt!");
				$strSoort = "Zichtbaarheid veranderd";
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft de zichtbaarheid van het blok met de naam '".$objBlok->getTitel()."' (ID: ".
					$intBID.") van de website met de titel '".$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") op 'uit' gezet.");
			}
			else {
				showErrMessage("Blok met het ID-nummer '$intBID' kon niet onzichbtaar worden gemaakt!");
				$strSoort = "Fout";
				if(is_object($objWebsite))
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het blok met ID-nummer '$intBID' van de website met de titel '".
						$objWebsite->getTitel()."' (ID: ".$intWebsiteID.") onzichtbaar te maken. Dit is mislukt.");
				else 
					$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het blok met ID-nummer '$intBID' van de website met ID-nummer ".
					" '$intWebsiteID' onzichtbaar te maken. Dit is mislukt.");

			}
			if(isset($objLIAdmin))
				verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
			else
				verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
			showPagina( $intPaginaID, $intWebsiteID, $objLIGebRechten );
		}
	}
	elseif(isset($_GET['actie'])) {
		$strActie = checkData($_GET['actie']);
		if($strActie == "newO") {
			addOnderdeelForm( $intWebsiteID, $objLIGebRechten );
		}
		elseif($strActie == "newSO") {
			if(isset($_GET['ido'])) {
				$intOID = $_GET['ido'];
				addOnderdeelForm( $intWebsiteID, $objLIGebRechten, "ja", $intOID );
			}
			else {
				addOnderdeelForm( $intWebsiteID, $objLIGebRechten, "ja" );
			}
		}
		elseif($strActie == "newP") {
			if(isset($_GET['ido'])) {
				$intOID = $_GET['ido'];
				addPaginaForm( $intWebsiteID, $objLIGebRechten, $intOID );
			}
			else {
				addPaginaForm( $intWebsiteID, $objLIGebRechten );
			}
		}				
	}
	// Onderdelen
 	elseif(isset($_POST['addOnderdeelKnop'])) {
		$objOnderdeel = new Onderdeel();
		$objOnderdeel->setTitel( checkData($_POST['titel'] ));
		$objOnderdeel->setOmschrijving( checkData($_POST['omschrijving'] ));
		$objOnderdeel->setWebsiteID( $intWebsiteID );
		$objOnderdeel->setZichtbaar( checkData($_POST['zichtbaar']) );
		if(isset($_POST['bewerkbaar']))
			$objOnderdeel->setBewerkbaar( checkData($_POST['bewerkbaar']) );
		elseif($intGebruikersID != -42)
			$objOnderdeel->setBewerkbaar( "ja" );

 		if(isset($_POST['parent_id']))
			$objOnderdeel->setParentID( checkData($_POST['parent_id'], "integer"));
		$objOnderdeel->setPositie( getMaxPositie( "onderdeel", $objOnderdeel->getParentID(), $objOnderdeel->getWebsiteID() ));
 		if(insertOnderdeel($objOnderdeel)) {
 			showMedMessage( "Onderdeel succesvol toegevoegd." );
 			$strSoort = "Toevoeging";
			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft een onderdeel met de naam '".$objOnderdeel->getTitel().
			"' toegevoegd.");
 		}
 		else {
 			showErrMessage( "Onderdeel kon niet worden toegvoegd." );
 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd een onderdeel met de naam '".$objOnderdeel->getTitel().
			"' proberen toe te voegen. Dit is mislukt.");
 			$strSoort = "Fout";
 		}
		if(isset($objLIAdmin))
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
		else
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
		showWebsiteInhoud( $intWebsiteID, $objLIGebRechten );
 	}
 	elseif(isset($_POST['editOnderdeelKnop'])) {
		$objOnderdeel = getOnderdeel(checkData($_POST['oid']), $intWebsiteID);
		$objOnderdeel->setOnderdeelID( checkData($_POST['oid'] ));
		$objOnderdeel->setTitel( checkData($_POST['titel'] ));
		$objOnderdeel->setOmschrijving( checkData($_POST['omschrijving'] ));
		$objOnderdeel->setZichtbaar( checkData($_POST['zichtbaar']) );
		if(isset($_POST['bewerkbaar']))
			$objOnderdeel->setBewerkbaar( checkData($_POST['bewerkbaar']) );
		$objOnderdeel->setWebsiteID( $intWebsiteID );
		
 		if(updateOnderdeel($objOnderdeel)) {
 			showMedMessage( "Het onderdeel is succesvol bewerkt.");
 			$strSoort = "Bewerking";
 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft succesvol het onderdeel met de naam '".$objOnderdeel->getTitel().
			"' (ID: ".$objOnderdeel->getOnderdeelID().") bewerkt.");
 		}
 		else {
 			showErrMessage( "Het onderdeel kon niet worden bewerkt.");
 			$strSoort = "Fout";
 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het onderdeel met de naam '".$objOnderdeel->getTitel().
			"' (ID: ".$objOnderdeel->getOnderdeelID().") proberen te bewerken. Dit is mislukt.");

 		}
		if(isset($objLIAdmin))
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
		else
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
		showWebsiteInhoud( $intWebsiteID, $objLIGebRechten );
 	}
  	elseif(isset($_POST['delOnderdeelKnop'])) {
		$intOID = checkData($_POST['oid']);
		$objOnderdeel = getOnderdeel( $intOID, $intWebsiteID );
 		if(is_object($objOnderdeel) && deleteOnderdeel($intOID, $intWebsiteID)) {
 			showMedMessage( "Het onderdeel is succesvol verwijderd." );
 			$strSoort = "Verwijdering";
 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft het onderdeel met de naam '".$objOnderdeel->getTitel().
			"'  (ID: ".$objOnderdeel->getOnderdeelID().") verwijderd.");
 		}
 		else {
 			showErrMessage( "Het onderdeel kon niet worden verwijderd." );
 			$strSoort = "Fout";
 			if(is_object($objOnderdeel))
	 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het onderdeel met de naam '".$objOnderdeel->getTitel().
				"' (ID: ".$objOnderdeel->getOnderdeelID().") proberen te verwijderen. Dit is mislukt. ");
			else
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het onderdeel met het ID-nummer '".$intOID.
				"' proberen te verwijderen. Dit is mislukt, omdat het onderdeel niet in de database gevonden kan worden.");
 		}

		if(isset($objLIAdmin))
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
		else
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
		showWebsiteInhoud( $intWebsiteID, $objLIGebRechten );
 	}
 	// Pagina
 	elseif(isset($_POST['addPaginaKnop'])) {
 		$objPagina = new Pagina();
 		$objPagina->setTitel( checkData($_POST['titel'] ));
 		$objPagina->setLimiet( checkData($_POST['limiet'], "integer" ));
		$objPagina->setZichtbaar( $_POST['zichtbaar'] );
		if(isset($_POST['bewerkbaar']))
			$objPagina->setBewerkbaar( checkData($_POST['bewerkbaar']));
		elseif($intGebruikersID != -42)
			$objPagina->setBewerkbaar( "ja" );
		$objPagina->setWebsiteID( $intWebsiteID );

 		if(isset($_POST['parent_id']))
			$objPagina->setOnderdeelID( checkData($_POST['parent_id'], "integer"));

		$objPagina->setPositie( getMaxPositie("pagina", $objPagina->getOnderdeelID(), $objPagina->getWebsiteID() ) );
 		if(insertPagina($objPagina)) {
 			showMedMessage( "De pagina is succesvol toegevoegd.");
 			$strSoort = "Toevoeging";
			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft een pagina met de naam '".$objPagina->getTitel().
			"' toegevoegd.");
 		}
 		else {
 			showErrMessage( "De pagina kon niet worden toegevoegd." );
 			$strSoort = "Fout";
 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd een pagina met de naam '".$objPagina->getTitel().
			"' proberen toe te voegen. Dit is mislukt.");
 		}

		if(isset($objLIAdmin))
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
		else
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
		showWebsiteInhoud( $intWebsiteID, $objLIGebRechten );
 	}
  	elseif(isset($_POST['editPaginaKnop'])) {
 		$objPagina = getPagina( checkData($_POST['pid'], "nummer" ), $intWebsiteID);
 		$objPagina->setTitel( checkData($_POST['titel'] ));
 		$objPagina->setLimiet( checkData($_POST['limiet'], "integer" ));
		if(isset($_POST['zichtbaar']))
			$objPagina->setZichtbaar( checkData($_POST['zichtbaar'] ));
		$objPagina->setWebsiteID( $intWebsiteID );
		if(isset($_POST['bewerkbaar']))
			$objPagina->setBewerkbaar( checkData( $_POST['bewerkbaar'] ));
 		if(isset($_POST['parent_id'])) {
 			$intOldOnderdeelID = $objPagina->getOnderdeelID();
 			$objPagina->setOnderdeelID( checkData($_POST['parent_id'], "integer"));
 			if($intOldOnderdeelID != $objPagina->getOnderdeelID()) {
	 			veranderPaginaPositie( $objPagina->getPaginaID(), $intOldOnderdeelID, $objPagina->getPositie(), $objPagina->getWebsiteID());
 				$objPagina->setPositie( getMaxPositie("pagina", $objPagina->getOnderdeelID(), $objPagina->getWebsiteID() ) );
 			}
		}
 		if(updatePagina($objPagina)) {
 			showMedMessage( "De pagina is succesvol bewerkt." );
 			$strSoort = "Bewerking";
 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft succesvol de pagina met de naam '".$objPagina->getTitel().
			"' (ID: ".$objPagina->getPaginaID().") bewerkt.");
 		}
 		else {
 			showErrMessage( "De pagina kon niet worden bewerkt." );
 			$strSoort = "Fout";
 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd de pagina met de naam '".$objPagina->getTitel().
			"' (ID: ".$objPagina->getPaginaID().") proberen te bewerken. Dit is mislukt.");
 		}

		if(isset($objLIAdmin))
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
		else
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
 		showPagina( $objPagina->getPaginaID(), $intWebsiteID, $objLIGebRechten  );
 	}
  	elseif(isset($_POST['delPaginaKnop'])) {
		$intPID = checkData($_POST['pid']);
		$intOID = checkData($_POST['oid']);
		$objPagina = getPagina($intPID, $intWebsiteID);
 		if(is_object($objPagina) && deletePagina($intPID, $intWebsiteID)) {
 			showMedMessage( "De pagina is succesvol verwijderd." );
 			$strSoort = "Verwijdering";
 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft succesvol de pagina met de naam '".$objPagina->getTitel().
			"' (ID: ".$objPagina->getPaginaID().") verwijderd.");
 		}
 		else {
 			showErrMessage( "De pagina kon niet worden verwijderd." );
 			$strSoort = "Fout";
 			if(is_object($objPagina))
	 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd de pagina met de naam '".$objPagina->getTitel().
				"' (ID: ".$objPagina->getPaginaID().") proberen te verwijderen. Dit is mislukt.");
			else
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd de pagina met het ID-nummer '$intPID' proberen te ".
					" verwijderen. Dit is mislukt, omdat de pagina niet in de database gevonden kan worden..");
 		}

		if(isset($objLIAdmin))
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
		else
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
 		showOnderdeel($intOID, $intWebsiteID, $objLIGebRechten);
 	}
 	// Blokken
 	elseif(isset($_POST['addBlokKnop1'])) {
 		$objBlok = new Blok();
 		$objBlok->setBlokID( getHighestIDNummer("blok", $intWebsiteID ) );
 		$objBlok->setPaginaID( checkData($_POST['pid'] ) );
 		$objBlok->setTitel( checkData($_POST['titel']));
 		$objBlok->setSubType( checkData($_POST['type']));
		$objBlok->setWebsiteID( $intWebsiteID );
 		$objBlok->setPositie(getMaxPositie("blok", $objBlok->getPaginaID(), $objBlok->getWebsiteID()) );
		$objBlok->setZichtbaar( checkData($_POST['zichtbaar']) );
		if(isset($_POST['bewerkbaar']))
			$objBlok->setBewerkbaar( checkData($_POST['bewerkbaar']) );
		elseif( $intGebruikersID != 42)
			$objBlok->setBewerkbaar( "ja" );
		$objBlok->setDatum( getDatumTijd() );
 		if(isset($_POST['datacheck']) && $_POST['begindatum'] != "")
			$objBlok->setFormatedBegindatum( $_POST['begindatum']);
		else
			$objBlok->setBeginDatum( "0000-00-00 00:00:00" );
 		if(isset($_POST['datacheck']) && $_POST['einddatum'] != "")
			$objBlok->setFormatedEinddatum( $_POST['einddatum'] );
		else
			$objBlok->setEindDatum( "9999-12-31 23:59:59" );
 		$objBlok->setUitlijning( checkData($_POST['uitlijning']));
 		$objBlok->setBreedte( checkData($_POST['breedte'], "integer"));
 		$objBlok->setHoogte( checkData($_POST['hoogte'], "integer"));
 		$objBlok->setBorder( checkData($_POST['border'], "integer"));
 		$objBlok->setBorderKleur( checkData($_POST['bordercolor']));
 		$objBlok->setBorderType( checkData($_POST['bordertype']));
 		$objBlok->setAchtergrondKleur( checkData($_POST['backgroundcolor']));
 		if(isset($_POST['introcheck']) && isset($_POST['intro']))
			$objBlok->setIntro( checkData($_POST['intro'], "tekst") );
		
		if(insertBlok($objBlok)) {
			addBlokForm2( $objBlok->getSubType(), $objBlok->getBlokID(), $intWebsiteID, $objLIGebRechten );
 			$strSoort = "Toevoeging";
			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft het eerste gedeelte van een blok met de naam '".$objBlok->getTitel().
			"' toegevoegd. ");
		}
		else {
			showErrMessage( "Helaas, het is niet gelukt om het blok toe te voegen" );	
			showPagina( $objBlok->getPaginaID(), $intWebsiteID, $objLIGebRechten );
 			$strSoort = "Fout";
 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd een blok met de naam '".$objBlok->getTitel().
			"' proberen toe te voegen. Dit is mislukt.");

		}

		if(isset($objLIAdmin))
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
		else
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
 	}
 	elseif(isset($_POST['addBlokKnop2'])) {
 		// Automatisch klassenaam genereren
		$strSubType = checkData($_POST['type']);
 		$strKlasseNaam = getGoedeSubType( $strSubType ) . "Blok";
		$objBlok = new $strKlasseNaam;
 		$objBlok->setBlokID( checkData($_POST['bid']));
 		$objBlok->setSubType( $strSubType );
 		$objBlok->setWebsiteID( $intWebsiteID );
 		// Verschillende soorten insert-functies en info toegevoegd aan objecten
 		if($objBlok->getSubType() == "afbeelding") {
 			if($_POST['urlofbestand'] == "bestand") {
	 			$objBlok->setBestandID( checkData($_POST['bestandid'], "integer"));
	 			$objBlok->setURL( "" );
 			}
 			else {
	 			$objBlok->setURL( checkData($_POST['afburl']));
	 			$objBlok->setBestandID( "" );
	 		}
 			$objBlok->setAfbWidth( checkData($_POST['afbbreedte'], "integer") );
 			$objBlok->setAfbHeight( checkData($_POST['afbhoogte'], "integer") );
  			$objBlok->setAfbBorder( checkData($_POST['afbborder'], "integer") );
  			$objBlok->setAlt( checkData($_POST['alt']) );
			$booGelukt = insertAfbeeldingBlok( $objBlok );
 		} 
 		elseif($objBlok->getSubType() == "contactform") {
   			$objBlok->setMailAdres( checkData($_POST['mailadres']) );
			if(isset($_POST['adresoptie']))
				$objBlok->setAdresOptie( checkData($_POST['adresoptie']) );
			if(isset($_POST['teloptie']))
				$objBlok->setTelOptie( checkData($_POST['teloptie']) );
			$objBlok->setTaal( checkData($_POST['taal']) );
			$objBlok->setVerstuurdBericht( checkData($_POST['welverstuurd'], "tekst"));
			$objBlok->setNietVerstuurdBericht( checkData($_POST['nietverstuurd'], "tekst"));
			$objBlok->setLetterType( checkData($_POST['lettertype']));
			$objBlok->setLetterGrootte( checkData($_POST['lettergrootte'], "integer"));
			$booGelukt = insertContactFormBlok( $objBlok );
 		}
 		elseif($objBlok->getSubType() == "downloads") {
 			if($_POST['urlofbestand'] == "bestand") {
	 			$objBlok->setBestandID( checkData($_POST['bestandid'], "integer"));
	 			$objBlok->setURL( "" );
 			}
 			else {
	 			$objBlok->setURL( checkData($_POST['url']));
	 			$objBlok->setBestandID( "" );
	 		}
 			$objBlok->setNaam( checkData($_POST['naam']) );
			$booGelukt = insertLinksBlok( $objBlok );
 		}
 		elseif($objBlok->getSubType() == "flash") {
 			if($_POST['urlofbestand'] == "bestand") {
	 			$objBlok->setBestandID( checkData($_POST['bestandid'], "integer"));
	 			$objBlok->setFlashURL( "" );
 			}
 			else {
	 			$objBlok->setFlashURL( checkData($_POST['flashurl']));
	 			$objBlok->setBestandID( "" );
	 		}
 			$objBlok->setFlsWidth( checkData($_POST['flsbreedte'], "integer") );
 			$objBlok->setFlsHeight( checkData($_POST['flshoogte'], "integer") );
			if(isset($_POST['autoplay']))
 				$objBlok->setAutoPlay( checkData($_POST['autoplay']) );
 			$objBlok->setKwaliteit( checkData($_POST['kwaliteit']) );
 			$objBlok->setAchtergrondKleur( checkData($_POST['achtergrondkleur']) );
 			if(isset($_POST['loop']))
 				$objBlok->setLoop( checkData($_POST['loop']) );
 			$booGelukt = insertFlashBlok( $objBlok );
 		} 		
 		elseif($objBlok->getSubType() == "html" || $objBlok->getSubType() == "wysiwyg") {
 			$objBlok->setHTMLcode( checkData($_POST['html'], "html" ));
			$booGelukt = insertHtmlBlok( $objBlok );
		}
 		elseif($objBlok->getSubType() == "links") {
 			$objBlok->setURL( checkData($_POST['url']) );
 			$objBlok->setNaam( checkData($_POST['naam']) );
			$booGelukt = insertLinksBlok( $objBlok );
 		}		
 		elseif($objBlok->getSubType() == "tekstafb") {
 			$objBlok->setTekst( checkData($_POST['tekst'], "tekst") );
 			$objBlok->setLetterGrootte( checkData($_POST['lettergrootte'], "integer") );
 			$objBlok->setLetterType( checkData($_POST['lettertype']) );
 			$objBlok->setLetterKleur( checkData($_POST['letterkleur']) );
 			if($_POST['urlofbestand'] == "bestand") {
	 			$objBlok->setBestandID( checkData($_POST['bestandid'], "integer"));
	 			$objBlok->setURL( "" );
 			}
 			else {
	 			$objBlok->setURL( checkData($_POST['afburl']));
	 			$objBlok->setBestandID( "" );
	 		}
 			$objBlok->setAfbWidth( checkData($_POST['afbbreedte'], "integer") );
 			$objBlok->setAfbHeight( checkData($_POST['afbhoogte'], "integer") );
 			$objBlok->setAfbBorder( checkData($_POST['afbborder'], "integer") );
 			$objBlok->setAfbAlt( checkData($_POST['afbalt']));
 			$objBlok->setKeuze( checkData($_POST['keuze']));
			$booGelukt = insertTekstAfbBlok( $objBlok );
 		}
 		elseif($objBlok->getSubType() == "tekst") {
 			$objBlok->setTekst( checkData($_POST['tekst'], "tekst") );
 			$objBlok->setLetterGrootte( checkData($_POST['lettergrootte'], "integer") );
 			$objBlok->setLetterType( checkData($_POST['lettertype']) );
 			$objBlok->setLetterKleur( checkData($_POST['letterkleur']) );
			$booGelukt = insertTekstBlok( $objBlok );
 		}

	 	if($booGelukt) {
			showMedMessage( "Het is gelukt om een blok toe te voegen" );
 			$strSoort = "Toevoeging";
 			$objBlok = getBlok( $objBlok->getBlokID(), $intWebsiteID );
			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft het tweede gedeelte van een blok met de naam '".$objBlok->getTitel().
			"' (ID: ".$objBlok->getBlokID().") toegevoegd. ");
		}
		else {
			showErrMessage( "Helaas, het is niet gelukt om een blok toe te voegen." );	
 			$strSoort = "Fout";
 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het tweede gedeelte van een blok met het ID-nummer '".$objBlok->getBlokID().
			"' proberen toe te voegen. Dit is mislukt.");
		} 		

		if(isset($objLIAdmin))
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
		else
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );

    	showBlok( $objBlok->getBlokID() , $intWebsiteID, $objLIGebRechten );
 	}
  	elseif(isset($_POST['editBlokKnop'])) {
  		// De klasse wordt automatisch aangemaakt nav. de type
 		$strSubType = checkData($_POST['type']);
 		$strFunctie = "get".ucfirst(getGoedeSubType( $strSubType ))."Blok";
		$objBlok = $strFunctie( checkData($_POST['bid'], "integer"), $intWebsiteID );
 		$objBlok->setBlokID( checkData($_POST['bid'], "integer"));
 		$objBlok->setSubType( $strSubType );
 		if(isset($_POST['datacheck']) && $_POST['begindatum'] != "")
			$objBlok->setFormatedBegindatum( $_POST['begindatum']);
		else
			$objBlok->setBeginDatum( "0000-00-00 00:00:00" );
 		if(isset($_POST['datacheck']) && $_POST['einddatum'] != "")
			$objBlok->setFormatedEinddatum( $_POST['einddatum'] );
		else
			$objBlok->setEindDatum( "9999-12-31 23:59:59" );
 		$objBlok->setUitlijning( checkData($_POST['uitlijning']));

 		$objBlok->setBreedte( checkData($_POST['breedte'], "integer"));
 		$objBlok->setHoogte( checkData($_POST['hoogte'], "integer"));
 		$objBlok->setBorder( checkData($_POST['border'], "integer"));
 		$objBlok->setBorderType( checkData($_POST['bordertype']));
 		$objBlok->setBorderKleur( checkData($_POST['bordercolor']));
 		$objBlok->setAchtergrondKleur( checkData($_POST['backgroundcolor']));
 		if(isset($_POST['introcheck']) && isset($_POST['intro']))
			$objBlok->setIntro( checkData($_POST['intro'], "tekst" ));
		else 
			$objBlok->setIntro( checkData($_POST['intro'], "tekst" ));		
 		$objBlok->setWebsiteID( $intWebsiteID );
		$objBlok->setZichtbaar( checkData($_POST['zichtbaar']));
		if(isset($_POST['bewerkbaar']) && $objLIGebRechten == "ja") 
			$objBlok->setBewerkbaar( checkData($_POST['bewerkbaar'] ));
		elseif($objLIGebRechten != "ja")
			$objBlok->setBewerkbaar( "ja ");
 		$objBlok->setTitel( checkData($_POST['titel']) ); 		
 		// Verschillende update functies en verschillende info toevoegen
 		if($objBlok->getSubType() == "afbeelding") {
 			if($_POST['urlofbestand'] == "bestand") {
	 			$objBlok->setBestandID( checkData($_POST['bestandid'], "integer"));
	 			$objBlok->setURL( "" );
 			}
 			else {
	 			$objBlok->setURL( checkData($_POST['afburl']));
	 			$objBlok->setBestandID( "" );
	 		}
 			$objBlok->setAfbWidth( checkData($_POST['afbbreedte'], "integer") );
 			$objBlok->setAfbHeight( checkData($_POST['afbhoogte'], "integer") );
  			$objBlok->setAfbBorder( checkData($_POST['afbborder'], "integer") );
  			$objBlok->setAlt( checkData($_POST['alt']) );
			$booGelukt = updateBlok( $objBlok );
 		} 
 		elseif($objBlok->getSubType() == "contactform") {
   			$objBlok->setMailAdres( checkData($_POST['mailadres']) );
			if(isset($_POST['adresoptie']))
				$objBlok->setAdresOptie( checkData($_POST['adresoptie']) );
			else
				$objBlok->setAdresOptie( "nee" );
			if(isset($_POST['teloptie']))
				$objBlok->setTelOptie( checkData($_POST['teloptie']) );
			else
				$objBlok->setTelOptie( "nee" );
			$objBlok->setTaal( checkData($_POST['taal']) );
			$objBlok->setVerstuurdBericht( checkData($_POST['welverstuurd'], "tekst") );
			$objBlok->setNietVerstuurdBericht( checkData($_POST['nietverstuurd'], "tekst") );
			$objBlok->setLetterType( checkData($_POST['lettertype']));
			$objBlok->setLetterGrootte( checkData($_POST['lettergrootte'], "integer"));
			$booGelukt = updateBlok( $objBlok );
 		}
 		elseif($objBlok->getSubType() == "downloads") {
 			if($_POST['urlofbestand'] == "bestand") {
	 			$objBlok->setBestandID( checkData($_POST['bestandid'], "integer"));
	 			$objBlok->setURL( "" );
 			}
 			else {
	 			$objBlok->setURL( checkData($_POST['url']));
	 			$objBlok->setBestandID( "" );
	 		}
 			$objBlok->setNaam( checkData($_POST['naam']) );
 			$objBlok->setOmschrijving( checkData($_POST['omschrijving'], "tekst"));
			$booGelukt = updateBlok( $objBlok );
 		}
 		elseif($objBlok->getSubType() == "flash") {
 			if($_POST['urlofbestand'] == "bestand") {
	 			$objBlok->setBestandID( checkData($_POST['bestandid'], "integer"));
	 			$objBlok->setFlashURL( "" );
 			}
 			else {
	 			$objBlok->setFlashURL( checkData($_POST['flashurl']));
	 			$objBlok->setBestandID( "" );
	 		}
 			$objBlok->setFlsWidth( checkData($_POST['flsbreedte'], "integer") );
 			$objBlok->setFlsHeight( checkData($_POST['flshoogte'], "integer") );
			if(isset($_POST['autoplay']))
 				$objBlok->setAutoPlay( checkData($_POST['autoplay']) );
 			else
 				$objBlok->setAutoPlay( "nee" ); 			
 			$objBlok->setKwaliteit( checkData($_POST['kwaliteit']) );
 			$objBlok->setAchtergrondKleur( checkData($_POST['achtergrondkleur']) );
 			if(isset($_POST['loop']))
 				$objBlok->setLoop( checkData($_POST['loop']) );
 			else 
 				$objBlok->setLoop( "nee" );
 			$booGelukt = updateBlok( $objBlok );
 		} 		
 		elseif($objBlok->getSubType() == "html" || $objBlok->getSubType() == "wysiwyg") {
 			$objBlok->setHTMLcode( checkData($_POST['html'], "html") );
			$booGelukt = updateBlok( $objBlok );
		}
 		elseif($objBlok->getSubType() == "links") {
 			$objBlok->setURL( checkData($_POST['url']) );
 			$objBlok->setNaam( checkData($_POST['naam']) );
			$booGelukt = updateBlok( $objBlok );
 		}		
 		elseif($objBlok->getSubType() == "tekstafb") {
 			$objBlok->setTekst( checkData($_POST['tekst'], "tekst" ));
 			$objBlok->setLetterGrootte( checkData($_POST['lettergrootte'], "integer") );
 			$objBlok->setLetterType( checkData($_POST['lettertype']) );
 			$objBlok->setLetterKleur( checkData($_POST['letterkleur']) );
 			if($_POST['urlofbestand'] == "bestand") {
	 			$objBlok->setBestandID( checkData($_POST['bestandid'], "integer"));
	 			$objBlok->setURL( "" );
 			}
 			else {
	 			$objBlok->setURL( checkData($_POST['afburl']));
	 			$objBlok->setBestandID( "" );
	 		}
 			$objBlok->setAfbWidth( checkData($_POST['afbbreedte'], "integer") );
 			$objBlok->setAfbHeight( checkData($_POST['afbhoogte'], "integer") );
 			$objBlok->setAfbBorder( checkData($_POST['afbborder'], "integer") );
 			$objBlok->setAfbAlt( checkData($_POST['afbalt']));
 			$objBlok->setKeuze( checkData($_POST['keuze'])); 			
			$booGelukt = updateBlok( $objBlok );
 		}
 		elseif($objBlok->getSubType() == "tekst") {
 			$objBlok->setTekst( checkData($_POST['tekst']), "tekst"  );
 			$objBlok->setLetterGrootte( checkData($_POST['lettergrootte'], "integer") );
 			$objBlok->setLetterType( checkData($_POST['lettertype']) );
 			$objBlok->setLetterKleur( checkData($_POST['letterkleur']) );
			$booGelukt = updateBlok( $objBlok );
 		}

	 	if($booGelukt) {
			showMedMessage( "Het blok is succesvol bewerkt." );
 			$strSoort = "Bewerking";
 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft succesvol het blok met de naam '".$objBlok->getTitel().
			"' (ID: ".$objBlok->getBlokID().") bewerkt.");
		}
		else {
			showErrMessage( "Helaas, het is niet gelukt om een blok te bewerken.");	
 			$strSoort = "Fout";
 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het blok met de naam '".$objBlok->getTitel().
			"' (ID: ".$objBlok->getBlokID().") proberen te bewerken. Dit is mislukt.");
		}

		if(isset($objLIAdmin))
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
		else
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
 		

    	showBlok( $objBlok->getBlokID(), $intWebsiteID, $objLIGebRechten );
 	}
  	elseif(isset($_POST['delBlokKnop'])) {
		$intBlokID = checkData($_POST['bid']);
		$intPID = checkData($_POST['pagid']);
		$objBlok = getBlok( $intBlokID, $intWebsiteID);
 		if(is_object($objBlok) && deleteBlok($intBlokID, $intWebsiteID)) {
			showMedMessage( "Het blok is succesvol verwijderd." );
 			$strSoort = "Verwijdering";
 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft succesvol het blok met de naam '".$objBlok->getTitel().
			"' (ID: ".$objBlok->getBlokID().") verwijderd.");
		}
		else {
			showErrMessage( "Helaas, het is niet gelukt om een blok te verwijderen.");	
 			$strSoort = "Fout";
 			if(is_object($objBlok))
	 			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het blok met de naam '".$objBlok->getTitel().
				"' (ID: ".$intBlokID.") proberen te verwijderen. Dit is mislukt.");
			else
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd het blok met het ID-nummer '".$intBlokID.
					"' proberen te verwijderen. Dit is mislukt, omdat het blok niet in de database gevonden kan worden.");
		}
		if(isset($objLIAdmin))
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
		else
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort );
		showPagina( $intPID, $intWebsiteID, $objLIGebRechten );
 	}
 else {
		showWebsiteInhoud( $intWebsiteID, $objLIGebRechten );
		if(is_object($objWebsite)) {
			$strTekst = maakLogTekst( $strType, $objPersoon, "heeft de inhoud van de website met de titel '".
				$objWebsite->getTitel()."' bekeken.");
			$strSoort = "Bekijken";
		}
		else {
				$strTekst = maakLogTekst( $strType, $objPersoon, "heeft geprobeerd de inhoud van de website met ID-nummer $intWebsiteID te bekijken.");
			$strSoort = "Fout";
		}

		if(isset($objLIAdmin))
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), $intWebsiteID, $strSoort );	
		else
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $intWebsiteID, $strSoort);
	}	
}
if(isset($objLIGebRechten) && $objLIGebRechten != "ja") {
	echo "<br><br><b>Rechten van gebruiker</b>\n";
	echo " <ul>\n";
	echo "  <li>Onderdelen beheren: <i>". $objLIGebRechten->getOnderdeelRecht()."</i>\n";
	echo "  <li>Subonderdelen beheren: <i>". $objLIGebRechten->getSubOnderdeelRecht()."</i>\n";
	echo "  <li>Pagina's beheren: <i>". $objLIGebRechten->getPaginaRecht()."</i>\n </ul>\n";

}

include("footer.php");
?>