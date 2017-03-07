<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: config.php
 * Beschrijving: Het configuratiebestand van het systeem
 *
 * Het bestand 'fckconfig.js' in de map 'fckeditor' bevat de instellingen van 
 * de WYSIWYG-editor die wordt toegepast in dit systeem. 
 */
 
// De database gegevens
$strHostname = ""; 		// De hostname welke gebruikt wordt voor de verbinding met de database
$strGebruikersnaam = ""; 		// De gebruikersnaam welke gebruikt wordt voor de verbinding met de database
$strWachtwoord = "";			// Het wachtwoord welke gebruikt wordt voor de verbinding met de database
$strDatabase = "tb_icms";				// De database welke gebruikt wordt voor de verbinding met de database

// Type database, mogelijkheid tussen 'mysql' en 'mysqli'.  Zie de verschillen op PHP.net
// Aangeraden wordt mysqli, want mysql zelf is amper getest. 
$strDBType = "mysqli";

// Algemene gegevens
$strCMSURL = "";  // Het internetadres van het systeem (met / aan het einde)
$strCMSDir = "";				 // De map waarin het systeem staat (zonder / in het begin )
$strGebIndex = "index.php";					 // Het bestand voor de gebruikersindex, standaard index.php
$strAdmIndex = "admin.php";					 // Het bestand voor de beheerdersindex, standaard admin.php

$strCMSNaam = "i-CMS";						 	// De naam van het content management systeem, standaard i-CMS
$strBedrijfsNaam = "Impression New Media";	// De naam van het bedrijf, standaard Impression New Media
$strInfoMailAdres = ""; 	// Het e-mailadres van het bedrijf, standaard info@impression.nl

// De map waarin alle bestanden van de gebruikers moet komen. Deze map moet alle rechten hebben, dus chmod 777 
// De mapnaam moet op een slash (/) eindigen 
$strUploadMap = "bestanden/";

// Het aantal uur dat een gebruiker of beheerder ingelogd mag blijven. 
// Zonder aanhalingstekens en alleen hele getallen.
// Als deze variabele op 0 staat, dan wordt deze functie niet ingeschakeld.
$strMaximaalAantalUur = 8;
// Het aantal minuten dat een gebruiker of beheerder is verbannen nadat hij 3 maal de verkeerde 
// logingegevens heeft ingevoerd
$strAantalMinVerbannen = 30;


// Handleiding en URL's, alleen volledige URL's
$strGebHandleidingURL = "";	// Het adres naar de online gebruikershandleidng
$strAdmHandleidingURL = "";	// Het adres naar de online beheerdershandleidng

// Een array met de tabellen erin vermeld. Deze wordt gebruikt bij de installatie om te controleren
// of de tabellen wel juist zijn aangemaakt.
$arrTables  = Array( "admin", "afbeeldingblok", "bestand", "blok", "contactformblok", 
			 "flashblok", "gebruiker", "gebruikersrechten", "htmlblok", "linksblok", "logboek", 
			 "onderdeel", "pagina", "tekstafbblok","tekstblok", "website");

?>