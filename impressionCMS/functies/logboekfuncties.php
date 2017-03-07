<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Logboekfuncties.php
 * Beschrijving: De functies mbt de logs
 */
 
 // Functie om een log in te voeren
 function insertLogRegel( LogRegel $objLog ) {
 	$sql = "INSERT INTO logboek (tekst, ipadres, gid, aid, wid, datumtijd, soort) VALUES ( '".$objLog->getTekst()."', ";
 	$sql .= " '".$objLog->getIPAdres() . "', '".$objLog->getGebruikersID(). "', '".$objLog->getAdminID()."',";
 	$sql .= " '".$objLog->getWebsiteID()."', '".$objLog->getDatumTijd()."', '".$objLog->getSoort()."' )";
	global $dbConnectie;
 	return $dbConnectie->setData($sql);
 }
 // Functie om een stuk tekst om te zetten naar een log 
 function verwerkLogRegel( $strTekst, $intGebruikersID = '', $intAdminID = '', $intWebsiteID = '', $strSoort = '') {
 	$objLog = new LogRegel();
 	$objLog->setTekst( checkData( $strTekst) );
 	$objLog->setGebruikersID( $intGebruikersID );
 	$objLog->setAdminID( $intAdminID );
 	$objLog->setWebsiteID( $intWebsiteID );
 	$objLog->setSoort( $strSoort );
 	$objLog->setIPAdres( $_SERVER['REMOTE_ADDR'] );
 	$objLog->setDatumTijd( getDatumTijd() );
 	insertLogRegel( $objLog );
 }
 
 
 // Functie om een log uptedaten
 function updateLogRegel( LogRegel $objLog ) {
 	$sql = "UPDATE logboek SET tekst = '" . $objLog->getTekst() . "'";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql); 	
 } 
 // Functie om een log te verwijderen
 function delLogRegel( $intLogID ) {
 	$sql = "DELETE FROM logboek WHERE id = '$intLogID'";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
 }
 // Functie om het gehele logboek te legen
 function deleteLogBoek() {
 	$sql = "TRUNCATE TABLE logboek";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
 }
 // Functie om een log op te vragen
 function getLogRegel( $intLogID ) {
 	$sql = "SELECT * FROM logboek WHERE id ='$intLogID' ";
 	global $dbConnectie;
 	$arrLogRegels = $dbConnectie->getData($sql); 
 	if($arrLogRegels != false) {
 	    $objLog = new LogRegel();
    	$objLog->setValues($arrLogRegels[0]);
    	return $objLog;
 	}
 	else {
 		return false;
 	} 	
 }
 // Functie om logs op te vragen met GebruikersID
 function getLogRegelGID( $intGebruikersID ) {
 	$sql = "SELECT * FROM logboek WHERE gid ='$intGebruikersID' ";
 	global $dbConnectie;
 	$arrLogRegels = $dbConnectie->getData($sql); 
 	if($arrLogRegels != false) {
 	    $objLog = new LogRegel();
    	$objLog->setValues($arrLogRegels[0]);
    	return $objLog;
 	}
 	else {
 		return false;
 	} 
 }
  // Functie om logs op te vragen met AdminID
 function getLogRegelAID( $intAdminID ) {
 	$sql = "SELECT * FROM logboek WHERE aid ='$intAdminID' ";
 	global $dbConnectie;
 	$arrLogRegels = $dbConnectie->getData($sql); 
 	if($arrLogRegels != false) {
 	    $objLog = new LogRegel();
    	$objLog->setValues($arrLogRegels[0]);
    	return $objLog;
 	}
 	else {
 		return false;
 	} 
 }
 // Functie om alle soorten op te vragen
 function getSoorten() {
 	$sql = "SELECT DISTINCT(soort) FROM logboek ORDER BY soort ASC";
 	global $dbConnectie;
 	$arrSoorten = $dbConnectie->getData($sql);
 	return $arrSoorten; 
 }
 // functie om alle soorten in een select-menutje te zetten
 function showSoortenList( $strSelected ) {
 	$arrSoorten = getSoorten();
 	if($arrSoorten != false) {
		$intArraySize = count($arrSoorten);
		echo "<select name=\"soort\" class=\"groot\">\n";
		echo "<option value=\"\"";
		if($strSelected == "")
			echo " SELECTED";
		echo ">\n";

		for($i = 0;$i < $intArraySize; $i++) {
			echo "<option value=\"".$arrSoorten[$i]['soort']."\"";
			if($arrSoorten[$i]['soort'] == $strSelected )
				echo " SELECTED";
			echo ">".$arrSoorten[$i]['soort']."\n";
		}
		echo "</select>\n";
 	}
 	else {
 		echo "<i>Niet mogelijk</i>";
 	}
 }
 // Functie om hele logboek op te vragen
 function getLogBoek( $arrInstellingen = '', $intVan = 0, $intLimit = 50 ) {
 	$sql = "SELECT * FROM logboek WHERE id != 0";
 	if(isset($arrInstellingen['websiteid']))
 		$sql .= " AND wid = '".$arrInstellingen['websiteid']."'";
 	if(isset($arrInstellingen['adminid']))
 		$sql .= " AND aid = '".$arrInstellingen['adminid']."'";
 	if(isset($arrInstellingen['gebruikersid']))
 		$sql .= " AND gid = '".$arrInstellingen['gebruikersid']."'";
 	if(isset($arrInstellingen['begindatum']) && isset($arrInstellingen['einddatum'])) {
 		$sql .= " AND datumtijd BETWEEN '".$arrInstellingen['begindatum']."' AND '".$arrInstellingen['einddatum']."'";	
 	}
 	elseif(isset($arrInstellingen['begindatum'])) {
 		$sql .= " AND datumtijd >= '".$arrInstellingen['begindatum']."'";
 	}
 	elseif(isset($arrInstellingen['einddatum']))  {
 		$sql .= " AND datumtijd <= '".$arrInstellingen['einddatum']."'";
 	}
 	if(isset($arrInstellingen['soort']))
 		$sql .= " AND soort = '".$arrInstellingen['soort']."'";
 	if(isset($arrInstellingen['ip']))
 		$sql .= " AND ipadres = '".$arrInstellingen['ip']."'";

 	$sql .= " ORDER BY id DESC LIMIT $intVan, $intLimit";
 	global $dbConnectie;
 	$arrBestanden = $dbConnectie->getData($sql);
 	return $arrBestanden;
 }
 // Functie om hele logboek op te vragen
 function getTotaalLog($arrInstellingen) {
 	$sql = "SELECT * FROM logboek WHERE id != 0 ";
 	if(isset($arrInstellingen['websiteid']))
 		$sql .= " AND wid = '".$arrInstellingen['websiteid']."'";
 	if(isset($arrInstellingen['adminid']))
 		$sql .= " AND aid = '".$arrInstellingen['adminid']."'";
 	if(isset($arrInstellingen['gebruikersid']))
 		$sql .= " AND gid = '".$arrInstellingen['gebruikersid']."'";
 	if(isset($arrInstellingen['begindatum']) && isset($arrInstellingen['einddatum'])) {
 		$sql .= " AND datumtijd BETWEEN '".$arrInstellingen['begindatum']."' AND '".$arrInstellingen['einddatum']."'";	
 	}
 	elseif(isset($arrInstellingen['begindatum'])) {
 		$sql .= " AND datumtijd >= '".$arrInstellingen['begindatum']."'";
 	}
 	elseif(isset($arrInstellingen['einddatum']))  {
 		$sql .= " AND datumtijd <= '".$arrInstellingen['einddatum']."'";
 	}
 	if(isset($arrInstellingen['soort']))
 		$sql .= " AND soort = '".$arrInstellingen['soort']."'";
 	if(isset($arrInstellingen['ip']))
 		$sql .= " AND ipadres = '".$arrInstellingen['ip']."'";
 	global $dbConnectie;
 	$arrBestanden = $dbConnectie->getData($sql);
 	return count($arrBestanden);
 }
 // Functie om bestandoverzicht te laten zien
 function showLogBoek( $arrInstellingen = '', $intVan = 0, $intLimit = 10 ) {
 	$arrLogBoek = getLogBoek( $arrInstellingen, $intVan, $intLimit );
 	echo "<h1>Logboek</h1><br>\n";
 	if($arrLogBoek == false || $arrLogBoek == null) {
	   echo "<table class=\"overzicht\" cellspacing=\"0\">\n";
	   echo "<tr><td class=\"tabletitle\">Geen logs aanwezig</td></tr>\n";
     	echo "<tr><td class=\"formvak\">Er zijn nog geen logs in de database aanwezig";
     	if($arrInstellingen != "") 
	     		echo " die aan de opgegeven gegevens voldoen";     	
     	echo ".</td></tr>\n";
     	echo "<tr><td class=\"tablelinks\">";
     	if($arrInstellingen != "")
	     	echo " <a href=\"".$_SERVER['PHP_SELF']."?reset\" class=\"linkitem\">Reset zoekcriteria</a>";     	
     	echo "&nbsp;</td></tr>\n";
		echo "</table>\n";
 	}
 	else {
 		$intArraySize = count($arrLogBoek);
 		$intTotaal = getTotaalLog($arrInstellingen);
 		global $objLIAdmin;
 		echo "<table cellspacing=\"0\" class=\"overzicht\">\n";
 		echo "<tr><td class=\"tabletitle\" colspan=\"4\">Logboek</td>";
 		if($objLIAdmin->getSuperUser() == "ja") {
	 		echo "<td class=\"tabletitle\" style=\"font-size: 10px; text-align: right; vertical-align: bottom;\">".
 				" [ <a href=\"".$_SERVER['PHP_SELF']."?legen\" class=\"linkitem\">Leeg Logboek</a> ]</td>";
 		}
 		else { echo "<td class=\"tabletitle\">&nbsp;</td>"; }
 		echo "</tr>\n";
 		for($i = 0; $i < $intArraySize; $i++) {
	 		$objLog = new LogRegel();
 			$objLog->setValues( $arrLogBoek[$i] );
 			echo "<tr><td class=\"tableinfo\">ID:</td>";
			echo "<td class=\"tableinfo\">Datum:</td>";
			echo "<td class=\"tableinfo\">Tijd:</td>";
			echo "<td class=\"tableinfo\">IP-Adres:</td>";
			echo "<td class=\"tableinfo\">Soort:</td></tr>\n";
 			echo "<tr><td class=\"formvak\">".$objLog->getLogID()."</td>";
 			echo "<td class=\"formvak\">".$objLog->getDatum()."</td>";
 			echo "<td class=\"formvak\">".$objLog->getTijd()."</td>";
			echo "<td class=\"formvak\">".$objLog->getIPAdres()."</td>";
			echo "<td class=\"formvak\">".$objLog->getSoort()."</td></tr>\n";
			echo "<tr><td class=\"formvak2\" colspan=\"5\">".$objLog->getTekst()."</td></tr>";
			echo "<tr><td class=\"formvak2\" colspan=\"3\"><b>Gebruiker:</b> ";
			if($objLog->getGebruikersID() == 0)
				echo "<i>Geen</i>";
			else {
				$objGebruiker = getGebruiker( $objLog->getGebruikersID() );
				if($objGebruiker != null && $objGebruiker != false)
					echo "<a href=\"gebruikersbeheer.php?actie=bg&id=".$objLog->getGebruikersID()."\">".$objGebruiker->getVolledigeNaam()."</a>";
				else
					echo "(ID ".$objLog->getGebruikersID().")";
			}
			echo "<br><b>Beheerder:</b> ";
			if($objLog->getAdminID() == 0) 
				echo "<i>Geen</i>";
			else {
				$objAdmin = getAdmin( $objLog->getAdminID() );
				if($objAdmin != null && $objAdmin != false)
					echo "<a href=\"adminbeheer.php?actie=ba&id=".$objLog->getAdminID()."\">".$objAdmin->getVolledigeNaam()."</a>";
				else
					echo "(ID ".$objLog->getAdminID().")";
			}
			echo "<td class=\"formvak2\" style=\"vertical-align: top;\" colspan=\"3\"><b>Website:</b> ";
			if($objLog->getWebsiteID() == 0) 
				echo "<i>Geen</i>";
			else {
				$objWebsite = getWebsite( $objLog->getWebsiteID() );
				if($objWebsite != null && $objWebsite != false)
					echo "<a href=\"websitebeheer.php?actie=bw&id=".$objWebsite->getWebsiteID()."\">".$objWebsite->getTitel()."</a>";
				else
					echo "(ID ".$objLog->getWebsiteID().")";
			}
			echo "</td></tr>\n";


 		}
     	echo "<tr><td class=\"tablelinks\" colspan=\"2\">";
     	if($intVan > 0)
	     	echo "<a href=\"".$_SERVER['PHP_SELF']."?van=".($intVan-$intLimit)."\" class=\"linkitem\">&lt;-- Vorige $intLimit</a>";
     	echo "&nbsp;</td><td class=\"tablelinks\">";
     	if($arrInstellingen != "")
	     	echo " <a href=\"".$_SERVER['PHP_SELF']."?reset\" class=\"linkitem\">Reset zoekcriteria</a>";
     	echo "&nbsp;</td><td class=\"tablelinks\" colspan=\"2\">";
     	if($intTotaal > ($intLimit+$intVan))
	     	echo " <a href=\"".$_SERVER['PHP_SELF']."?van=".($intVan+$intLimit)."\" class=\"linkitem\">Volgende $intLimit --&gt;</a>";
     	echo "</td></tr>\n";
 		echo "</table>\n";
 	}
 	echo "<br><br>\n";
 	echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">\n";
 	echo "<table cellspacing=\"0\" class=\"overzicht\">\n";
 	echo "<tr><td class=\"tabletitle\" colspan=\"2\">Zoekcriteria logboek</td></tr>\n";
 	echo "<tr><td class=\"tableinfo\" colspan=\"2\">Het is niet verplicht om alles in te vullen.</td></tr>\n";
	echo "<tr><td class=\"formvakb\" width=\"100\">Website:</td><td class=\"formvak\">";
	if(isset($arrInstellingen['websiteid']))
		showWebsiteList($arrInstellingen['websiteid'], true);
	else
		showWebsiteList("", true);
	echo "</td></tr>\n";
	echo "<tr><td class=\"formvakb\">Gebruiker:</td><td class=\"formvak\">";
	if(isset($arrInstellingen['gebruikersid']))
			showGebruikersList($arrInstellingen['gebruikersid'], true);
	else
		showGebruikersList("", true );
	echo "</td></tr>\n";
	echo "<tr><td class=\"formvakb\">Beheerder:</td><td class=\"formvak\">";
	if(isset($arrInstellingen['adminid']))
			showBeheerdersList($arrInstellingen['adminid'], true);
	else
		showBeheerdersList("", true );	echo "</td></tr>\n";
	echo "<tr><td class=\"formvakb\">Begindatum:</td><td class=\"formvak\">";
	if(isset($arrInstellingen['begindatum'])) {
		$arrDatumTijd =	explode(" ", $arrInstellingen['begindatum']);
		$arrDatum = explode("-", $arrDatumTijd[0]);
		$arrInstellingen['begindatum'] = $arrDatum[2]."-".$arrDatum[1]."-".$arrDatum[0]." ".$arrDatumTijd[1];
	}
	if(isset($arrInstellingen['einddatum'])) {
		$arrDatumTijd =	explode(" ", $arrInstellingen['einddatum']);
		$arrDatum = explode("-", $arrDatumTijd[0]);
		$arrInstellingen['einddatum'] = $arrDatum[2]."-".$arrDatum[1]."-".$arrDatum[0]." ".$arrDatumTijd[1];
	}
	
	echo "<input type=\"text\" name=\"begindatum\" id=\"begindatum\" ";
	if(isset($arrInstellingen['begindatum']))
		echo " value=\"".$arrInstellingen['begindatum']."\"";
	echo "size=\"19\" maxsize=\"19\"> <a href=\"javascript:NewCal('begindatum','ddMMyyyy',true,24);\"><img src=\"images/cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Kies een begindatum\" title=\"Kies een begindatum\"></a>";
	echo "</td></tr>\n";
	echo "<tr><td class=\"formvakb\">Einddatum:</td><td class=\"formvak\">";
	echo "<input type=\"text\" name=\"einddatum\" id=\"einddatum\" ";
	if(isset($arrInstellingen['einddatum']))
		echo " value=\"".$arrInstellingen['einddatum']."\"";	
	echo "size=\"19\" maxsize=\"19\"> <a href=\"javascript:NewCal('einddatum','ddMMyyyy',true,24);\"><img src=\"images/cal.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Kies een einddatum\" title=\"Kies een einddatum\"></a>";
	echo "</td></tr>\n";
	echo "<tr><td class=\"formvakb\">IP-adres:</td><td class=\"formvak\"><input type=\"text\" name=\"ip\"";
	if(isset($arrInstellingen['ip']))
		echo " value=\"".$arrInstellingen['ip']."\"";
	echo "></td></tr>\n";
	echo "<tr><td class=\"formvakb\">Soort melding:</td><td class=\"formvak\">";
	if(isset($arrInstellingen['soort']))
		showSoortenList($arrInstellingen['soort']);
	else
		showSoortenList("");	
	echo "</td></tr>\n";
	echo "<tr><td class=\"buttonvak\" colspan=\"2\"><input type=\"submit\" name=\"changeGegevensKnop\" value=\"Bekijk logboek\" class=\"button\"></td></tr>\n";
	echo "<tr><td class=\"tablelinks\" colspan=\"2\">&nbsp;</td></tr>";
	echo "</table>\n";	
	echo "</form>\n";
 }
