<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: Banfuncties.php
 * Beschrijving: De functies mbt bans
 */
 
 // Functie om een bestand in te voeren
 function insertBan( Ban $objBan ) {
 	$sql = "INSERT INTO bestand (ipadres, datumtijd, reden, verkort) VALUES ('".
 	 $objBan->getIPAdres()."', '".$objBan->getDatumTijd()."', '".$objBan->getReden()."', '".
 	 $objBan->getVerkort()."' )";
	global $dbConnectie;
 	return $dbConnectie->setData($sql);
 }
 // Functie om een bestand uptedaten
 function updateBan( Ban $objBan ) {
 	$sql = "UPDATE bestand SET ipadres = '".$objBan->getIPAdres()."', reden = '".$objBan->getReden()."', ";
 	$sql .= " verkort = '".$objBan->getVerkort()."'";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql); 	
 } 
 // Functie om een bestand te verwijderen
 function delBan( $intBanID ) {
 	$sql = "DELETE FROM ban WHERE id = '$intBanID'";
 	global $dbConnectie;
 	return $dbConnectie->setData($sql);
 }
 // Functie om een bestand op te vragen
 function getBan( $intBanID ) {
 	$sql = "SELECT * FROM ban WHERE id ='$intBanID' ";
 	global $dbConnectie;	
 	$arrBans = $dbConnectie->getData($sql); 
 	if($arrBans != false) {
 	    $objBan = new Ban();
    	$objBan->setValues($arrBans[0]);
    	return $objBan;
 	}
 	else {
 		return false;
 	} 
 }
 function getBanByIP( $intBanIP ) {
 	$sql = "SELECT * FROM ban WHERE ipadres ='$intBanIP' ";
 	global $dbConnectie;
 	$arrBans = $dbConnectie->getData($sql); 
 	if($arrBans != false) {
 	    $objBan = new Ban();
    	$objBan->setValues($arrBans[0]);
    	return $objBan;
 	}
 	else {
 		return false;
 	}
 }
 function getBanList( $intVan = 0, $intLimit = 50 ) {
 	$sql = "SELECT * FROM bestand LIMIT '$intVan', '$intLimit' ";
 	global $dbConnectie;
 	$arrBestanden = $dbConnectie->getData($sql);
 	return $arrBestanden;
 }
 // Functie om bestandoverzicht te laten zien
 function showBanList( $intVan = 0, $intLimit = 50 ) {
 	$arrBanList = getBanList( $intVan, $intLimit );
 	echo "<h1>Banlist</h1><br>\b";
 	if($arrBanList == false || $arrBanList == null) {
 		echo "Er zijn geen mensen (meer) geband.";
 	}
 	else {
 		$intArraySize = count($arrBanList);
 		$objBan = new Ban();
 		echo "<table cellspacing=\"0\" class=\"overzicht\">\n";
 		echo "<tr><td class=\"tabletitle\" colspan=\"3\">Banlist</td></tr>\n";
 		echo "<tr><td class=\"tableinfo\">IP-Adres:</td><td class=\"tableinfo\">Reden:</td>";
 		echo "<td class=\"tableinfo\">Datum:</td><td class=\"tableinfo\">Korte ban:</td><td class=\"tableinfo\">Opties:</td></tr>\n";
 		for($i = 0; $i < $intArraySize; $i++) {
 			$objBan->setValues( $arrBanList[$i] );
 			echo "<tr><td class=\"formvak\">".$objBan->getIPAdres()."</td>";
 			echo "<td class=\"formvak\">".$objBan->getReden()."</td>";
 			echo "<td class=\"formvak\">".$objBan->getDatumTijd()."</td>";
 			echo "<td class=\"formvak\">".$objBan->getVerkort()."</td><td class=\"formvak\">\n";
 			// showBanMenu(); 
 			echo "</td></tr>\n";
 		}
 		echo "<tr><td class=\"tablelinks\" colspan=\"5\"></td></tr>\n";
 		echo "</table>\n";
 	}
	
 }
 
?>