<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: header.php
 * Beschrijving: De standaardcontent staat hierin.
 */

// Het uitzetten van cache, om bepaalde problemen tegen te gaan
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Het uitzetten van display_errors 
ini_set("display_errors", "Off" );

// De beans worden automatisch geinclude door de functie __autoload (in functies/algemeen.php)
// Het includen van de overige bestanden
// Config-file:
include_once("config/config.php");
// Functies:
include_once("functies/algemeen.php");
include_once("functies/gebruikersfuncties.php");
include_once("functies/adminfuncties.php");
include_once("functies/websitefuncties.php");
include_once("functies/onderdeelfuncties.php");
include_once("functies/paginafuncties.php");
include_once("functies/blokfuncties.php");
include_once("functies/bestandsfuncties.php");
include_once("functies/logboekfuncties.php");

// De databaseconnectie wordt alleen aangemaakt als er geen dberror-parameter wordt meegegeven
// Deze kan vanuit de FoutMeldingklasse meegegeven worden, bijvoorbeeld als er een database-verbindingsfout is 
if(!isset($_GET['dberror']))
	if($strDBType == "mysql")
		$dbConnectie = new MySQLDatabaseConnectie($strHostname, $strGebruikersnaam, $strWachtwoord, $strDatabase);
	else
		$dbConnectie = new MySQLiDatabaseConnectie($strHostname, $strGebruikersnaam, $strWachtwoord, $strDatabase);
elseif(!isset($_GET['dberror']) && !$dbConnectie) 
	header("Location: errorPagina.php?dberror=true");

/*if(checkBan()) {
	header("Location: errorPagina.php?ban=true");
	 $strTekst = "Persoon met IP-adres '".$_SERVER['REMOTE_ADDR']."; heeft 3 pogingen gedaan om in te loggen. ";
	 $strTekst .= " Deze zijn allen mislukt. Daarom wordt de persoon voor $strAantalMinVerbannen minuten verbannen. ";
		verwerkLogRegel( $strTekst, '', '', '', "Foute inlogpoging" );
	}
	
	
	*/

 // Als de gebruiker probeert in te loggen
if(isset($_POST['gebruikersInlogKnop'])) {
 	$strLoginnaam = checkData($_POST['gebruikersnaam']);
 	$strWachtwoord = checkData($_POST['wachtwoord']);
 	if($strLoginnaam == "" || $strWachtwoord == "") {
 		$strErrorMSG = "Het is verplicht om beide velden in te vullen, dus gebruikersnaam en wachtwoord. ";	

	 	$strTekst = "Gebruiker met het IP-adres '".$_SERVER['REMOTE_ADDR']."' heeft een poging gedaan om in te loggen. ";
	 	$strTekst .= " Dit is mislukt, omdat de tekstvelden leeg waren. ";
		verwerkLogRegel( $strTekst, '', '', '', "Foute inlogpoging" );
 	}
 	else {
	 	$booLoginWaarde = checkGebruikerLogin($strLoginnaam, $strWachtwoord); 		
 	}
 	
 	if(!isset($strErrorMSG) && ($booLoginWaarde == null || $booLoginWaarde == false)) {
 		$strErrorMSG = "De gegevens komen niet voor in onze database.<br><br>\n";
 		$strErrorMSG .= "Probeer het nogmaals in onderstaand formulier. Let op, gebruikersnaam en wachtwoord zijn hoofdlettergevoelig.";
		// Wegschrijven naar logbestand 
	 	$strTekst = "Gebruiker met de gebruikersnaam '$strLoginnaam' en IP-adres '".$_SERVER['REMOTE_ADDR']."' heeft een poging gedaan om in te loggen. ";
	 	$strTekst .= " Dit is mislukt, omdat de gegevens niet juist waren.";
		verwerkLogRegel( $strTekst, '', '', '', "Foute inlogpoging" );
 	}
 	elseif(!isset($strErrorMSG) || $strErrorMSG == null) {
 	    $objLIGebruiker = new Gebruiker();
 	    $objLIGebruiker->setValues( $booLoginWaarde[0] );
 	    $objLIGebruiker->setIP($_SERVER['REMOTE_ADDR']);
 	    $objLIGebRechten = getGebruikersRechten( $objLIGebruiker->getID() );
		// Wegschrijven naar logbestand 
		$strTekst = maakLogTekst("Gebruiker",$objLIGebruiker, "is succesvol ingelogd.");
		verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $objLIGebruiker->getWebsiteID(), "Ingelogd" );

		updateLastLogin($objLIGebruiker->getGebruikersID(), $objLIGebruiker->getIP() );
 	    $objLIGebruiker->setLastLogin( getDatumTijd() );
 	    $_SESSION['login'] = "gebruiker";
 		$_SESSION['geb'] = serialize($objLIGebruiker);
 		$_SESSION['gebrechten'] = serialize($objLIGebRechten);
 		if(isset($_POST['referer']))
 			header("Location:" . $_POST['referer']);
 	}
 }
 // Als de admin probeert in te loggen
