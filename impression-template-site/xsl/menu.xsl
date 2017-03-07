<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version ="1.0"
				xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html"/>
	<xsl:template match="/">
	<!-- Hierboven staat standaardinformatie. Het gedeelte vanaf					##
		  hieronder is bewerkbaar.															##
	 ##   Project: i-CMS																		##
	 ## 	Auteur: Frits Bosschert															##
	 ##   In opdracht van Impression New Media											##
	 ##   																						##
	 ##   Bestandsnaam: menu.xsl															##
	 ##   Beschrijving:																		##
	 ##   Dit document is voor het omzetten van de menu gegevens in XML naar ##
	 ##   leesbare content.																	##
	 ##																							-->
	
			
			  <!-- Dit gedeelte is om de onderdeelinformatie te laten zien			##
			   ## Onderdeel heeft de volgende attributen attributen:   	   	##
			   ## * ID-nummer 		[onderdeelid]											##
			   ## * Titel			[onderdeeltitel]										##
			   ##	* Positie 		[onderdeelpositie]										##
			  	##																					-->
	          <xsl:for-each select="menu/onderdeel">
	            <span style="font-family: Verdana; font-size: 10px; font-weight: bold; text-transform: uppercase;">
	            	<xsl:element name="a">
	            		<xsl:attribute name="href">index.php?<xsl:value-of select="onderdeelid"/></xsl:attribute>
	            		<xsl:attribute name="style">color: white;</xsl:attribute>
	            		<xsl:value-of select="onderdeeltitel"/>
	            	</xsl:element>
	            </span><br/>

			  <!-- Dit gedeelte is om de paginainformatie te laten zien		##
			  	 ## onderdeel een onderdeel.										##
			  	 ## 																		##
			    ## Pagina heeft de volgende attributen attributen: 			##
			    ##  * ID-nummer 		[paginaid]									##
			    ##  * Titel				[paginatitel]								## 
			    ##  * Positie 			[paginapositie]								##
			    ##  * OnderdeelID (waaronder de pagina hangt) [paginaoid]	##
			    ##  																		-->

	          <xsl:for-each select="pagina">
	            <span style="font-family: Verdana; font-size: 10px;">
	            	<xsl:element name="a">
	            		<xsl:attribute name="href">index.php?<xsl:value-of select="paginaoid"/>/<xsl:value-of select="paginaid"/></xsl:attribute>
	            		<xsl:attribute name="style">color: white; text-decoration: underline;</xsl:attribute>
	            		<xsl:value-of select="paginatitel"/>
	            	</xsl:element>
	            </span><br/>
	          </xsl:for-each>	
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
	          <xsl:for-each select="menu/pagina/error">
	            <p class="nieuwsKOP">Er is iets mis gegaan..</p>
	            <div class="nieuwsBROOD"><b><i>Foutnummer: </i></b> <xsl:value-of select="errorcode"/><br/>
	            <b><i>Foutmelding: </i></b> <xsl:value-of select="errorbericht"/><br/></div>
	          </xsl:for-each>
	          
	          <!-- Vanaf hier niet meer bewerken -->
	</xsl:template>
</xsl:stylesheet>        