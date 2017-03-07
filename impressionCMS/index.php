<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: index.php
 * Beschrijving: De index-pagina voor gebruikers
 */
session_start();
 include("header.php");
 
 if(isset($_SESSION['login'])) {
 	if(isset($objLIGebruiker))  {
 		echo "<h1>Welkom ".$objLIGebruiker->getVoorNaam()." ".$objLIGebruiker->getTussenvoegsel()." ".$objLIGebruiker->getAchterNaam()."!</h1>\n";
 		echo "U bevind zich nu in het content management systeem van $strBedrijfsNaam. Via dit systeem kunt u uw website beheren. ";
 		echo "Dat wil zeggen dat u bepaalde onderdelen, pagina's en stukken content kan bekijken, bewerken en/of verwijderen.\n<br><br>\n";
 		echo "Voor extra uitleg bij dit systeem kunt u <a href=\"$strGebHandleidingURL\">deze handleiding</a> raadplegen.<br><br>\n";

 		echo "Daarnaast kunt u ons raadplegen als u er niet uitkomt. Maak via het menu aan de linkerkant uw keuze.\n<br>\n";
 		if($objLIGebRechten == false || $objLIGebRechten == null) {
 			echo "<h1>Geen rechten ingesteld</h1>\n";
 			echo "Op dit moment is het nog niet mogelijk om dit content management systeem te gebruiken, dit heeft te maken dat de gebruikersrechten nog niet zijn ingesteld. ";
 		}			
 	}
 	else {
 		echo "<h1>Geen toegang voor administrators</h1>\n";
 		echo "Om deze pagina te gebruiken, moet je een klant zijn van Impression New Media, geen beheerder.\n";
		if(isset($objLIAdmin)) {
			$strTekst = maakLogTekst( "De beheerder", $objLIAdmin, "heeft zonder toestemming de pagina '".$_SERVER['PHP_SELF']."' proberen aan te roepen. ");
			verwerkLogRegel( $strTekst, '', $objLIAdmin->getID(), '', "Geen toegang" );
		}
 	}
 }
 elseif(isset($_GET['vergeten'])) {
?>
<h1>Wachtwoord vergeten</h1>
Dit formulier is bestemd voor gebruikers van het content management systeem van <? echo $strBedrijfsNaam; ?> die hun logingegevens kwijt zijn. <br><br>
Als u het onderstaand formulier invult, dan wordt er een link verstuurd naar uw e-mailadres. Deze link moet u aanklikken, waardoor u de aanvraag bevestigd. Vervolgens worden uw nieuwe logingegevens verstuurd naar uw e-mailadres.
<br><br>
<div align="center">
<form action="<? echo $_SERVER['PHP_SELF']; ?>" name="stuurWachtwoordForm" method="POST">
 <table class="inlogform" cellspacing="0">
  <tr><td class="tabletitle" colspan="2">Verstuur wachtwoord</td></tr>
  <tr><td class="formvak">E-mailadres:</td><td class="formvak"><input type="text" name="email"></td></tr>
  <tr><td class="tablelinks"><a href="<? echo $_SERVER['PHP_SELF']; ?>" class="linkitem">Inlogformulier</a></td><td class="tablelinks"><input type="submit" class="button" value="Verstuur aanvraag" name="stuurAanvraagKnop"></td></tr>
 </table>
</form>
</div>
<?php
 }
 elseif(isset($_GET['k']) && isset($_GET['id'])) {
 	$strMD5ww = checkData($_GET['k']);
 	$intGebruikersID = checkData($_GET['id']);
 	$objGebruiker = getGebruiker($intGebruikersID);

 	if($objGebruiker == false || $objGebruiker == null) {
		echo "<h1>Logingegevens konden niet worden verstuurd</h1>\n";
		echo "De logingegevens konden niet worden verstuurd, omdat de opgegeven gegevens niet juist zijn. Probeer de hele link te kopieren en te plakken in de adresbalk, er mogen geen spaties in de link staan.<br><br>\n";
		$strTekst = "De persoon met IP-adres '".$_SERVER['REMOTE_ADDR']."' heeft geprobeerd een nieuw wachtwoord aan te vragen voor de gebruiker met het ID-nummer '".
		 $intAdminID."'. Dit is mislukt, omdat er geen beheerder is gevonden in de database met dat ID-nummer.";
		verwerkLogRegel( $strTekst, $intGebruikersID, '', '', "Fout" );

 	}
 	elseif(substr(md5($objGebruiker->getWachtwoord()), 0, 15) != $strMD5ww) {
		echo "<h1>Logingegevens konden niet worden verstuurd</h1>\n";
		echo "De logingegevens konden niet worden verstuurd, omdat de opgegeven gegevens niet juist zijn. Probeer de hele link te kopieren en te plakken in de adresbalk, er mogen geen spaties in de link staan.<br><br>\n";
		$strTekst = "De persoon met IP-adres '".$_SERVER['REMOTE_ADDR']."' heeft geprobeerd een nieuw wachtwoord aan te vragen voor de gebruiker met de naam '".
			 $objGebruiker->getVolledigeNaam()."' (ID: '".$intGebruikersID."'). Dit is mislukt, omdat de opgegeven gegevens niet juist waren.";
		verwerkLogRegel( $strTekst, $intGebruikersID, '', '', "Fout" );
 	}
 	else {
		$strResult = verstuurNieuwWachtwoord($objGebruiker, "gebruiker"); 		
		if($strResult == "niet gelukt") {
			echo "<h1>Logingegevens konden niet worden verstuurd</h1>\n";
			echo "De logingegevens konden niet worden verstuurd, omdat er technische problemen zijn.<br><br>\n";
			echo "Probeer het later nogmaals.\n";
			$strTekst = "De persoon met IP-adres '".$_SERVER['REMOTE_ADDR']."' heeft geprobeerd een nieuw wachtwoord aan te vragen voor de gebruiker met de naam '".
			 $objGebruiker->getVolledigeNaam()."' (ID: '".$intGebruikersID."'). Dit is mislukt.";
			verwerkLogRegel( $strTekst, $intGebruikersID, '', '', "Fout" );
		}
	 	elseif($strResult == "goed gelukt") {
			echo "<h1>Wachtwoord verstuurd</h1>\n";
			echo "De logingegevens zijn verstuurd naar ".$objGebruiker->getEMail().". <br><br>\n";
			echo "U kunt nu met uw nieuwe gegevens inloggen op <a href=\"".$_SERVER['PHP_SELF']."\">deze pagina</a>.";
			$strTekst = "De persoon met IP-adres '".$_SERVER['REMOTE_ADDR']."' heeft succesvol een nieuw wachtwoord aangevraagd voor de gebruiker met de naam '".
			 $objGebruiker->getVolledigeNaam()."' (ID: '".$intGebruikersID."').";
			verwerkLogRegel( $strTekst, $intGebruikersID, '', '', "Wachtwoord aanvraag" );
		}
 	}
 }
 elseif(isset($_POST['stuurAanvraagKnop'])) {
	$strEmail = checkData($_POST['email']);
	$strResult = verstuurWachtwoordBevestiging($strEmail, "gebruiker");
	
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
 
  	if(isset($_SERVER['HTTP_REFERER'])) {
 		$arrReferer = explode("/", $_SERVER['HTTP_REFERER']);
		if($arrReferer[2] == $_SERVER['HTTP_HOST'] && !eregi($strAdmIndex, $_SERVER['HTTP_REFERER']) && !eregi("adminbeheer", $_SERVER['HTTP_REFERER']) && !eregi("websitebeheer", $_SERVER['HTTP_REFERER'])) {
			$booReferer = "true";
		 	$strReferer = $_SERVER['HTTP_REFERER'];
		}
	 }
	 if(isset($_GET['telang']) && $strMaximaalAantalUur != 0 && $strMaximaalAantalUur > 0) {
	 	$strErrorMsg = "U bent langer als $strMaximaalAantalUur uur ingelogd. Om veiligheidsredenen moet u daarom weer opnieuw inloggen via het onderstaand formulier. <br><br>U wordt dan weer teruggestuurd naar de pagina waar u vandaan komt.";
	 }
?>
<h1>Inloggen bij <? echo $strCMSNaam; ?></h1>
<?
 if(isset($strErrorMsg)) {
  showErrMessage( $strErrorMsg );
 }
?>

Via het onderstaande formulier kan worden ingelogd in het content management systeem van uw website. De gegevens die u moet invullen heeft u van <? echo $strBedrijfsNaam; ?> ontvangen.<br>
Als u uw wachtwoord bent vergeten, dan kan er een nieuwe aangevraagd worden door op de link 'Wachtwoord vergeten' te drukken.<br><br>
<div align="center">
<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST" name="gebruikersInlogForm">
 <table class="inlogform" cellspacing="0">
  <tr><td class="tabletitle" colspan="2">Inlogformulier voor klanten</td></tr>
  <tr><td class="formvak">Gebruikersnaam:</td><td class="formvak"><input type="text" name="gebruikersnaam"></td></tr>
  <tr><td class="formvak">Wachtwoord:</td><td class="formvak"><input type="password" name="wachtwoord"></td></tr>
  <tr><td class="tablelinks"><a href="<? echo $_SERVER['PHP_SELF']; ?>?vergeten" class="linkitem">Wachtwoord vergeten</a></td>
  <td class="tablelinks"><input type="submit" class="button" value="Inloggen" name="gebruikersInlogKnop"></td></tr>
 </table>
<?
if(isset($booReferer) && $booReferer == "true")
	echo "<input type=\"hidden\" name=\"referer\" value=\"".$strReferer."\">\n";
?>
</form>
</div>

<?
}
include("footer.php");
?>