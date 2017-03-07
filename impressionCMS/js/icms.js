/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: icms.js
 * Beschrijving: Een aantal javascript-functies
 */
 
// Functie om automatisch de extensies toe te voegen aan het textarea
function updateExtensieArea( ) {
	// De vars met alle extensies, let op de spatie aan het einde
	var arrExtensies = new Array();
	var strPlaatjesExt = "JPG JPEG JPE PNG GIF BMP TIFF TIF ICO PCX ";
	var strWebsiteExt = "HTM HTML CSS XHTML JS SWF SHTML XML ";
	var strVideoExt = "AVI MPEG MPG WMV WMF ASF ASX RM RA RAM VIV MOV  ";
	var strMuziekExt = "MP3 WAV MID OGC AU SND WMA ";
	var strDocumentExt = "DOC TXT PDF XLS CVS PPT ";
	var strIngepaktExt = "ZIP RAR ACE ARJ CAB TAR GZ TGZ ";
	
    // De vars die nodig zijn om te checken of er onbekende extensies aanwezig zijn
    var strExtensies = strPlaatjesExt + strWebsiteExt + strVideoExt + strMuziekExt + strDocumentExt + strIngepaktExt;

	var arrOldExtensies = new Array();
	var strTextArea = document.forms[0].extensies.value;
	
	// Controleren welke checkbox 'aan' of 'uit' staat en dan extensies toevoegen aan string
	var strGekozenExtensies = "";
	if(document.forms[0].plaatjes.checked) 
		strGekozenExtensies += strPlaatjesExt;
	if(document.forms[0].website.checked) 
		strGekozenExtensies += strWebsiteExt;
	if(document.forms[0].video.checked) 
		strGekozenExtensies += strVideoExt;
	if(document.forms[0].muziek.checked) 
		strGekozenExtensies += strMuziekExt;
	if(document.forms[0].documenten.checked) 
		strGekozenExtensies += strDocumentExt;
	if(document.forms[0].ingepakt.checked) 
		strGekozenExtensies += strIngepaktExt;


    // De check of textarea niet leeg is
	if((strTextArea != "") && (strTextArea != null)) {
		arrExtensies = strExtensies.split(" ");
 		arrOldExtensies = strTextArea.split(" ");
		// Als er nog strings zijn die niet bij de checkboxs horen, wordt ie nu toegevoegd
		strGekozenExtensies += checkOldExtensies( arrExtensies, arrOldExtensies );
	}
	document.forms[0].extensies.value = strGekozenExtensies;
}
// Functie om te checken of er nog extensies in de textarea zijn die niet
// automatisch toegevoegd worden door de checkboxjes
function checkOldExtensies( arrExtensies, arrOldExtensies ) {
	var strNewExtensies = "";
	for(var i = 0; i < arrOldExtensies.length; i++) {
		for(var j = 0; j < arrExtensies.length && arrOldExtensies[i] != ""; j++ ) {
			if(arrOldExtensies[i] == arrExtensies[j]) {
				arrOldExtensies[i] = "";
			}
		}
		if(arrOldExtensies[i] != "")
			strNewExtensies += arrOldExtensies[i] + " ";
	}
	return strNewExtensies;
}
// Functie om checkboxen aan te kruizen waarvan de extensies bij het laden in de tekstvak staan
function checkExtensiesArea() {
	if(document.forms[0] != null && document.forms[0].extensies != null) {
		var strTextArea = document.forms[0].extensies.value;
		if(strTextArea.indexOf("JPG JPEG JPE PNG GIF BMP TIFF TIF ICO PCX")!= -1)
			document.forms[0].plaatjes.checked = true;
		if(strTextArea.indexOf("HTM HTML CSS XHTML JS SWF SHTML XML")!= -1)
			document.forms[0].website.checked = true;
		if(strTextArea.indexOf("AVI MPEG MPG WMV WMF ASF ASX RM RA RAM VIV MOV")!= -1)
			document.forms[0].video.checked = true;
		if(strTextArea.indexOf("MP3 WAV MID OGC AU SND WMA")!= -1)
			document.forms[0].muziek.checked = true;
		if(strTextArea.indexOf("DOC TXT PDF XLS CVS PPT")!= -1)
			document.forms[0].documenten.checked = true;		
		if(strTextArea.indexOf("ZIP RAR ACE ARJ CAB TAR GZ TGZ")!= -1)
			document.forms[0].ingepakt.checked = true;
	}
}

// Functie om checkbox automatisch 'aan' of 'uit' te zetten
function changeCheckBox( objCheckBox, strOptieUpdateOff ) {
	objCheckBox = eval(objCheckBox);
	objCheckBox.checked = !objCheckBox.checked;
	if(strOptieUpdateOff == null)
		updateExtensieArea();
}
// Functie om radiobox automatisch 'aan' of 'uit' te zetten
function changeRadioBox( strID, strOptieUpdateOff ) {
	objRadioBox = document.getElementById(strID);
	objRadioBox.checked = !objRadioBox.checked;
}
// Functie om een veld zichtbaar of onzichtbaar maken 
function changeDisable( objInput ) {
	objInput = eval(objInput);
	objInput.disabled=!objInput.disabled;
	if(arguments[1] != null) {
		objInput = eval(arguments[1]);
		objInput.disabled=!objInput.disabled;
	}	
}
// Functie die checkt of de data velden wel of niet disabled zijn
function checkDataEnabled( checkBoxNaam, TextveldNaam ) {
	if(checkBoxNaam.disabled == true)
		alert("Het is niet mogelijk om een datum te kiezen, want het gebruik van data is uitgeschakeld.");
	else
		NewCal(TextveldNaam,'ddMMyyyy',true,24);

}

// Functie om textarea om te zetten naar WYSIWYG-editor, als het moet iig 
function checkWYSIWYGArea() {
   var booHtml = document.getElementById('html');
	if(booHtml != null) {
		var oFCKeditor = new FCKeditor( 'html', 520, 500 ) ;
		oFCKeditor.BasePath = 'fckeditor/' ;
		oFCKeditor.ReplaceTextarea() ;
	}
}

// Voor het laten zien van div/blocks en verbergen ervan 
function showhide( idNaam ){	if (document.getElementById){		obj = document.getElementById(idNaam);		if (obj.style.display == "none"){			obj.style.display = "";		} else {			obj.style.display = "none";		}	}} 
