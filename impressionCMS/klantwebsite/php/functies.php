<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: functies.php
 * Beschrijving: De functies die de gebruiker nodig heeft
 */

 // Functie om de tekst goed weer te geven op het scherm
 function fixData($string, $type = 'normaal') {
  	$transtbl = get_html_translation_table(HTML_ENTITIES);  	$transtbl = array_flip($transtbl);  	$string = strtr($string, $transtbl);
 	$string = html_entity_decode( $string );  	
 	$string = stripslashes( $string );
 	return $string;
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

 // Functie om headers op te vragen voor e-mails
function getHeaders( $strAfzNaam, $strAfzEmail) {
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
	$headers .= "From: ".$strAfzNaam." <".$strAfzEmail.">\r\n";
	$headers .= "Reply-To: ".$strAfzNaam." <".$strAfzEmail.">\r\n";
	$headers .= "Message-ID: <".md5(uniqid(time()))."@{$_SERVER['SERVER_NAME']}>\r\n";
	$headers .= "Return-Path: ".$strAfzEmail."\r\n";
	$headers .= "X-Priority: 3\r\n";
	$headers .= "X-MSmail-Priority: Normal\r\n";
	$headers .= "X-Sender: ".$strAfzEmail."\r\n";
	$headers .= "X-Mailer: Microsoft Office Outlook, Build 11.0.5510\r\n";
	$headers .= "X-MimeOLE: Produced By Microsoft MimeOLE V6.00.2800.1441\r\n";
	$headers .= "X-Sender: ".$strAfzEmail."\r\n";
	return $headers;
}