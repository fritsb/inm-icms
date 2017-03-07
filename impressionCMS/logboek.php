<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: logboek.php
 * Beschrijving: Dit is het logboek, wat de acties laat zien. 
 */
 session_start();
 include("header.php");
 
 if(!isset($_SESSION['login']) || $_SESSION['login'] == "gebruiker") {
 	echo "<h1>Geen toegang</h1>\n";
 	echo "Om deze pagina te gebruiken, moet je eerst inloggen bij het administratiegedeelte.\n";

	// Logboek 
	if(isset($objLIGebruiker)) {
		$strTekst = maakLogTekst( "Gebruiker", $objLIGebruiker, "heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen.");
		verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $objLIGebruiker->getWebsiteID(), "Geen toegang" );
	}
	else {
		$strTekst = "Persoon met het IP-adres ".$_SERVER['REMOTE_ADDR']." heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen.";
		verwerkLogRegel( $strTekst, '','','', "Geen toegang" );
	}
	
 }
 elseif($_SESSION['login'] == "admin") {
	$intVan = 0;
	$arrGegevens = "";
	if(isset($_GET['legen'])) {
		maakLeegLogboekForm();
	}
	elseif(isset($_POST['leegLogboekKnop'])) {
		if($objLIAdmin->getSuperUser() == "ja" && deleteLogBoek()) {
			showMedMessage("Het logboek is succesvol geleegd.");
			$strSoort = "Verwijdering";
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft het logboek succesvol geleegd.");
		}
		else {
			showErrMessage("Het logboek kon niet worden geleegd.");
			$strTekst = maakLogTekst( $strType, $objLIAdmin, "heeft geprobeerd het logboek te legen. Dit is mislukt.");
			$strSoort = "Fout";
		}
		verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), '', $strSoort );
		showLogBoek();
	}
	elseif(isset($_POST['changeGegevensKnop'])) {
		if(isset($_POST['wid']) && $_POST['wid'] != "" && $_POST['wid'] != 0) 
			$arrGegevens['websiteid'] = checkData( $_POST['wid'], "integer" );
		if(isset($_POST['aid']) && $_POST['aid'] != "" && $_POST['aid'] != 0) 
			$arrGegevens['adminid'] = checkData( $_POST['aid'], "integer" );
		if(isset($_POST['gid']) && $_POST['gid'] != "" && $_POST['gid'] != 0) 
			$arrGegevens['gebruikersid'] = checkData( $_POST['gid'], "integer" );
		if(isset($_POST['ip']) && $_POST['ip'] != null) 
			$arrGegevens['ip'] = checkData( $_POST['ip'] );
		if(isset($_POST['begindatum']) && $_POST['begindatum'] != "") {
			$strBeginDatum = checkData($_POST['begindatum']);
			$arrDatumTijd =	explode(" ", $strBeginDatum);
			$arrDatum = explode("-", $arrDatumTijd[0]);
			$arrGegevens['begindatum'] = $arrDatum[2]."-".$arrDatum[1]."-".$arrDatum[0]." ".$arrDatumTijd[1];	
		}
		if(isset($_POST['einddatum']) && $_POST['einddatum'] != "")  {
			$strEindDatum = checkData($_POST['einddatum']);
			$arrDatumTijd =	explode(" ", $strEindDatum);
			$arrDatum = explode("-", $arrDatumTijd[0]);
			$arrGegevens['einddatum'] = $arrDatum[2]."-".$arrDatum[1]."-".$arrDatum[0]." ".$arrDatumTijd[1];	
		}	
		if(isset($_POST['soort']) && $_POST['soort'] != null) 
			$arrGegevens['soort'] = checkData( $_POST['soort']  );
								
		$_SESSION['loggegevens'] = serialize($arrGegevens);
		showLogBoek($arrGegevens);
	}
	else {
		if(isset($_GET['van'])) $intVan = checkData( $_GET['van'], "integer");
		if(isset($_GET['reset'])) unset($_SESSION['loggegevens']);
		if(isset($_SESSION['loggegevens'])) $arrGegevens = unserialize($_SESSION['loggegevens']);
			showLogBoek($arrGegevens, $intVan);
	}
 }
 include("footer.php");
?>