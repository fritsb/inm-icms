<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version ="1.0"
				xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html"/>
	<xsl:template match="/">
	<!-- Hierboven staat standaardinformatie. Het gedeelte vanaf					##
		  hieronder is bewerkbaar															##
	 ##   Project: i-CMS																		##
	 ## 	Auteur: Frits Bosschert															##
	 ##   In opdracht van Impression New Media											##
	 ##   																						##
	 ##   Bestandsnaam: headlines.xsl														##
	 ##   Beschrijving:																		##
	 ##   Dit document is voor het omzetten van de headlinesgegevens in XML	##
	 ##   naar leesbare content.															##
	 ##																							-->
			
			  <!-- Dit gedeelte is om de paginainformatie te laten zien				##
			   ## Pagina heeft de volgende attributen attributen:   	   		##
			   ## * ID-nummer 		[paginaid]												##
			   ## * Titel			[paginatitel]											##
			   ##	* Positie 		[paginapositie]											##
			   ##	* OnderdeelID (waaronder de pagina hangt) [paginaoid]			##
			   ##	* Deelnummer, vooral nuttig bij nieuwspagina's [paginadeelnr]	##
  			   ##	 Op dit moment wordt er niets getoond van de pagina, omdat	##
  			   ## het tussen commentaartags staat.										##
			  	##																					-->
<!--	          <xsl:for-each select="website/pagina">
	            <h1 style="text-transform: uppercase;"><xsl:value-of select="titel"/></h1>
	          </xsl:for-each>																-->

			  <!-- Dit gedeelte is om de blokinfo te laten zien	 					##
			   ## blok heeft de volgende attributen attributen: 						##
			   ## * ID-nummer 		[blokid]													##
			   ## * Titel			[bloktitel]												##
			   ##	* Bloktype		[bloktype]												##
			   ##	* Positie 		[blokpositie]											##
			   ##	* Intro 			[intro]													##
			    ##  Wanneer een bericht begint:											##
			    ##	* Dag van plaatsing (begindatum) 		[begindag]				##
			    ##	* Maand van plaatsing (begindatum)	[beginmaand]				##
			    ##	* Jaar van plaatsing (begindatum) 		[beginjaar]				##
			    ##	* Uur van plaatsing (begindatum) 		[beginuur]				##
			    ##	* Minuut van plaatsing (begindatum) 	[beginminuut]			##
			    ##  Wanneer het bericht afloopt:											##
			    ##	* Dag van aflopen (einddatum) 			[einddag]					##
			    ##	* Maand van aflopen (einddatum) 		[eindmaand]				##
			    ##	* Jaar van aflopen (einddatum) 		[eindjaar]				##
			    ##	* Uur van aflopen (einddatum) 			[einduur]					##
			    ##	* Minuut van aflopen (einddatum) 		[eindminuut]				##
			   ##	* De content   [content]													##
			   ## OPMERKING: datum en intro kunnen leeg zijn! 						##
			  	##																					-->	
			  	<xsl:for-each select="website/pagina/blok">
			   <table width="150" border="0" cellspacing="0" cellpadding="0">
	            <tr>
	              <td width="136" valign="top">
	                <p class="nieuwsKOP"><xsl:value-of select="bloktitel"/></p>
	                <p class="nieuwsBROOD"><xsl:value-of select="intro"/></p>
	              </td>
               	  <td width="14" valign="bottom" style="vertical-align: bottom;">
	            	<xsl:element name="a">
	            		<xsl:attribute name="href">index.php?<xsl:value-of select="/website/oid"/>/<xsl:value-of select="/website/pid"/>/<xsl:value-of select="blokid"/></xsl:attribute>
	            		<xsl:attribute name="onMouseOut">MM_swapImgRestore()</xsl:attribute>
	            		<xsl:attribute name="onMouseOver">MM_swapImage('pijl<xsl:value-of select="id"/>','','images/assets/pijl_f2.gif',1)"</xsl:attribute>
						<xsl:element name="img">
	            			<xsl:attribute name="src">images/assets/pijl.gif</xsl:attribute>
	            			<xsl:attribute name="name">pijl<xsl:value-of select="id"/></xsl:attribute>
	            			<xsl:attribute name="width">11</xsl:attribute>
	            			<xsl:attribute name="height">9</xsl:attribute>
	            			<xsl:attribute name="border">0</xsl:attribute>
	            		</xsl:element>
		             </xsl:element>
	            	</td>
	            </tr>
	           </table>
	           <img src="images/assets/lijn.gif" width="150" height="25"/>
	           
	          </xsl:for-each>

			  <!-- Dit gedeelte is om de error te laten zien					##
			   ## Error heeft de volgende attributen attributen:   			##
		    	##  * Errorcode [errorcode]											##
		    	##  * Errorbericht [errorbericht]									##
			  	##															-->	
			  	
			  <!-- Error's bij de pagina's zelf -->
	          <xsl:for-each select="website/error">
	            <p class="nieuwsKOP">Er is iets mis gegaan..</p>
	            <div class="nieuwsBROOD"><b><i>Foutnummer:</i></b> <xsl:value-of select="errorcode"/><br/>
	            <b><i>Foutmelding:</i></b> <xsl:value-of select="errorbericht"/><br/></div>
	          </xsl:for-each>
	          
	          <!-- Errors bij de pagina's -->
	          <xsl:for-each select="website/pagina/error">
	            <p class="nieuwsKOP">Er is iets mis gegaan..</p>
	            <div class="nieuwsBROOD"><b><i>Foutnummer: </i></b> <xsl:value-of select="errorcode"/><br/>
	            <b><i>Foutmelding: </i></b> <xsl:value-of select="errorbericht"/><br/></div>
	          </xsl:for-each>
	          
	          <!-- Vanaf hier niet meer bewerken -->
	</xsl:template>
</xsl:stylesheet>        