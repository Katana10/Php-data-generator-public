<?php
  session_start();
  require_once('constante.php');

  
  function createStrFile($file){
      // prend le nombre de ligne du fichier
      $fichier_ligne = file($file);
      $fichier_ligne = str_replace("\r\n","\n", $fichier_ligne);
      $i = count($fichier_ligne);
  
      // initialise et prend un nombre aléatoire entre 0 et $i:
      srand((double)microtime()*1000000);
      $id = rand(0,$i);
      $temp = str_replace("\n", "", $fichier_ligne[$id]);
      
      return $temp;
  }

  function finition($file){
    $fichier_ligne = file($file);
    $i = count($fichier_ligne);
    $temp = str_replace(",\n", ";", $fichier_ligne[$i-1]);
    $fichier_ligne[$i-1] = $temp;
    echo $temp;
    
    //return $temp;
  }
  
  
  // function createPrenom($file){
  //   // prend le nombre de ligne du fichier
  //   $fichier_ligne = file($file);
  //   $i = count($fichier_ligne);

  //   // initialise et prend un nombre aléatoire entre 0 et $i:
  //   srand((double)microtime()*1000000);
  //   $id = rand(0,$i);

  //   // affiche la ligne
  //   echo $fichier_ligne[$id];
  // }


  function dbConnect(){
    try{
      $db = new PDO(DB_DSN,
        DB_USER, DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
       
    }catch (PDOException $exception){
      
      error_log('Connection error: '.$exception->getMessage());
      return false;
    } 
    return $db;
  }
  
  function dbRequestModele($db, $libelle){
    try{
      $statement = $db->prepare("SELECT nom_fichier, nom_table FROM `modele` WHERE libelle = :libelle");
      $statement->bindParam(':libelle',$libelle, PDO::PARAM_STR);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      // $result = $result["0"];
    }catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }

  function searchModele($db){
  try{
    $statement = $db->prepare('SELECT * FROM modele ORDER BY `modele`.`date_creation` DESC');
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

  }catch (PDOException $exception){
    
    error_log('Request error: '.$exception->getMessage());
    return false;
  }
  return $result;  
  }

  function dbRequestActif($db){
    
    try{
      
      $statement = $db->prepare("SELECT * FROM type_champ");
      $statement->execute();
      //$result = $statement->fetchAll(PDO::FETCH_COLUMN);
      //$result = $result["0"];
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    }catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }
  
  function dbUpdateActif($db,$type,$actif){
    try{
      $statement = $db->prepare("UPDATE type_champ SET actif=:actif WHERE type_champ= :type_champ");
      $statement->bindParam(':actif', $actif, PDO::PARAM_INT);
      $statement->bindParam(':type_champ', $type, PDO::PARAM_STR);
      $statement->execute();
              
    }catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }

  function dbChampNum($db,$nom_champ,$type_champ,$libelle,$val_min,$val_max){
    
    try{
      
      $statement = $db->prepare("INSERT INTO champs (nom_champ,type_champ,libelle,val_min_nb,val_max_nb) VALUES (:nom_champ,:type_champ,:libelle,:val_min_nb,:val_max_nb)");
      $statement->bindParam(':nom_champ',$nom_champ, PDO::PARAM_STR);
      $statement->bindParam(':type_champ',$type_champ, PDO::PARAM_STR);
      $statement->bindParam(':libelle',$libelle, PDO::PARAM_STR);
      $statement->bindParam(':val_min_nb',$val_min, PDO::PARAM_INT);
      $statement->bindParam(':val_max_nb',$val_max, PDO::PARAM_INT);
      
      
      $statement->execute();
      
      
    }catch (PDOException $exception){
      
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }   
  
  function dbChampDate($db,$nom_champ,$type_champ,$libelle,$val_min,$val_max){
    try{
      
      $statement = $db->prepare("INSERT INTO champs (nom_champ,type_champ,libelle,val_min_date,val_max_date) VALUES (:nom_champ,:type_champ,:libelle,:val_min_date,:val_max_date)");
      $statement->bindParam(':nom_champ',$nom_champ, PDO::PARAM_STR);
      $statement->bindParam(':type_champ',$type_champ, PDO::PARAM_STR);
      $statement->bindParam(':libelle',$libelle, PDO::PARAM_STR);
      $statement->bindParam(':val_min_date',$val_min, PDO::PARAM_STR);
      $statement->bindParam(':val_max_date',$val_max, PDO::PARAM_STR);
     
      $statement->execute();
      
      
    }catch (PDOException $exception){
      
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true; 
  }

  function dbChampStr($db,$nom_champ,$type_champ,$libelle,$longueur,$fichier){
    
    try{
      
      $statement = $db->prepare("INSERT INTO champs (nom_champ,type_champ,libelle,longueur,fichier) VALUES (:nom_champ,:type_champ,:libelle,:longueur,:fichier)");
      $statement->bindParam(':nom_champ',$nom_champ, PDO::PARAM_STR);
      $statement->bindParam(':type_champ',$type_champ, PDO::PARAM_STR);
      $statement->bindParam(':libelle',$libelle, PDO::PARAM_STR);
      $statement->bindParam(':longueur',$longueur, PDO::PARAM_INT);
      $statement->bindParam(':fichier',$fichier, PDO::PARAM_STR);
      
      
      $statement->execute();
      
      
    }catch (PDOException $exception){
      
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }

  function dbChampBool($db,$nom_champ,$type_champ,$libelle, $valeur){
    
    try{
      
      $statement = $db->prepare("INSERT INTO champs (nom_champ,type_champ,libelle,list_txt) VALUES (:nom_champ,:type_champ,:libelle,:valeur)");
      $statement->bindParam(':nom_champ',$nom_champ, PDO::PARAM_STR);
      $statement->bindParam(':type_champ',$type_champ, PDO::PARAM_STR);
      $statement->bindParam(':libelle',$libelle, PDO::PARAM_STR);
      $statement->bindParam(':valeur',$valeur, PDO::PARAM_STR);
      
      
      $statement->execute();
      
      
    }catch (PDOException $exception){
      
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }

  function dbCreation($db, $libelle ){
    try{
      $statement = $db->prepare("SELECT * FROM `champs` WHERE libelle = :libelle");
      $statement->bindParam(':libelle',$libelle, PDO::PARAM_STR);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      // $result = $result["0"];
    }catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }


   
?>