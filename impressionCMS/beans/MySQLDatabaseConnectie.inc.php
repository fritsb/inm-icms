<?php
/* Project: i-CMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: MySQLDatabaseConnectie.inc.php
 * Beschrijving: De MySQLDatabaseConnectie klasse voor verbinding met MySQL-database. 
 * De klasse FoutMelding vangt de foutmeldingen (exceptions) op en stuurt deze door naar de errorpagina. 
 * De try&catch's in deze functies zijn dus om de exceptions op te vangen
 * 
 */
// Subklasse van mysqli-klasse
class MySQLDatabaseConnectie {
  private $booConnection = false;
  private $result;
  private $strHostname;
  private $strGebruikersnaam;
  private $strWachtwoord;
  private $strDatabase;
  private $strErrorPage;
  private $arrResult;
  
  // Constructor voor PHP5	
  public function __construct($strHostname = '', $strGebruikersnaam = '', $strWachtwoord = '', $strDatabase = '', $strErrorPage = true ) {
	 $this->strHostname = $strHostname;
	 $this->strGebruikersnaam = $strGebruikersnaam;
	 $this->strWachtwoord = $strWachtwoord; 
	 $this->strDatabase = $strDatabase;
	 $this->strErrorPage = $strErrorPage;
	
	 if($this->strHostname == "" || $this->strGebruikersnaam == "" || $this->strWachtwoord == "") {
      	$this->booConnection = false;
      	$objFoutMelding = new FoutMelding("Ontbrekende gegevens", 1);
        	if($this->strErrorPage)
    	  		$objFoutMelding->getErrorPage();
    	  	else
    	  		return false;
	 }
	 else {
     	try {
        	mysql_connect( $this->strHostname, $this->strGebruikersnaam, $this->strWachtwoord);
			if(!mysql_select_db( $this->strDatabase )) {
  	   	  	throw new FoutMelding(mysql_error(), 1, mysql_errno());
  	    	}
  	    	else {
  	      	$this->booConnection = true;
  	   	}
     	}
     	catch(FoutMelding $objFoutMelding) {
        	$this->booConnection = false;
        	if($this->strErrorPage)
    	  		$objFoutMelding->getErrorPage();
    	  	else
    	  		return false;
     	}
    }
  }
  
  // Destructor; sluit de connectie  
  public function __destruct() {
  	 if($this->booConnection == true) {
  		mysql_close();
  	 }
  }
  
  // Methode om andere DB te selecteren
  public function setDB($newDatabase) {
  	$this->strDatabase = $newDatabase;
	try {
	  	if(mysql_select_db($this->strDatabase)) {
	  		throw new FoutMelding(mysql_error(), 4, mysql_errno());
	  	}
	  	else {
	  		return true;
	  	}
	}
	catch(FoutMelding $objFoutMelding) {
		$this->booConnection = false;
     	if($this->strErrorPage)
  	  		$objFoutMelding->getErrorPage();
  	  	else
  	  		return false;
	}
  }
  
  // Methode om DB op te vragen
  public function getDB() {
  	return $this->strDatabase;
  }
  // Methode om data op te vragen, returnt een array of false/null als het niet goed gaat
  public function getData($sql) {
  	 if($this->booConnection != true) 
  	 	return false;
  	 
  	 try {	
  	   $this->result = mysql_query( $sql);
  	   if(mysql_error()) {
  		  throw new FoutMelding(mysql_error(), 2, mysql_errno(), $sql);
  	   }
  	   elseif($this->result == false || $this->result == null) {
  	 	  mysql_free_result($this->result);
  	      return false;
  	   }
  	   elseif(mysql_num_rows($this->result) == 0) {
  		  mysql_free_result($this->result);
  	 	  return null;
       }
   	 elseif(mysql_num_rows($this->result) >= 1) {
  	      for( $i = 0; $i < mysql_num_rows($this->result); $i++ ) {
  		      $arrResult[$i] = mysql_fetch_array($this->result);
  	      }
  	      mysql_free_result($this->result);
  	      return $arrResult;    	
  	   }
  	   else {
  		  mysql_free_result($this->result);
  	   	  return false;
  	   }  	
  	 }
  	 catch(Foutmelding $objFoutMelding) {
     	if($this->strErrorPage)
  	  		$objFoutMelding->getErrorPage();
  	  	else
  	  		return false;
     }
  }
  // Methode om data te setten, dus voor INSERT, UPDATE, DELETE
  public function setData($sql) {
     if($this->booConnection != true) 
  	 	return false;
  	 
  	 mysql_query($sql);
  	 try {	
  	   if(mysql_error()) {
  		  throw new FoutMelding(mysql_error(), 3, mysql_errno(), $sql);
  	   }
  	   else {
  	 	  return true;
  	   }
  	 }
  	 catch(Foutmelding $objFoutMelding) {
     	if($this->strErrorPage)
  	  		$objFoutMelding->getErrorPage();
  	  	else
  	  		return false;
     }  	 	 
  }
  // Methode om de ID van de laatste INSERT-query op te vragen
  public function getLastInsertedID() {
     if($this->booConnection != true) 
  	 	return false;
  
  	 return mysql_insert_id();
  }  
}

?>