// elseif(isset($_POST['adminInlogKnop']) && $_SERVER['HTTP_REFERER'] == $strCMSURL."/".$strCMSDir."/".$strAdmIndex) {
 elseif(isset($_POST['adminInlogKnop'])) {
 	$strLoginnaam = checkData($_POST['gebruikersnaam']);
 	$strWachtwoord = checkData($_POST['wachtwoord']);

	if($strLoginnaam == "" || $strWachtwoord == "") {
 		$strErrorMSG = "Het is verplicht om beide velden in te vullen, dus gebruikersnaam en wachtwoord. ";
	 	$strTekst = "Beheerder met het IP-adres '".$_SERVER['REMOTE_ADDR']."' heeft een poging gedaan om in te loggen.";
	 	$strTekst .= " Dit is mislukt, omdat de tekstvelden leeg waren. ";
		verwerkLogRegel( $strTekst, '', '', '', "Foute inlogpoging" );
 	}
 	 else {
		$booLoginWaarde = checkAdminLogin($strLoginnaam, $strWachtwoord); 	 
 	 }


 	if($booLoginWaarde == "leeg") {
		header("Location: registreer.php");
 	}
 	if(!isset($strErrorMSG) && ($booLoginWaarde == null || $booLoginWaarde == false)) {
 		$strErrorMSG = "De gegevens komen niet voor in onze database.<br><br>\n";
 		$strErrorMSG .= "Probeer het nogmaals in onderstaand formulier. Let op, gebruikersnaam en wachtwoord zijn hoofdlettergevoelig.";
		// Wegschrijven naar logbestand 
	 	$strTekst = "Beheerder met de gebruikersnaam '$strLoginnaam' en IP-adres '".$_SERVER['REMOTE_ADDR']."' heeft een poging gedaan om in te loggen. ";
	 	$strTekst .= "Dit is mislukt, omdat de gegevens niet juist waren.";
		verwerkLogRegel( $strTekst, '', '', '', "Foute inlogpoging" );
	}
 	elseif(!isset($strErrorMSG)) {
 	   $objLIAdmin = new Admin();
 	   $objLIAdmin->setValues( $booLoginWaarde[0] );
 	   $objLIAdmin->setIP($_SERVER['REMOTE_ADDR']);
		updateLastLogin($objLIAdmin->getAdminID(), $objLIAdmin->getIP(), "admin" );
	 	$objLIAdmin->setLastLogin( getDatumTijd() );
		// Wegschrijven naar logbestand
		$strTekst = maakLogTekst("Beheerder",$objLIAdmin, "is succesvol ingelogd.");
		verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), '', "Ingelogd" );

 	   $_SESSION['login'] = "admin";
 		$_SESSION['adm'] = serialize($objLIAdmin);
 		$_SESSION['gebrechten'] = "ja";
	 	if(isset($_POST['referer']))
 			header("Location:" . $_POST['referer']);
 	} 			
 }
 // Als admin of gebruiker wilt uitloggen
 // Dan worden alles uit de sessie gegooid
 elseif(isset($_GET['uitloggen'])) {
 	if(isset($objLIAdmin) || $_SESSION['adm']) {
 		$objLIAdmin = unserialize($_SESSION['adm']);
 		// Wegschrijven naar logfile
		$strTekst = maakLogTekst("Beheerder",$objLIAdmin, "is uitgelogd.");
		verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), '', "Uitgelogd" );
		unset($_SESSION['adm']);
 		$objLIAdmin = null;
 		$strAppel = "adm";
 	}
 	elseif(isset($objLIGebruiker)) {
 		$objLIGebruiker = unserialize($_SESSION['geb']);
 		// Wegschrijven naar logfile
		$strTekst = maakLogTekst("Gebruiker",$objLIAdmin, "is uitgelogd.");
		verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $objLIGebruiker->getWebsiteID(), "Uitgelogd" );
		unset($_SESSION['geb']);
 		$objLIGebruiker = null;
 	}
 	if(isset($objLIGebRechten))
 		$objLIGebRechten = null;
	if(isset($_SESSION['login']))
		unset($_SESSION['login']);
	if(isset($_SESSION['gebrechten']))
		unset($_SESSION['gebrechten']);

	session_destroy();
	if(!isset($strAppel))
		header("Location: ".$strGebIndex);
	else
		header("Location: ".$strAdmIndex);

 }
 // Check voor hoe lang de gebruiker ingelogd mag blijven, alleen als hoger is ingesteld als 0 
 elseif(isset($_SESSION['login']) && isset($strMaximaalAantalUur) && $strMaximaalAantalUur != 0 && $strMaximaalAantalUur > 0) {
	if(isset($_SESSION['geb'])) {
	// Opvragen van Lastlogin en huidige datum&tijd 
	 	$objGebruiker = unserialize($_SESSION['geb']);
	 	$strLastLogin = $objGebruiker->getLastLogin();
	 	$strDatumNu = getDatumTijd();
	 	// Unix Timestamps (vandaar uts) van de data
	 	$utsLastLogin = strtotime($strLastLogin);
	  	$utsDatumNu = strtotime($strDatumNu);
		// Checken of de gebruiker niet langer als opgegeven is ingelogd 
		if(($utsDatumNu - $utsLastLogin) > ($strMaximaalAantalUur * 60 * 60)) {
			// Wegschrijven naar logfile 
			$strTekst = maakLogTekst("Gebruiker",$objGebruiker, "is langer dan $strMaximaalAantalUur uur ingelogd. Hij is daardoor automatisch uitgelogd.");
			verwerkLogRegel( $strTekst, $objGebruiker->getID(), '', $objGebruiker->getWebsiteID(), "Uitgelogd" );
		 	if(isset($objGebruiker))
		 		$objGebruiker = null;
			if(isset($_SESSION['login']))
				unset($_SESSION['login']);
			if(isset($_SESSION['geb']))	
				unset($_SESSION['geb']);
			if(isset($_SESSION['gebrechten']))
				unset($_SESSION['gebrechten']);
			session_destroy();
			header("Location: ".$strGebIndex."?telang=true");	
		}
	}
	elseif(isset($_SESSION['adm'])) {
	// Opvragen van Lastlogin en huidige datum&tijd 
	 	$objAdmin = unserialize($_SESSION['adm']);
	 	$strLastLogin = $objAdmin->getLastLogin();
	 	$strDatumNu = getDatumTijd();
	 	// Unix Timestamps (vandaar uts) van de data
	 	$utsLastLogin = strtotime($strLastLogin);
	  	$utsDatumNu = strtotime($strDatumNu);
		// Checken of de gebruiker niet langer als opgegeven is ingelogd 
		if(($utsDatumNu - $utsLastLogin) > ($strMaximaalAantalUur * 60 * 60)) {
			// Wegschrijven naar logfile 
			$strTekst = maakLogTekst("Beheerder",$objAdmin, "is langer dan $strMaximaalAantalUur uur ingelogd. Hij is daardoor automatisch uitgelogd.");
			verwerkLogRegel( $strTekst, '',$objAdmin->getID() , '', "Uitgelogd" );
		 	if(isset($objAdmin))
		 		$objAdmin = null;
			if(isset($_SESSION['login']))
				unset($_SESSION['login']);
			if(isset($_SESSION['adm']))	
				unset($_SESSION['adm']);
			if(isset($_SESSION['gebrechten']))
				unset($_SESSION['gebrechten']);
			session_destroy();
			header("Location: ".$strAdmIndex."?telang=true");	
		}
	}
 	
 }
 
 if(isset($_SESSION['login'])) {
  		if($_SESSION['login'] == "gebruiker" && !isset($_POST['gebruikersInlogKnop'])) {
		  	$objLIGebruiker = unserialize($_SESSION['geb']);
		  	$objLIGebRechten = unserialize($_SESSION['gebrechten']);
	  }
  	  elseif($_SESSION['login'] == "admin" && !isset($_POST['adminInlogKnop'])) {
  			$objLIAdmin = unserialize($_SESSION['adm']);
		  	$objLIGebRechten = $_SESSION['gebrechten'];
	  }
  }

