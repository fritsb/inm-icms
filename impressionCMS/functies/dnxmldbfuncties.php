<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: dnxmldbfuncties.php
 * Beschrijving: De functies mbt het omzetten van data uit de MySQL database naar XML.
 * Deze functies hebben allemaal betrekking tot de database
 */
 
  // Functie om een website-id met sitecode te controleren
  function checkWebsite( $intWebsiteID, $strSiteCode ) {
  	$sql = "SELECT id FROM website WHERE id = '$intWebsiteID' AND sitecode = '$strSiteCode'";
  	global $dbConnectie;
  	$arrWebsites = $dbConnectie->getData($sql);
  	if($arrWebsites != false && $arrWebsites != null) {
		return true;
  	}
  	else {
  		return false;
  	}
  }
  
  // Functie om de posities op te vragen bij een paginaid
  function getPosities( $intWebsiteID, $intPaginaID ) {
  	$sql = "SELECT p.positie AS pagpos, o.positie AS ondpos FROM pagina AS p, onderdeel AS o WHERE o.wid = '$intWebsiteID' AND ";
  	$sql .= " p.wid = '$intWebsiteID' AND p.paginaid = '$intPaginaID' AND p.oid = o.onderdeelid ORDER BY o.positie, p.positie LIMIT 1";
 	
  	global $dbConnectie;
  	$arrPaginas = $dbConnectie->getData($sql);
 	if($arrPaginas != false && $arrPaginas != null) {
		$arrGegevens['pid'] = $arrPaginas[0]['pagpos'];
		$arrGegevens['oid'] = $arrPaginas[0]['ondpos'];
		return $arrGegevens;
 	}
 	else {
		$arrGegevens['pid'] = 1;
		$arrGegevens['oid'] = 1;
		return $arrGegevens;
 	}
  }
  // Functie om totaal aantal blokken bij een pagina op te vragen
  function getTotaalBlokken( $intPaginaID, $intWebsiteID ) {
  	$sql = "SELECT blokid FROM blok WHERE pid = '$intPaginaID' AND wid = '$intWebsiteID'";

  	global $dbConnectie;
  	$arrBlokken = $dbConnectie->getData($sql);
  	if($arrBlokken != false && $arrBlokken != null) {
		return count($arrBlokken);
  	}
  	else {
  		return 0;
  	}
  } 
  // Functie om onderdeelID en paginaID op te vragen die bij een blok hoort
  function getIDsByBlok( $intBlokID, $intWebsiteID ) {
  	$sql = "SELECT p.paginaid, p.oid FROM blok AS b, pagina AS p, onderdeel AS o WHERE o.wid = '$intWebsiteID' AND ";
  	$sql .= " p.wid = '$intWebsiteID' AND b.blokid = '$intBlokID' AND p.paginaid = b.pid AND p.oid = o.onderdeelid";
  	global $dbConnectie;

  	$arrPaginas = $dbConnectie->getData($sql);
 	if($arrPaginas != false && $arrPaginas != null) {
		$arrGegevens['pid'] = $arrPaginas[0]['paginaid'];
		$arrGegevens['oid'] = $arrPaginas[0]['oid'];
		return $arrGegevens;
 	}
 	else {	
 		return false;
 	}
  }
  // Functie om onderdeelID op te vragen die bij een pagina hoort
  function getOIDByPagina( $intPaginaID, $intWebsiteID ) {
  	$sql = "SELECT oid FROM pagina WHERE wid = '$intWebsiteID' AND paginaid = '$intPaginaID'";
  	global $dbConnectie;

  	$arrPaginas = $dbConnectie->getData($sql);
 	if($arrPaginas != false && $arrPaginas != null) {
		return $arrPaginas[0]['oid'];
 	}
 	else {	
 		return false;
 	}
 }
  
  // Functie om de XML-code van een onderdeel op te vragen
  function getXMLOnderdeel( $intWebsiteID, $intOnderdeelID  ) {
   	$sql = "SELECT onderdeelid, titel, omschrijving, positie, parent_id, wid FROM pagina WHERE zichtbaar = 'ja' AND ";
   	$sql .= " wid = '$intWebsiteID' AND onderdeelid =  $intOnderdeelID";
   	
    global $dbConnectie;	
 	$arrOnderdelen  = $dbConnectie->getData($sql);
	$strXML = "";
 	if($arrOnderdelen != false && $arrOnderdelen != null) {
	 	$objOnderdeel = new Pagina();
    	$objOnderdeel->setValues($arrOnderdelen[0]);
		$strXML .= "  <onderdeel>\n";
		$strXML .= "    <id>".$objOnderdeel->getOnderdeelID()."</id>\n";
		$strXML .= "    <titel>".htmlentities($objOnderdeel->getTitel())."</titel>\n";
		$strXML .= "    <omschrijving>".htmlentities($objOnderdeel->getOmschrijving())."</omschrijving>\n";
		$strXML .= "    <positie>".$objOnderdeel->getPositie()."</positie>\n";
		$strXML .= "    <parentid>".$objOnderdeel->getParentID()."</parentid>\n";
		$strXML .= "  </onderdeel>\n";
 	}
 	else {
		  $strXML .= "<error>\n";
		  $strXML .= "  <errorcode>11</errorcode>\n";
		  $strXML .= "  <errorbericht>De informatie over het opgevraagde onderdeel kon niet worden gevonden.</errorbericht>\n";
		  $strXML .= "</error>\n";
 	}	
 	return utf8_encode($strXML);
  }
 
  // Functie om de XML-code van een pagina op te vragen
  function getXMLPagina( $intWebsiteID, $intOnderdeelID, $intPaginaID, $intPaginaDeelNr = 0, $intBlokAantal = 0, $intBlokID = 0, $strVolgorde = "A") {
		$sql = "SELECT paginaid, type, titel, limiet, positie, oid, wid FROM pagina WHERE zichtbaar = 'ja' AND ";
   	$sql .= " wid = '$intWebsiteID' AND oid = (SELECT onderdeelid FROM onderdeel WHERE onderdeelid = '$intOnderdeelID' ";
   	$sql .= "AND wid = '$intWebsiteID' AND zichtbaar = 'ja') ";
   	if($intPaginaID == "0")
	   	$sql .= "AND positie = '1' ";
	   else 
	   	$sql .= "AND paginaid = '$intPaginaID' ";
	   	
    global $dbConnectie;
 	$arrPaginas  = $dbConnectie->getData($sql);
	$strXML = "";
 	if($arrPaginas != false && $arrPaginas != null) {
	 	$objPagina = new Pagina();
    	$objPagina->setValues($arrPaginas[0]);
		$strXML .= "  <pagina>\n";
		$strXML .= "    <paginaid>".$objPagina->getPaginaID()."</paginaid>\n";
		$strXML .= "    <paginatitel>".htmlentities($objPagina->getTitel())."</paginatitel>\n";
		$strXML .= "    <paginapositie>".$objPagina->getPositie()."</paginapositie>\n";
		$strXML .= "    <paginaoid>".$intOnderdeelID."</paginaoid>\n";
		$strXML .= "    <paginadeelnr>".$intPaginaDeelNr."</paginadeelnr>\n";
		if($intBlokID == 0)
			$strXML .= "    <totaal>".getTotaalBlokken($objPagina->getPaginaID(), $intWebsiteID)."</totaal>\n";

		if($intBlokAantal == 0)
			$intBlokAantal = $objPagina->getLimiet();
		$strXML .= "    <limiet>".$intBlokAantal."</limiet>\n";
		if($intBlokID != 0)
			$strXML .= getXMLBlok( $intWebsiteID, $intOnderdeelID, $intPaginaID, $intBlokID);
		else
			$strXML .= getXMLBlokken( $intWebsiteID, $intOnderdeelID, $intPaginaID, $intPaginaDeelNr, $intBlokAantal, $strVolgorde);
		
		$strXML .= "  </pagina>\n";
 	}
 	else {
		  $strXML .= "<error>\n";
		  $strXML .= "  <errorcode>12</errorcode>\n";
		  $strXML .= "  <errorbericht>De informatie over de opgevraagde pagina kon niet worden gevonden.</errorbericht>\n";
		  $strXML .= "</error>\n";
 	}	
 	return utf8_encode($strXML);
  }
  // Functie om een blok op te vragen
  function getXMLBlok( $intWebsiteID, $intOnderdeelID, $intPaginaID, $intBlokID ) {
	$sql = "SELECT blokid, titel, positie, intro, begindatum, einddatum FROM blok WHERE wid = '$intWebsiteID' AND zichtbaar = 'ja' ";
	$sql .= " AND pid = (SELECT paginaid FROM pagina WHERE paginaid = '$intPaginaID' AND zichtbaar = 'ja' AND wid = '$intWebsiteID' ";
	$sql .= " AND oid = (SELECT onderdeelid FROM onderdeel WHERE onderdeelid = '$intOnderdeelID' AND wid = '$intWebsiteID' AND zichtbaar = 'ja'))";
	$sql .= " AND blokid = '$intBlokID' AND begindatum < '".getDatumTijd()."' AND einddatum > '".getDatumTijd()."'";

	global $dbConnectie;
	$arrblokken = $dbConnectie->getData($sql);
	
	if($arrblokken != false && $arrblokken != null) {
		$intArraySize = count($arrblokken);
 		// Aanmaken van XML 
 		$strXML = "";
		for($i = 0; $i < $intArraySize; $i++ ) {
 		  $objBlok = new Blok();
	     $objBlok->setValues($arrblokken[$i]);
		  $strXML .= "    <blok>\n";
		  $strXML .= "      <blokid>".$objBlok->getBlokID()."</blokid>\n";
		  $strXML .= "      <bloktitel>".htmlentities($objBlok->getTitel())."</bloktitel>\n";
		  $strXML .= "      <bloktype>".$objBlok->getSubType()."</bloktype>\n";
		  $strXML .= "      <blokpositie>".$objBlok->getPositie()."</blokpositie>\n";
		  $strXML .= "      <intro>".htmlentities($objBlok->getIntro())."</intro>\n";
		  $strXML .= "      <begindag>".substr($objBlok->getBeginDatum(), 8, 2)."</begindag>\n";
		  $strXML .= "      <beginmaand>".substr($objBlok->getBeginDatum(), 5 ,2 )."</beginmaand>\n";
		  $strXML .= "      <beginjaar>".substr($objBlok->getBeginDatum(), 0, 4 )."</beginjaar>\n";
		  $strXML .= "      <beginuur>".substr($objBlok->getBeginDatum(), 11 , 2)."</beginuur>\n";
		  $strXML .= "      <beginminuut>".substr($objBlok->getBeginDatum(), 14, 2)."</beginminuut>\n";
		  $strXML .= "      <einddag>".substr($objBlok->getEindDatum(), 8, 2)."</einddag>\n";
		  $strXML .= "      <eindmaand>".substr($objBlok->getEindDatum(), 5, 2)."</eindmaand>\n";
		  $strXML .= "      <eindjaar>".substr($objBlok->getEindDatum(), 0, 4)."</eindjaar>\n";
		  $strXML .= "      <einduur>".substr($objBlok->getEindDatum(), 11, 2)."</einduur>\n";
		  $strXML .= "      <eindminuut>".substr($objBlok->getEindDatum(), 14, 2)."</eindminuut>\n";
		  $strXML .= "      <pid>".$intPaginaID."</pid>\n";
		  $strXML .= "      <oid>".$intOnderdeelID."</oid>\n";
		
		  $strType = getBlokType( $objBlok->getBlokID(), $intWebsiteID);
		  $strType = getGoedeSubType( $strType );
	     $strType = ucfirst($strType);
		  $strFunctie = "get".$strType."Blok";
	  	  $objBlok = $strFunctie( $objBlok->getBlokID(), $intWebsiteID );
		  if($objBlok != null && $objBlok != false) {
			  $strContent = htmlentities($objBlok->getContent());
			  $strXML .= "        <content>".$strContent."</content>\n";
		  }
		  $strXML .= "      </blok>\n";
		}
	}
	elseif($arrblokken == null) {
		// Aanmaken van error-XML 
		  $strXML = "<error>\n";
		  $strXML .= "  <errorcode>13</errorcode>\n";
		  $strXML .= "  <errorbericht>Er is nog geen content op deze pagina.</errorbericht>\n";
		  $strXML .= "</error>\n";		
	}
	else {
		// Aanmaken van error-XML 
		  $strXML = "<error>\n";
		  $strXML .= "  <errorcode>14</errorcode>\n";
		  $strXML .= "  <errorbericht>Het content van deze pagina kon niet worden gevonden.</errorbericht>\n";
		  $strXML .= "</error>\n";
	}
	return utf8_encode($strXML);
  }
  // Functie om de blokken op te vragen
  function getXMLBlokken( $intWebsiteID, $intOnderdeelID, $intPaginaID, $intPaginaDeelNr = 0, $intBlokAantal, $strVolgorde ) {
	$sql = "SELECT blokid, titel, positie, intro, begindatum, einddatum FROM blok WHERE wid = '$intWebsiteID' AND zichtbaar = 'ja' ";
	$sql .= " AND pid = (SELECT paginaid FROM pagina WHERE ";
	if($intPaginaID != "0")
		$sql .= " paginaid = '$intPaginaID' ";
	else
		$sql .= " positie = '1'";
	$sql .= " AND zichtbaar = 'ja' AND wid = '$intWebsiteID' ";
	$sql .= " AND oid = (SELECT onderdeelid FROM onderdeel WHERE onderdeelid = '$intOnderdeelID' AND wid = '$intWebsiteID' AND zichtbaar = 'ja'))";
	$sql .= "  AND begindatum < '".getDatumTijd()."' AND einddatum > '".getDatumTijd()."'";
	if($strVolgorde == "O")
		$sql .= " ORDER BY positie DESC";
	else
		$sql .= " ORDER BY positie ASC";

//	echo $sql;

	if($intBlokAantal != 0)
		$sql .= " LIMIT ".($intPaginaDeelNr * $intBlokAantal).", $intBlokAantal";
	global $dbConnectie;
	$arrblokken = $dbConnectie->getData($sql);
	
	if($arrblokken != false && $arrblokken != null) {
		$intArraySize = count($arrblokken);
 		// Aanmaken van XML 
 		$strXML = "";
		for($i = 0; $i < $intArraySize; $i++ ) {
 		  $objBlok = new Blok();
	     $objBlok->setValues($arrblokken[$i]);
		  $strXML .= "    <blok>\n";
		  $strXML .= "      <blokid>".$objBlok->getBlokID()."</blokid>\n";
		  $strXML .= "      <bloktitel>".htmlentities($objBlok->getTitel())."</bloktitel>\n";
		  $strXML .= "      <bloktype>".$objBlok->getSubType()."</bloktype>\n";
		  $strXML .= "      <blokpositie>".$objBlok->getPositie()."</blokpositie>\n";
		  $strXML .= "      <intro>".htmlentities($objBlok->getIntro())."</intro>\n";
		  $strXML .= "      <begindag>".substr($objBlok->getBeginDatum(), 8, 2)."</begindag>\n";
		  $strXML .= "      <beginmaand>".substr($objBlok->getBeginDatum(), 5 ,2 )."</beginmaand>\n";
		  $strXML .= "      <beginjaar>".substr($objBlok->getBeginDatum(), 0, 4 )."</beginjaar>\n";
		  $strXML .= "      <beginuur>".substr($objBlok->getBeginDatum(), 11 , 2)."</beginuur>\n";
		  $strXML .= "      <beginminuut>".substr($objBlok->getBeginDatum(), 14, 2)."</beginminuut>\n";
		  $strXML .= "      <einddag>".substr($objBlok->getEindDatum(), 8, 2)."</einddag>\n";
		  $strXML .= "      <eindmaand>".substr($objBlok->getEindDatum(), 5, 2)."</eindmaand>\n";
		  $strXML .= "      <eindjaar>".substr($objBlok->getEindDatum(), 0, 4)."</eindjaar>\n";
		  $strXML .= "      <einduur>".substr($objBlok->getEindDatum(), 11, 2)."</einduur>\n";
		  $strXML .= "      <eindminuut>".substr($objBlok->getEindDatum(), 14, 2)."</eindminuut>\n";
		  $strXML .= "      <pid>".$intPaginaID."</pid>\n";
		  $strXML .= "      <oid>".$intOnderdeelID."</oid>\n";
		
		  $strType = getBlokType( $objBlok->getBlokID(), $intWebsiteID);
		  $strType = getGoedeSubType( $strType );
	     $strType = ucfirst($strType);
		  $strFunctie = "get".$strType."Blok";
	  	  $objBlok = $strFunctie( $objBlok->getBlokID(), $intWebsiteID );
		  // $strXML .= "        <content>".htmlentities($objblok->getContent())."</content>\n";
		  if($objBlok != null && $objBlok != false) {
			  $strContent = htmlentities($objBlok->getContent());
			  $strXML .= "        <content>".$strContent."</content>\n";
		  }
		  $strXML .= "      </blok>\n";
		}
	}
	elseif($arrblokken == null) {
		// Aanmaken van error-XML 
		  $strXML = "<error>\n";
		  $strXML .= "  <errorcode>13</errorcode>\n";
		  $strXML .= "  <errorbericht>Er is nog geen content op deze pagina.</errorbericht>\n";
		  $strXML .= "</error>\n";		
	}
	else {
		// Aanmaken van error-XML 
		  $strXML = "<error>\n";
		  $strXML .= "  <errorcode>14</errorcode>\n";
		  $strXML .= "  <errorbericht>Het content van deze pagina kon niet worden gevonden.</errorbericht>\n";
		  $strXML .= "</error>\n";
	}
	return utf8_encode($strXML);
  }

  // Functie om het onderdeel-menu te maken
  function getMenu(  $intWebsiteID, $strMenuType = 'middle' ) {
	$sql = "SELECT onderdeelid, titel, positie FROM onderdeel WHERE wid = '$intWebsiteID' AND parent_id = 0 AND "; 
	$sql .= " zichtbaar = 'ja' ORDER BY positie";
	global $dbConnectie;
	$arrOnderdelen  = $dbConnectie->getData($sql);
	
	if($arrOnderdelen != false && $arrOnderdelen != null) {
		$intArraySize = count($arrOnderdelen);
		$strXML = "<menu>\n";
		for($i = 0; $i < $intArraySize; $i++) {
			$objOnderdeel = new Onderdeel();
			$objOnderdeel->setValues( $arrOnderdelen[$i] );
			$strXML .=  "  <onderdeel>\n";
			$strXML .=  "    <onderdeelid>".$objOnderdeel->getOnderdeelID()."</onderdeelid>\n";
			$strXML .=  "    <onderdeeltitel>".$objOnderdeel->getTitel()."</onderdeeltitel>\n";
			$strXML .=  "    <onderdeelpositie>".$objOnderdeel->getPositie()."</onderdeelpositie>\n";
			if($strMenuType == "large" || $strMenuType == "middle")
				$strXML .= getSubOnderdelenMenu( $objOnderdeel->getOnderdeelID(), $intWebsiteID, $strMenuType );
			if($strMenuType == "large")
				$strXML .= getPaginasMenu( $objOnderdeel->getOnderdeelID(), $intWebsiteID, $strMenuType );
			$strXML .=  "  </onderdeel>\n";		
		}
		$strXML .=  "</menu>\n";
	}
	else {
			// Aanmaken van error-XML 
		  $strXML = "<error>\n";
		  $strXML .= "  <errorcode>xx</errorcode>\n";
		  $strXML .= "  <errorbericht>Het menu kon niet worden opgemaakt.</errorbericht>\n";
		  $strXML .= "</error>\n";
	}
	return utf8_encode($strXML);
  }
  // Functie om het menu te maken
  function getSubOnderdelenMenu( $intParentID, $intWebsiteID, $strMenuType = 'large', $intDiepte = 0 ) {
	$sql = "SELECT onderdeelid, titel FROM onderdeel WHERE parent_id = '$intParentID' AND wid = '$intWebsiteID' AND ";
	$sql .= " zichtbaar = 'ja' ORDER BY positie";
	global $dbConnectie;
	$arrOnderdelen  = $dbConnectie->getData($sql);
	if($arrOnderdelen != false && $arrOnderdelen != null) {
		$intArraySize = count($arrOnderdelen);
		for($i = 0; $i < $intArraySize; $i++) {
			$objOnderdeel = new Onderdeel();
			$objOnderdeel->setValues( $arrOnderdelen[$i] );
			$strXML =  "  <subonderdeel$intDiepte>\n";
			$strXML .=  "    <onderdeelid>".$objOnderdeel->getOnderdeelID()."</onderdeelid>\n";
			$strXML .=  "    <subonderdeeltitel>".$objOnderdeel->getTitel()."</subonderdeeltitel>\n";
			if($intDiepte < 2)
				$strXML .= getSubOnderdelenMenu( $objOnderdeel->getOnderdeelID(), $intWebsiteID, $strMenuType, $intDiepte + 1 );
			if($strMenuType == "large")
				$strXML .= getPaginasMenu( $objOnderdeel->getOnderdeelID(), $intWebsiteID, $strMenuType );
			$strXML .= "  </subonderdeel$intDiepte>\n";		
		}
	 }
	 else {
	 	$strXML = "";
	 }
	 return $strXML;
  }  
  // Functie om het pagina-menu te maken
  function getPaginasMenu( $intOnderdeelID, $intWebsiteID,  $strMenuType = 'large' ) {
  	$sql = "SELECT paginaid, titel, positie, oid FROM pagina WHERE oid = '$intOnderdeelID' AND wid = '$intWebsiteID' AND ";
  	$sql .= " zichtbaar = 'ja' ORDER BY positie";
  	global $dbConnectie;
  	$arrPaginas = $dbConnectie->getData($sql);
  	
  	if($arrPaginas != false || $arrPaginas != null) {
  		$intArraySize = count($arrPaginas);
  		for($i = 0; $i < $intArraySize; $i++ ) {
	  		$objPagina = new Pagina();
	  		$objPagina->setValues( $arrPaginas[$i] );
			$strXML = "    <pagina>\n";
			$strXML .= "      <paginaid>".$objPagina->getPaginaID()."</paginaid>\n";
			$strXML .= "      <paginatitel>".$objPagina->getTitel()."</paginatitel>\n";
			$strXML .= "      <paginapositie>".$objPagina->getPositie()."</paginapositie>\n";
			$strXML .= "      <paginaoid>".$objPagina->getOnderdeelID()."</paginaoid>\n";
			$strXML .= "    </pagina>\n";
  		}
  	}
  	else {
			$strXML = "";  		
  	}
  	return $strXML;
  }
  
?>