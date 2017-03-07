<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: dataNaarXML.php
 * Beschrijving: Script die de data uit MySQL-db omzet tot een XML-bestand
 */

// De beans worden automatisch ingeladen door de functie __autoload() 
// De specifieke bestanden met functies en database-functies voor Data naar XML
include_once("functies/dnxmldbfuncties.php");
include_once("functies/dnxmlblokfuncties.php");
include_once("functies/bestandsfuncties.php");
include_once("functies/algemeen.php");
// Het configuratiebestand
include_once("config/config.php");

header("Content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"";
echo "?";
echo ">\n";
if($strDBType == "mysql")
	$dbConnectie = new MySQLDatabaseConnectie($strHostname, $strGebruikersnaam, $strWachtwoord, $strDatabase, false);
else
	$dbConnectie = new MySQLiDatabaseConnectie($strHostname, $strGebruikersnaam, $strWachtwoord, $strDatabase, false);
// Checken of er wel een sitecode of website-id is meegegeven
if(!isset($_GET['sitecode']) || !isset($_GET['wid'])) {
	$strXML = "<website>\n";
	$strXML .= "  <error>\n";
	$strXML .= "    <errorcode>1</errorcode>\n";
	$strXML .= "    <errorbericht>De gegevens van deze website zijn nog niet ingesteld.</errorbericht>\n";
	$strXML .= "  </error>\n";
	$strXML .= "</website>\n";
	echo $strXML;
}
// Checken of de sitecode en website-id wel bij elkaar horen
elseif(!checkWebsite($_GET['wid'], $_GET['sitecode'])) {
	$strXML = "<website id=\"".$_GET['wid']."\">\n";
	$strXML .= "  <error>\n";
	$strXML .= "    <errorcode>2</errorcode>\n";
	$strXML .= "    <errorbericht>De instellingen van deze website zijn onjuist.</errorbericht>\n";
	$strXML .= "  </error>\n";
	$strXML .= "</website>\n";
	echo $strXML;
}
// Nu de daadwerkelijke acties; opvragen van content
// Hieronder wordt content opgevraagd voor als er een e-mail verstuurd moet worden
elseif(isset($_GET['mail']) && $_GET['mail'] == "true"&& isset($_GET['bid'])) {
	$intWebsiteID = checkData($_GET['wid'], "integer");
	$intBlokID = checkData($_GET['bid'], "integer");

	$strXML = "<website id=\"$intWebsiteID\">\n";
	$strXML .= getContactBericht($intWebsiteID, $intBlokID);
	$strXML .= "</website>\n";
	
	echo $strXML;
}
// Hieronder wordt de overige content opgevraagd
else {
	// Voor het menu
	if(isset($_GET['sitecode']) && isset($_GET['wid']) && isset($_GET['menutype'])) {
		$strMenuType = checkData($_GET['menutype']);
		$intWebsiteID = checkData( $_GET['wid'], "integer");
		echo getMenu( $intWebsiteID, $strMenuType );
	}
	// Voor 1 blok
	elseif(isset($_GET['sitecode']) && isset($_GET['wid']) && isset($_GET['blokid'])) {
		$strSiteCode = checkData($_GET['sitecode']);
		$intWebsiteID = checkData($_GET['wid'], "integer");
		$intBlokID = checkData( $_GET['blokid'], "integer" );
		$arrIDs = getIDsByBlok( $intBlokID, $intWebsiteID );
		$intOnderdeelID = $arrIDs['oid'];
		$intPaginaID = $arrIDs['pid'];
		

		$strXML = "<website id=\"$intWebsiteID\">\n";
		$strXML .= " <oid>".$intOnderdeelID."</oid>\n";
		$strXML .= " <pid>".$intPaginaID."</pid>\n";
		$strXML .= getXMLPagina($intWebsiteID, $intOnderdeelID, $intPaginaID, 0, 0, $intBlokID);
		$strXML .= "</website>\n";
		echo $strXML;
	}
	// Voor de headlines..
	// Als er een aantal en pagina is opgegeven, dan wordt er 1 pagina teruggegeven
	elseif(isset($_GET['sitecode']) && isset($_GET['wid']) && isset($_GET['aantal']) && isset($_GET['pid']) && isset($_GET['volg'])) {
		$strSiteCode = checkData($_GET['sitecode']);
		$intWebsiteID = checkData($_GET['wid'], "integer");
		$intAantal = checkData($_GET['aantal'], "integer");
		$strVolgorde = checkData($_GET['volg']);
		$intPaginaDeelNr = 0;
		if(isset($_GET['pagdnr'])) 
			$intPaginaDeelNr = checkData($_GET['pagdnr'], "integer");

		$intPaginaID = checkData($_GET['pid'], "integer");
		$intOnderdeelID = getOIDByPagina( $intPaginaID, $intWebsiteID );

	
		if(isset($intOnderdeelID) && isset($intPaginaID)) {
			$strXML = "<website id=\"$intWebsiteID\">\n";
			$strXML .= " <oid>".$intOnderdeelID."</oid>\n";
			$strXML .= " <pid>".$intPaginaID."</pid>\n";
			$strXML .= getXMLPagina($intWebsiteID, $intOnderdeelID, $intPaginaID, $intPaginaDeelNr, $intAantal, '', $strVolgorde);
			$strXML .= "</website>\n";
			echo $strXML;
		}

	}
	// Checken of er wel een onderdeel-id en pagina-id zijn meegegeven
	elseif(!isset($_GET['oid']) || !isset($_GET['pid'])) {
		$strXML = "<website id=\"".checkData($_GET['wid'],"integer")."\">\n";
		$strXML .= "  <error>\n";
		$strXML .= "    <errorcode>3</errorcode>\n";
		$strXML .= "    <errorbericht>Er is geen onderdeel of pagina geselecteerd.</errorbericht>\n";
		$strXML .= "  </error>\n";
		$strXML .= "</website>\n";
		echo $strXML;
	}
	// Opvragen van een pagina
	elseif(isset($_GET['sitecode']) && isset($_GET['wid']) && isset($_GET['oid']) && isset($_GET['pid'])) {
		$strSiteCode = checkData($_GET['sitecode']);
		$intWebsiteID = checkData($_GET['wid'], "integer");
		$intOnderdeelID = checkData($_GET['oid'], "integer");
		$intPaginaID = checkData($_GET['pid'], "integer");
		
		$intBlokID = 0;
		$intAantal = 0;
		$intPaginaDeelNr = 0;
		if(isset($_GET['bid'])) 
			$intBlokID = checkData($_GET['bid'], "integer");
		if(isset($_GET['aantal'])) 
			$intAantal = checkData($_GET['aantal'], "integer");
		if(isset($_GET['pagdnr'])) 
			$intPaginaDeelNr = checkData($_GET['pagdnr'], "integer");

		$strXML = "<website id=\"$intWebsiteID\">\n";
		$strXML .= " <oid>".$intOnderdeelID."</oid>\n";
		$strXML .= " <pid>".$intPaginaID."</pid>\n";
		$strXML .= getXMLPagina($intWebsiteID, $intOnderdeelID, $intPaginaID, $intPaginaDeelNr, $intAantal, $intBlokID);
		$strXML .= "</website>\n";
		echo $strXML;
	
	}
}
?>