// Vanaf hieronder wordt de bovenkant van de pagina opgebouwd
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title><? echo $strCMSNaam ." - Content Management Systeem van " . $strBedrijfsNaam; ?></title>
  <style type="text/css">
	<!-- 
	/* Importeer de stylesheet (icms.css) */
	@import url(icms.css);
	-->
  </style>
  <script language="JavaScript" src="js/icms.js" type="text/javascript"></script>
  <script language="JavaScript" src="js/ColorPicker2.js" type="text/javascript"></script>
  <script language="JavaScript" src="js/AnchorPosition.js" type="text/javascript"></script>
  <script language="JavaScript" src="js/PopupWindow.js" type="text/javascript"></script>
  <script language="JavaScript" src="js/datetimepicker.js" type="text/javascript"></script>
  <script language="JavaScript" src="fckeditor/fckeditor.js" type="text/javascript"></script>
  <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
 </head>
 <body onLoad="checkExtensiesArea(), checkWYSIWYGArea()">
 <div align="center">
 <table class="websiteTable" cellspacing="0">
   <tr>
     <td class="leeg" rowspan="2"></td>
     <td class="header"><img src="images/header2.png" width="600" height="120" alt="De header"><br></td>
     <td class="leeg" rowspan="2"></td>
   </tr>

   <tr>
     <td class="gebruikersinfo">
