<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: admin.php
 * Beschrijving: De index-pagina voor admin's
 */

session_start();
 include("header.php");
 
 if(isset($_SESSION['login'])) {
 	if(isset($objLIAdmin))  {
 		echo "<h1>Welkom ".$objLIAdmin->getVoornaam()." ".$objLIAdmin->getTussenvoegsel()." ".$objLIAdmin->getAchterNaam()."!</h1>\n";
 		echo "U bevind zich nu in het content management systeem van $strBedrijfsNaam. ";
 		echo "Via dit systeem kunt u de accounts van gebruikers en hun websites beheren. Dat wil zeggen dat u bepaalde onderdelen, pagina's en stukken content kan bekijken, bewerken of verwijderen.\n<br><br>\n";
 		echo "Voor extra uitleg bij dit systeem kunt u <a href=\"$strAdmHandleidingURL\">deze handleiding</a> raadplegen die op het kantoor aanwezig is. <br><br>\n";
 		echo "Maak via het menu aan de linkerkant uw keuze.\n<br>\n";
 		
 	}
 	else {
		echo "<h1>Geen toegang voor klanten</h1>\n";
 		echo "Om deze pagina te gebruiken, moet je een beheerder zijn van $strBedrijfsNaam.\n<br>\n";
		if(isset($objLIGebruiker)) {
			$strTekst = maakLogTekst( "De gebruiker", $objLIGebruiker, "heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen. ");
			verwerkLogRegel( $strTekst, $objLIGebruiker->getID(), '', $objLIGebruiker->getWebsiteID(), "Geen toegang" );
		}
 	}
 }
 elseif(isset($_GET['vergeten'])) {
?>
<h1>Wachtwoord vergeten</h1>
Dit formulier is bestemd voor beheerders van het content management systeem van <? echo $strBedrijfsNaam; ?> die hun logingegevens kwijt zijn. <br><br>
Als u het onderstaand formulier invult, dan wordt er een link verstuurd naar uw e-mailadres. Deze link moet u aanklikken, waardoor u de aanvraag bevestigd. Vervolgens worden uw nieuwe logingegevens verstuurd naar uw e-mailadres.
<br><br>
<div align="center">
<form action="<? echo $_SERVER['PHP_SELF']; ?>" name="stuurWachtwoordForm" method="POST">
 <table class="inlogform" cellspacing="0">
  <tr><td class="tabletitle" colspan="2">Verstuur aanvraag nieuw wachtwoord</td></tr>
  <tr><td class="formvak">E-mailadres:</td><td class="formvak"><input type="text" name="email"></td></tr>
  <tr><td class="tablelinks"><a href="<? echo $_SERVER['PHP_SELF']; ?>" class="linkitem">Inlogformulier</a></td><td class="tablelinks"><input type="submit" class="button" value="Verstuur aanvraag" name="stuurAanvraagKnop"></td></tr>
 </table>
</form>
</div>
<?php
 }
 elseif(isset($_GET['k']) && isset($_GET['id'])) {
 	$strMD5ww = checkData($_GET['k']);
 	$intAdminID = checkData($_GET['id'], "integer");
 	$objAdmin = getAdmin($intAdminID);

 	if($objAdmin == false || $objAdmin == null) {
		echo "<h1>Logingegevens konden niet worden verstuurd</h1>\n";
		echo "De logingegevens konden niet worden verstuurd, omdat de opgegeven gegevens niet juist zijn. Probeer de hele link te kopieren en te plakken in de adresbalk, er mogen geen spaties in de link staan.<br><br>\n";
		$strTekst = "De persoon met IP-adres '".$_SERVER['REMOTE_ADDR']."' heeft geprobeerd een nieuw wachtwoord aan te vragen voor de beheerder met het ID-nummer '".
		 $intAdminID."'. Dit is mislukt, omdat er geen beheerder is gevonden in de database met dat ID-nummer.";
		verwerkLogRegel( $strTekst, '', $intAdminID, '', "Fout" );
 	}
 	elseif(substr(md5($objAdmin->getWachtwoord()), 0, 15) != $strMD5ww) {
		echo "<h1>Logingegevens konden niet worden verstuurd</h1>\n";
		echo "De logingegevens konden niet worden verstuurd, omdat de opgegeven gegevens niet juist zijn. Probeer de hele link te kopieren en te plakken in de adresbalk, er mogen geen spaties in de link staan.<br><br>\n";
		$strTekst = "De persoon met IP-adres '".$_SERVER['REMOTE_ADDR']."' heeft geprobeerd een nieuw wachtwoord aan te vragen voor de beheerder met de naam '".
			 $objAdmin->getVolledigeNaam()."' (ID: '".$intAdminID."'). Dit is mislukt, omdat de opgegeven gegevens niet juist waren.";
		verwerkLogRegel( $strTekst, '', $intAdminID, '', "Fout" );
 	}
 	else {
		$strResult = verstuurNieuwWachtwoord($objAdmin, "admin"); 		
		if($strResult == "niet gelukt") {
			echo "<h1>Logingegevens konden niet worden verstuurd</h1>\n";
			echo "De logingegevens konden niet worden verstuurd, omdat er technische problemen zijn.<br><br>\n";
			echo "Probeer het later nogmaals.\n";
			$strTekst = "De persoon met IP-adres '".$_SERVER['REMOTE_ADDR']."' heeft geprobeerd een nieuw wachtwoord aan te vragen voor de beheerder met de naam '".
			 $objAdmin->getVolledigeNaam()."' (ID: '".$intAdminID."'). Dit is mislukt.";
			verwerkLogRegel( $strTekst, '', $objAdmin->getID(), '', "Fout" );
		}
	 	elseif($strResult == "goed gelukt") {
			echo "<h1>Wachtwoord verstuurd</h1>\n";
			echo "De logingegevens zijn verstuurd naar ".$objAdmin->getEMail().".<br><br>\n";
			echo "U kunt nu met uw nieuwe gegevens inloggen op <a href=\"".$_SERVER['PHP_SELF']."\">deze pagina</a>.";
			$strTekst = "De persoon met IP-adres '".$_SERVER['REMOTE_ADDR']."' heeft succesvol een nieuw wachtwoord aangevraagd voor de beheerder met de naam '".
			 $objAdmin->getVolledigeNaam()."' (ID: '".$intAdminID."').";
			verwerkLogRegel( $strTekst, '', $objAdmin->getID(), '', "Wachtwoord aanvraag" );
		}
 	}
 }
 elseif(isset($_POST['stuurAanvraagKnop'])) {
	$strEmail = checkData($_POST['email']);
	$strResult = verstuurWachtwoordBevestiging($strEmail, "admin");
	
	if($strResult == "niet gelukt") {
		echo "<h1>Bevestiging kon niet worden verstuurd</h1>\n";
		echo "De bevestiging kon niet worden verstuurd, omdat er technische problemen zijn.<br><br>\n";
		echo "<a href=\"".$_SERVER['PHP_SELF']."?vergeten\">Ga terug</a> en probeer het nogmaals.\n";
	}
	elseif($strResult == "goed gelukt") {
		echo "<h1>Bevestiging verstuurd</h1>\n";
		echo "De bevestiging is verstuurd naar $strEmail. In deze e-mail staat een link om te controleren of u wel de eigenaar bent van het betreffende e-mailadres.<br><br>\n";
		echo "<a href=\"".$_SERVER['PHP_SELF']."\">Ga naar het inlogformulier</a>.\n";
	}
	elseif($strResult == "onbekend email") {
		echo "<h1>Bevestiging kon niet worden verstuurd</h1>\n";
		echo "De bevestiging kon niet worden verstuurd, omdat het e-mailadres niet is gevonden in onze database.<br><br>\n";
		echo "<a href=\"".$_SERVER['PHP_SELF']."?vergeten\">Ga terug</a> en probeer het nogmaals.\n";
	}
	elseif($strResult == "fout email") {
		echo "<h1>Bevestiging kon niet worden verstuurd</h1>\n";
		echo "De bevestiging kon niet worden verstuurd, omdat het e-mailadres niet correct was. <br><br>\n";
		echo "<a href=\"".$_SERVER['PHP_SELF']."?vergeten\">Ga terug</a> en probeer het nogmaals.\n";
	}
 }
 else {
	$arrAdmins = getAdmins();
	if($arrAdmins == null) 
		header("Location: registreer.php");
		
 	if(isset($_SERVER['HTTP_REFERER'])) {
 		$arrReferer = explode("/", $_SERVER['HTTP_REFERER']);
		if($arrReferer[2] == $_SERVER['HTTP_HOST'] && !eregi("registreer.php", $_SERVER['HTTP_REFERER']) && !eregi($strGebIndex, $_SERVER['HTTP_REFERER']) && !eregi("errorPagina.php", $_SERVER['HTTP_REFERER'])) {
			$booReferer = "true";
			$strReferer = $_SERVER['HTTP_REFERER'];
		}
	 } 
?>
<h1>Inloggen bij <? echo $strCMSNaam; ?></h1>
Via het onderstaande formulier kan worden ingelogd in het beheergedeelte van het systeem. De gegevens die ingevuld moeten worden, heb je ontvangen van de hoofdbeheerder.<br><br>
<div align="center">
<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST" name="adminInlogForm">
 <table class="inlogform" cellspacing="0">
  <tr><td class="tabletitle" colspan="2">Inlogformulier voor beheerders</td></tr>
  <tr><td class="formvak">Gebruikersnaam:</td><td class="formvak"><input type="text" name="gebruikersnaam"></td></tr>
  <tr><td class="formvak">Wachtwoord:</td><td class="formvak"><input type="password" name="wachtwoord"></td></tr>
  <tr><td class="tablelinks"><a href="<? echo $_SERVER['PHP_SELF']; ?>?vergeten" class="linkitem">Wachtwoord vergeten</a></td><td class="tablelinks"><input type="submit" class="button" value="Inloggen" name="adminInlogKnop"></td></tr>
 </table>
<?php
if(isset($booReferer) && $booReferer == "true")
	echo "<input type=\"hidden\" name=\"referer\" value=\"".$strReferer."\">\n";
?> 
</form>
</div>

<?php
}
include("footer.php");
?>