<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: algemeen.php
 * Beschrijving: De algemene functies, functies die door meerdere gedeeltes van de website worden gebruikt.
 */

 // Functie om klassen automatisch in te laden als ze nodig zijn.
 function __autoload($strKlasseNaam) {
   include_once("beans/".$strKlasseNaam.".inc.php");
 }
// Functie om te checken of alle tabellen wel zijn aangemaakt.
function checkDBTables( ) {
	global $arrTables;
	sort($arrTables);
 	reset($arrTables);
 	
	$sql = "SHOW TABLES";
 	global $dbConnectie;
 	$arrResults = $dbConnectie->getData($sql);

 	$intArrayTabSize = count($arrTables);
 	$intArrayResSize = count($arrResults);
 	
 	if($intArrayTabSize != $intArrayResSize) {
 		return false;
 	}
 	else {
	 	for($i = 0	; $i < $intArrayTabSize; $i++ ) {
	 		if($arrResults[$i][0] != $arrTables[$i]) {
	 			return false;
	 		}
	 	}
	 	return true;
 	}	
}
// Functie om de last-login up te daten
function updateLastLogin( $intID, $strIP, $strType = 'gebruiker') {
	$sql = "UPDATE $strType SET lastlogin = '".getDatumTijd()."', ip = '".$strIP."' WHERE id = '$intID'";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
}
 
 
 // Functie om data te checken.
 function checkData($strData, $strType = 'regeltekst') {
 	if($strType == "regeltekst") {
 		$strData = addslashes($strData); 	
  		$strData = htmlentities($strData);
 	}
 	elseif($strType == "tekst") {
 		$strData = addslashes($strData);
 		$strData = htmlentities($strData);
 		$strData = nl2br($strData);
 	}
 	elseif($strType == "html") {
 	    $strData = addslashes($strData);
 	}
	elseif($strType == "wysiwyg" ) {
		$strData = addslashes( $strData );
		$strData = htmlentities( $strData );
	}
 	elseif($strType == "integer") {
 		settype($strData, "integer");
 	}
 	elseif($strType == "checkbox") {
 		if($strData == "")
 			$strData = "nee"; 
 	}
 	elseif($strType == "mail") {
 		if(!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$", $strData))
 			return false;
 		else
			return $strData;
 	}
 	return $strData;
 }
 // Functie om data te fixen
 function fixData($strData, $strType = 'normaal') {
 	if($strType == "normaal") {
 		$strData = stripslashes($strData);
 		return $strData;
 	}
 	elseif($strType == "tekstvak") {
 		$strData = stripslashes($strData);
	   $strData = preg_replace( '!<br.*>!iU', "", $strData );
 		return $strData;
 	} 	
 }
 // Functie om huidige datum+tijd op te vragen
 function getDatumTijd() {
    $dtDatum = date("Y-m-d H:i:s");
    return $dtDatum;
 }
 // Functie om datum/tijd te converteren tot leesbare datum/tijd
 function convertDatumTijd( $dtDatum = '') {
    if($dtDatum == null) {
    	$dtDatum = getDatumTijd();
    }
 	$arrDatum['jaar'] = substr($dtDatum, 0, 4);  	
 	$arrDatum['maand'] = substr($dtDatum, 5, 2);
 	$arrDatum['dag'] = substr($dtDatum, 8, 2);
 	$arrDatum['uur'] =  substr($dtDatum, 11, 2);
 	$arrDatum['minuten'] = substr($dtDatum, 14, 2);
 	$arrDatum['seconden'] = substr($dtDatum, 17, 2);
 	
 	return $arrDatum;
 }
 // Functie om oude datum/tijd te converteren naar leesbare datum/tijd en dan echo'en
 function DisplayConvertedDatumTijd( $dtDatum = '' ) {
    if($dtDatum == null) {
    	$dtDatum = getDatumTijd();
    }
 	$arrDatum['jaar'] = substr($dtDatum, 0, 4);  	
 	$arrDatum['maand'] = substr($dtDatum, 5, 2);
 	$arrDatum['dag'] = substr($dtDatum, 8, 2);
 	$arrDatum['uur'] =  substr($dtDatum, 11, 2);
 	$arrDatum['minuten'] = substr($dtDatum, 14, 2);
 	$arrDatum['seconden'] = substr($dtDatum, 17, 2);
 	echo $arrDatum['dag'] . "-" . $arrDatum['maand'] . "-" . $arrDatum['jaar'] . " om " . $arrDatum['uur'] . ":" . $arrDatum['minuten'] ;	
 }
// Functie om error-berichten op het scherm te laten zien
function showErrMessage( $strErrorMSG ) {
	echo " <div id=\"error\">\n  ";
	echo $strErrorMSG."\n";
	echo " </div>\n"; 
}
// Functie om mededelingen op het scherm te laten zien
function showMedMessage( $strMededeling ) {
	echo " <div id=\"mededeling\">\n  ";
	echo $strMededeling."\n";
	echo "\n </div>\n"; 
 	
}
// Functie om te kijken of een checkbox checked moet zijn of niet
function checkedValue( $strValue ) {
	if($strValue == "ja") {
		return "CHECKED";
	}
}
// Functie om select-menu te maken en te kijken wat selected is
function getSelectMenu( $strNaam, $strValue = 'ja') {
	$strCode = "<select name=\"$strNaam\">\n";
	if($strValue == "ja" || $strValue == "") {
		$strCode .= "<option value=\"ja\" SELECTED>Ja\n";
		$strCode .= "<option value=\"nee\">Nee\n";
	}
	elseif($strValue == "nee") {
		$strCode .= "<option value=\"ja\">Ja\n";
		$strCode .= "<option value=\"nee\" SELECTED>Nee\n";		
	}
	elseif($strValue == "aan") {
		$strCode .= "<option value=\"aan\" SELECTED>Aan\n";
		$strCode .= "<option value=\"uit\">Uit\n";		
	}
	elseif($strValue == "uit") {
		$strCode .= "<option value=\"aan\">Aan\n";
		$strCode .= "<option value=\"uit\" SELECTED>Uit\n";		
	}
	elseif($strValue == "wel") {
		$strCode .= "<option value=\"wel\" SELECTED>Aan\n";
		$strCode .= "<option value=\"niet\">Uit\n";		
	}
	elseif($strValue == "niet") {
		$strCode .= "<option value=\"wel\">Aan\n";
		$strCode .= "<option value=\"niet\" SELECTED>Uit\n";		
	}
	$strCode .= "</select>\n";
	return $strCode;
}
// Functie om het laatste ID-nummer uit database op te vragen
function getLastID() {
    global $dbConnectie;
	return $dbConnectie->getLastInsertedID();
}
// Functie om een select-menu te krijgen van lettertypes
function showLetterTypeMenu( $strNaam, $strSelected = '' ) {
	$arrLetterTypes[0] = "Arial";
	$arrLetterTypes[1] = "Arial Black";
	$arrLetterTypes[2] = "Comic Sans MS";
	$arrLetterTypes[3] = "Courier New";
	$arrLetterTypes[4] = "cursive";
	$arrLetterTypes[5] = "fantasy";
	$arrLetterTypes[6] = "Georgia";
	$arrLetterTypes[7] = "Impact";
	$arrLetterTypes[8] = "monospace";
	$arrLetterTypes[9] = "sans-serif";
	$arrLetterTypes[10] = "serif";
	$arrLetterTypes[11] = "Tahoma";
	$arrLetterTypes[12] = "Times New Roman";
	$arrLetterTypes[13] = "Trebuchet";
	$arrLetterTypes[14] = "Verdana";
	$intArraySize = count($arrLetterTypes);
	
	echo "<select name=\"$strNaam\">\n"; 
	for($i = 0; $i < $intArraySize; $i++)  {
		
		echo "<option value=\"$arrLetterTypes[$i]\"";
		if($strSelected == $arrLetterTypes[$i])
			echo " SELECTED";
		echo ">$arrLetterTypes[$i]\n";
	}
	echo "</select>\n";
}
// Functie om een select-menu te krijgen van lettergroottes
function showLetterGrootteMenu( $strNaam, $strSelected = '' ) {
	for($i = 0; $i < 20; $i++ ) {
		$arrLetterGrootte[$i] = $i + 6;
	}

	$intArraySize = count($arrLetterGrootte);
	
	echo "<select name=\"$strNaam\" style=\"width: 60px;\">\n";
	for($i = 0; $i <$intArraySize; $i++) {
		echo "<option value=\"$arrLetterGrootte[$i]\"";
		if($arrLetterGrootte[$i] == $strSelected) 
			echo " SELECTED";
		echo ">$arrLetterGrootte[$i]\n";
	}
	echo "</select>\n";
}
function showKleurMenu( $strNaam, $strSelected = '' ) {
	$arrKleurenEN = Array("black", "white", "blue", "aqua", "navy", "olive", "yellow" , "silver", "gray", "lime",
		"green", "teal", "purple", "fuchsia", "red", "maroon");
	$arrKleurenNL = Array("Zwart", "Wit", "Blauw", "Blauw (licht)", "Blauw (donker)", "Bruin (olijf-)",
		"Geel" , "Grijs (licht)", "Grijs (donker)", "Groen (licht) ", "Groen (donker)", "Groen/blauw", "Paars",
		"Paars (fuchsia-)", "Rood", "Rood/Bruin");

	$intArraySize = count($arrKleurenEN);
	echo "<select name=\"$strNaam\">\n";
	for($i = 0; $i <$intArraySize; $i++) {
//		echo "<option value=\"$arrKleurenEN[$i]\" style=\"background-color: $arrKleurenEN[$i]\" ";
		echo "<option value=\"$arrKleurenEN[$i]\"";
		if($arrKleurenEN[$i] == $strSelected) 
			echo " SELECTED";
		echo ">$arrKleurenNL[$i]\n";
	}
	echo "</select>\n";


}
  // Functie om selectmenu te maken voor kwaliteit-types bij flash-form
  function showKwaliteitMenu( $strNaam, $strSelected = 'autohigh' ) {
  	$arrKwaliteit[0] = "low";
  	$arrKwaliteit[1] = "autolow";
  	$arrKwaliteit[2] = "autohigh";
  	$arrKwaliteit[3] = "high";
  	$intArraySize = count($arrKwaliteit);
  	if($strSelected == "") $strSelected  = $arrKwaliteit[2];
  	
  	echo "<select name=\"$strNaam\">\n";
  	for( $i = 0; $i < $intArraySize; $i++ ) {
  		echo "<option value=\"".$arrKwaliteit[$i]."\"";
  		if($strSelected == $arrKwaliteit[$i])
  			echo " SELECTED";
		echo ">".$arrKwaliteit[$i]."\n";
  	}
  	echo "</select>\n";
  }
  // Functie om het keuzemenu van de indeling van de pagina te laten zien
  function showFiguurKeuzeMenu( $intSelected ) {
  	$intFiguurKeuze = 4;
	//echo "<table widht=\"440\">\n";
	echo "<tr>";
  	for($i = 1; $i - 1 < $intFiguurKeuze; $i++) {
  		echo "<td style=\"text-align: center;\">\n";
  		echo "<img src=\"images/optie$i.gif\" width=\"100\" height=\"60\" border=\"0\" alt=\"Figuur van optie $i\" onClick=\"changeRadioBox('keuze$i')\"  class=\"linkCursor\"><br>\n";
  		echo "<span class=\"linkCursor\" onClick=\"changeRadioBox('keuze$i')\">Keuze $i:</span><input type=\"radio\" name=\"keuze\" id=\"keuze$i\" value=\"$i\"";
		if($intSelected == $i)
  			echo " checked";
  		echo ">\n";
  		echo "</td>";
  	}
  	echo "</tr>\n";
  }
  // Functie om lijst voor dagen te maken
  function showDagLijst( $strPrefix, $intSelected = -1) {
	if($intSelected == -1)
  		$intSelected = 	date("j");
	echo "<select name=\"".$strPrefix."Dag\" style=\"width: 50px;\">\n";
  	for($intKeuzeNr = 1; $intKeuzeNr < 32; $intKeuzeNr++ ) {
  		if(strlen($intKeuzeNr) == 1)
  			$intNewKeuzeNr = "0" . $intKeuzeNr;
  		else
  			$intNewKeuzeNr = $intKeuzeNr;
		echo "<option value=\"$intNewKeuzeNr\"";
		if($intSelected == $intNewKeuzeNr)
			echo " SELECTED";
		echo ">$intKeuzeNr\n";
  	}
  	echo "</select>\n";
  }
  // Functie om een lijst voor maanden te maken
  function showMaandLijst( $strPrefix, $intSelected = -1) {
	  if($intSelected == -1)
  		$intSelected = 	date("n") - 1;
	$arrMaanden[1] = "Januari";
	$arrMaanden[2] = "Februari";
	$arrMaanden[3] = "Maart";
	$arrMaanden[4] = "April";
	$arrMaanden[5] = "Mei";
	$arrMaanden[6] = "Juni";
	$arrMaanden[7] = "Juli";
	$arrMaanden[8] = "Augustus";
	$arrMaanden[9] = "September";
	$arrMaanden[10] = "Oktober";
	$arrMaanden[11] = "November";
	$arrMaanden[12] = "December";
	$intArraySize = count($arrMaanden);

  	echo "<select name=\"".$strPrefix."Maand\" style=\"width: 100px;\">\n";
  	for($intKeuzeNr = 1; $intKeuzeNr < $intArraySize; $intKeuzeNr++ ) {
  		if(strlen($intKeuzeNr) == 1)
  			$intNewKeuzeNr = "0" . $intKeuzeNr;
  		else
  			$intNewKeuzeNr = $intKeuzeNr;
		echo "<option value=\"$intNewKeuzeNr\"";
		if($intSelected == $intKeuzeNr)
			echo " SELECTED";
		echo ">".$arrMaanden[$intKeuzeNr]."\n";
  	}
  	echo "</select>\n";
  }
  // Functie om lijst voor jaren te maken
  function showJaarLijst( $strPrefix, $intSelected = -1) {
	$intJaar = date("Y");
  	if($intSelected == -1)
  		$intSelected = $intJaar;
  	elseif($intSelected == -2)
  		$intSelected = $intJaar + 1;
  		
	echo "<select name=\"".$strPrefix."Jaar\" style=\"width: 65px;\">\n";
  	for($intKeuzeNr = 0; $intKeuzeNr < 11; $intKeuzeNr++ ) {
		echo "<option value=\"$intJaar\"";
		if($intSelected == $intJaar)
			echo " SELECTED";
		echo ">$intJaar\n";
		$intJaar = $intJaar + 1;
  	}
  	echo "</select>\n";
  }
  // Functie om lijst voor uren te maken
  function showUurLijst( $strPrefix, $intSelected = -1) {
	  if($intSelected == -1)
  		$intSelected = date("G");
	echo "<select name=\"".$strPrefix."Uur\" style=\"width: 50px;\">\n";
  	for($intKeuzeNr = 0; $intKeuzeNr < 24; $intKeuzeNr++ ) {
  		if(strlen($intKeuzeNr) == 1)
  			$intKeuzeNr = "0" . $intKeuzeNr;
		echo "<option value=\"$intKeuzeNr\"";
		if($intSelected == $intKeuzeNr)
			echo " SELECTED";
		echo ">$intKeuzeNr\n";
  	}
  	echo "</select>\n";
  }
  // Functie om lijst voor minuten te maken
  function showMinuutLijst( $strPrefix, $intSelected = -1) {
	  if($intSelected == -1)
  		$intSelected = date("i");
	echo "<select name=\"".$strPrefix."Minuut\" style=\"width: 50px;\">\n";
  	for($intKeuzeNr = 0; $intKeuzeNr < 60; $intKeuzeNr++ ) {
  		if(strlen($intKeuzeNr) == 1)
  			$intKeuzeNr = "0" . $intKeuzeNr;
		echo "<option value=\"$intKeuzeNr\"";
		if($intSelected == $intKeuzeNr)
			echo " SELECTED";
		echo ">$intKeuzeNr\n";
  	}
  	echo "</select>\n";
  } 
  // Functie om de talen te laten zien
  function showTaalMenu($strSelected) {
  	$arrTalen['nl'] = "Nederlands";
  	$arrTalen['en'] = "Engels";

	echo "<select name=\"taal\">\n";  	
	while (list($strKey, $strVal) = each($arrTalen)) {
   		echo "<option value=\"$strKey\"";
   		if($strSelected == $strKey)
   			echo " SELECTED";
   		echo ">".$strVal;
	}
	echo "</select>\n";
  }
 // Functie om het menu bij het WebsiteInhoud-gedeelte automatisch te maken
 function showInhoudMenu( $strType, $intObjectID, $intParentID = '0', $intWebsiteID ) {
	global $objLIGebRechten;
	$strExtra = checkBeheerder( $objLIGebRechten, $intWebsiteID );
	echo "<td class=\"inhoudMenu\">";
	echo " <a href=\"".$_SERVER['PHP_SELF']."?".$strType."=".$intObjectID.$strExtra;
	echo "&amp;actie=edit\" title=\"Bewerken\"><img src=\"images/editicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Bewerken\"></a> \n";
	echo " <a href=\"".$_SERVER['PHP_SELF']."?".$strType."=".$intObjectID;
	if($strType == "bid"  && $intParentID != 0) 
		echo "&amp;pagid=".$intParentID;
	elseif($strType == "pid" && $intParentID != 0)
		echo "&amp;ondid=".$intParentID;
	echo $strExtra."&amp;actie=del\" title=\"Verwijderen\"><img src=\"images/deleteicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Verwijderen\"></a> \n";
 }
 // Functie om het gedeelte van de menu te laten zien om zichtbaar en onzichtbaar te maken
 function showZichtbaarKeuze( $strType, $intObjectID, $intParentID, $strZichtbaar, $intWebsiteID) {
	global $objLIGebRechten;
	$strExtra = checkBeheerder( $objLIGebRechten, $intWebsiteID);
 	echo " <a href=\"".$_SERVER['PHP_SELF']."?".$strType."=".$intObjectID.$strExtra;
	echo "&amp;par=".$intParentID."&amp;actie=";
 	if($strZichtbaar == "ja")
 		echo "visibileoff\" title=\"Zet zichtbaarheid uit\"><img src=\"images/unvisibilityicon.gif\"";
	elseif($strZichtbaar == "nee")
		echo "visibileon\" title=\"Zet zichtbaarheid aan\"><img src=\"images/visibilityicon.gif\""; 	
	echo " width=\"20\" height=\"15\" border=\"0\" alt=\"";
 	
 	if($strZichtbaar == "ja")
	 	echo "Zet zichtbaarheid uit";
	elseif($strZichtbaar == "nee")
 		echo "Zet zichtbaarheid aan";
 	echo "\"></a> \n";	 	
 }
 // Functie om het gedeelte van menu te laten zien om de positie te wijzigen
 function showUpAndDownMenu( $strType, $intID, $intPositieID, $intParentID, $strPlaats = 'nvt', $intWebsiteID ) {
	global $objLIGebRechten;
	$strExtra = checkBeheerder( $objLIGebRechten, $intWebsiteID);
   if($strPlaats == "eerste" || $strPlaats == "beide") {
   		echo " <img src=\"images/upicondis.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Omhoog verplaatsen onmogelijk\"> \n";
   }
   else {
   		echo " <a href=\"".$_SERVER['PHP_SELF']."?".$strType."=".$intID."&amp;pos=".$intPositieID."&amp;par=".$intParentID.$strExtra;
   		echo "&amp;actie=moveup\" title=\"Verplaatst omhoog\"><img src=\"images/upicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Omhoog verplaatsen\"></a> \n";
   }
   if($strPlaats == "laatste" || $strPlaats == "beide") {
		echo " <img src=\"images/downicondis.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Omlaag verplaatsen onmogelijk\"> \n";	   	
   }
   else {
		echo " <a href=\"".$_SERVER['PHP_SELF']."?".$strType."=".$intID."&amp;pos=".$intPositieID."&amp;par=".$intParentID.$strExtra;
		echo "&amp;actie=movedown\" title=\"Verplaatst omlaag\"><img src=\"images/downicon.gif\" width=\"20\" height=\"15\" border=\"0\" alt=\"Omlaag verplaatsen\"></a> \n";	   	
   }
   echo "</td>"; 	
 }
 // Functie om het uitlijning-menu te laten zien
 function showUitlijningMenu( $strSelected = 'left') {
	$arrUitlijning['left'] = "Links";
	$arrUitlijning['center'] = "Gecentreerd";
	$arrUitlijning['right'] = "Rechts";
	
	echo "<select name=\"uitlijning\">\n";
	while (list($strKey, $strVal) = each($arrUitlijning)) {
   		echo "<option value=\"$strKey\"";
   		if($strSelected == $strKey)
   			echo " SELECTED";
   		echo ">".$strVal;
	}
	echo "</select>\n";
 }
 // Functie om voor huidige waarde, van bovenstaande functie, de naam te zien
 function showUitlijningNaam( $strSelected ) {
	$arrUitlijning['left'] = "Links";
	$arrUitlijning['center'] = "Gecentreerd";
	$arrUitlijning['right'] = "Rechts";
	while (list($strKey, $strVal) = each($arrUitlijning)) {
   		if($strSelected == $strKey)
   			echo $strVal;
	}
 }
 // Functie om een select-menu te laten zien voor de kader-stijl
 function showKaderMenu( $strSelected = 'none' ) {
 		$arrKaders['none'] = "Geen kader";
		$arrKaders['solid'] = "Vlakke kader";
		$arrKaders['dotted'] = "Kader bestaande uit punten";
		$arrKaders['dashed'] = "Kader bestaande uit streepjes";
		$arrKaders['double'] = "Dubbele kader";
		$arrKaders['groove'] = "Ingesneden kader";
		$arrKaders['ridge'] = "Richel";
		$arrKaders['inset'] = "Verdiept";
		$arrKaders['outset'] = "Uitstekend";
		echo "\n<select name=\"bordertype\" class=\"groot\">\n";
		while (list($strKey, $strVal) = each($arrKaders)) {
   		echo "<option value=\"$strKey\"";
   		if($strSelected == $strKey)
   			echo " SELECTED";
   		echo ">".$strVal."\n";
		}
		echo "</select>\n";
 }
 
  // Functie om positie op te vragen
  function getMaxPositie( $strTable, $intNR, $intWebsiteID ) {
  	$sql = "SELECT MAX(positie) AS pos FROM $strTable WHERE ";
  	if($strTable == "blok") {
	  		$sql .= " pid = '$intNR'";
  	}
  	elseif($strTable == "pagina") {
  		$sql .= " oid = '$intNR'";
  	}
  	elseif($strTable == "onderdeel") {
  		$sql .= " parent_id = '$intNR'";
  	}
  	$sql .= " AND wid = '$intWebsiteID'";
  	global $dbConnectie;
  	$arrPositie = $dbConnectie->getData($sql);
  	if($arrPositie != null && $arrPositie != false) {
  		return $arrPositie['0']['pos'] + 1;
  	}
  	else {
  		return 1;	
  	}
  }
  // Functie om het nieuwsid of faqid van de website op te vragen
  function getHighestIDNummer( $strTabel, $intWebsiteID ) {
  	$sql = "SELECT MAX(".$strTabel."id) AS highestid FROM $strTabel WHERE wid = '$intWebsiteID'";
  	global $dbConnectie;
  	$arrPositie = $dbConnectie->getData($sql);
  	if($arrPositie != null && $arrPositie != false) {
  		return $arrPositie['0']['highestid'] + 1;
  	}
  	else {
  		return 1;	
  	}
  }
 // Functie om te checken of onderdeel, pagina, blok bewerkbaar is
 function checkBewerkbaar($strType, $intID, $intWebsiteID ) {
 	$sql = "SELECT bewerkbaar FROM $strType WHERE ".$strType."id = '$intID' and wid = '$intWebsiteID'";
 	global $dbConnectie;
 	$arrBewerkbaar = $dbConnectie->getData($sql);
 	if($arrBewerkbaar != null && $arrBewerkbaar != false) {
 		if($arrBewerkbaar[0]['bewerkbaar'] == "ja") 
 			return true;
		else
			return false;
 	}
 	else {
 			return false;
 	}
 	
 }  

 // Functie om te checken of afzender wel van de site komt
 function checkReferer() {
 	if(isset($_SERVER['HTTP_REFERER'])) {
 		$arrReferer = explode("/", $_SERVER['HTTP_REFERER']);
		if($arrReferer[2] == $_SERVER['HTTP_HOST']) {
			return true;
		}
		else {
			return false;
		}
	}
 	else {
 		return false;
	}
 }
 // Functie om random wachtwoord te genereren
 function getRandomPass( $intLengte = 25) {
	$strAlphaNumValues = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	return random_string($strAlphaNumValues, $intLengte);
 }

// Functie om random char te genereren (gekopieerd van phpfreakz)
// Aangepast door mijzelf
function random_char($strTekst) {
  $intLengte = strlen($strTekst);
  $intPositie = mt_rand(0, $intLengte - 1);
  return($strTekst[$intPositie]);
}
// Functie om random string te genereren (gekopieerd van phpfreakz)
// Aangepast door mijzelf
function random_string($strCharSet, $intLengte) {
  $strReturnString = "";
  for ($i = 0; $i < $intLengte; $i++) 
    $strReturnString .= random_char($strCharSet);

  return $strReturnString;
}

// Functie om te checken of de beheerder is.
function checkBeheerder($objGebRechten, $intWebsiteID) {
	if($objGebRechten == "ja")
		return "&amp;wid=".$intWebsiteID;
	else
		return "";	
}
// Functie om een nieuw wachtwoord te versturen naar een admin of gebruiker 
function verstuurNieuwWachtwoord( $objPersoon, $strType ) {
	if(!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$", $objPersoon->getEMail())) {
		return "fout email";
	}
	global $strCMSURL;
	global $strCMSDir;
	global $strInfoMailAdres;
	global $strCMSNaam;
	global $strBedrijfsNaam;
	$strWachtwoord = getRandomPass(15);
	if($strType == "gebruiker")
		$strResult = updateGebruikerWachtwoord($objPersoon->getID(), $strWachtwoord);
	else
		$strResult = updateAdminWachtwoord($objPersoon->getID(), $strWachtwoord);
		
	global $strInfoMailAdres;
	
	if($objPersoon == false || $objPersoon == null)
		return "onbekend email";
	elseif($strResult == true) {
		$strBericht = "Beste ".$objPersoon->getVoorNaam()." ".$objPersoon->getAchterNaam().", \n\n";
		$strBericht .= "U heeft zojuist uw aanvraag, om uw wachtwoord van het content management systeem ".$strCMSNaam." van ".$strBedrijfsNaam." te veranderen, bevestigd. Hieronder staan je nieuwe logingegevens vermeld: \n";
		$strBericht .= "* GebruikersID: ".$objPersoon->getID()."\n";
		$strBericht .= "* Gebruikersnaam: ".$objPersoon->getGebruikersNaam()."\n";
		$strBericht .= "* Wachtwoord: ".$strWachtwoord."\n\n";
		$strBericht .= "Als u problemen heeft met het inloggen met deze gegevens, dan kunt u contact opnemen met ".$strBedrijfsNaam." via het e-mailadres ".$strInfoMailAdres.".\n\n\n";
		$strBericht .= "Einde van dit automatisch gegenereerde bericht.";	
		
		if(!mail($objPersoon->getEMail(), "Logingegevens van ".$strCMSNaam." - ".$strBedrijfsNaam, $strBericht, getHeaders($strCMSNaam." ".$strBedrijfsNaam, $strInfoMailAdres) )) {
			return "niet gelukt";
		}
		else {
			return "goed gelukt";
	 	}
	}
}
// Functie om een vraag om een bevestiging te versturen naar een admin of gebruiker 
function verstuurWachtwoordBevestiging( $strEmail, $strType = 'gebruiker' ) {
	if(!eregi("^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$", $strEmail)) {
		return "fout email";
	}
	elseif($strType == "gebruiker") 
		$objPersoon = getGebruikerMetMail($strEmail);
	elseif($strType == "admin")
		$objPersoon = getAdminMetMail($strEmail);
	
	if($objPersoon == false || $objPersoon == null) {
		if(!is_object($objPersoon))
		return "onbekend email";
	}
	else {
		global $strCMSURL;
		global $strCMSDir;
		global $strGebIndex;
		global $strAdmIndex;
		global $strInfoMailAdres;
		global $strCMSNaam;
		global $strBedrijfsNaam;
		
		$strKey = substr(md5($objPersoon->getWachtwoord()), 0, 15);
		$strURL = $strCMSURL.$strCMSDir;
		if($strType == "gebruiker")
			$strURL .= $strGebIndex;
		else
			$strURL .= $strAdmIndex;
		$strURL .= "?id=".$objPersoon->getID()."&k=".$strKey;

		$arrData = convertDatumTijd(getDatumTijd());
		$strDatum = "om ".$arrData['uur'].":".$arrData['minuten']." op ".$arrData['dag']."-".$arrData['maand']."-".$arrData['jaar'];

		$strBericht = "Beste ".$objPersoon->getVoorNaam()." ".$objPersoon->getAchterNaam().", \n\n";
		$strBericht .= "U heeft ".$strDatum." een aanvraag gedaan via het content management systeem ".$strCMSNaam." van ";
		$strBericht .= $strBedrijfsNaam." om een nieuw wachtwoord op te sturen. Aangezien uw wachtwoord dan wordt veranderd, ";
		$strBericht .= "is er een bevestiging voor deze aanvraag nodig. Dit is ter controle of u deze aanvraag wel heeft gedaan. ";
		$strBericht .= "De aanvraag is vanaf het IP-adres ".$_SERVER['REMOTE_ADDR']." (".gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$strBericht .= ") gedaan.\n";
		$strBericht .= "Klik op de link om uw aanvraag te bevestigen:\n";
		$strBericht .= $strURL."\n\n";
		$strBericht .= "Als u problemen heeft met het bevestigen van uw aanvraag, probeer dan de link te kopieren (ook eventuele tekens ";
		$strBericht .= "op de volgende regel) en te plakken in uw adresbalk. Als dit niet lukt, kunt u ook nog contact opnemen met ";
		$strBericht .= $strBedrijfsNaam." via het e-mailadres ".$strInfoMailAdres." met het verzoek om uw wachtwoord te wijzigen.\n\n";
		$strBericht .= "Als u geen aanvraag heeft gedaan om uw wachtwoord te wijzigen, dan kunt u dit bericht negeren. Als u vaker dit";
		$strBericht .= " bericht krijgt van een persoon met hetzelfde IP-adres, stuur dan het IP-adres (".$_SERVER['REMOTE_ADDR'].") door naar het e-mailadres ".$strInfoMailAdres.".\n\n\n";
		$strBericht .= "Einde van dit automatisch gegenereerde bericht.\n";

		if(!mail($strEmail, "Bevestiging gevraagd voor wachtwoordaanvraag van ".$strCMSNaam." - ".$strBedrijfsNaam, $strBericht, getHeaders( $strCMSNaam." ".$strBedrijfsNaam, $strInfoMailAdres) )) {
			return "niet gelukt";
		}
		else {
			return "goed gelukt";
	 	}
	}
}
// Functie om headers op te vragen voor e-mails
function getHeaders( $strAfzNaam, $strAfzMail) {
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
	$headers .= "From: ".$strAfzNaam." <".$strAfzMail.">\r\n";
	$headers .= "Reply-To: ".$strAfzNaam." <".$strAfzMail.">\r\n";
	$headers .= "Message-ID: <".md5(uniqid(time()))."@{$_SERVER['SERVER_NAME']}>\r\n";
	$headers .= "Return-Path: ".$strAfzMail."\r\n";           
	$headers .= "X-Priority: 3\r\n";
	$headers .= "X-MSmail-Priority: Normal\r\n";
	// Wat hieronder staat wordt toegevoegd, omdat het waarschijnlijk beter bij Hotmail overkomt
	$headers .= "X-Mailer: Microsoft Office Outlook, Build 11.0.5510\r\n";
	$headers .= "X-MimeOLE: Produced By Microsoft MimeOLE V6.00.2800.1441\r\n";
	$headers .= "X-Sender: ".$strAfzMail."\r\n";
	return $headers;
}
// Functie om te checken of er velden leeg zijn bij het adminformulier
function checkErrors($arrError) {
    $intArraySize = count($arrError);
    $booError = false;
    $intErrorAantal = 0;
    for($intTeller = 0; $intTeller < $intArraySize; $intTeller++) {
      if(isset($arrError[$intTeller])) {
		$booError = true;
      }
      else { 
      	$intErrorAantal++; 
      }
    }
}
 // Functie die van php.net komt, vergelijkbaar met htmlentities() alleen voor XML-bestanden
 function xmlentities($string, $quote_style=ENT_QUOTES) {
   static $trans;
   if (!isset($trans)) {
       $trans = get_html_translation_table(HTML_ENTITIES, $quote_style);
       foreach ($trans as $key => $value)
           $trans[$key] = '&#'.ord($key).';';
       // dont translate the '&' in case it is part of &xxx;
       $trans[chr(38)] = '&';
   }
   // after the initial translation, _do_ map standalone '&' into '&#38;'
	return preg_replace("/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,3};)/","&#38;" , strtr($string, $trans));
}

// Functie die op php.net stond die de date-functie corrigeert bij kleine data
// Aangepast door mijzelf 
function getTimeDifference ($timedifference) {   if ($timedifference >= 3600) {       $hval = ($timedifference / 3600);       $hourtime = intval($hval);       $leftoverhours = ($timedifference % 3600);       $mval = ($leftoverhours / 60);       $minutetime = intval($mval);       $leftoverminutes = ($leftoverhours % 60);       $secondtime = intval($leftoverminutes);       $hourtime = str_pad($hourtime, 2, "0", STR_PAD_LEFT);       $minutetime = str_pad($minutetime, 2, "0", STR_PAD_LEFT);       $secondtime = str_pad($secondtime, 2, "0", STR_PAD_LEFT);       return "$hourtime:$minutetime:$secondtime";   }   elseif ($timedifference >= 60) {       $hourtime = 0;       $mval = ($timedifference / 60);       $minutetime = intval($mval);       $leftoverminutes = ($timedifference % 60);       $secondtime = intval($leftoverminutes);       $hourtime = str_pad($hourtime, 2, "0", STR_PAD_LEFT);       $minutetime = str_pad($minutetime, 2, "0", STR_PAD_LEFT);       $secondtime = str_pad($secondtime, 2, "0", STR_PAD_LEFT);       return "$hourtime:$minutetime:$secondtime";   }   $hourtime = 0;   $minutetime = 0;   if ($timedifference < 0 ) { $secondtime = 0; }   else {    $secondtime = $timedifference; }   $hourtime = str_pad($hourtime, 2, "0", STR_PAD_LEFT);   $minutetime = str_pad($minutetime, 2, "0", STR_PAD_LEFT);   $secondtime = str_pad($secondtime, 2, "0", STR_PAD_LEFT);   return "$hourtime:$minutetime:$secondtime";  }
// Functie om directory  op te vragen 
function getHuidigeDir() {
	$arrDir = explode("/",$_SERVER['SCRIPT_FILENAME']);
	$intArrSize = count($arrDir);
	$strDir = "";
	for($intTeller = 0; $intTeller < $intArrSize - 1; $intTeller++) 
		$strDir .= $arrDir[$intTeller]."/";
	
	return $strDir;
}

?>