<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: index.php
 * Beschrijving: De hoofdpagina van de klantsite
 */

// Het includen van de benodigde bestanden
include("php/Template.inc.php");
include("php/xmlParser.inc.php");
include("php/functies.php");
// Het configuratiebestand
include("php/config.php");

// Errors display uitzetten:
ini_set("display_errors", 0);

// Aanmaak van het template-object
$tmpTemplate = new Template($strTemplateURL);

// Checken of er een referer is 
if(isset($_SERVER['HTTP_REFERER'])) {
	$arrReferer = explode("?",$_SERVER['HTTP_REFERER']);
}
// Actie als het contactformulier is ingevuld
if(isset($_POST['verstuurMailKnop']) && $arrReferer[0] == $strSiteURL."index.php") {
	// Check of alle benodigde gegevens wel zijn ingevuld, zo niet, dan wordt dat ook in de array opgeslagen
	if(!isset($_POST['naam']) || !isset($_POST['email']) || $_POST['naam'] == "" || $_POST['email'] == "" || !isset($_POST['comment']) || $_POST['comment'] == "") {
		$arrContactVelden['legevelden'] = true;
	} 
	// Gegevens worden opgeslagen in error, alleen als ze zijn opgegeven 
	if(isset($_POST['naam']))
		$arrContactVelden['naam'] = $_POST['naam'];
	if(isset($_POST['email']))
		$arrContactVelden['email'] = $_POST['email'];
	if(isset($_POST['straat']))
		$arrContactVelden['straat'] = $_POST['straat'];
	if(isset($_POST['huisnr']))
		$arrContactVelden['huisnr'] = $_POST['huisnr'];
	if(isset($_POST['postcode']))
		$arrContactVelden['postcode'] = $_POST['postcode'];
	if(isset($_POST['woonplaats']))
		$arrContactVelden['woonplaats'] = $_POST['woonplaats'];
	if(isset($_POST['telnr']))
		$arrContactVelden['telnr'] = $_POST['telnr'];
	if(isset($_POST['mobielnr']))
		$arrContactVelden['mobielnr'] = $_POST['mobielnr'];
	if(isset($_POST['comment']))
		$arrContactVelden['comment'] = $_POST['comment'];
    $tmpTemplate->set("intOnderdeelID",  $_POST['oid']);
    $tmpTemplate->set("intPaginaID",  $_POST['pid']);
    $tmpTemplate->set("intBlokID",  $_POST['bid']);
	// De template verwerkt de e-mail 
	echo $tmpTemplate->verwerkEmail( $arrContactVelden);
}
// Bij de normale situatie
else {
  // De URL wordt opgedeeld 
  $arrURL = explode("?", $_SERVER['REQUEST_URI']);
  if(isset($arrURL[1])) {
		$arrCijfers = explode("/", $arrURL[1]);
  }
  if(isset($arrCijfers[0])) {
		$tmpTemplate->set("intOnderdeelID", $arrCijfers[0]);
  }
  if(isset($arrCijfers[1])) {
		$arrPaginaNr = explode("-", $arrCijfers[1]);
	   $tmpTemplate->set("intPaginaID", $arrPaginaNr[0]);
    	if(isset($arrPaginaNr[1])) {
    		$tmpTemplate->set("intPagDeelNr", $arrPaginaNr[1]);
    	}
  }
  if(isset($arrCijfers[2])) {
    	$tmpTemplate->set("intBlokID", $arrCijfers[2]);
  }
  // De website wordt getoond 
  echo $tmpTemplate->displaySite();
}
?>