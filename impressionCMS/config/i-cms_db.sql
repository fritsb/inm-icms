## ---------- iCMS -------------------------------------------------------
## 
## Auteur: Frits Bosschert
## In opdracht van Impression New Media
##
## Bestandsnaam: i-cms_db.sql
## Omschrijving: Het SQL script om de database en de bijbehorende tabellen mee aan te maken
## Datum: 15/04/2005
## Versie: 5.0
## 
## De volgende tabellen worden aangemaakt in deze volgorde:
## 
## * admin
## * website
## * gebruiker
## * gebruikersrechten
## * bestand
## * onderdeel
## * pagina 
## * blok
## * afbeeldingblok
## * contactformblok
## * flashblok
## * htmlblok
## * linksblok
## * tekstafbblok
## * tekstblok
## * logboek
## -------------------------------------------------------------------------------//

## ---------------------------------------------------------------------------------
##  Database 'iCMS' 
## -------------------------------------------------------------------------------//
DROP DATABASE IF EXISTS `iCMS`;
CREATE DATABASE IF NOT EXISTS `iCMS` CHARACTER SET utf8 COLLATE utf8_general_ci;
USE iCMS;

## ---------------------------------------------------------------------------------
## Tabel  `admin`
## -------------------------------------------------------------------------------//

## DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(255) NOT NULL auto_increment,
  `loginnaam` varchar(15) NOT NULL default '',
  `wachtwoord` varchar(100) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `voornaam` varchar(100) NOT NULL default '',
  `tussenvoegsel` varchar(20) NOT NULL default '',
  `achternaam` varchar(100) NOT NULL default '',
  `aanmelddatum` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastlogin` datetime NOT NULL default '0000-00-00 00:00:00',
  `actief` varchar(3) NOT NULL default 'nee',
  `superuser` varchar(3) NOT NULL default 'nee',
  `ip` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB CHARSET=utf8;

## ---------------------------------------------------------------------------------
## Tabel  `website`
## -------------------------------------------------------------------------------//

DROP TABLE IF EXISTS `website`;
CREATE TABLE IF NOT EXISTS `website` (
  `id` int(255) NOT NULL auto_increment,
  `url` varchar(100) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `titel` varchar(255) NOT NULL default '',
  `omschrijving` text NOT NULL,
  `aanmelddatum` datetime NOT NULL default '0000-00-00 00:00:00',
  `ftphost` varchar(100) NOT NULL default '',
  `ftpuser` varchar(100) NOT NULL default '',
  `ftppass` varchar(100) NOT NULL default '',
  `sitecode` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB CHARSET=utf8;

## ---------------------------------------------------------------------------------
## Tabel  `gebruiker`
## -------------------------------------------------------------------------------//

DROP TABLE IF EXISTS `gebruiker`;
CREATE TABLE IF NOT EXISTS `gebruiker` (
  `id` int(255) NOT NULL auto_increment,
  `gebruikersnaam` varchar(15) NOT NULL default '',
  `wachtwoord` varchar(100) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `voornaam` varchar(100) NOT NULL default '',
  `tussenvoegsel` varchar(20) NOT NULL default '',
  `achternaam` varchar(100) NOT NULL default '',
  `straat` varchar(100) NOT NULL default '',
  `huisnr` varchar(100) NOT NULL default '',
  `postcode` varchar(6) NOT NULL default '',
  `woonplaats` varchar(100) NOT NULL default '',
  `telnr` varchar(15) NOT NULL default '',
  `faxnr` varchar(15) NOT NULL default '',
  `mobielnr` varchar(15) NOT NULL default '',
  `aanmelddatum` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastlogin` datetime NOT NULL default '0000-00-00 00:00:00',
  `actief` char(3) NOT NULL default '',
  `ip` varchar(100) NOT NULL default '',
  `wid` int(255) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  INDEX (`wid`),
  FOREIGN KEY `wid` (`wid`)
  REFERENCES website(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB CHARSET=utf8;

## ---------------------------------------------------------------------------------
## Tabel  `gebruikersrechten`
## -------------------------------------------------------------------------------//

DROP TABLE IF EXISTS `gebruikersrechten`;
CREATE TABLE IF NOT EXISTS `gebruikersrechten` (
  `id` int(255) NOT NULL auto_increment,
  `onderdelen` varchar(3) NOT NULL default 'nee',
  `subonderdelen` varchar(3) NOT NULL default 'nee',
  `contentpagina` varchar(3) NOT NULL default 'nee',
  `nieuwspagina` varchar(3) NOT NULL default 'nee',
  `afbeelding` varchar(3) NOT NULL default 'nee',
  `contactform` varchar(3) NOT NULL default 'nee',
  `downloads` varchar(3) NOT NULL default 'nee',
  `flash` varchar(3) NOT NULL default 'nee',
  `htmlcode` varchar(3) NOT NULL default 'nee',
  `links` varchar(3) NOT NULL default 'nee',
  `tekstafb` varchar(3) NOT NULL default 'nee',
  `tekst` varchar(3) NOT NULL default 'ja',
  `wysiwyg` varchar(3) NOT NULL default 'ja',
  `bekijken` varchar(3) default 'ja',
  `uploaden` varchar(3) default 'nee',
  `verwijderen` varchar(3) default 'nee',
  `maxsize` int(20) default '1024000',
  `extensies` text,
  `gid` int(255) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  INDEX (`gid`),
  FOREIGN KEY `gid` (`gid`)
  REFERENCES gebruiker(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB CHARSET=utf8;

## ---------------------------------------------------------------------------------
## Tabel  `bestand`
## -------------------------------------------------------------------------------//

DROP TABLE IF EXISTS `bestand`;
CREATE TABLE IF NOT EXISTS `bestand` (
  `id` int(255) NOT NULL auto_increment,
  `bestandid` int(255) NOT NULL default '0',
  `bestandsnaam` varchar(30) NOT NULL default '',
  `locatie` TEXT NOT NULL default '',
  `omschrijving` text NOT NULL,
  `datum` datetime default NULL,
  `gid` int(255) NOT NULL default '0',
  `wid` int(255) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  INDEX (`wid`),
  FOREIGN KEY (`wid`)
  REFERENCES website(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

## ---------------------------------------------------------------------------------
## Tabel  `onderdeel`
## -------------------------------------------------------------------------------//

DROP TABLE IF EXISTS `onderdeel`;
CREATE TABLE IF NOT EXISTS `onderdeel` (
  `id` int(255) NOT NULL auto_increment,
  `onderdeelid` int(255) NOT NULL default '0',
  `titel` varchar(255) NOT NULL default '',
  `omschrijving` text NOT NULL,
  `positie` int(100) NOT NULL default '0',
  `zichtbaar` varchar(3) NOT NULL default 'nee',
  `bewerkbaar` varchar(3) NOT NULL default 'nee',
  `parent_id` int(255) NOT NULL default '0',
  `wid` int(255) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  INDEX (`wid`),
  FOREIGN KEY (`wid`)
  REFERENCES website(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

## ---------------------------------------------------------------------------------
## Tabel  `pagina`
## -------------------------------------------------------------------------------//

DROP TABLE IF EXISTS `pagina`;
CREATE TABLE IF NOT EXISTS `pagina` (
  `id` int(255) NOT NULL auto_increment,
  `paginaid` int(255) NOT NULL default '0',
  `titel` varchar(255) NOT NULL default '',
  `type` varchar(10) NOT NULL default 'content',
  `limiet` varchar(50) NOT NULL default '-1',
  `positie` int(100) NOT NULL default '0',
  `zichtbaar` varchar(3) NOT NULL default 'nee',
  `bewerkbaar` varchar(3) NOT NULL default 'nee',
  `oid` int(255) NOT NULL default '0',
  `wid` int(255) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  INDEX (`wid`),
  FOREIGN KEY (`wid`)
  REFERENCES website(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
## ---------------------------------------------------------------------------------
## Tabel  `blok`
## -------------------------------------------------------------------------------//

DROP TABLE IF EXISTS `blok`;
CREATE TABLE IF NOT EXISTS `blok` (
  `id` int(255) NOT NULL auto_increment,
  `blokid` int(255) NOT NULL default '0',
  `positie` int(255) NOT NULL default '0',
  `zichtbaar` varchar(3) NOT NULL default 'nee',
  `bewerkbaar` varchar(3) NOT NULL default 'nee',
  `titel` varchar(255) NOT NULL default '',
  `datum` datetime NOT NULL default '0000-00-00 00:00:00',
  `begindatum` datetime NOT NULL default '0000-00-00 00:00:00',
  `einddatum` datetime NOT NULL default '0000-00-00 00:00:00',
  `subtype` varchar(50) NOT NULL default '',  
  `uitlijning` varchar(20) NOT NULL default 'left',
  `breedte` int(20) NOT NULL default '0',
  `hoogte` int(20) NOT NULL default '0',
  `border` int(3) NOT NULL default '0',
  `bordercolor` varchar(20) NOT NULL default '',
  `bordertype` varchar(50) NOT NULL default '',
  `backgroundcolor` varchar(20) NOT NULL default '',
  `intro` text NOT NULL default '',
  `pid` int(255) NOT NULL default '0',
  `wid` int(255) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  INDEX (`wid`),
  FOREIGN KEY (`wid`)
  REFERENCES website(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
## ---------------------------------------------------------------------------------
## Tabel  `afbeeldingblok`
## -------------------------------------------------------------------------------//

DROP TABLE IF EXISTS `afbeeldingblok`;
CREATE TABLE IF NOT EXISTS `afbeeldingblok` (
  `blokid` int(255) NOT NULL default '0',
  `afburl` varchar(255) NOT NULL default '',
  `afbwidth` int(3) NOT NULL default '0',
  `afbheight` int(3) NOT NULL default '0',
  `afbborder` int(1) NOT NULL default '0',
  `alt` varchar(100) NOT NULL default '',
  `bestandid` int(255) NOT NULL default '0',
  `wid` int(255) NOT NULL default '0',
  INDEX (`wid`),
  FOREIGN KEY (`wid`)
  REFERENCES website(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

## ---------------------------------------------------------------------------------
## Tabel  `contactformblok`
## -------------------------------------------------------------------------------//

DROP TABLE IF EXISTS `contactformblok`;
CREATE TABLE IF NOT EXISTS `contactformblok` (
  `blokid` int(255) NOT NULL default '0',
  `mailadres` varchar(50) NOT NULL default '',
  `adresoptie` varchar(3) NOT NULL default 'nee',
  `teloptie` varchar(3) NOT NULL default 'nee',
  `taal` varchar(3) NOT NULL default 'nl',
  `verstuurd` TEXT NOT NULL default '',
  `nietverstuurd` TEXT NOT NULL default '',
  `lettergrootte` varchar(4) NOT NULL default '10',
  `lettertype` varchar(50) NOT NULL default 'Verdana',
  `wid` int(255) NOT NULL default '0',
  INDEX (`wid`),
  FOREIGN KEY (`wid`)
  REFERENCES website(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

## ---------------------------------------------------------------------------------
## Tabel  `flashblok`
## -------------------------------------------------------------------------------//

DROP TABLE IF EXISTS `flashblok`;
CREATE TABLE IF NOT EXISTS `flashblok` (
  `blokid` int(255) NOT NULL default '0',
  `flswidth` int(4) NOT NULL default '0',
  `flsheight` int(4) NOT NULL default '0',
  `flashurl` varchar(200) NOT NULL default '',
  `kwaliteit` varchar(10) NOT NULL default 'high',
  `loop` varchar(3) NOT NULL default 'ja',
  `autoplay` varchar(3) NOT NULL default 'ja',
  `achtergrond` varchar(10) NOT NULL default '',
  `bestandid` int(255) NOT NULL default '0',
  `wid` int(255) NOT NULL default '0',
  INDEX (`wid`),
  FOREIGN KEY (`wid`)
  REFERENCES website(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

## ---------------------------------------------------------------------------------
## Tabel  `htmlblok`
## -------------------------------------------------------------------------------//

DROP TABLE IF EXISTS `htmlblok`;
CREATE TABLE IF NOT EXISTS `htmlblok` (
  `blokid` int(255) NOT NULL default '0',
  `htmlcode` text NOT NULL,
  `wid` int(255) NOT NULL default '0',
  INDEX (`wid`),
  FOREIGN KEY (`wid`)
  REFERENCES website(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

## ---------------------------------------------------------------------------------
## Tabel  `linksblok`
## -------------------------------------------------------------------------------//

DROP TABLE IF EXISTS `linksblok`;
CREATE TABLE IF NOT EXISTS `linksblok` (
  `blokid` int(255) NOT NULL default '0',
  `url` text NOT NULL,
  `naam` varchar(50) NOT NULL default '',
  `bestandid` int(255) NOT NULL default '0',
  `wid` int(255) NOT NULL default '0',
  INDEX (`wid`),
  FOREIGN KEY (`wid`)
  REFERENCES website(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

## ---------------------------------------------------------------------------------
## Tabel  `tekstafbblok`
## -------------------------------------------------------------------------------//

DROP TABLE IF EXISTS `tekstafbblok`;
CREATE TABLE IF NOT EXISTS `tekstafbblok` (
  `blokid` int(255) NOT NULL default '0',
  `tekst` text,
  `lettertype` varchar(50) NOT NULL default '',
  `lettergrootte` int(3) NOT NULL default '0',
  `letterkleur` varchar(50) NOT NULL default '#000000',
  `afburl` varchar(255) NOT NULL default '',
  `afbwidth` int(3) NOT NULL default '0',
  `afbheight` int(3) NOT NULL default '0',
  `afbborder` int(1) NOT NULL default '0',
  `alt` varchar(100) NOT NULL default '',
  `keuze` varchar(2) NOT NULL default '',
  `bestandid` int(255) NOT NULL default '0',
  `wid` int(255) NOT NULL default '0',
  INDEX (`wid`),
  FOREIGN KEY (`wid`)
  REFERENCES website(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

## ---------------------------------------------------------------------------------
## Tabel  `tekstblok`
## -------------------------------------------------------------------------------//

DROP TABLE IF EXISTS `tekstblok`;
CREATE TABLE IF NOT EXISTS `tekstblok` (
  `blokid` int(255) NOT NULL default '0',
  `tekst` text,
  `lettertype` varchar(50) NOT NULL default '',
  `lettergrootte` int(3) NOT NULL default '12',
  `letterkleur` varchar(50) NOT NULL default '#000000',
  `wid` int(255) NOT NULL default '0',
  INDEX (`wid`),
  FOREIGN KEY (`wid`)
  REFERENCES website(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


## ---------------------------------------------------------------------------------
## Tabel  `logboek`
## -------------------------------------------------------------------------------//

DROP TABLE IF EXISTS `logboek`;
CREATE TABLE IF NOT EXISTS `logboek` (
  `id` int(255) NOT NULL auto_increment,
  `tekst` text NOT NULL,
  `ipadres` varchar(100) NOT NULL default '',
  `gid` int(255) NOT NULL default '0',
  `aid` int(255) NOT NULL default '0',
  `wid` int(255) NOT NULL default '0',
  `soort` varchar(100) NOT NULL,
  `datumtijd` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB CHARACTER SET =utf8;

## -------------------------------------------------------------------------------//