// Functie om een formulier te maken om een 
function maakLeegLogboekForm() {
 	echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">\n";
 	echo "<table cellspacing=\"0\" class=\"overzicht\">\n";
 	echo "<tr><td class=\"tabletitle\" colspan=\"2\">Leeg logboek</td></tr>\n";
 	echo "<tr><td class=\"formvak\" colspan=\"2\">Klik op de knop hieronder om het logboek definitief te legen. Een back-up van het huidige logboek kan via phpMyAdmin worden gemaakt.</td></tr>";
 	echo "<tr><td class=\"buttonvak\"><input type=\"button\" name=\"leegLogboekNietKnop\" value=\"Leeg het logboek niet\" class=\"button\" onClick=\"history.back()\" ></td>";
 	echo "<td class=\"buttonvak\"><input type=\"submit\" name=\"leegLogboekKnop\" value=\"Leeg het logboek\" class=\"button\"></td></tr>";
	echo "<tr><td class=\"tablelinks\" colspan=\"2\">&nbsp;</td></tr>";
	echo "</table>\n";	
	echo "</form>\n";
}
 // Functie om de logtekst aan te maken
 function maakLogTekst( $strType, $objPersoon, $strTekst ) {
 	$strReturn = $strType." met de naam '".$objPersoon->getVolledigeNaam();
 	$strReturn .= "' (ID: ".$objPersoon->getID().") ".$strTekst;
 	return $strReturn; 
 }
?>