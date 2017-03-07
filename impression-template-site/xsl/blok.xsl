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
	 ##   Bestandsnaam: blok.xsl															##
	 ##   Beschrijving:																		##
	 ##   Dit document is voor het omzetten van de blokgegevens in XML			##
	 ##   naar leesbare content.															##
	 ##																							-->
			  <!-- Dit gedeelte is om de paginainformatie te laten zien.	##
			    ## Pagina heeft de volgende attributen attributen: 			##
			    ##  * ID-nummer 		[paginaid]									##
			    ##  * Titel				[paginatitel]								##
			    ##  * Positie 			[paginapositie]								##
			    ##  * OnderdeelID (waaronder de pagina hangt) [paginaoid]	##
			  	 ##  Op dit moment wordt er niets mee gedaan, omdat het	##
			  	 ##  tussen commentaar tekens staat								##															
			    ##  																		-->
<!--	          <xsl:for-each select="website/pagina">
	            <h1 style="text-transform: uppercase;"><xsl:value-of select="paginatitel"/></h1>
	          </xsl:for-each>												-->

			  <!-- Dit gedeelte is om de blokinfo te laten zien.				##
			    ## blok heeft de volgende attributen attributen: 			##
			    ##  * ID-nummer 		[blokid]										##
			    ##  * Titel				[bloktitel]									##
			    ##  * Bloktype 		[bloktype]									##
			    ##  * Positie 			[blokpositie]								##
			    ##  Wanneer een bericht wordt geplaatst:						##
			    ##	* Dag van plaatsing (begindatum) 		[begindag]		##
			    ##	* Maand van plaatsing (begindatum)	[beginmaand]		##
			    ##	* Jaar van plaatsing (begindatum) 		[beginjaar]		##
			    ##	* Uur van plaatsing (begindatum) 		[beginuur]		##
			    ##	* Minuut van plaatsing (begindatum) 	[beginminuut]	##
			    ##  Wanneer het bericht afloopt:									##
			    ##	* Dag van aflopen (einddatum) 			[einddag]			##
			    ##	* Maand van aflopen (einddatum) 		[eindmaand]		##
			    ##	* Jaar van aflopen (einddatum) 		[eindjaar]		##
			    ##	* Uur van aflopen (einddatum) 			[einduur]			##
			    ##	* Minuut van aflopen (einddatum) 		[eindminuut]		##
			    ##  * Intro [intro]													##
			    ##  * Content [content]												##
			    ## OPMERKING: Data en intro kunnen leeg zijn!				##
			  	 ##																		-->	
	          <xsl:for-each select="website/pagina/blok">
<!--	            <p class="tekstKOP"><xsl:value-of select="bloktitel"/></p> //-->
	            <xsl:value-of select="content"/><br/>
	          </xsl:for-each>
	          


			  <!-- Dit gedeelte is om de error te laten zien					##
			    ## Error heeft de volgende attributen attributen:   		##
			    ##  * Errorcode [errorcode]										##
			    ##  * Errorbericht [errorbericht]								##
			    ##  Zie de documentatie voor de specifieke betekenis van	##
			    ##  de errorcodes													##
			    ##																		-->	
			  	
			  <!-- Error's bij de pagina's zelf -->
	          <xsl:for-each select="website/error">
	            <p class="tekstKOP">Er is iets mis gegaan..</p>
	            <b><i>Foutnummer:</i></b> <xsl:value-of select="errorcode"/><br/>
	            <b><i>Foutmelding:</i></b> <xsl:value-of select="errorbericht"/><br/>
	          </xsl:for-each>
	          
	          <!-- Errors bij de pagina's -->
	          <xsl:for-each select="website/pagina/error">
	            <p class="tekstKOP">Er is iets mis gegaan..</p>
	            <b><i>Foutnummer:</i></b> <xsl:value-of select="errorcode"/><br/>
	            <b><i>Foutmelding:</i></b> <xsl:value-of select="errorbericht"/><br/>
	          </xsl:for-each>

				<!-- Het gedeelte hieronder is om onder op de pagina links te laten zien 
					   voor als er meer dan de toegestande blokken op de pagina aanwezig zijn. -->
	          <xsl:for-each select="website/pagina">
		            	<xsl:if test="paginadeelnr &gt; 0">
		            		<xsl:element name="a">
	    	    	    		<xsl:attribute name="href">index.php?<xsl:value-of select="/website/oid"/>/<xsl:value-of select="/website/pid"/>-<xsl:value-of select="paginadeelnr - 1"/></xsl:attribute>
				            		<span style="float: left;">Meer items</span>
    	    		    	</xsl:element>
						</xsl:if>
						<xsl:if test="totaal &gt; ((paginadeelnr+1) * limiet)">
		            		<xsl:element name="a">
	    	    	    		<xsl:attribute name="href">index.php?<xsl:value-of select="/website/oid"/>/<xsl:value-of select="/website/pid"/>-<xsl:value-of select="paginadeelnr + 1"/></xsl:attribute>
				            		<span style="float: right;">Vorige items</span>
    	    		    	</xsl:element>
						</xsl:if>
	          </xsl:for-each>												

	          
	          <!-- Vanaf hier niet meer bewerken -->
	</xsl:template>
</xsl:stylesheet>        