<?php
 // De tekst dat de klant is ingelogd als admin of als gebruiker en anders een link om in te loggen
  if(isset($_SESSION['login']) && $_SESSION['login'] == "gebruiker") {
  	echo "       Ingelogd als klant onder de naam ".$objLIGebruiker->getGebruikersNaam()." (<a href=\"gebruikersbeheer.php?actie=bg&amp;id=".$objLIGebruiker->getGebruikersID()."\">".$objLIGebruiker->getVoorNaam()." ".$objLIGebruiker->getTussenvoegsel()." ".$objLIGebruiker->getAchterNaam()."</a>)\n";
  }
  elseif(isset($_SESSION['login']) && $_SESSION['login'] == "admin") {
  	echo "       Ingelogd als beheerder met de gebruikersnaam ".$objLIAdmin->getLoginNaam()." (<a href=\"adminbeheer.php?actie=ba&amp;id=".$objLIAdmin->getAdminID()."\">". $objLIAdmin->getVoorNaam()." ".$objLIAdmin->getTussenvoegsel()." ".$objLIAdmin->getAchterNaam()."</a>)\n";
  }
  else {
  	echo "       <a href=\"".$strGebIndex."\">Inloggen in het systeem</a>\n";
  }
 ?>
     </td>
   </tr>
   <tr>
     <td class="menu">
