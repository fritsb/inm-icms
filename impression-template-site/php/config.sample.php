<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: config.php
 * Beschrijving: De instellingen van de gebruiker
 */

 // URL van de template
 $strTemplateURL = "template.html";
 // ID-nummer van website
 $intWebsiteID = 1	;
 // De speciale, unieke code die de website heeft
 $strSiteCode = "";
 // Het adres van de website (met / op het einde)
 $strSiteURL = "";

 // Het adres van de website waar de content van af wordt gehaald (met / op het einde)
 $strFunctiesURL = "";
 // Bestandsnaam van het externe script dat wordt gebruikt om de content op te vragen 
 $strXMLscript = "dataNaarXML.php";

 // De lokale XSLT-bestanden, om de data om te zetten naar leesbare content
 $strXSLTpagina = "xsl/pagina.xsl";
 $strXSLTheadlines = "xsl/headlines.xsl";
 $strXSLTmenu = "xsl/menu.xsl";
 $strXSLTblok = "xsl/blok.xsl";

 // Naam en e-mail van de eigenaar van CMS
 $strEigenaarNaam = "";
 $strEigenaarEmail = "";
 
?>