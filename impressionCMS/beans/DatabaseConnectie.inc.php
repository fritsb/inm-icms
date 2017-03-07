<?php
/* Project: iCMS
 * Auteur: Frits Bosschert 
 * In opdracht van Impression New Media
 * 
 * Bestandsnaam: DatabaseConnectie.inc.php
 * Beschrijving: De DatabaseConnectie klasse voor verbinding met MySQL-database mbv de Improved MySQL Extension. 
 * De klasse FoutMelding vangt de foutmeldingen (exceptions) op en stuurt deze door naar de errorpagina. 
 * De try&catch's in deze functies zijn dus om de exceptions op te vangen
 * 
 */

class DatabaseConnectie extends mysqli {
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
        	parent::__construct( $this->strHostname, $this->strGebruikersnaam, $this->strWachtwoord, $this->strDatabase );
  	    
  	    	if(mysqli_connect_errno()) {
  	   	  	throw new FoutMelding(mysqli_connect_error(), 1, mysqli_connect_errno($this));
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
  		parent::close();
  	 }
  }
  
  // Methode om andere DB te selecteren
  public function setDB($newDatabase) {
  	$this->strDatabase = $newDatabase;
	try {
	  	if(!parent::select_db($this->strDatabase)) {
	  		throw new FoutMelding(mysqli_error($this), 4, mysqli_errno($this));
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
  	   $this->result = parent::query( $sql );
  	   if(mysqli_error($this)) {
  		  throw new FoutMelding(mysqli_error($this), 2, mysqli_errno($this), $sql);
  	   }
  	   elseif($this->result == false || $this->result == null) {
  	 	  $this->result->close();
  	      return false;
  	   }
  	   elseif(mysqli_num_rows($this->result) == 0) {
  		  $this->result->close();
  	 	  return null;
       }
   	 elseif(mysqli_num_rows($this->result) >= 1) {
  	      for( $i = 0; $i < mysqli_num_rows($this->result); $i++ ) {
  		      $arrResult[$i] = $this->result->fetch_array();
  	      }
  	      $this->result->close();
  	      return $arrResult;    	
  	   }
  	   else {
  	 	  $this->result->close();
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
  	 
  	 parent::query($sql);
  	 try {	
  	   if(mysqli_error($this)) {
  		  throw new FoutMelding(mysqli_error($this), 3, mysqli_errno($this), $sql);
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
  
  	 return $this->insert_id;
  }  
}

?>