<?php
// Het menu voor de gebruiker, admin of iemand anders die nog moet inloggen
if(isset($_SESSION['login'])) {
	echo "	   <table class=\"menu\" cellspacing=\"0\">";
	echo "     <tr><td class=\"menutitle\">Menu</td></tr>";
	
	if($_SESSION['login'] == "gebruiker") {
		$strMenu = "	     <tr><td class=\"menuitem\" onMouseOver=\"this.className='menuitemover'\" onMouseOut=\"this.className='menuitem'\" onClick=\"document.location='".$strGebIndex."';\"><a href=\"".$strGebIndex."\" class=\"menuitem\">Home</a></td></tr>\n";
		$strMenu .= "	     <tr><td class=\"menuitem\" onMouseOver=\"this.className='menuitemover'\" onMouseOut=\"this.className='menuitem'\" onClick=\"document.location='inhoudbeheer.php';\"><a href=\"inhoudbeheer.php\" class=\"menuitem\">Websitebeheer</a></td></tr>\n";
		if(is_object($objLIGebRechten) && $objLIGebRechten->getBekijkRecht() != "nee") $strMenu .= "	     <tr><td class=\"menuitem\" onMouseOver=\"this.className='menuitemover'\" onMouseOut=\"this.className='menuitem'\" onClick=\"document.location='bestandsbeheer.php';\"><a href=\"bestandsbeheer.php\" class=\"menuitem\">Bestandsbeheer</a></td></tr>\n";
		$strMenu .= "	     <tr><td class=\"menuitem\" onMouseOver=\"this.className='menuitemover'\" onMouseOut=\"this.className='menuitem'\" onClick=\"document.location='gebruikersbeheer.php?actie=bg';\"><a href=\"gebruikersbeheer.php?actie=bg\" class=\"menuitem\">Persoonlijke informatie</a></td></tr>\n";
		$strMenu .= "	     <tr><td class=\"menuitem\" onMouseOver=\"this.className='menuitemover'\" onMouseOut=\"this.className='menuitem'\" onClick=\"document.location='".$_SERVER['PHP_SELF']."?uitloggen';\"><a href=\"".$_SERVER['PHP_SELF']."?uitloggen\" class=\"menuitem\">Uitloggen</a></td></tr>\n";
	}
	elseif($_SESSION['login'] == "admin") {
		$strMenu = "	     <tr><td class=\"menuitem\" onMouseOver=\"this.className='menuitemover'\" onMouseOut=\"this.className='menuitem'\" onClick=\"document.location='".$strAdmIndex."';\"><a href=\"".$strAdmIndex."\" class=\"menuitem\">Home</a></td></tr>\n";
		$strMenu .= "	     <tr><td class=\"menuitem\" onMouseOver=\"this.className='menuitemover'\" onMouseOut=\"this.className='menuitem'\" onClick=\"document.location='websitebeheer.php';\"><a href=\"websitebeheer.php\" class=\"menuitem\">Websitesbeheer</a></td></tr>\n";
		$strMenu .= "	     <tr><td class=\"menuitem\" onMouseOver=\"this.className='menuitemover'\" onMouseOut=\"this.className='menuitem'\" onClick=\"document.location='gebruikersbeheer.php';\"><a href=\"gebruikersbeheer.php\" class=\"menuitem\">Gebruikersbeheer</a></td></tr>\n";
		$strMenu .= "	     <tr><td class=\"menuitem\" onMouseOver=\"this.className='menuitemover'\" onMouseOut=\"this.className='menuitem'\" onClick=\"document.location='bestandsbeheer.php';\"><a href=\"bestandsbeheer.php\" class=\"menuitem\">Bestandsbeheer</a></td></tr>\n";
		if($objLIAdmin->getSuperUser() == "ja")
			$strMenu .= "	     <tr><td class=\"menuitem\" onMouseOver=\"this.className='menuitemover'\" onMouseOut=\"this.className='menuitem'\" onClick=\"document.location='adminbeheer.php';\"><a href=\"adminbeheer.php\" class=\"menuitem\">Beheerdersbeheer</a></td></tr>\n";
		$strMenu .= "	     <tr><td class=\"menuitem\" onMouseOver=\"this.className='menuitemover'\" onMouseOut=\"this.className='menuitem'\" onClick=\"document.location='adminbeheer.php?actie=ba&amp;id=".$objLIAdmin->getAdminID()."';\"><a href=\"adminbeheer.php?actie=ba&amp;id=".$objLIAdmin->getAdminID()."\" class=\"menuitem\">Persoonlijke informatie</a></td></tr>\n";
		$strMenu .= "	     <tr><td class=\"menuitem\" onMouseOver=\"this.className='menuitemover'\" onMouseOut=\"this.className='menuitem'\" onClick=\"document.location='logboek.php';\"><a href=\"logboek.php\" class=\"menuitem\">Logboek</a></td></tr>\n";
		$strMenu .= "	     <tr><td class=\"menuitem\" onMouseOver=\"this.className='menuitemover'\" onMouseOut=\"this.className='menuitem'\" onClick=\"document.location='".$_SERVER['PHP_SELF']."?uitloggen';\"><a href=\"".$_SERVER['PHP_SELF']."?uitloggen\" class=\"menuitem\">Uitloggen</a></td></tr>\n";
	}
	echo $strMenu;
	echo "	   </table>\n";
}
echo "       <br>\n     </td>\n";
echo "     <td class=\"content\">\n";

 if(isset($strErrorMSG)) {
  showErrMessage( $strErrorMSG );
 }

?>